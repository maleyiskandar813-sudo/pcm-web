@extends('layouts.admin')

@section('title', 'Edit Berita — ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-brand-indigo">Edit Berita</h1>
        <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="mt-6 max-w-4xl space-y-5 rounded-2xl bg-white p-8 shadow-md">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="mb-1 block text-sm font-semibold text-gray-700">Judul Berita</label>
            <input type="text" name="title" id="title" required value="{{ old('title', $post->title) }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="category_id" class="mb-1 block text-sm font-semibold text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                    <option value="">Tanpa kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="mb-1 block text-sm font-semibold text-gray-700">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                    <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
                </select>
            </div>
        </div>

        <div>
            <label for="excerpt" class="mb-1 block text-sm font-semibold text-gray-700">Ringkasan (excerpt)</label>
            <textarea name="excerpt" id="excerpt" rows="2" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        <div>
            <label for="body" class="mb-1 block text-sm font-semibold text-gray-700">Isi Berita</label>
            <textarea name="body" id="body" rows="10" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">{{ old('body', $post->body) }}</textarea>
            @error('body')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="cover_image" class="mb-1 block text-sm font-semibold text-gray-700">Gambar Sampul</label>
                <input type="file" name="cover_image" id="cover_image" accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-lg border px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-brand-soft file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-brand-indigo {{ $errors->has('cover_image') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                @if ($post->cover_image)
                    <p class="mt-1 text-xs text-gray-400">Biarkan kosong untuk mempertahankan gambar saat ini.</p>
                @endif
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="published_at" class="mb-1 block text-sm font-semibold text-gray-700">Tanggal Terbit</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="needs_approval" value="1" @checked(old('needs_approval', $post->needs_approval)) class="h-4 w-4 rounded border-gray-300 text-brand-navy">
            Berita ini memerlukan persetujuan Ketua sebelum tampil publik
        </label>

        <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white hover:opacity-90">
            Simpan Perubahan
        </button>
    </form>
@endsection
