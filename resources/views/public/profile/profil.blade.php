@extends('layouts.app')

@section('title', 'Profil PCM Pujon — ' . config('app.name'))

@section('meta_description', 'Profil, visi misi, sejarah, dan struktur organisasi Pimpinan Cabang Muhammadiyah Pujon, Malang.')

@section('content')
    <section class="section-soft pb-12 pt-28 md:pt-32">
        <div class="mx-auto w-[90%] max-w-5xl">
            <h1 class="page-title">Profil PCM Pujon</h1>
            <p class="mt-2 text-gray-600">Mengenal lebih dekat Pimpinan Cabang Muhammadiyah Pujon.</p>

            {{-- ===== VISI MISI ===== --}}
            {{-- ===== VISI MISI ===== --}}
<a href="{{ route('profil.visi-misi') }}" class="fade-up mt-10 flex items-center justify-between rounded-2xl bg-white p-8 shadow-md transition hover:shadow-lg">
    <div>
        <h2 class="sub-title">Visi &amp; Misi</h2>
        <p class="mt-2 text-gray-500">Lihat visi dan misi Pimpinan Cabang Muhammadiyah Pujon selengkapnya.</p>
    </div>
    <i class="fas fa-arrow-right text-xl text-brand-indigo"></i>
</a>

            {{-- ===== SEJARAH ===== --}}
<a href="{{ route('profil.sejarah') }}" class="fade-up mt-8 flex items-center justify-between rounded-2xl bg-white p-8 shadow-md transition hover:shadow-lg">
    <div>
        <h2 class="sub-title">Sejarah Cabang</h2>
        <p class="mt-2 text-gray-500">Baca sejarah singkat Pimpinan Cabang Muhammadiyah Pujon selengkapnya.</p>
    </div>
    <i class="fas fa-arrow-right text-xl text-brand-indigo"></i>
</a>

            {{-- ===== STRUKTUR ORGANISASI ===== --}}
<a href="{{ route('profil.struktur') }}" class="fade-up mt-8 flex items-center justify-between rounded-2xl bg-white p-8 shadow-md transition hover:shadow-lg">
    <div>
        <h2 class="sub-title">Struktur Organisasi</h2>
        <p class="mt-2 text-gray-500">Lihat susunan Pimpinan Cabang Muhammadiyah Pujon selengkapnya.</p>
    </div>
    <i class="fas fa-arrow-right text-xl text-brand-indigo"></i>
</a>