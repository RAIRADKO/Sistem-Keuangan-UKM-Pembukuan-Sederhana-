<x-app-layout>
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="page-title">Hutang & Piutang</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">{{ $store->name }} - Kelola Kasbon</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('debts.create', ['type' => 'payable']) }}" class="btn btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Catat Hutang
                    </a>
                    <a href="{{ route('debts.create', ['type' => 'receivable']) }}" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Catat Piutang
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 dark:from-rose-900/30 dark:to-pink-900/30 rounded-2xl p-6 border border-rose-100 dark:border-rose-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
                <p class="text-sm font-semibold text-rose-600 dark:text-rose-400">Total Hutang Belum Lunas</p>
                <p class="text-2xl font-bold text-rose-700 dark:text-rose-300 mt-1">Rp {{ number_format($summary['total_payable'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-2xl p-6 border border-emerald-100 dark:border-emerald-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.15s;">
                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">Total Piutang Belum Lunas</p>
                <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300 mt-1">Rp {{ number_format($summary['total_receivable'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 rounded-2xl p-6 border border-amber-100 dark:border-amber-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                <p class="text-sm font-semibold text-amber-600 dark:text-amber-400">Jatuh Tempo</p>
                <p class="text-2xl font-bold text-amber-700 dark:text-amber-300 mt-1">{{ $summary['overdue_count'] }} item</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-8 animate-fade-in-up" style="opacity: 0; animation-delay: 0.25s;">
            <div class="p-6">
                <form method="GET" action="{{ route('debts.index') }}" class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-input">
                            <option value="">Semua</option>
                            <option value="payable" {{ request('type') === 'payable' ? 'selected' : '' }}>Hutang</option>
                            <option value="receivable" {{ request('type') === 'receivable' ? 'selected' : '' }}>Piutang</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="">Semua</option>
                            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>Sebagian</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kontak</label>
                        <select name="contact_id" class="form-input">
                            <option value="">Semua</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}" {{ request('contact_id') == $contact->id ? 'selected' : '' }}>{{ $contact->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Deskripsi..." class="form-input">
                    </div>
                    <div class="flex items-end gap-2">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="overdue" value="1" {{ request('overdue') ? 'checked' : '' }} class="rounded">
                            Jatuh Tempo
                        </label>
                        <button type="submit" class="btn btn-primary flex-1">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Debts Table -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.3s;">
            @if($debts->count() > 0)
                <div class="table-container border-0 rounded-t-2xl">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Kontak</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Dibayar</th>
                                <th class="text-right">Sisa</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($debts as $debt)
                                <tr class="{{ $debt->is_overdue ? 'bg-rose-50 dark:bg-rose-900/20' : '' }}">
                                    <td class="text-slate-600 dark:text-slate-400">
                                        {{ $debt->debt_date->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $debt->type === 'payable' ? 'badge-danger' : 'badge-success' }}">
                                            {{ $debt->type_label }}
                                        </span>
                                    </td>
                                    <td class="font-medium text-slate-900 dark:text-slate-100">
                                        {{ $debt->contact->name }}
                                    </td>
                                    <td class="text-right text-slate-600 dark:text-slate-400">
                                        Rp {{ number_format($debt->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right text-slate-600 dark:text-slate-400">
                                        Rp {{ number_format($debt->paid_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right font-semibold {{ $debt->remaining_amount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                        Rp {{ number_format($debt->remaining_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-slate-600 dark:text-slate-400">
                                        @if($debt->due_date)
                                            <span class="{{ $debt->is_overdue ? 'text-rose-600 dark:text-rose-400 font-semibold' : '' }}">
                                                {{ $debt->due_date->format('d M Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $debt->status_color }}">
                                            {{ $debt->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('debts.show', $debt) }}" class="text-slate-400 hover:text-cyan-600 transition-colors" title="Detail">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            @if($debt->status !== 'paid')
                                                <a href="{{ route('debts.payment.form', $debt) }}" class="text-slate-400 hover:text-emerald-600 transition-colors" title="Bayar">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $debts->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="empty-state-title">Belum ada hutang/piutang</p>
                    <p class="empty-state-text">Catat hutang ke supplier atau piutang dari pelanggan</p>
                    <div class="flex gap-3 justify-center">
                        <a href="{{ route('debts.create', ['type' => 'payable']) }}" class="btn btn-danger">Catat Hutang</a>
                        <a href="{{ route('debts.create', ['type' => 'receivable']) }}" class="btn btn-success">Catat Piutang</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
