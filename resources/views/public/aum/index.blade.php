@extends('layouts.app')

@section('title', 'Direktori AUM — ' . config('app.name'))

@section('meta_description', 'Direktori Amal Usaha Muhammadiyah di Kecamatan Pujon: pertanian, masjid, dan panti asuhan.')
@section('content')
    <section class="section-soft py-12">
        <div class="mx-auto w-[90%] max-w-7xl">
            <h1 class="page-title">Direktori Amal Usaha Muhammadiyah</h1>
           <p class="mt-2 text-gray-600">Pertanian, masjid, dan panti asuhan Muhammadiyah di Pujon.</p>

            <div class="mt-6 flex flex-wrap gap-2">
                <a href="{{ route('aum.index') }}"
                    class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ ! $activeType ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach ($types as $type)
                    <a href="{{ route('aum.index', ['type' => $type]) }}"
                        class="rounded-full px-4 py-1.5 text-sm font-medium capitalize transition {{ $activeType === $type ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $type }}
                    </a>
                @endforeach
            </div>

            @if ($aums->isEmpty())
                <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
                    Belum ada data Amal Usaha Muhammadiyah untuk tampilan ini.
                </p>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($aums as $aum)
                        <a href="{{ route('aum.show', $aum->id) }}" class="group overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:shadow-xl">
                            <div class="aspect-[16/9] w-full overflow-hidden bg-gray-200">
                                @if ($aum->photo)
                                    <img src="{{ asset('storage/' . $aum->photo) }}" alt="{{ $aum->name }}" loading="lazy"
                                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-4xl text-gray-300">
                                        <i class="fas fa-building-columns"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <p class="text-xs font-semibold uppercase tracking-wide text-brand-green">{{ $aum->type }}</p>
                                <h2 class="mt-1 line-clamp-2 font-semibold text-gray-800 group-hover:text-brand-indigo">{{ $aum->name }}</h2>
                                @if ($aum->address)
                                    <p class="mt-2 line-clamp-2 text-sm text-gray-600"><i class="fas fa-location-dot mr-1"></i>{{ $aum->address }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $aums->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
