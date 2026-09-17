@extends('layouts.app')

@section('title', '419 — Sesi Telah Berakhir')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center section-soft py-20">
    @include('errors.card', [
        'code' => 419,
        'icon' => 'fas fa-hourglass-end',
        'title' => 'Sesi Telah Berakhir',
        'message' => 'Sesi Anda telah berakhir karena halaman terlalu lama terbuka. Silakan muat ulang dan coba lagi.',
    ])
</section>
@endsection
