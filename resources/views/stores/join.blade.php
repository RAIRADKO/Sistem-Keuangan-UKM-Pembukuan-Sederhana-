<x-app-layout>
    <div class="page-container animate-fade-in">
        <div class="max-w-xl mx-auto">
            <!-- Page Header -->
            <div class="page-header text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-purple-400 to-violet-500 rounded-2xl mb-4 shadow-lg shadow-purple-200/50 dark:shadow-purple-900/30">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h1 class="page-title">Gabung ke Toko</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Masukkan kode undangan dari pemilik toko</p>
            </div>

            <!-- Form Card -->
            <div class="card mt-6">
                <div class="card-body">
                    <form method="POST" action="{{ route('stores.join.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="invite_code" class="form-label">Kode Undangan</label>
                            <div class="relative">
                                <input id="invite_code" 
                                       type="text" 
                                       name="invite_code" 
                                       value="{{ old('invite_code') }}" 
                                       class="form-input text-center text-2xl tracking-[0.3em] font-mono uppercase" 
                                       required 
                                       autofocus 
                                       maxlength="8"
                                       placeholder="XXXXXXXX"
                                       style="letter-spacing: 0.3em;">
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                                Minta kode undangan 8 karakter dari pemilik toko
                            </p>
                            <x-input-error :messages="$errors->get('invite_code')" class="mt-2" />
                        </div>

                        <!-- Info Box -->
                        <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-amber-700 dark:text-amber-300">
                                    <p class="font-semibold mb-1">Perhatian</p>
                                    <p>Dengan bergabung, Anda akan menjadi <strong>Kasir</strong> di toko tersebut dengan akses terbatas untuk mencatat transaksi.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-6">
                            @if($hasStores)
                                <a href="{{ route('stores.index') }}" class="btn btn-secondary flex-1">Batal</a>
                            @else
                                <a href="{{ route('stores.select') }}" class="btn btn-secondary flex-1">Kembali</a>
                            @endif
                            <button type="submit" class="btn btn-primary flex-1">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Gabung ke Toko
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
