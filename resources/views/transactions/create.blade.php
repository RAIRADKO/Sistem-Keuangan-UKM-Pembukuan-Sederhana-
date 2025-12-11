<x-app-layout>
    <div class="page-container animate-fade-in">
        <div class="max-w-xl mx-auto">
            <!-- Page Header -->
            <div class="page-header text-center">
                <h1 class="page-title">{{ $type === 'income' ? 'Catat Pemasukan' : 'Catat Pengeluaran' }}</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">{{ $store->name }}</p>
            </div>

            <!-- Type Switcher - Clear visual feedback -->
            <div class="flex gap-2 mb-8">
                <a href="{{ route('transactions.create', ['type' => 'income']) }}" 
                   class="flex-1 py-3 text-center rounded-xl font-medium transition-all {{ $type === 'income' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 dark:shadow-emerald-900/30' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                    Pemasukan
                </a>
                <a href="{{ route('transactions.create', ['type' => 'expense']) }}" 
                   class="flex-1 py-3 text-center rounded-xl font-medium transition-all {{ $type === 'expense' ? 'bg-red-600 text-white shadow-lg shadow-red-200 dark:shadow-red-900/30' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                    Pengeluaran
                </a>
            </div>

            <!-- Form Card -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('transactions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <!-- Amount - Most important, largest visual -->
                        <div class="form-group">
                            <label for="amount" class="form-label">Jumlah</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                                <input id="amount" type="number" name="amount" value="{{ old('amount') }}" 
                                       class="form-input pl-12 text-2xl font-semibold h-14" 
                                       required min="0" step="1" placeholder="0" autofocus>
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label for="account_id" class="form-label">Kategori</label>
                            <select id="account_id" name="account_id" class="form-input" required>
                                <option value="">Pilih kategori</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                            @if($accounts->isEmpty())
                                <p class="mt-2 text-sm text-amber-600 dark:text-amber-400">
                                    Belum ada kategori. <a href="{{ route('accounts.create') }}" class="underline">Buat kategori</a>
                                </p>
                            @endif
                        </div>

                        <!-- Date -->
                        <div class="form-group">
                            <label for="transaction_date" class="form-label">Tanggal</label>
                            <input id="transaction_date" type="date" name="transaction_date" 
                                   value="{{ old('transaction_date', date('Y-m-d')) }}" 
                                   class="form-input" required>
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="form-label">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea id="description" name="description" rows="2" 
                                      class="form-input resize-none" 
                                      placeholder="Tambahkan keterangan...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Proof Upload -->
                        <div class="form-group">
                            <label for="proof_file" class="form-label">Bukti <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-6 text-center hover:border-indigo-300 dark:hover:border-indigo-700 transition-colors">
                                <input id="proof_file" type="file" name="proof_file" accept="image/*,.pdf" class="hidden">
                                <label for="proof_file" class="cursor-pointer">
                                    <svg class="w-8 h-8 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Klik untuk upload foto atau PDF</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('proof_file')" class="mt-2" />
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 pt-4">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary flex-1">Batal</a>
                            <button type="submit" class="btn {{ $type === 'income' ? 'btn-success' : 'btn-danger' }} flex-1">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
