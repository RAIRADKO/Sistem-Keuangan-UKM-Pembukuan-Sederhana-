<x-app-layout>
    <div class="page-container animate-fade-in">
        <div class="max-w-2xl mx-auto">
            <!-- Page Header -->
            <div class="page-header text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-cyan-400 to-teal-500 rounded-2xl mb-4 shadow-lg shadow-cyan-200/50 dark:shadow-cyan-900/30">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h1 class="page-title text-2xl font-bold text-slate-900 dark:text-white">Selamat Datang!</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Pilih cara untuk memulai mengelola keuangan usaha Anda</p>
            </div>

            <!-- Info Alert -->
            @if(session('info'))
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl text-blue-700 dark:text-blue-300 text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('info') }}
                    </div>
                </div>
            @endif

            <!-- Options Grid -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Create Store Option -->
                <a href="{{ route('stores.create') }}" class="group block">
                    <div class="card h-full p-6 hover:shadow-xl hover:shadow-cyan-100/30 dark:hover:shadow-cyan-900/20 transition-all duration-300 border-2 border-transparent hover:border-cyan-400 dark:hover:border-cyan-500">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-green-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-200/50 dark:shadow-emerald-900/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Buat Toko Baru</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Buat toko baru dan menjadi pemilik (Owner) dengan akses penuh</p>
                            <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1 text-left">
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Akses penuh sebagai Owner
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Dapat mengundang anggota tim
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Kode undangan unik untuk tim
                                </li>
                            </ul>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <span class="flex items-center justify-center gap-2 text-cyan-600 dark:text-cyan-400 font-semibold group-hover:gap-3 transition-all">
                                Buat Toko
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Join Store Option -->
                <a href="{{ route('stores.join') }}" class="group block">
                    <div class="card h-full p-6 hover:shadow-xl hover:shadow-purple-100/30 dark:hover:shadow-purple-900/20 transition-all duration-300 border-2 border-transparent hover:border-purple-400 dark:hover:border-purple-500">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-violet-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-purple-200/50 dark:shadow-purple-900/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Gabung ke Toko</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Masukkan kode undangan untuk bergabung sebagai Kasir</p>
                            <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-1 text-left">
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Gunakan kode dari pemilik toko
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Akses sebagai Kasir
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Dapat mencatat transaksi
                                </li>
                            </ul>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <span class="flex items-center justify-center gap-2 text-purple-600 dark:text-purple-400 font-semibold group-hover:gap-3 transition-all">
                                Gabung dengan Kode
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Footer Note -->
            <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                <p>Anda dapat mengelola beberapa toko sekaligus setelah membuat atau bergabung ke toko pertama.</p>
            </div>
        </div>
    </div>
</x-app-layout>
