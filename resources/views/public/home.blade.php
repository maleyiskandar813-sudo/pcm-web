@extends('layouts.app')

@section('title', 'Beranda — ' . config('app.name'))

@section('content')
   {{-- ===== HERO (replikasi referensi) ===== --}}
<section class="hero" aria-label="Sambutan">
    <img src="{{ asset('img/hero.jpg') }}" alt="{{ $namaCabang }}" class="block w-full h-auto">
    <h1 class="sr-only">{{ $namaCabang }}</h1>
    @if ($taglines)
        <p id="hero-tagline"
            class="hero-tagline sr-only"
            data-taglines='@json($taglines, JSON_HEX_TAG | JSON_HEX_APOS)'
            aria-label="Tagline">
            <span class="hero-tagline-item block">{{ $taglines[0] }}</span>
            <span class="hero-tagline-item absolute inset-0 block opacity-0" aria-hidden="true"></span>
        </p>
    @endif
</section>

    {{-- ===== SAMBUTAN KETUA ===== --}}
    @if ($sambutan)
        <section class="mx-auto w-[90%] max-w-7xl px-8 py-16" aria-label="Sambutan Ketua">
            <div class="grid items-start gap-16 md:grid-cols-2">
                <div class="md:sticky md:top-24 md:self-start">
                    <div class="fade-up">
                        <div class="mx-auto aspect-[3/4] w-full max-w-[400px] overflow-hidden rounded-3xl shadow-lg">
                            {{-- GANTI: foto Ketua PCM Pujon --}}
                            <img src="{{ asset('img/anggota.png') }}" alt="Foto Ketua Pimpinan Cabang Muhammadiyah Pujon"
                                class="h-full w-full object-cover"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/400x500/1a2a75/ffffff?text=Ketua+PCM+Pujon';">
                        </div>
                    </div>
                </div>
                <div class="fade-up">
                    <h2 class="text-2xl font-bold text-brand-indigo md:text-3xl">Sambutan Ketua Pimpinan Cabang Muhammadiyah {{ str_replace('Pimpinan Cabang Muhammadiyah ', '', $namaCabang) }}</h2>
                   <p class="mt-6 whitespace-pre-line text-justify leading-normal text-gray-700">{{ $sambutan }}</p>
                    <p class="mt-4 font-semibold text-brand-indigo">Drs. H. Junaidi, M.Pd.</p>
                    <p class="text-sm text-gray-500">Ketua PCM Pujon</p>
                    {{-- GANTI: nama Ketua PCM Pujon --}}
                </div>
            </div>
        </section>
    @endif

    {{-- ===== KEGIATAN & INFORMASI UTAMA (3 kartu, hover gradient) ===== --}}
    <section class="bg-gray-100 py-16">
        <div class="mx-auto w-[90%] max-w-7xl">
            <h2 class="fade-up text-center text-2xl font-bold text-brand-indigo md:text-3xl">Kegiatan &amp; Informasi Utama</h2>
            <div class="mt-10 grid gap-8 md:grid-cols-3">
                <a href="{{ route('profil') }}" class="group rounded-2xl bg-white p-8 text-center shadow-md transition-all duration-300 hover:bg-gradient-to-br hover:from-brand-navy hover:to-brand-green hover:shadow-xl">
                    <i class="fas fa-sitemap text-5xl text-brand-indigo transition-colors duration-300 group-hover:text-white"></i>
                    <h3 class="mt-4 text-xl font-semibold text-gray-800 transition-colors duration-300 group-hover:text-white">Organisasi</h3>
                    <p class="mt-2 text-gray-600 transition-colors duration-300 group-hover:text-white/90">Profil, struktur, majelis, dan lembaga PCM Pujon.</p>
                </a>
                <a href="{{ route('aum.index') }}" class="group rounded-2xl bg-white p-8 text-center shadow-md transition-all duration-300 hover:bg-gradient-to-br hover:from-brand-navy hover:to-brand-green hover:shadow-xl">
                    <i class="fas fa-building-columns text-5xl text-brand-indigo transition-colors duration-300 group-hover:text-white"></i>
                    <h3 class="mt-4 text-xl font-semibold text-gray-800 transition-colors duration-300 group-hover:text-white">Amal Usaha &amp; Aset</h3>
                    <p class="mt-2 text-gray-600 transition-colors duration-300 group-hover:text-white/90">Direktori sekolah, masjid, dan panti asuhan Muhammadiyah di Pujon.</p>
                </a>
                <a href="{{ route('berita.index') }}" class="group rounded-2xl bg-white p-8 text-center shadow-md transition-all duration-300 hover:bg-gradient-to-br hover:from-brand-navy hover:to-brand-green hover:shadow-xl">
                    <i class="fas fa-newspaper text-5xl text-brand-indigo transition-colors duration-300 group-hover:text-white"></i>
                    <h3 class="mt-4 text-xl font-semibold text-gray-800 transition-colors duration-300 group-hover:text-white">Berita &amp; Galeri</h3>
                    <p class="mt-2 text-gray-600 transition-colors duration-300 group-hover:text-white/90">Kabar terbaru kegiatan dakwah, pendidikan, dan sosial cabang.</p>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== BERITA TERBARU ===== --}}
    <section class="mx-auto w-[90%] max-w-7xl py-16">
        <div class="flex items-end justify-between">
            <h2 class="text-2xl font-bold text-brand-indigo md:text-3xl">Berita Terbaru</h2>
            <a href="{{ route('berita.index') }}" class="font-semibold text-brand-indigo hover:underline">Lihat Semua &rarr;</a>
        </div>

        @if ($latestPosts->isEmpty())
            <p class="mt-8 rounded-xl border border-dashed border-gray-300 bg-brand-soft p-10 text-center text-gray-500">
                Belum ada berita. Silakan kembali lagi nanti.
            </p>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latestPosts as $post)
                    <a href="{{ route('berita.show', $post->slug) }}" class="group overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                        <div class="aspect-[16/9] w-full overflow-hidden bg-gray-200">
                            @if ($post->cover_image)
                                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-4xl text-gray-300"><i class="fas fa-newspaper"></i></div>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-xs font-semibold uppercase tracking-wide text-brand-green">
                                {{ $post->category?->name ?? 'Berita' }}
                                <span class="ml-1 font-normal normal-case text-gray-400">{{ $post->published_at?->format('d M Y') }}</span>
                            </p>
                            <h3 class="mt-2 line-clamp-2 font-semibold leading-snug text-gray-800 group-hover:text-brand-indigo">{{ $post->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
