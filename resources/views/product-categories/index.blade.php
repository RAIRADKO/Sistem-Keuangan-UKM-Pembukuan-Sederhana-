<x-app-layout>
    <div class="page-container max-w-4xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('products.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="page-title">Kategori Produk</h1>
                        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">{{ $store->name }}</p>
                    </div>
                </div>
                <a href="{{ route('product-categories.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            @if($categories->count() > 0)
                <div class="table-container border-0 rounded-t-2xl">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Jumlah Produk</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($categories as $category)
                                <tr>
                                    <td class="font-medium text-slate-900 dark:text-slate-100">
                                        {{ $category->name }}
                                    </td>
                                    <td class="text-slate-600 dark:text-slate-400 max-w-xs truncate">
                                        {{ $category->description ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                            {{ $category->products_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $category->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('product-categories.edit', $category) }}" class="text-slate-400 hover:text-cyan-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('product-categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $categories->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada kategori</p>
                    <p class="empty-state-text">Buat kategori untuk mengorganisir produk Anda</p>
                    <a href="{{ route('product-categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
