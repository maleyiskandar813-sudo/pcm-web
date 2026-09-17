@extends('layouts.admin')

@section('title', 'Tambah Agenda — ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-brand-indigo">Tambah Agenda</h1>
        <a href="{{ route('admin.agenda.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.agenda.store') }}" class="mt-6 max-w-3xl space-y-5 rounded-2xl bg-white p-8 shadow-md">
        @csrf

        <div>
            <label for="title" class="mb-1 block text-sm font-semibold text-gray-700">Nama Kegiatan</label>
            <input type="text" name="title" id="title" required value="{{ old('title') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="starts_at" class="mb-1 block text-sm font-semibold text-gray-700">Mulai</label>
                <input type="datetime-local" name="starts_at" id="starts_at" required value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                @error('starts_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="ends_at" class="mb-1 block text-sm font-semibold text-gray-700">Selesai (opsional)</label>
                <input type="datetime-local" name="ends_at" id="ends_at" value="{{ old('ends_at') }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                @error('ends_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="location" class="mb-1 block text-sm font-semibold text-gray-700">Lokasi</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
        </div>

        <div>
            <label for="description" class="mb-1 block text-sm font-semibold text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white hover:opacity-90">
            Simpan Agenda
        </button>
    </form>
@endsection
