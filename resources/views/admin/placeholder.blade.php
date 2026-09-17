@extends('layouts.admin')

@section('title', $title . ' — ' . config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-brand-indigo">{{ $title }}</h1>
    <p class="mt-3 text-gray-500">Modul ini sedang disiapkan.</p>
@endsection
