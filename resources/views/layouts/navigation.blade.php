<nav x-data="{ open: false }" class="nav-premium">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-9 h-9 rounded-xl shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-200 object-cover">
                    <span class="hidden md:inline text-lg font-bold bg-gradient-to-r from-cyan-600 to-teal-600 bg-clip-text text-transparent">UMKM Keuangan</span>
                </a>

                <!-- Navigation Links - Simplified -->
                <div class="hidden lg:flex lg:items-center lg:ml-8 space-x-1">
                    <a href="{{ route('dashboard') }}" class="nav-link-premium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <!-- POS Mode - Highlighted -->
                    <a href="{{ route('pos.index') }}" class="nav-link-premium {{ request()->routeIs('pos.*') ? 'active' : '' }} !bg-gradient-to-r !from-emerald-500 !to-teal-500 !text-white !shadow-md hover:!shadow-lg">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Kasir
                    </a>

                    <a href="{{ route('transactions.index') }}" class="nav-link-premium {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        Transaksi
                    </a>
                    
                    <!-- Master Data Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="nav-link-premium {{ request()->routeIs('products.*') || request()->routeIs('product-categories.*') || request()->routeIs('accounts.*') || request()->routeIs('contacts.*') ? 'active' : '' }} inline-flex items-center">
                                Master Data
                                <svg class="ml-1.5 h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Inventori</div>
                            <x-dropdown-link :href="route('products.index')">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Produk
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('product-categories.index')">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                Kategori Produk
                            </x-dropdown-link>
                            <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                            <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Referensi</div>
                            <x-dropdown-link :href="route('accounts.index')">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                Akun Keuangan
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('contacts.index')">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Kontak
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Keuangan Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="nav-link-premium {{ request()->routeIs('debts.*') || request()->routeIs('budgets.*') ? 'active' : '' }} inline-flex items-center">
                                Keuangan
                                <svg class="ml-1.5 h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('debts.index')">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Hutang & Piutang
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('budgets.index')">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                Anggaran
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Reports Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="nav-link-premium {{ request()->routeIs('reports.*') ? 'active' : '' }} inline-flex items-center">
                                Laporan
                                <svg class="ml-1.5 h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('reports.income')">
                                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                Pemasukan
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.expense')">
                                <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                Pengeluaran
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.profit-loss')">
                                <svg class="w-4 h-4 mr-2 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Laba Rugi
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.cashflow')">
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                Arus Kas
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <a href="{{ route('stores.index') }}" class="nav-link-premium {{ request()->routeIs('stores.*') ? 'active' : '' }}">
                        Toko
                    </a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:gap-2">
                <!-- Dark Mode Toggle -->
                <button id="darkModeToggle" class="dark-mode-toggle" title="Toggle Dark Mode">
                    <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                    </svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                </button>

                <!-- Store Switcher - Compact -->
                @if(Auth::user()->stores->count() > 0)
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="max-w-[100px] truncate text-xs">{{ Auth::user()->currentStore()?->name ?? 'Pilih Toko' }}</span>
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-3 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pilih Toko</div>
                        @foreach(Auth::user()->stores as $store)
                            <form method="POST" action="{{ route('stores.switch', $store) }}">
                                @csrf
                                <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center justify-between {{ session('current_store_id') == $store->id ? 'bg-cyan-50 dark:bg-cyan-900/30' : '' }}">
                                    {{ $store->name }}
                                    @if(session('current_store_id') == $store->id)
                                        <svg class="w-4 h-4 text-cyan-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </x-dropdown-link>
                            </form>
                        @endforeach
                    </x-slot>
                </x-dropdown>
                @endif

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-1.5 text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-slate-900 dark:hover:text-white transition-all duration-200 group">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-400 to-teal-500 flex items-center justify-center text-white text-sm font-bold shadow group-hover:shadow-md group-hover:scale-105 transition-all duration-200">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <svg class="h-3 w-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 dark:text-rose-400">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" class="p-2 rounded-xl text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden border-t border-slate-100 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur-lg">
        <div class="py-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-cyan-500 to-teal-500 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Dashboard</a>
            <a href="{{ route('pos.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-sm">⚡ Mode Kasir</a>
            <a href="{{ route('transactions.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('transactions.*') ? 'bg-gradient-to-r from-cyan-500 to-teal-500 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Transaksi</a>
            
            <div class="pt-2 pb-1">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Master Data</p>
            </div>
            <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('products.*') ? 'bg-cyan-50 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Produk</a>
            <a href="{{ route('accounts.index') }}" class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('accounts.*') ? 'bg-cyan-50 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Akun</a>
            <a href="{{ route('contacts.index') }}" class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('contacts.*') ? 'bg-cyan-50 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Kontak</a>
            
            <div class="pt-2 pb-1">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Keuangan</p>
            </div>
            <a href="{{ route('debts.index') }}" class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('debts.*') ? 'bg-cyan-50 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Hutang & Piutang</a>
            <a href="{{ route('budgets.index') }}" class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('budgets.*') ? 'bg-cyan-50 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Anggaran</a>
            
            <div class="pt-2 pb-1">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Laporan</p>
            </div>
            <a href="{{ route('reports.profit-loss') }}" class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('reports.profit-loss') ? 'bg-cyan-50 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Laba Rugi</a>
            <a href="{{ route('reports.cashflow') }}" class="block px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('reports.cashflow') ? 'bg-cyan-50 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200">Arus Kas</a>
            
            <a href="{{ route('stores.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('stores.*') ? 'bg-gradient-to-r from-cyan-500 to-teal-500 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }} transition-all duration-200 mt-2">Toko</a>
        </div>

        <div class="pt-3 pb-3 border-t border-slate-100 dark:border-slate-800 px-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-teal-500 flex items-center justify-center text-white font-bold shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('profile.edit') }}" class="flex-1 text-center px-4 py-2 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-200">Profil</a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 rounded-xl text-sm font-medium text-white bg-rose-500 hover:bg-rose-600 transition-all duration-200">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('darkModeToggle');
    const html = document.documentElement;

    // Check for saved preference or system preference
    if (localStorage.getItem('darkMode') === 'true' || 
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    }

    darkModeToggle?.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('darkMode', html.classList.contains('dark'));
    });
</script>
