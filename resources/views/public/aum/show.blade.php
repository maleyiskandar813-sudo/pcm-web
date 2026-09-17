@extends('layouts.app')

@section('title', $aum->name . ' — ' . config('app.name'))

@section('meta_description', $aum->description ?? 'Informasi ' . $aum->name . ', Amal Usaha Muhammadiyah di Pujon, Malang.')

@section('content')
    <article class="mx-auto w-[90%] max-w-5xl py-12">
        <nav aria-label="breadcrumb" class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> &raquo;
            <a href="{{ route('aum.index') }}" class="hover:underline">AUM</a> &raquo;
            <span class="text-gray-800">{{ $aum->name }}</span>
        </nav>

        <div class="mt-6 grid gap-10 lg:grid-cols-2">
            <div>
                <div class="overflow-hidden rounded-2xl">
                    @if ($aum->photo)
                        <img src="{{ asset('storage/' . $aum->photo) }}" alt="{{ $aum->name }}" class="aspect-[4/3] w-full object-cover">
                    @else
                        <div class="flex aspect-[4/3] w-full items-center justify-center bg-gray-200 text-6xl text-gray-300"><i class="fas fa-building-columns"></i></div>
                    @endif
                </div>
            </div>

            <div>
                <span class="rounded-full bg-brand-green/10 px-3 py-1 text-sm font-semibold uppercase text-brand-green">{{ $aum->type }}</span>
                <h1 class="mt-3 text-3xl font-bold leading-tight text-brand-indigo">{{ $aum->name }}</h1>

                <ul class="mt-6 space-y-3 text-gray-700">
                    @if ($aum->address)
                        <li class="flex gap-3"><i class="fas fa-location-dot mt-1 w-5 text-brand-green"></i><span>{{ $aum->address }}</span></li>
                    @endif
                    @if ($aum->phone)
                        <li class="flex gap-3"><i class="fas fa-phone mt-1 w-5 text-brand-green"></i><span>{{ $aum->phone }}</span></li>
                    @endif
                </ul>

                @if ($aum->description)
                    <p class="mt-6 whitespace-pre-line leading-relaxed text-gray-700">{{ $aum->description }}</p>
                @endif
            </div>
        </div>

        @if ($aum->maps_url)
            <div class="aum-map mt-10 overflow-hidden rounded-2xl">
                <iframe
                    title="Peta lokasi {{ $aum->name }}"
                    src="{{ $aum->maps_url }}"
                    class="h-[350px] w-full border-0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen></iframe>
            </div>
        @endif
    </article>

    @if ($others->isNotEmpty())
        <section class="section-soft py-14">
            <div class="mx-auto w-[90%] max-w-7xl">
                <h2 class="text-2xl font-bold text-brand-indigo">{{ ucfirst($aum->type) }} Lainnya</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($others as $item)
                        <a href="{{ route('aum.show', $item->id) }}" class="group overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase text-brand-green">{{ $item->type }}</p>
                                <h3 class="mt-1 line-clamp-2 font-semibold text-gray-800 group-hover:text-brand-indigo">{{ $item->name }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
