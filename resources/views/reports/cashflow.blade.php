<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                💵 {{ __('Laporan Arus Kas') }} - {{ $store->name }}
            </h2>
            <a href="{{ route('reports.export', ['type' => 'cashflow', 'format' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition">
                📄 Export PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('reports.cashflow') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-500">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Saldo Awal</p>
                    <p class="text-xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($openingBalance, 0, ',', '.') }}</p>
                </div>
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4">
                    <p class="text-sm text-indigo-600 dark:text-indigo-400">Perubahan</p>
                    <p class="text-xl font-bold {{ ($closingBalance - $openingBalance) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ ($closingBalance - $openingBalance) >= 0 ? '+' : '' }}Rp {{ number_format($closingBalance - $openingBalance, 0, ',', '.') }}
                    </p>
                </div>
                <div class="{{ $closingBalance >= 0 ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }} rounded-lg p-4">
                    <p class="text-sm {{ $closingBalance >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">Saldo Akhir</p>
                    <p class="text-xl font-bold {{ $closingBalance >= 0 ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">Rp {{ number_format($closingBalance, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Cash Flow Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Grafik Arus Kas</h3>
                    <canvas id="cashflowChart" height="100"></canvas>
                </div>
            </div>

            <!-- Daily Detail -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Detail Harian</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kas Masuk</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kas Keluar</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Saldo</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($cashflowData as $row)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($row['date'])->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-right text-green-600 dark:text-green-400">
                                            @if($row['income'] > 0)
                                                +Rp {{ number_format($row['income'], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right text-red-600 dark:text-red-400">
                                            @if($row['expense'] > 0)
                                                -Rp {{ number_format($row['expense'], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right font-medium {{ $row['balance'] >= 0 ? 'text-gray-900 dark:text-gray-100' : 'text-red-600 dark:text-red-400' }}">
                                            Rp {{ number_format($row['balance'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data dalam periode ini</td>
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
        const cashflowData = @json($cashflowData);
        if (cashflowData.length > 0) {
            const ctx = document.getElementById('cashflowChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: cashflowData.map(d => d.date),
                    datasets: [{
                        label: 'Saldo',
                        data: cashflowData.map(d => d.balance),
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Saldo: Rp ' + context.raw.toLocaleString('id-ID');
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
