<x-app-layout>
    <div class="page-container animate-fade-in">
        <div class="max-w-xl mx-auto">
            <!-- Page Header -->
            <div class="page-header text-center">
                <h1 class="page-title">Tambah Toko Baru</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Isi informasi toko Anda</p>
            </div>

            <!-- Form Card -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('stores.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label">Nama Toko</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" 
                                   class="form-input" required autofocus 
                                   placeholder="Contoh: Warung Makan Barokah">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label for="business_type" class="form-label">Jenis Usaha <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <input id="business_type" type="text" name="business_type" value="{{ old('business_type') }}" 
                                   class="form-input" 
                                   placeholder="Contoh: Kuliner, Retail, Jasa">
                            <x-input-error :messages="$errors->get('business_type')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">Alamat <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea id="address" name="address" rows="2" 
                                      class="form-input resize-none" 
                                      placeholder="Alamat lengkap toko">{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Telepon <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" 
                                   class="form-input" 
                                   placeholder="08xxxxxxxxxx">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="flex gap-3 pt-4">
                            <a href="{{ route('stores.index') }}" class="btn btn-secondary flex-1">Batal</a>
                            <button type="submit" class="btn btn-primary flex-1">Simpan Toko</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
