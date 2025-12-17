<x-app-layout>
    <div class="page-container max-w-4xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('contacts.index') }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="page-title">{{ $contact->name }}</h1>
                        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                            <span class="badge {{ $contact->type === 'supplier' ? 'badge-info' : 'badge-purple' }}">
                                {{ $contact->type === 'supplier' ? 'Supplier' : 'Pelanggan' }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('debts.create', ['type' => $contact->type === 'supplier' ? 'payable' : 'receivable', 'contact_id' => $contact->id]) }}" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ $contact->type === 'supplier' ? 'Catat Hutang' : 'Catat Piutang' }}
                    </a>
                    <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-secondary">Edit</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Contact Info -->
            <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-4">Informasi Kontak</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Telepon</dt>
                            <dd class="text-slate-900 dark:text-slate-100">{{ $contact->phone ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Alamat</dt>
                            <dd class="text-slate-900 dark:text-slate-100">{{ $contact->address ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Catatan</dt>
                            <dd class="text-slate-900 dark:text-slate-100">{{ $contact->notes ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Status</dt>
                            <dd>
                                <span class="badge {{ $contact->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $contact->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="lg:col-span-2 space-y-4">
                @if($contact->type === 'supplier')
                    <div class="bg-gradient-to-br from-rose-50 to-pink-50 dark:from-rose-900/30 dark:to-pink-900/30 rounded-2xl p-6 border border-rose-100 dark:border-rose-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                        <p class="text-sm font-semibold text-rose-600 dark:text-rose-400">Total Hutang Belum Lunas</p>
                        <p class="text-2xl font-bold text-rose-700 dark:text-rose-300 mt-1">Rp {{ number_format($contact->total_payable, 0, ',', '.') }}</p>
                    </div>
                @else
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-2xl p-6 border border-emerald-100 dark:border-emerald-800 animate-fade-in-up" style="opacity: 0; animation-delay: 0.2s;">
                        <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">Total Piutang Belum Lunas</p>
                        <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300 mt-1">Rp {{ number_format($contact->total_receivable, 0, ',', '.') }}</p>
                    </div>
                @endif

                <!-- Recent Debts -->
                <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.3s;">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">
                                {{ $contact->type === 'supplier' ? 'Riwayat Hutang' : 'Riwayat Piutang' }}
                            </h3>
                            <a href="{{ route('debts.index', ['contact_id' => $contact->id]) }}" class="text-sm text-cyan-600 hover:text-cyan-700">Lihat Semua</a>
                        </div>

                        @if($contact->debts->count() > 0)
                            <div class="space-y-3">
                                @foreach($contact->debts as $debt)
                                    <a href="{{ route('debts.show', $debt) }}" class="block p-4 rounded-lg bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-slate-900 dark:text-slate-100">
                                                    Rp {{ number_format($debt->total_amount, 0, ',', '.') }}
                                                </p>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                                    {{ $debt->debt_date->format('d M Y') }}
                                                </p>
                                            </div>
                                            <span class="badge badge-{{ $debt->status_color }}">
                                                {{ $debt->status_label }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
