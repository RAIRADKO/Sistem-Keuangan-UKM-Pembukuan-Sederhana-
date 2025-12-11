<x-app-layout>
    <div class="page-container animate-fade-in">
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="page-title">Transaksi</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">{{ $store->name }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Pemasukan
                    </a>
                    <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="btn btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                        Pengeluaran
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters - Clean & minimal -->
        <div class="card mb-8">
            <div class="p-5">
                <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-2 md:grid-cols-6 gap-4">
                    <div>
                        <label class="form-label">Tipe</label>
                        <select name="type" class="form-input">
                            <option value="">Semua</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kategori</label>
                        <select name="account_id" class="form-input">
                            <option value="">Semua</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Dari</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Sampai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Deskripsi..." class="form-input">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="btn btn-primary w-full">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-5">
                <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Total Pemasukan</p>
                <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300 mt-1">Rp {{ number_format($summary['total_income'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-5">
                <p class="text-sm font-medium text-red-600 dark:text-red-400">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-red-700 dark:text-red-300 mt-1">Rp {{ number_format($summary['total_expense'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card">
            @if($transactions->count() > 0)
                <div class="table-container border-0 rounded-t-xl">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-center">Bukti</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="text-gray-600 dark:text-gray-400">
                                        {{ $transaction->transaction_date->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $transaction->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $transaction->type === 'income' ? 'Masuk' : 'Keluar' }}
                                        </span>
                                    </td>
                                    <td class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $transaction->account->name }}
                                    </td>
                                    <td class="text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                        {{ $transaction->description ?? '-' }}
                                    </td>
                                    <td class="text-right {{ $transaction->type === 'income' ? 'money-positive' : 'money-negative' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        @if($transaction->proof_file)
                                            <a href="{{ Storage::url($transaction->proof_file) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-300 dark:text-gray-600">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('transactions.edit', $transaction) }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}" class="inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="empty-state-title">Belum ada transaksi</p>
                    <p class="empty-state-text">Mulai catat pemasukan dan pengeluaran Anda</p>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
