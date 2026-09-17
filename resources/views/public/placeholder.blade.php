@extends('layouts.app')

@section('title', $pageTitle . ' — ' . config('app.name'))

@section('content')
    <section class="section-soft py-16">
        <div class="mx-auto w-[90%] max-w-7xl">
            <h1 class="page-title">{{ $pageTitle }}</h1>
            <p class="mt-4 text-lg text-gray-600">{{ $message }}</p>
            <p class="mt-6 text-sm text-gray-400">
                Halaman ini sedang dalam pengembangan. Kembali ke <a href="{{ route('home') }}" class="text-brand-indigo underline">Beranda</a>.
            </p>
        </div>
    </section>
@endsection
