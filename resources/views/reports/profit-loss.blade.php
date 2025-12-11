<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📊 {{ __('Laporan Laba Rugi') }} - {{ $store->name }}
            </h2>
            <a href="{{ route('reports.export', ['type' => 'profit-loss', 'format' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition">
                📄 Export PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('reports.profit-loss') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

            <!-- Report -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">LAPORAN LABA RUGI</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $store->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                    </div>

                    <!-- Income Section -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 border-b pb-2">PENDAPATAN</h4>
                        @foreach($incomeByCategory as $item)
                            <div class="flex justify-between py-2 px-4">
                                <span class="text-gray-700 dark:text-gray-300">{{ $item->account->name }}</span>
                                <span class="text-gray-900 dark:text-gray-100">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between py-2 px-4 bg-green-50 dark:bg-green-900/20 font-semibold">
                            <span class="text-green-700 dark:text-green-300">Total Pendapatan</span>
                            <span class="text-green-700 dark:text-green-300">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Expense Section -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 border-b pb-2">BEBAN / PENGELUARAN</h4>
                        @foreach($expenseByCategory as $item)
                            <div class="flex justify-between py-2 px-4">
                                <span class="text-gray-700 dark:text-gray-300">{{ $item->account->name }}</span>
                                <span class="text-gray-900 dark:text-gray-100">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between py-2 px-4 bg-red-50 dark:bg-red-900/20 font-semibold">
                            <span class="text-red-700 dark:text-red-300">Total Pengeluaran</span>
                            <span class="text-red-700 dark:text-red-300">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Net Profit -->
                    <div class="border-t-2 border-gray-300 dark:border-gray-600 pt-4">
                        <div class="flex justify-between py-3 px-4 {{ $netProfit >= 0 ? 'bg-green-100 dark:bg-green-900/40' : 'bg-red-100 dark:bg-red-900/40' }} rounded-lg">
                            <span class="text-xl font-bold {{ $netProfit >= 0 ? 'text-green-800 dark:text-green-200' : 'text-red-800 dark:text-red-200' }}">
                                {{ $netProfit >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' }}
                            </span>
                            <span class="text-xl font-bold {{ $netProfit >= 0 ? 'text-green-800 dark:text-green-200' : 'text-red-800 dark:text-red-200' }}">
                                Rp {{ number_format(abs($netProfit), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
