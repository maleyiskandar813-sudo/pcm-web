@extends('layouts.app')

@section('title', 'Majelis & Lembaga — ' . config('app.name'))

@section('meta_description', 'Daftar majelis dan lembaga Pimpinan Cabang Muhammadiyah Pujon, Malang.')

@section('content')
    <section class="section-soft py-12">
        <div class="mx-auto w-[90%] max-w-5xl">
            <h1 class="page-title">Majelis &amp; Lembaga</h1>
            <p class="mt-2 text-gray-600">Pembantu Pimpinan Cabang dalam menjalankan tugas-tugas Persyarikatan.</p>

            @if (count($majelis) === 0)
                <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
                    Daftar majelis dan lembaga belum diisi. Silakan kembali lagi nanti.
                </p>
            @else
                <div class="mt-10 grid gap-6 sm:grid-cols-2">
                    @foreach ($majelis as $item)
                        <div class="fade-up rounded-2xl border-l-4 border-brand-gold bg-white p-6 shadow-md">
                            <h2 class="text-lg font-semibold text-brand-indigo">{{ $item['nama'] ?? '' }}</h2>
                            @if (! empty($item['deskripsi']))
                                <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ $item['deskripsi'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
