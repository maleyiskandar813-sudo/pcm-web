@extends('layouts.app')

@section('title', $post->title . ' — ' . config('app.name'))

@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->body), 160))

@php use Illuminate\Support\Str; @endphp

@section('content')
    <article class="mx-auto w-[90%] max-w-4xl py-12">
        <nav aria-label="breadcrumb" class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> &raquo;
            <a href="{{ route('berita.index') }}" class="hover:underline">Berita</a> &raquo;
            <span class="text-gray-800">{{ $post->title }}</span>
        </nav>

        <h1 class="mt-4 text-3xl font-bold leading-tight text-brand-indigo md:text-4xl">{{ $post->title }}</h1>

        <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-gray-500">
            <span class="rounded-full bg-brand-green/10 px-3 py-1 font-semibold text-brand-green">{{ $post->category?->name ?? 'Berita' }}</span>
            <span><i class="far fa-calendar mr-1"></i>{{ $post->published_at?->format('d M Y H:i') }}</span>
            @if ($post->author)
                <span><i class="far fa-user mr-1"></i>{{ $post->author->name }}</span>
            @endif
        </div>

        <div class="mt-6 overflow-hidden rounded-2xl">
            @if ($post->cover_image)
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="aspect-[16/9] w-full object-cover">
            @else
                <div class="flex aspect-[16/9] w-full items-center justify-center bg-gray-200 text-6xl text-gray-300"><i class="fas fa-newspaper"></i></div>
            @endif
        </div>

        <div class="prose prose-gray mx-auto mt-8 max-w-none leading-relaxed text-gray-800">
            {!! $post->body !!}
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="section-soft py-14">
            <div class="mx-auto w-[90%] max-w-7xl">
                <h2 class="text-2xl font-bold text-brand-indigo">Berita Terkait</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('berita.show', $item->slug) }}" class="group overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                            <div class="aspect-[16/9] w-full overflow-hidden bg-gray-200">
                                @if ($item->cover_image)
                                    <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-4xl text-gray-300"><i class="fas fa-newspaper"></i></div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="line-clamp-2 font-semibold leading-snug text-gray-800 group-hover:text-brand-indigo">{{ $item->title }}</h3>
                                <p class="mt-2 text-xs text-gray-400">{{ $item->published_at?->format('d M Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
