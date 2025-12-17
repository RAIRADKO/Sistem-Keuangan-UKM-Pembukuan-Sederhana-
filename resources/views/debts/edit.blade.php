<x-app-layout>
    <div class="page-container max-w-2xl">
        <!-- Page Header -->
        <div class="page-header animate-fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('debts.show', $debt) }}" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="page-title">Edit {{ $debt->type_label }}</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">{{ $debt->contact->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card animate-fade-in-up" style="opacity: 0; animation-delay: 0.1s;">
            <form method="POST" action="{{ route('debts.update', $debt) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="contact_id" class="form-label">{{ $debt->type === 'payable' ? 'Supplier' : 'Pelanggan' }} <span class="text-rose-500">*</span></label>
                    <select id="contact_id" name="contact_id" required class="form-input @error('contact_id') border-rose-500 @enderror">
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ old('contact_id', $debt->contact_id) == $contact->id ? 'selected' : '' }}>{{ $contact->name }}</option>
                        @endforeach
                    </select>
                    @error('contact_id')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="total_amount" class="form-label">Jumlah <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                        <input type="number" id="total_amount" name="total_amount" value="{{ old('total_amount', $debt->total_amount) }}" required min="{{ $debt->paid_amount }}" step="1"
                               class="form-input pl-12 @error('total_amount') border-rose-500 @enderror">
                    </div>
                    @if($debt->paid_amount > 0)
                        <p class="mt-1 text-sm text-slate-500">Minimal: Rp {{ number_format($debt->paid_amount, 0, ',', '.') }} (sudah dibayar)</p>
                    @endif
                    @error('total_amount')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="debt_date" class="form-label">Tanggal <span class="text-rose-500">*</span></label>
                        <input type="date" id="debt_date" name="debt_date" value="{{ old('debt_date', $debt->debt_date->format('Y-m-d')) }}" required
                               class="form-input @error('debt_date') border-rose-500 @enderror">
                        @error('debt_date')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="due_date" class="form-label">Jatuh Tempo</label>
                        <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $debt->due_date?->format('Y-m-d')) }}"
                               class="form-input @error('due_date') border-rose-500 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="form-label">Keterangan</label>
                    <textarea id="description" name="description" rows="3"
                              class="form-input @error('description') border-rose-500 @enderror">{{ old('description', $debt->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('debts.show', $debt) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
