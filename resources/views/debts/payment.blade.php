<x-app-layout>
    <div class="page-container max-w-2xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('debts.show', $debt) }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Catat Pembayaran</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $debt->contact->name }} - {{ $debt->type_label }}</p>
                </div>
            </div>
        </div>

        <!-- Debt Summary -->
        <div class="card mb-6 animate-fade-in-up" style="opacity: 0; animation-delay: 0.05s;">
            <div class="p-6">
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($debt->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-emerald-600 dark:text-emerald-400">Dibayar</p>
                        <p class="text-lg font-bold text-emerald-700 dark:text-emerald-300">Rp {{ number_format($debt->paid_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-rose-600 dark:text-rose-400">Sisa</p>
                        <p class="text-lg font-bold text-rose-700 dark:text-rose-300">Rp {{ number_format($debt->remaining_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('debts.payment.store', $debt) }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="amount" class="form-label">Jumlah Pembayaran <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $debt->remaining_amount) }}" required min="1" max="{{ $debt->remaining_amount }}"
                               class="form-input pl-12 @error('amount') border-rose-500 @enderror"
                               placeholder="0">
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Maksimal: Rp {{ number_format($debt->remaining_amount, 0, ',', '.') }}</p>
                    @error('amount')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="payment_date" class="form-label">Tanggal Pembayaran <span class="text-rose-500">*</span></label>
                    <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required
                           class="form-input @error('payment_date') border-rose-500 @enderror">
                    @error('payment_date')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea id="notes" name="notes" rows="2"
                              class="form-input @error('notes') border-rose-500 @enderror"
                              placeholder="Catatan pembayaran (opsional)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <label class="flex items-start gap-3">
                        <input type="checkbox" name="create_transaction" value="1" checked
                               class="w-4 h-4 mt-0.5 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
                        <div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Buat transaksi otomatis</span>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Pembayaran akan dicatat sebagai transaksi
                                {{ $debt->type === 'payable' ? 'pengeluaran' : 'pemasukan' }}
                            </p>
                        </div>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('debts.show', $debt) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
