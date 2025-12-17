<x-app-layout>
    <div class="page-container max-w-xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('stores.team.index', $store) }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Undang Anggota Tim</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $store->name }}</p>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="mb-6 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.05s;">
            <p class="text-sm text-blue-700 dark:text-blue-300">
                <strong>Catatan:</strong> Pengguna yang diundang harus sudah memiliki akun di sistem. Masukkan email akun mereka untuk menambahkan ke tim.
            </p>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('stores.team.invite', $store) }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="email" class="form-label">Email Pengguna <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="form-input @error('email') border-rose-500 @enderror"
                           placeholder="email@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="form-label">Role <span class="text-rose-500">*</span></label>
                    <select id="role" name="role" required class="form-input @error('role') border-rose-500 @enderror">
                        <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="kasir" {{ old('role', 'kasir') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role descriptions -->
                <div class="space-y-3">
                    <div class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800">
                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Manager</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">Dapat mengelola transaksi, produk, stok, hutang/piutang, dan melihat semua laporan.</p>
                    </div>
                    <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Kasir</p>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">Dapat mencatat transaksi, melihat produk, dan mencatat pembayaran hutang/piutang.</p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('stores.team.index', $store) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Undang</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
