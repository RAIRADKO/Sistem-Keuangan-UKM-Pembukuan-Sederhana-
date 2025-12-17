<x-app-layout>
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="page-title">Kontak</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">{{ $store->name }} - Kelola Supplier & Pelanggan</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('contacts.create', ['type' => 'supplier']) }}" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Supplier
                    </a>
                    <a href="{{ route('contacts.create', ['type' => 'customer']) }}" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Pelanggan
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-8 animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <div class="p-6">
                <form method="GET" action="{{ route('contacts.index') }}" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-input">
                            <option value="">Semua</option>
                            <option value="supplier" {{ request('type') === 'supplier' ? 'selected' : '' }}>Supplier</option>
                            <option value="customer" {{ request('type') === 'customer' ? 'selected' : '' }}>Pelanggan</option>
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
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, telepon..." class="form-input">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="btn btn-primary w-full">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl p-6 border border-blue-100 dark:border-blue-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">Total Supplier</p>
                <p class="text-2xl font-bold text-blue-700 dark:text-blue-300 mt-1">{{ $summary['total_suppliers'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 rounded-2xl p-6 border border-purple-100 dark:border-purple-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.25s;">
                <p class="text-sm font-semibold text-purple-600 dark:text-purple-400">Total Pelanggan</p>
                <p class="text-2xl font-bold text-purple-700 dark:text-purple-300 mt-1">{{ $summary['total_customers'] }}</p>
            </div>
        </div>

        <!-- Contacts Table -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.3s;">
            @if($contacts->count() > 0)
                <div class="table-container border-0 rounded-t-2xl">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($contacts as $contact)
                                <tr>
                                    <td class="font-medium text-slate-900 dark:text-slate-100">
                                        {{ $contact->name }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $contact->type === 'supplier' ? 'badge-info' : 'badge-purple' }}">
                                            {{ $contact->type === 'supplier' ? 'Supplier' : 'Pelanggan' }}
                                        </span>
                                    </td>
                                    <td class="text-slate-600 dark:text-slate-400">
                                        {{ $contact->phone ?? '-' }}
                                    </td>
                                    <td class="text-slate-600 dark:text-slate-400 max-w-xs truncate">
                                        {{ $contact->address ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $contact->is_active ? 'badge-success' : 'badge-secondary' }}">
                                            {{ $contact->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('contacts.show', $contact) }}" class="text-slate-400 hover:text-cyan-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('contacts.edit', $contact) }}" class="text-slate-400 hover:text-cyan-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="inline" onsubmit="return confirm('Hapus kontak ini?')">
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
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada kontak</p>
                    <p class="empty-state-text">Tambahkan supplier atau pelanggan Anda</p>
                    <a href="{{ route('contacts.create') }}" class="btn btn-primary">Tambah Kontak</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
