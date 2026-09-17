<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name'))</title>

        @fonts
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        @stack('head')
    </head>
    <body class="bg-gray-100 font-sans antialiased">
        <div class="flex min-h-screen flex-col">
            {{-- ===== Top bar ===== --}}
            <header class="fixed inset-x-0 top-0 z-50 flex h-16 items-center justify-between px-4 sm:px-5"
                style="background: linear-gradient(90deg,#1a2a75,#079c4e);">
                <div class="flex items-center gap-3">
                    <button type="button" id="adminSidebarToggle" class="rounded-lg p-2 text-white lg:hidden" aria-label="Buka menu">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-white">
                        <img src="{{ asset('img/new-logo.webp') }}" alt="Logo Muhammadiyah" class="h-10 object-contain">
                    </a>
                </div>
                <div class="flex items-center gap-3 sm:gap-4 text-white">
                    <span class="hidden text-sm sm:block">{{ auth()->user()->name }}
                        <span class="ml-1 rounded-full bg-white/15 px-2 py-0.5 text-xs">
                            {{ auth()->user()->role === 'superadmin' ? 'Ketua' : 'Sekretaris' }}
                        </span>
                    </span>
                    <a href="{{ route('home') }}" class="text-sm text-white/85 hover:text-brand-cyan" title="Lihat website">
                        <i class="fas fa-globe"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-white/85 hover:text-brand-cyan" title="Keluar">
                            <i class="fas fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </header>

            {{-- ===== Overlay (mobile) ===== --}}
            <div id="adminSidebarOverlay" class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden"></div>

            <div class="mt-16 flex flex-1">
                {{-- ===== Sidebar ===== --}}
                <aside id="adminSidebar"
                    class="fixed inset-y-0 left-0 top-16 z-40 w-64 -translate-x-full overflow-y-auto border-r border-gray-200 bg-white p-4 transition-transform duration-200 lg:static lg:translate-x-0 lg:shrink-0">
                    <nav class="space-y-1 text-sm" aria-label="Menu admin">
                        @php
                            $menu = [
                                ['label' => 'Dashboard', 'icon' => 'fa-gauge-high', 'route' => 'admin.dashboard'],
                                ['label' => 'Berita', 'icon' => 'fa-newspaper', 'route' => 'admin.posts.index'],
                                ['label' => 'Agenda', 'icon' => 'fa-calendar', 'route' => 'admin.agenda.index'],
                                ['label' => 'AUM', 'icon' => 'fa-building-columns', 'route' => 'admin.aum.index'],
                                ['label' => 'Pengumuman', 'icon' => 'fa-bullhorn', 'route' => 'admin.announcements.index'],
                                ['label' => 'Pesan Masuk', 'icon' => 'fa-envelope', 'route' => 'admin.messages.index'],
                                ['label' => 'Arsip Dokumen', 'icon' => 'fa-folder-open', 'route' => 'admin.documents.index'],
                            ];
                            if (auth()->user()->isSuperAdmin()) {
                                $menu[] = ['label' => 'Persetujuan Berita', 'icon' => 'fa-check-double', 'route' => 'admin.approvals.index'];
                                $menu[] = ['label' => 'Manajemen User', 'icon' => 'fa-users', 'route' => 'admin.users.index'];
                            }
                        @endphp
                        @foreach ($menu as $item)
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center gap-3 rounded-lg px-3 py-2 font-medium transition {{ request()->routeIs($item['route'] . '*') ? 'bg-brand-navy text-white shadow' : 'text-gray-700 hover:bg-white hover:text-brand-navy' }}">
                                <i class="fas {{ $item['icon'] }} w-4 text-center"></i>{{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </aside>

                {{-- ===== Konten ===== --}}
                <main class="min-h-[70vh] w-full min-w-0 flex-1 bg-gray-100 p-4 sm:p-6">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                            <ul class="list-inside list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>

        <script>
            (function () {
                const toggle = document.getElementById('adminSidebarToggle');
                const sidebar = document.getElementById('adminSidebar');
                const overlay = document.getElementById('adminSidebarOverlay');
                if (!toggle || !sidebar || !overlay) return;

                function openSidebar() {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                }
                function closeSidebar() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
                toggle.addEventListener('click', openSidebar);
                overlay.addEventListener('click', closeSidebar);
            })();
        </script>

        @stack('scripts')
    </body>
</html>