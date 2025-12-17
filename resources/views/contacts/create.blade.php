<x-app-layout>
    <div class="page-container max-w-2xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('contacts.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Tambah {{ $type === 'supplier' ? 'Supplier' : 'Pelanggan' }}</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $store->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('contacts.store') }}" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                <div>
                    <label for="name" class="form-label">Nama <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                           class="form-input @error('name') border-rose-500 @enderror"
                           placeholder="Nama {{ $type === 'supplier' ? 'supplier' : 'pelanggan' }}">
                    @error('name')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="form-label">Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                           class="form-input @error('phone') border-rose-500 @enderror"
                           placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="form-label">Alamat</label>
                    <textarea id="address" name="address" rows="3"
                              class="form-input @error('address') border-rose-500 @enderror"
                              placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea id="notes" name="notes" rows="2"
                              class="form-input @error('notes') border-rose-500 @enderror"
                              placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
