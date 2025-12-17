<x-app-layout>
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="page-title">Anggaran (Budget)</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">{{ $store->name }} - Kontrol pengeluaran per kategori</p>
                </div>
                <a href="{{ route('budgets.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Anggaran
                </a>
            </div>
        </div>

        <!-- Alert Summary -->
        @if($alertedBudgets->count() > 0)
            <div class="mb-8 animate-fade-in-up" style="opacity: 0; animation-delay: 0.05s;">
                <div class="bg-gradient-to-r from-rose-50 to-amber-50 dark:from-rose-900/30 dark:to-amber-900/30 rounded-2xl p-6 border border-rose-200 dark:border-rose-800">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-rose-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-rose-800 dark:text-rose-300">Peringatan Anggaran!</h3>
                            <p class="text-rose-700 dark:text-rose-400 mt-1">{{ $alertedBudgets->count() }} anggaran sudah mendekati atau melebihi batas.</p>
                            <div class="mt-3 space-y-2">
                                @foreach($alertedBudgets as $budget)
                                    <div class="flex items-center gap-3 text-sm">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $budget->is_exceeded ? 'bg-rose-200 text-rose-800 dark:bg-rose-800 dark:text-rose-200' : 'bg-amber-200 text-amber-800 dark:bg-amber-800 dark:text-amber-200' }}">
                                            {{ $budget->usage_percentage }}%
                                        </span>
                                        <span class="text-rose-700 dark:text-rose-300 font-medium">{{ $budget->name }}</span>
                                        <span class="text-rose-600 dark:text-rose-400">
                                            Rp {{ number_format($budget->spent_amount, 0, ',', '.') }} / Rp {{ number_format($budget->amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Budgets Grid -->
        @if($budgets->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
                @foreach($budgets as $budget)
                    <div class="card p-6 {{ !$budget->is_active ? 'opacity-60' : '' }}">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="font-semibold text-slate-900 dark:text-slate-100">{{ $budget->name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $budget->account->name }} • {{ $budget->period_label }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('budgets.edit', $budget) }}" class="text-slate-400 hover:text-cyan-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('budgets.destroy', $budget) }}" class="inline" onsubmit="return confirm('Hapus anggaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-600 dark:text-slate-400">Terpakai</span>
                                <span class="font-semibold {{ $budget->is_exceeded ? 'text-rose-600' : ($budget->is_alert_triggered ? 'text-amber-600' : 'text-slate-900 dark:text-slate-100') }}">
                                    {{ $budget->usage_percentage }}%
                                </span>
                            </div>
                            <div class="h-3 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500
                                    {{ $budget->is_exceeded ? 'bg-gradient-to-r from-rose-500 to-red-600' : 
                                       ($budget->is_alert_triggered ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 
                                       'bg-gradient-to-r from-emerald-400 to-teal-500') }}"
                                    style="width: {{ min(100, $budget->usage_percentage) }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-slate-500 dark:text-slate-400">Terpakai</p>
                                <p class="font-semibold text-slate-900 dark:text-slate-100">Rp {{ number_format($budget->spent_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 dark:text-slate-400">Limit</p>
                                <p class="font-semibold text-slate-900 dark:text-slate-100">Rp {{ number_format($budget->amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500 dark:text-slate-400">Sisa</p>
                                <p class="font-semibold {{ $budget->remaining_amount > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    Rp {{ number_format($budget->remaining_amount, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-slate-500 dark:text-slate-400">Alert</p>
                                <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $budget->alert_threshold }}%</p>
                            </div>
                        </div>

                        @if(!$budget->is_active)
                            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                                <span class="badge badge-secondary">Non-Aktif</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada anggaran</p>
                    <p class="empty-state-text">Buat anggaran untuk mengontrol pengeluaran per kategori</p>
                    <a href="{{ route('budgets.create') }}" class="btn btn-primary">Tambah Anggaran</a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
