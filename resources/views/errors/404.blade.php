@extends('layouts.app')

@section('title', '404 — Halaman Tidak Ditemukan')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center section-soft py-20">
    @include('errors.card', [
        'code' => 404,
        'icon' => 'fas fa-compass',
        'title' => 'Halaman Tidak Ditemukan',
        'message' => 'Maaf, halaman yang Anda cari tidak ada, telah dihapus, atau dipindahkan ke alamat lain.',
    ])
</section>
@endsection
