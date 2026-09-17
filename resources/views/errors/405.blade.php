@extends('layouts.app')

@section('title', '405 — Metode Tidak Diizinkan')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center section-soft py-20">
    @include('errors.card', [
        'code' => 405,
        'icon' => 'fas fa-ban',
        'title' => 'Metode Tidak Diizinkan',
        'message' => 'Tindakan yang Anda lakukan tidak diizinkan pada halaman ini. Silakan gunakan tautan atau tombol yang tersedia.',
    ])
</section>
@endsection
