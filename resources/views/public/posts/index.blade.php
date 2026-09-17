@extends('layouts.app')

@section('title', ($activeCategory ? ucfirst($activeCategory) . ' — ' : '') . 'Berita — ' . config('app.name'))

@section('meta_description', 'Berita dan artikel resmi Pimpinan Cabang Muhammadiyah Pujon.')

@section('content')
    <section class="mx-auto w-[90%] max-w-7xl py-12">
        <h1 class="page-title">Berita &amp; Artikel</h1>
        <p class="mt-2 text-gray-600">Informasi resmi kegiatan dakwah, pendidikan, dan sosial PCM Pujon.</p>

        <div class="mt-6 flex flex-wrap gap-2">
            <a href="{{ route('berita.index') }}"
                class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ ! $activeCategory ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Semua
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('berita.category', $category->slug) }}"
                    class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ $activeCategory === $category->slug ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        @if ($posts->isEmpty())
            <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-brand-soft p-10 text-center text-gray-500">
                Belum ada berita untuk tampilan ini. Silakan kembali lagi nanti.
            </p>
        @else
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
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
                            <h2 class="mt-2 line-clamp-2 text-lg font-semibold leading-snug text-gray-800 group-hover:text-brand-indigo">{{ $post->title }}</h2>
                            @if ($post->excerpt)
                                <p class="mt-2 line-clamp-2 text-sm text-gray-600">{{ $post->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </section>
@endsection
