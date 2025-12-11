<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of stores
     */
    public function index()
    {
        $stores = Auth::user()->stores()->withCount(['transactions', 'accounts'])->get();
        return view('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store
     */
    public function create()
    {
        return view('stores.create');
    }

    /**
     * Store a newly created store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'business_type' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $store = Store::create($validated);

        // Attach user as owner
        $store->users()->attach(Auth::id(), ['role' => 'owner']);

        // Create default accounts
        $this->createDefaultAccounts($store);

        // Set as current store
        session(['current_store_id' => $store->id]);

        return redirect()->route('dashboard')
            ->with('success', 'Toko berhasil dibuat!');
    }

    /**
     * Show the form for editing a store
     */
    public function edit(Store $store)
    {
        $this->authorizeStore($store);
        return view('stores.edit', compact('store'));
    }

    /**
     * Update the specified store
     */
    public function update(Request $request, Store $store)
    {
        $this->authorizeStore($store);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'business_type' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $store->update($validated);

        return redirect()->route('stores.index')
            ->with('success', 'Toko berhasil diperbarui!');
    }

    /**
     * Remove the specified store
     */
    public function destroy(Store $store)
    {
        $this->authorizeStore($store);

        // Check if user is owner
        if (!Auth::user()->isOwnerOf($store)) {
            abort(403, 'Hanya owner yang dapat menghapus toko.');
        }

        $store->delete();

        // Clear session if current store was deleted
        if (session('current_store_id') == $store->id) {
            session()->forget('current_store_id');
        }

        return redirect()->route('stores.index')
            ->with('success', 'Toko berhasil dihapus!');
    }

    /**
     * Switch to a different store
     */
    public function switch(Store $store)
    {
        $this->authorizeStore($store);

        session(['current_store_id' => $store->id]);

        return redirect()->route('dashboard')
            ->with('success', "Beralih ke toko: {$store->name}");
    }

    /**
     * Check if user has access to store
     */
    private function authorizeStore(Store $store)
    {
        if (!Auth::user()->stores->contains($store)) {
            abort(403, 'Anda tidak memiliki akses ke toko ini.');
        }
    }

    /**
     * Create default account categories for a new store
     */
    private function createDefaultAccounts(Store $store)
    {
        $defaults = [
            ['name' => 'Penjualan', 'type' => 'income', 'is_default' => true],
            ['name' => 'Pendapatan Lainnya', 'type' => 'income', 'is_default' => false],
            ['name' => 'Transfer Masuk', 'type' => 'income', 'is_default' => false],
            ['name' => 'Gaji Pegawai', 'type' => 'expense', 'is_default' => false],
            ['name' => 'Bahan Baku', 'type' => 'expense', 'is_default' => true],
            ['name' => 'Listrik', 'type' => 'expense', 'is_default' => false],
            ['name' => 'Transport', 'type' => 'expense', 'is_default' => false],
            ['name' => 'Sewa', 'type' => 'expense', 'is_default' => false],
            ['name' => 'Operasional Lainnya', 'type' => 'expense', 'is_default' => false],
        ];

        foreach ($defaults as $account) {
            $store->accounts()->create($account);
        }
    }
}
