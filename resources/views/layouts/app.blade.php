<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name'))</title>
        <meta name="description" content="@yield('meta_description', 'Website resmi Pimpinan Cabang Muhammadiyah (PCM) Pujon — berisi informasi berita, agenda, dan Amal Usaha Muhammadiyah di Pujon, Malang.')">
        <link rel="canonical" href="{{ url()->current() }}">

        <script type="application/ld+json">
        @php
            $organization = [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'Pimpinan Cabang Muhammadiyah Pujon',
                'url' => url('/'),
                'email' => config('site.email'),
                'description' => 'Website resmi Pimpinan Cabang Muhammadiyah (PCM) Pujon, Kabupaten Malang.',
            ];
        @endphp
        {!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>

        @fonts
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                @vite(['resources/css/app.css'])
            </style>
        @endif
        @stack('head')
    </head>
    <body class="font-sans antialiased">
        {{-- ===== NAVBAR (replikasi referensi: fixed 80px gradient) ===== --}}
        <header class="navbar" data-turbo-permanent>
            <nav class="mx-auto flex h-full w-[90%] max-w-7xl items-center justify-between gap-4" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" class="flex items-center" aria-label="Beranda PCM Pujon">
                    {{-- GANTI: logo resmi PCM Pujon saat tersedia --}}
                    <img src="{{ asset('img/new-logo.webp') }}" alt="Logo Muhammadiyah" class="logo">
                </a>

                <div class="navbar-menu-desktop flex items-center gap-1 text-sm lg:gap-2 lg:text-base">
                    <a href="{{ route('home') }}" class="nav-link @if(request()->routeIs('home')) active @endif">Beranda</a>
                    <a href="{{ route('profil') }}" class="nav-link @if(request()->routeIs('profil*')) active @endif">Profil</a>
                    <a href="{{ route('majelis') }}" class="nav-link @if(request()->routeIs('majelis*')) active @endif">Majelis</a>
                    <a href="{{ route('berita.index') }}" class="nav-link @if(request()->routeIs('berita*')) active @endif">Berita</a>

                    <div class="dropdown">
                        <button type="button" class="nav-link">
                            AUM <i class="fas fa-chevron-down text-xs opacity-70"></i>
                        </button>
                       <div class="dropdown-content">
    <a href="{{ route('aum.index', ['type' => 'pertanian']) }}">Pertanian</a>
    <a href="{{ route('aum.index', ['type' => 'masjid']) }}">Masjid / Musholla</a>
    <a href="{{ route('aum.index', ['type' => 'panti']) }}">Panti Asuhan</a>
    <a href="{{ route('aum.index', ['type' => 'lainnya']) }}">AUM Lainnya</a>
</div>
                    </div>

                    <a href="{{ route('agenda.index') }}" class="nav-link @if(request()->routeIs('agenda*')) active @endif">Agenda</a>
                    <a href="{{ route('kontak') }}" class="nav-link @if(request()->routeIs('kontak')) active @endif">Kontak</a>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="ml-2 rounded-lg bg-white/15 px-3 py-1.5 font-semibold text-white transition hover:bg-white/25">
                            <i class="fas fa-user-shield mr-1"></i>Admin
                        </a>
                    @endauth
                </div>

                <button type="button" class="navbar-toggle items-center justify-center rounded-lg p-2 text-2xl text-white" id="navbarToggle" aria-label="Buka menu">
                    <i class="fas fa-bars"></i>
                </button>
            </nav>
        </header>

        {{-- ===== MOBILE DRAWER ===== --}}
        <div class="mobile-drawer" id="mobileDrawer" aria-hidden="true" data-turbo-permanent>
            <div class="flex items-center justify-between p-5">
                <img src="{{ asset('img/new-logo.webp') }}" alt="Logo Muhammadiyah" class="h-12 object-contain">
                <button type="button" class="rounded-lg bg-white/15 p-2 text-white" id="drawerClose" aria-label="Tutup menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <a href="{{ route('home') }}" class="drawer-link">Beranda</a>
            <a href="{{ route('profil') }}" class="drawer-link">Profil</a>
            <a href="{{ route('majelis') }}" class="drawer-link">Majelis</a>
            <a href="{{ route('berita.index') }}" class="drawer-link">Berita</a>
            <a href="{{ route('aum.index') }}" class="drawer-link">AUM (Amal Usaha)</a>
            <a href="{{ route('agenda.index') }}" class="drawer-link">Agenda</a>
            <a href="{{ route('kontak') }}" class="drawer-link">Kontak</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="drawer-link"><i class="fas fa-user-shield mr-1"></i>Dashboard Admin</a>
            @endauth
        </div>

        <main>
            @if (session('success'))
                <div class="mx-auto mt-4 w-[90%] max-w-7xl rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mx-auto mt-4 w-[90%] max-w-7xl rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        {{-- ===== FOOTER (replikasi referensi: 3 kolom + border gold) ===== --}}
        <footer class="footer" data-turbo-permanent>
            <div class="footer-container">
                <div class="footer-column">
                    {{-- GANTI: logo resmi (Muhammadiyah + PCM Pujon) --}}
                    <img src="{{ asset('img/footer-new.webp') }}" alt="Logo Muhammadiyah & PCM" class="footer-logo">
                    <p class="mt-4 text-sm leading-relaxed text-white/85">
                        Pimpinan Cabang Muhammadiyah Pujon — Cahaya Islam Berkemajuan, Membangun Umat, Menebar Kebaikan.
                    </p>
                </div>

                <div class="footer-column">
                    <h4>Alamat Kami</h4>
                    {{-- GANTI: alamat resmi kantor PCM Pujon --}}
                    <p class="text-sm leading-relaxed text-white/85">
                        Jl. Brigjend Abd. Manan Wijaya, Gesingan, Pujon Lor, Kec. Pujon, Kabupaten Malang, Jawa Timur 65391
                    </p>
                    <div class="mt-4 overflow-hidden rounded-xl">
                        {{-- GANTI: embed Google Maps alamat resmi PCM Pujon --}}
                        <iframe
    title="Peta lokasi PCM Pujon"
    src="https://www.google.com/maps?q=-7.8483686,112.4775472&output=embed"
    class="h-[150px] w-full border-0"
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
    allowfullscreen></iframe>
                    </div>
                </div>

                <div class="footer-column">
                    <h4>Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="mailto:{{ config('site.email', 'pcmpujon@gmail.com') }}">
                                <i class="fas fa-envelope"></i>{{ config('site.email', 'pcmpujon@gmail.com') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/{{ config('site.whatsapp', '6281234567890') }}" target="_blank" rel="noopener">
                                <i class="fa-brands fa-whatsapp"></i>{{ config('site.whatsapp_display', '+62 812-3456-7890') }}
                            </a>
                        </li>
                    </ul>
                    <div class="mt-5 flex gap-3 text-xl">
    <a href="https://instagram.com/pcmpujon" target="_blank" rel="noopener" aria-label="Instagram PCM Pujon"><i class="fa-brands fa-instagram"></i></a>
    <a href="https://www.youtube.com/@PCM-PujonMalang" target="_blank" rel="noopener" aria-label="YouTube PCM Pujon"><i class="fa-brands fa-youtube"></i></a>
</div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-container !justify-center">
                    <p class="text-center text-sm text-white/80">
                        &copy; {{ date('Y') }} Pimpinan Cabang Muhammadiyah Pujon. All Rights Reserved.
                    </p>
                </div>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
