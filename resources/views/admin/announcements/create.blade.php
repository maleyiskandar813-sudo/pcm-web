@extends('layouts.admin')

@section('title', 'Buat Pengumuman — ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-brand-indigo">Buat Pengumuman</h1>
        <a href="{{ route('admin.announcements.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.announcements.store') }}" class="mt-6 max-w-3xl space-y-5 rounded-2xl bg-white p-8 shadow-md">
        @csrf

        <div>
            <label for="title" class="mb-1 block text-sm font-semibold text-gray-700">Judul Pengumuman</label>
            <input type="text" name="title" id="title" required value="{{ old('title') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="body" class="mb-1 block text-sm font-semibold text-gray-700">Isi Pengumuman</label>
            <textarea name="body" id="body" rows="6" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">{{ old('body') }}</textarea>
            @error('body')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="published_at" class="mb-1 block text-sm font-semibold text-gray-700">Tanggal Terbit</label>
            <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
        </div>

        <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white hover:opacity-90">
            Simpan Pengumuman
        </button>
    </form>
@endsection
