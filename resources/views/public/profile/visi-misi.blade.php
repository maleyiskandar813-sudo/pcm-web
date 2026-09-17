@extends('layouts.app')

@section('title', 'Visi & Misi — ' . config('app.name'))

@section('meta_description', 'Visi dan misi Pimpinan Cabang Muhammadiyah Pujon, Malang.')

@section('content')
    <section class="section-soft py-12">
        <div class="mx-auto w-[90%] max-w-5xl">
            <a href="{{ route('profil') }}" class="text-sm font-semibold text-brand-indigo hover:underline">&larr; Kembali ke Profil</a>

            <h1 class="page-title mt-4">Visi &amp; Misi</h1>
            <p class="mt-2 text-gray-600">Visi dan misi Pimpinan Cabang Muhammadiyah Pujon.</p>

            <div class="fade-up mt-8 rounded-2xl bg-white p-8 shadow-md">
                @if ($visiMisi)
                    <div class="whitespace-pre-line leading-relaxed text-gray-700">{{ $visiMisi }}</div>
                @else
                    <p class="text-gray-500">Visi dan misi cabang belum diisi. Silakan kembali lagi nanti.</p>
                @endif
            </div>
        </div>
    </section>
@endsection