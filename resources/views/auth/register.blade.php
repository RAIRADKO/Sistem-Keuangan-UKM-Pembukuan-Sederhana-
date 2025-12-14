<x-guest-layout>
    <div class="animate-fade-in" x-data="{ showTermsModal: false, showPrivacyModal: false }">
        <!-- Mobile Logo -->
        <div class="lg:hidden flex items-center justify-center gap-2 mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-xl shadow-lg shadow-cyan-200 object-cover">
            <span class="text-xl font-bold text-slate-900 dark:text-white">UMKM Keuangan</span>
        </div>

        <!-- Card Container -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl shadow-slate-200/50 dark:shadow-slate-900/50 p-5 lg:p-6 border border-slate-100 dark:border-slate-700">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl mb-3 shadow-lg shadow-emerald-200/50">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Buat Akun Baru</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Mulai kelola keuangan usaha Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <!-- Name -->
                <div class="space-y-1">
                    <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                        Nama Lengkap
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="block w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:ring-0 focus:border-cyan-500 focus:bg-white dark:focus:bg-slate-800 transition-all duration-200"
                               placeholder="John Doe">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                        Email
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="block w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:ring-0 focus:border-cyan-500 focus:bg-white dark:focus:bg-slate-800 transition-all duration-200"
                               placeholder="nama@email.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                        Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="block w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:ring-0 focus:border-cyan-500 focus:bg-white dark:focus:bg-slate-800 transition-all duration-200"
                               placeholder="Min. 8 karakter">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                        Konfirmasi Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="block w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 focus:ring-0 focus:border-cyan-500 focus:bg-white dark:focus:bg-slate-800 transition-all duration-200"
                               placeholder="Ulangi password">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-start gap-2 pt-1">
                    <input id="terms" type="checkbox" name="terms" required
                           class="w-4 h-4 mt-0.5 rounded border border-slate-300 dark:border-slate-600 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-0 dark:bg-slate-700 transition-colors">
                    <label for="terms" class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Saya setuju dengan <button type="button" @click="showTermsModal = true" class="font-semibold text-cyan-600 dark:text-cyan-400 hover:underline">Syarat & Ketentuan</button> dan <button type="button" @click="showPrivacyModal = true" class="font-semibold text-cyan-600 dark:text-cyan-400 hover:underline">Kebijakan Privasi</button>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full py-2.5 px-4 text-sm text-white font-semibold rounded-lg shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl active:scale-[0.98]" 
                        style="background: linear-gradient(135deg, #10B981 0%, #0D9488 100%); box-shadow: 0 8px 20px -5px rgba(16, 185, 129, 0.4);">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Daftar Sekarang
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-4">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-3 bg-white dark:bg-slate-800 text-slate-500">sudah punya akun?</span>
                </div>
            </div>

            <!-- Login Link -->
            <a href="{{ route('login') }}" class="block w-full py-2.5 px-4 text-center text-sm font-semibold rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 transition-all duration-200">
                Masuk ke Akun
            </a>
        </div>

        <!-- Footer -->
        <p class="mt-8 text-center text-sm text-slate-500">
            © {{ date('Y') }} UMKM Keuangan. Kelola keuangan dengan mudah.
        </p>

        <!-- Terms Modal - Using Teleport to Body -->
        <template x-teleport="body">
            <div x-show="showTermsModal" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] overflow-y-auto"
                 @keydown.escape.window="showTermsModal = false">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showTermsModal = false"></div>
                
                <!-- Modal Container -->
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <div x-show="showTermsModal"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.stop
                         class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
                        
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-gradient-to-r from-cyan-500 to-teal-500 flex-shrink-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Syarat dan Ketentuan</h3>
                            </div>
                            <button @click="showTermsModal = false" class="p-2 hover:bg-white/20 rounded-xl transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Modal Content -->
                        <div class="flex-1 overflow-y-auto p-6">
                            <div class="text-slate-700 dark:text-slate-300 space-y-4">
                                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Sistem Keuangan UMKM - Pembukuan Sederhana</p>
                                
                                <div class="space-y-4 text-sm">
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">1. Ketentuan Umum</h4>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Syarat dan Ketentuan ini mengatur penggunaan aplikasi Sistem Keuangan UMKM - Pembukuan Sederhana ("Aplikasi") yang disediakan untuk membantu pelaku usaha mikro, kecil, dan menengah dalam mengelola pembukuan keuangan. Dengan mengakses dan menggunakan Aplikasi ini, Anda menyetujui untuk terikat dengan seluruh ketentuan yang berlaku.</p>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">2. Definisi</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li><strong>"Pengguna":</strong> Individu atau badan usaha yang mendaftar dan menggunakan layanan Aplikasi</li>
                                            <li><strong>"Layanan":</strong> Seluruh fitur dan fungsi yang tersedia dalam Aplikasi</li>
                                            <li><strong>"Data":</strong> Informasi yang diinput, disimpan, dan diproses melalui Aplikasi</li>
                                            <li><strong>"Akun":</strong> Akses pribadi Pengguna untuk menggunakan Layanan</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">3. Pendaftaran dan Akun</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Pengguna wajib berusia minimal 18 tahun atau telah dewasa menurut hukum Indonesia</li>
                                            <li>Pengguna bertanggung jawab untuk memberikan informasi yang akurat dan lengkap saat registrasi</li>
                                            <li>Pengguna wajib menjaga kerahasiaan password</li>
                                            <li>Satu akun hanya untuk satu pengguna</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">4. Penggunaan Layanan</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Menggunakan Aplikasi hanya untuk tujuan yang sah</li>
                                            <li>Tidak menggunakan untuk kegiatan yang melanggar hukum</li>
                                            <li>Tidak melakukan tindakan yang dapat merusak sistem</li>
                                            <li>Bertanggung jawab atas keakuratan data yang diinput</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">5. Kepemilikan Data</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Pengguna memiliki hak penuh atas data bisnis yang diinput</li>
                                            <li>Kami tidak akan menggunakan data untuk kepentingan komersial tanpa persetujuan</li>
                                            <li>Seluruh kode sumber dan fitur adalah hak kekayaan intelektual pengembang</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">6. Keamanan Data</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Kami menggunakan enkripsi standar industri</li>
                                            <li>Pengguna disarankan untuk mengekspor data secara berkala</li>
                                            <li>Kami tidak bertanggung jawab atas kehilangan data akibat kelalaian Pengguna</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">7. Batasan Tanggung Jawab</h4>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Kami tidak bertanggung jawab atas kerugian finansial, keputusan bisnis berdasarkan laporan aplikasi, kesalahan input data, atau gangguan layanan.</p>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">8-12. Ketentuan Lainnya</h4>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Kami berhak melakukan pemeliharaan dan pembaruan layanan. Syarat dan Ketentuan ini diatur berdasarkan hukum Republik Indonesia. Untuk pertanyaan, silakan hubungi kami melalui informasi kontak dalam Aplikasi.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 flex-shrink-0">
                            <button @click="showTermsModal = false" class="w-full py-3 px-6 bg-gradient-to-r from-cyan-500 to-teal-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-200">
                                Saya Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Privacy Modal - Using Teleport to Body -->
        <template x-teleport="body">
            <div x-show="showPrivacyModal" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] overflow-y-auto"
                 @keydown.escape.window="showPrivacyModal = false">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showPrivacyModal = false"></div>
                
                <!-- Modal Container -->
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <div x-show="showPrivacyModal"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.stop
                         class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden">
                        
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-gradient-to-r from-violet-500 to-purple-500 flex-shrink-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Kebijakan Privasi</h3>
                            </div>
                            <button @click="showPrivacyModal = false" class="p-2 hover:bg-white/20 rounded-xl transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Modal Content -->
                        <div class="flex-1 overflow-y-auto p-6">
                            <div class="text-slate-700 dark:text-slate-300 space-y-4">
                                <div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Sistem Keuangan UMKM - Pembukuan Sederhana</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Terakhir diperbarui: {{ date('d F Y') }}</p>
                                </div>
                                
                                <div class="space-y-4 text-sm">
                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">1. Pendahuluan</h4>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi data pribadi Anda sesuai dengan UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi.</p>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">2. Data yang Dikumpulkan</h4>
                                        <p class="font-medium text-slate-700 dark:text-slate-300 mb-1">A. Data Langsung:</p>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400 mb-2">
                                            <li>Informasi Akun: Nama, email, password (terenkripsi)</li>
                                            <li>Informasi Usaha: Nama toko, alamat, jenis usaha</li>
                                            <li>Data Transaksi dan Keuangan</li>
                                        </ul>
                                        <p class="font-medium text-slate-700 dark:text-slate-300 mb-1">B. Data Otomatis:</p>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Informasi perangkat dan browser</li>
                                            <li>Log aktivitas dan cookies</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">3. Tujuan Penggunaan</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Menyediakan layanan pencatatan keuangan</li>
                                            <li>Menghasilkan laporan keuangan</li>
                                            <li>Mengelola akun dan autentikasi</li>
                                            <li>Meningkatkan kualitas layanan</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">4. Keamanan Data</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Enkripsi SSL/TLS</li>
                                            <li>Password dalam bentuk hash</li>
                                            <li>Akses terbatas untuk personel berwenang</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">5. Pembagian Data</h4>
                                        <p class="text-red-600 dark:text-red-400 font-semibold mb-2">Kami TIDAK menjual data Anda kepada pihak ketiga.</p>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Data hanya dibagikan dengan persetujuan Anda, kepada penyedia layanan dengan perjanjian kerahasiaan, atau jika diwajibkan hukum.</p>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">6. Hak Pengguna</h4>
                                        <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-slate-400">
                                            <li>Mengakses dan memperbaiki data</li>
                                            <li>Meminta penghapusan data</li>
                                            <li>Mengekspor data (PDF, CSV)</li>
                                            <li>Menarik persetujuan kapan saja</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">7-13. Ketentuan Lainnya</h4>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">Kami menggunakan cookies untuk sesi login dan preferensi. Data disimpan selama akun aktif. Layanan tidak untuk pengguna di bawah 18 tahun. Untuk pertanyaan, hubungi kami melalui informasi dalam Aplikasi.</p>
                                    </div>
                                </div>

                                <div class="mt-4 p-4 bg-slate-100 dark:bg-slate-700 rounded-xl">
                                    <p class="text-sm text-slate-600 dark:text-slate-300 text-center">Dengan menggunakan Aplikasi ini, Anda menyatakan telah membaca, memahami, dan menyetujui Syarat & Ketentuan serta Kebijakan Privasi ini.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 flex-shrink-0">
                            <button @click="showPrivacyModal = false" class="w-full py-3 px-6 bg-gradient-to-r from-violet-500 to-purple-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-200">
                                Saya Mengerti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-guest-layout>
