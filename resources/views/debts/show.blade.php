<x-app-layout>
    <div class="page-container max-w-4xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('debts.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="page-title">Detail {{ $debt->type_label }}</h1>
                        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $debt->contact->name }}</p>
                    </div>
                </div>
                @if($debt->status !== 'paid')
                    <a href="{{ route('debts.payment.form', $debt) }}" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Catat Pembayaran
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Debt Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Summary Card -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <span class="badge {{ $debt->type === 'payable' ? 'badge-danger' : 'badge-success' }} mb-2">
                                    {{ $debt->type_label }}
                                </span>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
                                    Rp {{ number_format($debt->total_amount, 0, ',', '.') }}
                                </h3>
                            </div>
                            <span class="badge badge-{{ $debt->status_color }} text-base px-4 py-2">
                                {{ $debt->status_label }}
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-500">Progres Pembayaran</span>
                                <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $debt->payment_progress }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-cyan-500 to-teal-500 h-3 rounded-full transition-all duration-500" style="width: {{ $debt->payment_progress }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                                <p class="text-sm text-slate-500 dark:text-slate-400">Total</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($debt->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                <p class="text-sm text-emerald-600 dark:text-emerald-400">Dibayar</p>
                                <p class="text-lg font-bold text-emerald-700 dark:text-emerald-300">Rp {{ number_format($debt->paid_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-center p-4 bg-rose-50 dark:bg-rose-900/20 rounded-xl">
                                <p class="text-sm text-rose-600 dark:text-rose-400">Sisa</p>
                                <p class="text-lg font-bold text-rose-700 dark:text-rose-300">Rp {{ number_format($debt->remaining_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Riwayat Pembayaran</h3>

                        @if($debt->payments->count() > 0)
                            <div class="space-y-4">
                                @foreach($debt->payments as $payment)
                                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800 rounded-xl">
                                        <div>
                                            <p class="font-semibold text-emerald-600 dark:text-emerald-400">
                                                + Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                            </p>
                                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                                {{ $payment->payment_date->format('d M Y') }} • oleh {{ $payment->user->name }}
                                            </p>
                                            @if($payment->notes)
                                                <p class="text-sm text-slate-600 dark:text-slate-300 mt-1">{{ $payment->notes }}</p>
                                            @endif
                                        </div>
                                        @if($payment->transaction)
                                            <a href="{{ route('transactions.show', $payment->transaction) }}" class="text-cyan-600 hover:text-cyan-700 text-sm">
                                                Lihat Transaksi
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 dark:text-slate-400 text-center py-8">Belum ada pembayaran</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Detail Info -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.15s;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Informasi</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">{{ $debt->type === 'payable' ? 'Supplier' : 'Pelanggan' }}</dt>
                                <dd class="text-slate-900 dark:text-slate-100 font-medium">
                                    <a href="{{ route('contacts.show', $debt->contact) }}" class="text-cyan-600 hover:text-cyan-700">
                                        {{ $debt->contact->name }}
                                    </a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Tanggal</dt>
                                <dd class="text-slate-900 dark:text-slate-100">{{ $debt->debt_date->format('d M Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Jatuh Tempo</dt>
                                <dd class="{{ $debt->is_overdue ? 'text-rose-600 dark:text-rose-400 font-semibold' : 'text-slate-900 dark:text-slate-100' }}">
                                    {{ $debt->due_date ? $debt->due_date->format('d M Y') : '-' }}
                                    @if($debt->is_overdue)
                                        <span class="text-xs">(Lewat)</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-slate-500 dark:text-slate-400">Dicatat oleh</dt>
                                <dd class="text-slate-900 dark:text-slate-100">{{ $debt->user->name }}</dd>
                            </div>
                            @if($debt->description)
                                <div>
                                    <dt class="text-sm text-slate-500 dark:text-slate-400">Keterangan</dt>
                                    <dd class="text-slate-900 dark:text-slate-100">{{ $debt->description }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.25s;">
                    <div class="p-6 space-y-3">
                        <a href="{{ route('debts.edit', $debt) }}" class="btn btn-secondary w-full">Edit</a>
                        @if($debt->payments->count() === 0)
                            <form method="POST" action="{{ route('debts.destroy', $debt) }}" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-full">Hapus</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
