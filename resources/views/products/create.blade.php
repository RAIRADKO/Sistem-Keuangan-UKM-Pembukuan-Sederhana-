<x-app-layout>
    <div class="page-container max-w-2xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Tambah Produk</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $store->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('products.store') }}" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="name" class="form-label">Nama Produk <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                               class="form-input @error('name') border-rose-500 @enderror"
                               placeholder="Nama produk">
                        @error('name')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sku" class="form-label">SKU / Kode</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                               class="form-input @error('sku') border-rose-500 @enderror"
                               placeholder="PRD-001">
                        @error('sku')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="form-label">Kategori</label>
                        <select id="category_id" name="category_id" class="form-input @error('category_id') border-rose-500 @enderror">
                            <option value="">Tanpa Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="purchase_price" class="form-label">Harga Beli <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                            <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', 0) }}" required min="0"
                                   class="form-input pl-12 @error('purchase_price') border-rose-500 @enderror">
                        </div>
                        @error('purchase_price')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="selling_price" class="form-label">Harga Jual <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                            <input type="number" id="selling_price" name="selling_price" value="{{ old('selling_price', 0) }}" required min="0"
                                   class="form-input pl-12 @error('selling_price') border-rose-500 @enderror">
                        </div>
                        @error('selling_price')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stock_quantity" class="form-label">Stok Awal <span class="text-rose-500">*</span></label>
                        <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required min="0"
                               class="form-input @error('stock_quantity') border-rose-500 @enderror">
                        @error('stock_quantity')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="min_stock_alert" class="form-label">Minimal Stok (Peringatan)</label>
                        <input type="number" id="min_stock_alert" name="min_stock_alert" value="{{ old('min_stock_alert', 0) }}" min="0"
                               class="form-input @error('min_stock_alert') border-rose-500 @enderror">
                        <p class="mt-1 text-xs text-slate-500">Akan ditandai jika stok dibawah angka ini</p>
                        @error('min_stock_alert')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                              class="form-input @error('description') border-rose-500 @enderror"
                              placeholder="Deskripsi produk (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
