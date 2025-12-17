<x-app-layout>
    <div class="page-container max-w-xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('product-categories.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Tambah Kategori</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $store->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('product-categories.store') }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="name" class="form-label">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                           class="form-input @error('name') border-rose-500 @enderror"
                           placeholder="Nama kategori">
                    @error('name')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" rows="3"
                              class="form-input @error('description') border-rose-500 @enderror"
                              placeholder="Deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('product-categories.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
