<x-app-layout>
    <div class="page-container animate-fade-in">
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="page-title">Toko Saya</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Kelola semua toko Anda</p>
                </div>
                <a href="{{ route('stores.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Toko
                </a>
            </div>
        </div>

        <!-- Stores Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($stores as $store)
                <div class="card group hover:shadow-md transition-shadow {{ session('current_store_id') == $store->id ? 'ring-2 ring-indigo-500' : '' }}">
                    <div class="card-body">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $store->name }}
                                </h3>
                                @if($store->business_type)
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $store->business_type }}</p>
                                @endif
                            </div>
                            @if(session('current_store_id') == $store->id)
                                <span class="badge badge-info">Aktif</span>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="space-y-2 mb-6 text-sm text-gray-600 dark:text-gray-400">
                            @if($store->address)
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 mt-0.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $store->address }}</span>
                                </div>
                            @endif
                            @if($store->phone)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $store->phone }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="flex gap-4 py-4 border-t border-b border-gray-100 dark:border-gray-700 mb-4">
                            <div class="text-center flex-1">
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $store->transactions_count }}</p>
                                <p class="text-xs text-gray-500">Transaksi</p>
                            </div>
                            <div class="text-center flex-1">
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $store->accounts_count }}</p>
                                <p class="text-xs text-gray-500">Kategori</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('stores.switch', $store) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="btn {{ session('current_store_id') == $store->id ? 'btn-secondary' : 'btn-primary' }} w-full">
                                    {{ session('current_store_id') == $store->id ? 'Toko Aktif' : 'Pilih Toko' }}
                                </button>
                            </form>
                            <a href="{{ route('stores.edit', $store) }}" class="btn btn-ghost">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="card">
                        <div class="empty-state">
                            <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <p class="empty-state-title">Belum ada toko</p>
                            <p class="empty-state-text">Buat toko pertama Anda untuk mulai mencatat keuangan</p>
                            <a href="{{ route('stores.create') }}" class="btn btn-primary">Tambah Toko</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
