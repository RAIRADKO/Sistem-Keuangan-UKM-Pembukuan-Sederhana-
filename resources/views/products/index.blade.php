<x-app-layout>
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="page-title">Produk</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">{{ $store->name }} - Manajemen Inventori</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('product-categories.index') }}" class="btn btn-secondary">
                        Kategori
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Produk
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl p-6 border border-blue-100 dark:border-blue-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
                <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">Total Produk</p>
                <p class="text-2xl font-bold text-blue-700 dark:text-blue-300 mt-1">{{ $summary['total_products'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 rounded-2xl p-6 border border-amber-100 dark:border-amber-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.15s;">
                <p class="text-sm font-semibold text-amber-600 dark:text-amber-400">Stok Rendah</p>
                <p class="text-2xl font-bold text-amber-700 dark:text-amber-300 mt-1">{{ $summary['low_stock_count'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 dark:from-rose-900/30 dark:to-pink-900/30 rounded-2xl p-6 border border-rose-100 dark:border-rose-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                <p class="text-sm font-semibold text-rose-600 dark:text-rose-400">Stok Habis</p>
                <p class="text-2xl font-bold text-rose-700 dark:text-rose-300 mt-1">{{ $summary['out_of_stock_count'] }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-8 animate-fade-in-up" style="opacity: 0; animation-delay: 0.25s;">
            <div class="p-6">
                <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div>
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-input">
                            <option value="">Semua</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status Stok</label>
                        <select name="stock_status" class="form-input">
                            <option value="">Semua</option>
                            <option value="in" {{ request('stock_status') === 'in' ? 'selected' : '' }}>Tersedia</option>
                            <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Stok Rendah</option>
                            <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>Stok Habis</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="">Semua</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, SKU..." class="form-input">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="btn btn-primary w-full">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Table -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.3s;">
            @if($products->count() > 0)
                <div class="table-container border-0 rounded-t-2xl">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th class="text-right">Harga Beli</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-right">Margin</th>
                                <th class="text-center">Stok</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($products as $product)
                                <tr class="{{ $product->is_low_stock ? 'bg-amber-50 dark:bg-amber-900/20' : '' }}">
                                    <td>
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-slate-100">{{ $product->name }}</p>
                                            @if($product->sku)
                                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $product->sku }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-slate-600 dark:text-slate-400">
                                        {{ $product->category?->name ?? '-' }}
                                    </td>
                                    <td class="text-right text-slate-600 dark:text-slate-400">
                                        Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right text-slate-600 dark:text-slate-400">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">
                                            {{ $product->profit_margin_percent }}%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="inline-flex items-center justify-center min-w-[3rem] px-2.5 py-1 rounded-full text-sm font-semibold
                                            {{ $product->stock_quantity <= 0 ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400' : 
                                               ($product->is_low_stock ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 
                                               'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400') }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $product->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('products.show', $product) }}" class="text-slate-400 hover:text-cyan-600 transition-colors" title="Detail">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('products.adjust-stock.form', $product) }}" class="text-slate-400 hover:text-emerald-600 transition-colors" title="Sesuaikan Stok">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="text-slate-400 hover:text-cyan-600 transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $products->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="empty-state-title">Belum ada produk</p>
                    <p class="empty-state-text">Tambahkan produk untuk mulai mengelola inventori</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
