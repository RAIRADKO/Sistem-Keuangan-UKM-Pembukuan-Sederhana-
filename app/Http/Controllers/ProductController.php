<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $query = Product::where('store_id', $store->id)
            ->with('category');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->lowStock();
            } elseif ($request->stock_status === 'out') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($request->stock_status === 'in') {
                $query->inStock();
            }
        }

        // Filter by active status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('name')->paginate(20)->withQueryString();

        $categories = ProductCategory::where('store_id', $store->id)
            ->active()
            ->orderBy('name')
            ->get();

        // Summary
        $summary = [
            'total_products' => Product::where('store_id', $store->id)->count(),
            'low_stock_count' => Product::where('store_id', $store->id)->active()->lowStock()->count(),
            'out_of_stock_count' => Product::where('store_id', $store->id)->active()->where('stock_quantity', '<=', 0)->count(),
        ];

        return view('products.index', compact('products', 'categories', 'store', 'summary'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $categories = ProductCategory::where('store_id', $store->id)
            ->active()
            ->orderBy('name')
            ->get();

        return view('products.create', compact('store', 'categories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:product_categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        // Verify category belongs to store if provided
        if (!empty($validated['category_id'])) {
            $category = ProductCategory::findOrFail($validated['category_id']);
            if ($category->store_id !== $store->id) {
                abort(403);
            }
        }

        $validated['store_id'] = $store->id;
        $validated['is_active'] = true;
        $validated['min_stock_alert'] = $validated['min_stock_alert'] ?? 0;

        $product = Product::create($validated);

        // Record initial stock if > 0
        if ($product->stock_quantity > 0) {
            $product->stockMovements()->create([
                'user_id' => Auth::id(),
                'type' => 'in',
                'quantity' => $product->stock_quantity,
                'stock_before' => 0,
                'stock_after' => $product->stock_quantity,
                'notes' => 'Stok awal',
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $this->authorizeProduct($product);

        $product->load(['category', 'stockMovements' => function ($query) {
            $query->with('user')->orderByDesc('created_at')->limit(20);
        }]);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing a product
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

        $store = Auth::user()->currentStore();
        
        $categories = ProductCategory::where('store_id', $store->id)
            ->active()
            ->orderBy('name')
            ->get();

        return view('products.edit', compact('product', 'store', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:product_categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['min_stock_alert'] = $validated['min_stock_alert'] ?? 0;

        $product->update($validated);

        return redirect()->route('products.show', $product)
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        // Check if product has transaction items
        if ($product->transactionItems()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus produk yang sudah pernah dijual!');
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Show stock adjustment form
     */
    public function showAdjustStockForm(Product $product)
    {
        $this->authorizeProduct($product);

        return view('products.adjust-stock', compact('product'));
    }

    /**
     * Adjust stock for a product
     */
    public function adjustStock(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'adjustment_type' => 'required|in:in,out,set',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $stockBefore = $product->stock_quantity;
        $type = $validated['adjustment_type'];

        if ($type === 'in') {
            $product->adjustStock($validated['quantity'], 'in', Auth::id(), null, $validated['notes']);
            $message = "Stok masuk {$validated['quantity']} unit berhasil dicatat.";
        } elseif ($type === 'out') {
            if ($validated['quantity'] > $product->stock_quantity) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Jumlah stok keluar melebihi stok yang tersedia!');
            }
            $product->adjustStock($validated['quantity'], 'out', Auth::id(), null, $validated['notes']);
            $message = "Stok keluar {$validated['quantity']} unit berhasil dicatat.";
        } else { // set
            $product->adjustStock($validated['quantity'], 'adjustment', Auth::id(), null, $validated['notes']);
            $message = "Stok berhasil disesuaikan menjadi {$validated['quantity']} unit.";
        }

        return redirect()->route('products.show', $product)
            ->with('success', $message);
    }

    /**
     * Check if user has access to product's store
     */
    private function authorizeProduct(Product $product)
    {
        $store = Auth::user()->currentStore();

        if (!$store || $product->store_id !== $store->id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
    }
}
