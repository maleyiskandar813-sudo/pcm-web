@extends('layouts.app')

@section('title', '429 — Terlalu Banyak Permintaan')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center section-soft py-20">
    @include('errors.card', [
        'code' => 429,
        'icon' => 'fas fa-gauge-high',
        'title' => 'Terlalu Banyak Permintaan',
        'message' => 'Anda terlalu sering melakukan permintaan dalam waktu singkat. Silakan tunggu beberapa saat lalu coba lagi.',
    ])
</section>
@endsection
