@extends('layouts.app')

@section('title', '500 — Terjadi Kesalahan')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center section-soft py-20">
    @include('errors.card', [
        'code' => 500,
        'icon' => 'fas fa-triangle-exclamation',
        'title' => 'Terjadi Kesalahan',
        'message' => 'Maaf, terjadi kesalahan pada sistem kami. Silakan coba beberapa saat lagi, atau hubungi administrator.',
    ])
</section>
@endsection
