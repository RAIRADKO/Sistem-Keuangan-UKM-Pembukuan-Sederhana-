<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of product categories
     */
    public function index(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $query = ProductCategory::where('store_id', $store->id)
            ->withCount('products');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('name')->paginate(20)->withQueryString();

        return view('product-categories.index', compact('categories', 'store'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        return view('product-categories.create', compact('store'));
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $store = Auth::user()->currentStore();

        if (!$store) {
            return redirect()->route('stores.create');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['store_id'] = $store->id;
        $validated['is_active'] = true;

        ProductCategory::create($validated);

        return redirect()->route('product-categories.index')
            ->with('success', 'Kategori produk berhasil ditambahkan!');
    }

    /**
     * Show the form for editing a category
     */
    public function edit(ProductCategory $productCategory)
    {
        $this->authorizeCategory($productCategory);

        $store = Auth::user()->currentStore();

        return view('product-categories.edit', compact('productCategory', 'store'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $this->authorizeCategory($productCategory);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $productCategory->update($validated);

        return redirect()->route('product-categories.index')
            ->with('success', 'Kategori produk berhasil diperbarui!');
    }

    /**
     * Remove the specified category
     */
    public function destroy(ProductCategory $productCategory)
    {
        $this->authorizeCategory($productCategory);

        // Check if category has products
        if ($productCategory->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki produk!');
        }

        $productCategory->delete();

        return redirect()->route('product-categories.index')
            ->with('success', 'Kategori produk berhasil dihapus!');
    }

    /**
     * Check if user has access to category's store
     */
    private function authorizeCategory(ProductCategory $category)
    {
        $store = Auth::user()->currentStore();

        if (!$store || $category->store_id !== $store->id) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini.');
        }
    }
}
