<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📉 {{ __('Laporan Pengeluaran') }} - {{ $store->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('reports.export', ['type' => 'expense', 'format' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition">
                    📄 PDF
                </a>
                <a href="{{ route('reports.export', ['type' => 'expense', 'format' => 'excel', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 transition">
                    📊 Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('reports.expense') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Kategori</label>
                            <select name="account_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">Semua</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-500">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary -->
            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-6 mb-6">
                <p class="text-sm text-red-600 dark:text-red-400">Total Pengeluaran ({{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }})</p>
                <p class="text-3xl font-bold text-red-700 dark:text-red-300">Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>

            <!-- By Category -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Berdasarkan Kategori</h3>
                        @if($byCategory->count() > 0)
                            <div class="space-y-4">
                                @foreach($byCategory as $item)
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-gray-700 dark:text-gray-300">{{ $item['account']->name }}</span>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $total > 0 ? ($item['total'] / $total * 100) : 0 }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $item['count'] }} transaksi</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada data</p>
                        @endif
                    </div>
                </div>

                <!-- Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Distribusi Pengeluaran</h3>
                        <canvas id="expenseChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detail Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Deskripsi</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $transaction->account->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $transaction->description ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-right font-medium text-red-600 dark:text-red-400">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada transaksi dalam periode ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const categoryData = @json($byCategory);
        if (categoryData.length > 0) {
            const ctx = document.getElementById('expenseChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categoryData.map(d => d.account.name),
                    datasets: [{
                        data: categoryData.map(d => d.total),
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(249, 115, 22, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
    @endpush
</x-app-layout>
