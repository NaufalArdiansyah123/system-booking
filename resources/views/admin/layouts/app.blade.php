<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - FutsalKu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white text-gray-800 hidden md:flex flex-col border-r border-gray-200">
            <div class="px-6 py-6 border-b border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <span class="text-2xl">⚽</span>
                    <div>
                        <div class="text-lg font-bold text-blue-600">FutsalKu</div>
                        <div class="text-xs text-gray-500">Admin Panel</div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 px-2 py-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-md text-base font-medium hover:bg-blue-50 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-md text-base font-medium hover:bg-blue-50 {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-600 text-white' : 'text-gray-700' }}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Bookings
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-md text-base font-medium hover:bg-blue-50 {{ request()->routeIs('admin.services.*') ? 'bg-blue-600 text-white' : 'text-gray-700' }}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Services
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.statistics') }}" class="flex items-center gap-3 px-4 py-3 rounded-md text-base font-medium hover:bg-blue-50 {{ request()->routeIs('admin.statistics') ? 'bg-blue-600 text-white' : 'text-gray-700' }}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Statistics
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="px-4 py-6 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">A</div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Admin Jakarta</div>
                        <div class="text-xs text-gray-500">Admin</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Content area -->
        <div class="flex-1">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="md:hidden p-2 rounded-md bg-gray-100" x-data @click="$dispatch('toggle-sidebar')">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900">@yield('page_title', 'Admin')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-600">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700">Lihat Situs</a>
                </div>
            </header>

            <!-- Main -->
            <main class="p-6 pl-0">
                <div class="pl-6">
                    @yield('content')
                </div>
            </main>

            <footer class="p-4 text-sm text-gray-500 text-center border-t border-gray-200">
                &copy; {{ date('Y') }} FutsalKu — Admin Panel
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
