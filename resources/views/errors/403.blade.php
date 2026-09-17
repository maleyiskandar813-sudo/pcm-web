@extends('layouts.app')

@section('title', '403 — Akses Ditolak')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center section-soft py-20">
    @include('errors.card', [
        'code' => 403,
        'icon' => 'fas fa-lock',
        'title' => 'Akses Ditolak',
        'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini. Silakan masuk dengan akun yang memiliki hak akses.',
    ])
</section>
@endsection
