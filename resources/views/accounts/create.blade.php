<x-app-layout>
    <div class="page-container animate-fade-in">
        <div class="max-w-xl mx-auto">
            <!-- Page Header -->
            <div class="page-header text-center">
                <h1 class="page-title">Tambah Kategori</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Buat kategori untuk mengelompokkan transaksi</p>
            </div>

            <!-- Form Card -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('accounts.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" 
                                   class="form-input" required autofocus 
                                   placeholder="Contoh: Penjualan, Gaji Pegawai">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tipe Kategori</label>
                            <div class="grid grid-cols-2 gap-3 mt-2">
                                <label class="relative">
                                    <input type="radio" name="type" value="income" {{ old('type', 'income') === 'income' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">Pemasukan</p>
                                                <p class="text-xs text-gray-500">Uang masuk</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio" name="type" value="expense" {{ old('type') === 'expense' ? 'checked' : '' }} class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer transition-all peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">Pengeluaran</p>
                                                <p class="text-xs text-gray-500">Uang keluar</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Deskripsi <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea id="description" name="description" rows="2" 
                                      class="form-input resize-none" 
                                      placeholder="Keterangan tambahan...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex gap-3 pt-4">
                            <a href="{{ route('accounts.index') }}" class="btn btn-secondary flex-1">Batal</a>
                            <button type="submit" class="btn btn-primary flex-1">Simpan Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
