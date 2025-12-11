<x-app-layout>
    <div class="page-container animate-fade-in">
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="page-title">Kategori Akun</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">{{ $store->name }}</p>
                </div>
                <a href="{{ route('accounts.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Filter Pills -->
        <div class="flex gap-2 mb-8">
            <a href="{{ route('accounts.index') }}" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ !request('type') ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                Semua
            </a>
            <a href="{{ route('accounts.index', ['type' => 'income']) }}" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request('type') === 'income' ? 'bg-emerald-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                Pemasukan
            </a>
            <a href="{{ route('accounts.index', ['type' => 'expense']) }}" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request('type') === 'expense' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                Pengeluaran
            </a>
        </div>

        <!-- Accounts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Income Accounts -->
            <div class="card">
                <div class="card-header flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <h2 class="section-title">Kategori Pemasukan</h2>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($accounts->where('type', 'income') as $account)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $account->name }}</p>
                                @if($account->description)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $account->description }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $account->transactions_count }} transaksi</p>
                            </div>
                            <a href="{{ route('accounts.edit', $account) }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400">
                            Belum ada kategori pemasukan
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Expense Accounts -->
            <div class="card">
                <div class="card-header flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <h2 class="section-title">Kategori Pengeluaran</h2>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($accounts->where('type', 'expense') as $account)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $account->name }}</p>
                                @if($account->description)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $account->description }}</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ $account->transactions_count }} transaksi</p>
                            </div>
                            <a href="{{ route('accounts.edit', $account) }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400">
                            Belum ada kategori pengeluaran
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
