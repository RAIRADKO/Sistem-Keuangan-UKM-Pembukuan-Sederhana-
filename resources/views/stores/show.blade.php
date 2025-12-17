<x-app-layout>
    <div class="page-container max-w-4xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-500 to-teal-500 flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-cyan-200/50 dark:shadow-cyan-900/30">
                        {{ strtoupper(substr($store->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $store->name }}</h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="badge badge-info">{{ $store->business_type ?? 'Umum' }}</span>
                            @if(Auth::user()->isOwnerOf($store))
                                <span class="badge badge-purple">Owner</span>
                            @else
                                <span class="badge badge-secondary">Kasir</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if(Auth::user()->isOwnerOf($store))
                        <a href="{{ route('stores.edit', $store) }}" class="btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Toko
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s;">
            <!-- Main Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Info Card -->
                <div class="card p-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Toko
                    </h3>
                    
                    <div class="grid gap-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-500 dark:text-slate-400">Nomor Telepon</label>
                                <p class="text-slate-900 dark:text-white font-medium mt-1">
                                    {{ $store->phone ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500 dark:text-slate-400">Tanggal Bergabung</label>
                                <p class="text-slate-900 dark:text-white font-medium mt-1">
                                    {{ $store->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-slate-500 dark:text-slate-400">Alamat</label>
                            <p class="text-slate-900 dark:text-white mt-1 leading-relaxed">
                                {{ $store->address ?? 'Alamat belum diisi' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Invite Karyawan Banner -->
                @if(Auth::user()->isOwnerOf($store))
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 p-8 shadow-xl">
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="text-white text-center md:text-left">
                            <h3 class="text-xl font-bold mb-2">Butuh Bantuan Mengelola Toko?</h3>
                            <p class="text-purple-100 max-w-md">Undang karyawan untuk bergabung dan bantu catat transaksi. Anda akan mendapatkan kode unik untuk mereka.</p>
                        </div>
                        <a href="{{ route('stores.team.index', $store) }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-bold rounded-xl hover:bg-purple-50 transition-colors shadow-lg group">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Tambah Karyawan
                        </a>
                    </div>
                    
                    <!-- Decorative Circles -->
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-purple-500/20 blur-2xl"></div>
                </div>
                @endif
            </div>

            <!-- Sidebar Stats -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="card p-5">
                    <h4 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Statistik Singkat</h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Total Karyawan</p>
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $store->users()->count() }} User</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Total Transaksi</p>
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $store->transactions()->count() }} Data</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!Auth::user()->isOwnerOf($store))
                <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Akses Terbatas</p>
                            <p class="text-xs text-amber-700 dark:text-amber-300 mt-1">
                                Anda terdaftar sebagai <strong>Kasir</strong> di toko ini. Hubungi Owner jika memerlukan akses lebih.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
