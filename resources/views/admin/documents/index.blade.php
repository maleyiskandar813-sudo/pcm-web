@extends('layouts.admin')

@section('title', 'Arsip Dokumen — ' . config('app.name'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-brand-indigo">Arsip Dokumen</h1>
        <a href="#upload" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            <i class="fas fa-upload mr-1"></i>Upload Dokumen
        </a>
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        <a href="{{ route('admin.documents.index') }}" class="rounded-full px-3 py-1 text-xs font-medium {{ ! $activeCategory ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700' }}">Semua</a>
        @foreach (\App\Models\Document::CATEGORIES as $category)
            <a href="{{ route('admin.documents.index', ['category' => $category]) }}" class="rounded-full px-3 py-1 text-xs font-medium {{ $activeCategory === $category ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst($category) }}
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-2xl bg-white shadow-md lg:col-span-2">
            @if ($documents->isEmpty())
                <p class="p-10 text-center text-gray-500">Belum ada dokumen terunggah.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-white" style="background:#2c368b;">
                            <th class="px-4 py-3">Dokumen</th>
                            <th class="hidden px-4 py-3 md:table-cell">Ukuran</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr class="border-b border-gray-100">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-800">{{ $document->title }}</p>
                                    <p class="mt-0.5 text-xs text-gray-400">
                                        <span class="rounded-full bg-brand-soft px-2 py-0.5 font-semibold text-brand-indigo">{{ ucfirst($document->category) }}</span>
                                        &middot; {{ $document->file_name }} &middot; oleh {{ $document->uploader?->name }}
                                    </p>
                                </td>
                                <td class="hidden px-4 py-3 md:table-cell">{{ number_format($document->file_size / 1024, 1) }} KB</td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.documents.download', $document) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-green hover:bg-green-50">
                                        <i class="fas fa-download mr-1"></i>Unduh
                                    </a>
                                    <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" class="inline" onsubmit="return confirm('Hapus dokumen ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data" id="upload" class="h-fit space-y-4 rounded-2xl bg-white p-6 shadow-md">
            @csrf

            <h2 class="text-lg font-bold text-brand-indigo">Upload Dokumen</h2>

            <div>
                <label for="title" class="mb-1 block text-sm font-semibold text-gray-700">Judul Dokumen</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="mb-1 block text-sm font-semibold text-gray-700">Kategori</label>
                <select name="category" id="category" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                    @foreach (\App\Models\Document::CATEGORIES as $category)
                        <option value="{{ $category }}" @selected(old('category') === $category)>{{ ucfirst($category) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="file" class="mb-1 block text-sm font-semibold text-gray-700">File</label>
                <input type="file" name="file" id="file" required
                    class="w-full rounded-lg border px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-brand-soft file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-brand-indigo {{ $errors->has('file') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                <p class="mt-1 text-xs text-gray-400">PDF, Word, Excel, gambar, ZIP &mdash; maks 10 MB.</p>
                @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white hover:opacity-90">
                Unggah Dokumen
            </button>
        </form>
    </div>
@endsection
