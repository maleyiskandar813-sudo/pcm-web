@extends('layouts.app')

@section('title', 'Sejarah Cabang — ' . config('app.name'))

@section('meta_description', 'Sejarah singkat Pimpinan Cabang Muhammadiyah Pujon, Malang.')

@section('content')
    <section class="section-soft py-12">
        <div class="mx-auto w-[90%] max-w-5xl">
            <a href="{{ route('profil') }}" class="text-sm font-semibold text-brand-indigo hover:underline">&larr; Kembali ke Profil</a>

            <h1 class="page-title mt-4">Sejarah Cabang</h1>
            <p class="mt-2 text-gray-600">Sejarah singkat Pimpinan Cabang Muhammadiyah Pujon.</p>

            <div class="fade-up mt-8 rounded-2xl bg-white p-8 shadow-md">
                @if ($sejarah)
                    <div class="whitespace-pre-line text-justify leading-relaxed text-gray-700">{!! $sejarah !!}</div>
                @else
                    <p class="text-gray-500">Sejarah cabang belum diisi. Silakan kembali lagi nanti.</p>
                @endif
            </div>
        </div>
    </section>
@endsection