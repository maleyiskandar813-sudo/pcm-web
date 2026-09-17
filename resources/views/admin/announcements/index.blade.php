@extends('layouts.admin')

@section('title', 'Kelola Pengumuman — ' . config('app.name'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-brand-indigo">Kelola Pengumuman</h1>
        <a href="{{ route('admin.announcements.create') }}" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            <i class="fas fa-plus mr-1"></i>Buat Pengumuman
        </a>
    </div>

    @if ($announcements->isEmpty())
        <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            Belum ada pengumuman.
        </p>
    @else
        <div class="mt-6 space-y-4">
            @foreach ($announcements as $item)
                <article class="rounded-2xl bg-white p-6 shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1">
                            <h2 class="font-bold text-gray-800">{{ $item->title }}</h2>
                            <p class="mt-1 text-xs text-gray-400">{{ $item->published_at->format('d M Y, H:i') }}</p>
                            <p class="mt-3 line-clamp-3 text-sm text-gray-600">{{ $item->body }}</p>
                        </div>
                        <div class="whitespace-nowrap">
                            <a href="{{ route('admin.announcements.edit', $item) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-indigo hover:bg-gray-100">Edit</a>
                            <form method="POST" action="{{ route('admin.announcements.destroy', $item) }}" class="inline" onsubmit="return confirm('Hapus pengumuman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    @endif
@endsection
