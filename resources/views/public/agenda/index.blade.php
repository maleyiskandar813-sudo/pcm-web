@extends('layouts.app')

@section('title', 'Agenda & Pengumuman — ' . config('app.name'))

@section('meta_description', 'Agenda kegiatan dan pengumuman resmi Pimpinan Cabang Muhammadiyah Pujon, Malang.')

@section('content')
    <section class="section-soft py-12">
        <div class="mx-auto w-[90%] max-w-6xl">
            <h1 class="page-title">Agenda &amp; Pengumuman</h1>
            <p class="mt-2 text-gray-600">Kegiatan mendatang dan informasi resmi cabang.</p>

            {{-- ===== AGENDA MENDATANG ===== --}}
            <h2 class="sub-title mt-10">Agenda Mendatang</h2>
            @if ($upcoming->isEmpty())
                <p class="mt-6 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-500">
                    Belum ada agenda mendatang.
                </p>
            @else
                <div class="mt-6 space-y-4">
                    @foreach ($upcoming as $agenda)
                        <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 shadow-md sm:flex-row sm:items-center">
                            <div class="flex shrink-0 items-center gap-3 sm:w-40">
                                <div class="text-center">
                                    <p class="text-3xl font-bold text-brand-indigo">{{ $agenda->starts_at->format('d') }}</p>
                                    <p class="text-xs font-semibold uppercase text-brand-green">{{ $agenda->starts_at->format('M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $agenda->title }}</h3>
                                <p class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-600">
                                    <span><i class="far fa-clock mr-1"></i>{{ $agenda->starts_at->format('H:i') }}{{ $agenda->ends_at ? ' — ' . $agenda->ends_at->format('H:i') : '' }} WIB</span>
                                    @if ($agenda->location)
                                        <span><i class="fas fa-location-dot mr-1"></i>{{ $agenda->location }}</span>
                                    @endif
                                </p>
                                @if ($agenda->description)
                                    <p class="mt-2 text-sm text-gray-500">{{ $agenda->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $upcoming->links() }}
                </div>
            @endif

            {{-- ===== AGENDA LALU ===== --}}
            @if ($past->isNotEmpty())
                <h2 class="sub-title mt-12">Agenda yang Telah Berlangsung</h2>
                <div class="mt-6 space-y-3">
                    @foreach ($past as $agenda)
                        <div class="flex items-center gap-4 rounded-xl bg-white/70 px-5 py-4 shadow-sm">
                            <span class="shrink-0 text-sm font-semibold text-gray-400">{{ $agenda->starts_at->format('d M Y') }}</span>
                            <span class="font-medium text-gray-600 line-through decoration-gray-300">{{ $agenda->title }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- ===== PENGUMUMAN ===== --}}
            <h2 class="sub-title mt-12">Pengumuman</h2>
            @if ($announcements->isEmpty())
                <p class="mt-6 rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-gray-500">
                    Belum ada pengumuman.
                </p>
            @else
                <div class="mt-6 space-y-4">
                    @foreach ($announcements as $item)
                        <div class="rounded-2xl border-l-4 border-brand-gold bg-white p-6 shadow-md">
                            <p class="text-xs font-semibold uppercase tracking-wide text-brand-green">
                                <i class="fas fa-bullhorn mr-1"></i>{{ $item->published_at?->format('d M Y') }}
                            </p>
                            <h3 class="mt-1 text-lg font-semibold text-gray-800">{{ $item->title }}</h3>
                            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-600">{{ $item->body }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
