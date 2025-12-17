<x-app-layout>
    <div class="page-container max-w-4xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('products.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="page-title">{{ $product->name }}</h1>
                        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $product->sku ?? 'Tanpa SKU' }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('products.adjust-stock.form', $product) }}" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Sesuaikan Stok
                    </a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary">Edit</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Summary Cards -->
                <div class="grid grid-cols-3 gap-4 animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl p-4 border border-blue-100 dark:border-blue-800 text-center">
                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">Harga Beli</p>
                        <p class="text-lg font-bold text-blue-700 dark:text-blue-300 mt-1">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-2xl p-4 border border-emerald-100 dark:border-emerald-800 text-center">
                        <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">Harga Jual</p>
                        <p class="text-lg font-bold text-emerald-700 dark:text-emerald-300 mt-1">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 rounded-2xl p-4 border border-purple-100 dark:border-purple-800 text-center">
                        <p class="text-sm font-semibold text-purple-600 dark:text-purple-400">Margin</p>
                        <p class="text-lg font-bold text-purple-700 dark:text-purple-300 mt-1">{{ $product->profit_margin_percent }}%</p>
                    </div>
                </div>

                <!-- Stock Movements -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Riwayat Stok</h3>

                        @if($product->stockMovements->count() > 0)
                            <div class="space-y-3">
                                @foreach($product->stockMovements as $movement)
                                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                                {{ $movement->type === 'in' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 
                                                   ($movement->type === 'out' ? 'bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400' : 
                                                   'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400') }}">
                                                @if($movement->type === 'in')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                                    </svg>
                                                @elseif($movement->type === 'out')
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-900 dark:text-slate-100">
                                                    {{ $movement->type_label }}
                                                    <span class="{{ $movement->type === 'in' ? 'text-emerald-600' : ($movement->type === 'out' ? 'text-rose-600' : 'text-blue-600') }}">
                                                        {{ $movement->type === 'in' ? '+' : ($movement->type === 'out' ? '-' : '') }}{{ abs($movement->quantity) }}
                                                    </span>
                                                </p>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                                    {{ $movement->created_at->format('d M Y H:i') }} • {{ $movement->user->name }}
                                                </p>
                                                @if($movement->notes)
                                                    <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">{{ $movement->notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-slate-500">{{ $movement->stock_before }} → {{ $movement->stock_after }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 dark:text-slate-400 text-center py-8">Belum ada pergerakan stok</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Current Stock -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.15s;">
                    <div class="p-6 text-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">Stok Saat Ini</p>
                        <p class="text-4xl font-bold {{ $product->stock_quantity <= 0 ? 'text-rose-600' : ($product->is_low_stock ? 'text-amber-600' : 'text-emerald-600') }}">
                            {{ $product->stock_quantity }}
                        </p>
                        @if($product->is_low_stock)
                            <p class="text-sm text-amber-600 mt-2">⚠️ Stok Rendah</p>
                        @elseif($product->stock_quantity <= 0)
                            <p class="text-sm text-rose-600 mt-2">❌ Stok Habis</p>
                        @endif
                    </div>
                </div>

                <!-- Detail Info -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Informasi</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Kategori</dt>
                                <dd class="text-slate-900 dark:text-slate-100">{{ $product->category?->name ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Minimal Stok</dt>
                                <dd class="text-slate-900 dark:text-slate-100">{{ $product->min_stock_alert }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Status</dt>
                                <dd>
                                    <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </dd>
                            </div>
                            @if($product->description)
                                <div>
                                    <dt class="text-sm text-slate-500 dark:text-slate-400">Deskripsi</dt>
                                    <dd class="text-slate-900 dark:text-slate-100">{{ $product->description }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Sales Summary -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.25s;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Statistik Penjualan</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Unit Terjual</dt>
                                <dd class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ $product->total_units_sold }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Total Pendapatan</dt>
                                <dd class="text-xl font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
