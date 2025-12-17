<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UMKM Keuangan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>

        <!-- Dark Mode Init (prevents flash) -->
        <script>
            (function() {
                const darkMode = localStorage.getItem('darkMode');
                if (darkMode === 'true' || (!darkMode && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-cyan-50 via-sky-50 to-slate-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950">
            @include('layouts.navigation')

            <!-- Toast Notifications Container -->
            <div id="toast-container" class="toast-container"></div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-lg border-b border-slate-200/50 dark:border-slate-700/50 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="main-content">
                {{ $slot }}
            </main>
        </div>

        <!-- Mobile Bottom Navigation -->
        <nav class="mobile-bottom-nav">
            <div class="grid grid-cols-5 h-16">
                <a href="{{ route('dashboard') }}" class="mobile-bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                
                <a href="{{ route('transactions.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-xs mt-1">Transaksi</span>
                </a>
                
                <!-- FAB Button -->
                <a href="{{ route('pos.index') }}" class="mobile-bottom-nav-fab">
                    <div class="mobile-bottom-nav-fab-button">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </a>
                
                <a href="{{ route('products.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-xs mt-1">Produk</span>
                </a>
                
                <a href="{{ route('stores.index') }}" class="mobile-bottom-nav-item {{ request()->routeIs('stores.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-xs mt-1">Toko</span>
                </a>
            </div>
        </nav>

        @stack('scripts')

        <!-- Toast Notification Script -->
        <script>
            function showToast(message, type = 'success') {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                
                const iconMap = {
                    success: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
                    error: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                    info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
                };
                
                const colorMap = {
                    success: 'text-emerald-500',
                    error: 'text-rose-500',
                    info: 'text-cyan-500'
                };
                
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 ${colorMap[type]}" fill="currentColor" viewBox="0 0 20 20">
                            ${iconMap[type]}
                        </svg>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200">${message}</p>
                    </div>
                    <button onclick="closeToast(this.parentElement)" class="toast-close">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <div class="toast-progress"></div>
                `;
                
                container.appendChild(toast);
                
                // Auto remove after 4 seconds
                setTimeout(() => {
                    closeToast(toast);
                }, 4000);
            }
            
            function closeToast(toast) {
                if (!toast || toast.classList.contains('toast-hiding')) return;
                toast.classList.add('toast-hiding');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
            
            // Show session flash messages as toasts
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    showToast(@json(session('success')), 'success');
                @endif
                @if(session('error'))
                    showToast(@json(session('error')), 'error');
                @endif
                @if(session('info'))
                    showToast(@json(session('info')), 'info');
                @endif
            });
        </script>
    </body>
</html>

