<x-app-layout>
    <div class="page-container max-w-4xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('stores.show', $store) }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="page-title">Tim {{ $store->name }}</h1>
                        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">Kelola anggota tim toko Anda</p>
                    </div>
                </div>
                <a href="{{ route('stores.team.create', $store) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Undang Anggota
                </a>
            </div>
        </div>

        <!-- Team Members -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Anggota Tim</h3>
                
                <div class="space-y-4">
                    @foreach($members as $member)
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-cyan-500 to-teal-500 flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-slate-100">{{ $member->name }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $member->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                @php
                                    $role = $member->pivot->role;
                                    $roleColors = [
                                        'owner' => 'badge-purple',
                                        'manager' => 'badge-info',
                                        'kasir' => 'badge-secondary',
                                    ];
                                    $roleLabels = [
                                        'owner' => 'Pemilik',
                                        'manager' => 'Manager',
                                        'kasir' => 'Kasir',
                                    ];
                                @endphp
                                <span class="badge {{ $roleColors[$role] ?? 'badge-secondary' }}">
                                    {{ $roleLabels[$role] ?? $role }}
                                </span>
                                
                                @if($role !== 'owner')
                                    <div class="flex items-center gap-2">
                                        <!-- Change Role -->
                                        <form method="POST" action="{{ route('stores.team.update-role', [$store, $member]) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" class="form-input py-1 px-2 text-sm">
                                                <option value="manager" {{ $role === 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="kasir" {{ $role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                            </select>
                                        </form>
                                        
                                        <!-- Remove -->
                                        <form method="POST" action="{{ route('stores.team.remove', [$store, $member]) }}" class="inline" onsubmit="return confirm('Hapus {{ $member->name }} dari tim?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors p-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Role Permissions Info -->
        <div class="card animate-fade-in-up mt-6" style="opacity: 0; animation-delay: 0.2s;">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Hak Akses Role</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 rounded-xl bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800">
                        <h4 class="font-semibold text-purple-700 dark:text-purple-300 mb-2">Pemilik</h4>
                        <ul class="text-sm text-purple-600 dark:text-purple-400 space-y-1">
                            <li>✓ Semua akses</li>
                            <li>✓ Kelola tim</li>
                            <li>✓ Hapus transaksi</li>
                            <li>✓ Laporan laba rugi</li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                        <h4 class="font-semibold text-blue-700 dark:text-blue-300 mb-2">Manager</h4>
                        <ul class="text-sm text-blue-600 dark:text-blue-400 space-y-1">
                            <li>✓ Kelola transaksi</li>
                            <li>✓ Kelola produk & stok</li>
                            <li>✓ Kelola hutang/piutang</li>
                            <li>✓ Lihat semua laporan</li>
                        </ul>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-2">Kasir</h4>
                        <ul class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                            <li>✓ Catat transaksi</li>
                            <li>✓ Lihat produk</li>
                            <li>✓ Catat pembayaran hutang</li>
                            <li>✓ Laporan dasar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
