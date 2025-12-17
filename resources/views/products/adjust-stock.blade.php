<x-app-layout>
    <div class="page-container max-w-2xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('products.show', $product) }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Sesuaikan Stok</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $product->name }}</p>
                </div>
            </div>
        </div>

        <!-- Current Stock -->
        <div class="card mb-6 animate-fade-in-up" style="opacity: 0; animation-delay: 0.05s;">
            <div class="p-6 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">Stok Saat Ini</p>
                <p class="text-4xl font-bold {{ $product->stock_quantity <= 0 ? 'text-rose-600' : ($product->is_low_stock ? 'text-amber-600' : 'text-emerald-600') }}">
                    {{ $product->stock_quantity }}
                </p>
            </div>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('products.adjust-stock', $product) }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <label class="form-label">Tipe Penyesuaian <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-3 gap-3 mt-2">
                        <label class="flex items-center justify-center p-4 rounded-xl border-2 cursor-pointer transition-all
                            {{ old('adjustment_type', 'in') === 'in' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20' : 'border-slate-200 dark:border-slate-700 hover:border-emerald-300' }}">
                            <input type="radio" name="adjustment_type" value="in" class="sr-only" {{ old('adjustment_type', 'in') === 'in' ? 'checked' : '' }}>
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto text-emerald-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                </svg>
                                <span class="font-medium text-slate-700 dark:text-slate-300">Stok Masuk</span>
                            </div>
                        </label>
                        <label class="flex items-center justify-center p-4 rounded-xl border-2 cursor-pointer transition-all
                            {{ old('adjustment_type') === 'out' ? 'border-rose-500 bg-rose-50 dark:bg-rose-900/20' : 'border-slate-200 dark:border-slate-700 hover:border-rose-300' }}">
                            <input type="radio" name="adjustment_type" value="out" class="sr-only" {{ old('adjustment_type') === 'out' ? 'checked' : '' }}>
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto text-rose-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                </svg>
                                <span class="font-medium text-slate-700 dark:text-slate-300">Stok Keluar</span>
                            </div>
                        </label>
                        <label class="flex items-center justify-center p-4 rounded-xl border-2 cursor-pointer transition-all
                            {{ old('adjustment_type') === 'set' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-slate-200 dark:border-slate-700 hover:border-blue-300' }}">
                            <input type="radio" name="adjustment_type" value="set" class="sr-only" {{ old('adjustment_type') === 'set' ? 'checked' : '' }}>
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="font-medium text-slate-700 dark:text-slate-300">Set Stok</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="quantity" class="form-label">Jumlah <span class="text-rose-500">*</span></label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" required min="1"
                           class="form-input @error('quantity') border-rose-500 @enderror">
                    @error('quantity')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea id="notes" name="notes" rows="2"
                              class="form-input @error('notes') border-rose-500 @enderror"
                              placeholder="Alasan penyesuaian stok (opsional)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="adjustment_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('input[name="adjustment_type"]').forEach(r => {
                    const label = r.closest('label');
                    label.classList.remove('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-900/20');
                    label.classList.remove('border-rose-500', 'bg-rose-50', 'dark:bg-rose-900/20');
                    label.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                    label.classList.add('border-slate-200', 'dark:border-slate-700');
                });
                const label = this.closest('label');
                label.classList.remove('border-slate-200', 'dark:border-slate-700');
                if (this.value === 'in') {
                    label.classList.add('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-900/20');
                } else if (this.value === 'out') {
                    label.classList.add('border-rose-500', 'bg-rose-50', 'dark:bg-rose-900/20');
                } else {
                    label.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                }
            });
        });
    </script>
</x-app-layout>
