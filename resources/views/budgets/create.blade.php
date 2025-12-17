<x-app-layout>
    <div class="page-container max-w-xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('budgets.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Tambah Anggaran</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $store->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('budgets.store') }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="name" class="form-label">Nama Anggaran <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                           class="form-input @error('name') border-rose-500 @enderror"
                           placeholder="Contoh: Budget Listrik Bulanan">
                    @error('name')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="account_id" class="form-label">Kategori Pengeluaran <span class="text-rose-500">*</span></label>
                    <select id="account_id" name="account_id" required class="form-input @error('account_id') border-rose-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="amount" class="form-label">Limit Anggaran <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                            <input type="number" id="amount" name="amount" value="{{ old('amount') }}" required min="0"
                                   class="form-input pl-12 @error('amount') border-rose-500 @enderror"
                                   placeholder="500000">
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="period" class="form-label">Periode <span class="text-rose-500">*</span></label>
                        <select id="period" name="period" required class="form-input @error('period') border-rose-500 @enderror">
                            <option value="monthly" {{ old('period', 'monthly') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="weekly" {{ old('period') === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="yearly" {{ old('period') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                        @error('period')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="alert_threshold" class="form-label">Threshold Peringatan (%) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" id="alert_threshold" name="alert_threshold" value="{{ old('alert_threshold', 90) }}" required min="1" max="100"
                               class="form-input pr-10 @error('alert_threshold') border-rose-500 @enderror">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">%</span>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Peringatan akan muncul saat pengeluaran mencapai persentase ini</p>
                    @error('alert_threshold')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea id="notes" name="notes" rows="2"
                              class="form-input @error('notes') border-rose-500 @enderror"
                              placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('budgets.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Anggaran</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
