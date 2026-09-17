@extends('layouts.admin')

@section('title', 'Edit AUM — ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-brand-indigo">Edit AUM</h1>
        <a href="{{ route('admin.aum.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.aum.update', $aum) }}" enctype="multipart/form-data" class="mt-6 max-w-3xl space-y-5 rounded-2xl bg-white p-8 shadow-md">
        @csrf
        @method('PUT')

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="type" class="mb-1 block text-sm font-semibold text-gray-700">Jenis AUM</label>
                <select name="type" id="type" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                    @foreach (\App\Models\Aum::TYPES as $type)
                        <option value="{{ $type }}" @selected(old('type', $aum->type) === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="name" class="mb-1 block text-sm font-semibold text-gray-700">Nama AUM</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $aum->name) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="address" class="mb-1 block text-sm font-semibold text-gray-700">Alamat</label>
            <textarea name="address" id="address" rows="2" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">{{ old('address', $aum->address) }}</textarea>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="phone" class="mb-1 block text-sm font-semibold text-gray-700">Telepon</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $aum->phone) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
            </div>
            <div>
                <label for="maps_url" class="mb-1 block text-sm font-semibold text-gray-700">Link Google Maps (embed)</label>
                <input type="url" name="maps_url" id="maps_url" value="{{ old('maps_url', $aum->maps_url) }}" placeholder="https://www.google.com/maps/embed?pb=..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                @error('maps_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="description" class="mb-1 block text-sm font-semibold text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">{{ old('description', $aum->description) }}</textarea>
        </div>

        <div>
            <label for="photo" class="mb-1 block text-sm font-semibold text-gray-700">Foto (opsional)</label>
            <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/webp"
                class="w-full rounded-lg border px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-brand-soft file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-brand-indigo {{ $errors->has('photo') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
            @if ($aum->photo)
                <p class="mt-1 text-xs text-gray-400">Biarkan kosong untuk mempertahankan foto saat ini.</p>
            @endif
            @error('photo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white hover:opacity-90">
            Simpan Perubahan
        </button>
    </form>
@endsection
