@extends('layouts.admin')

@section('title', 'Kelola Berita — ' . config('app.name'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-brand-indigo">Kelola Berita</h1>
        <a href="{{ route('admin.posts.create') }}" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            <i class="fas fa-plus mr-1"></i>Buat Berita
        </a>
    </div>

    <div class="mt-4 flex gap-2">
        <a href="{{ route('admin.posts.index') }}" class="rounded-full px-3 py-1 text-xs font-medium {{ ! $activeStatus ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700' }}">Semua</a>
        @foreach (['draft', 'published'] as $status)
            <a href="{{ route('admin.posts.index', ['status' => $status]) }}" class="rounded-full px-3 py-1 text-xs font-medium {{ $activeStatus === $status ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($status) }}</a>
        @endforeach
    </div>

    @if ($posts->isEmpty())
        <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            Belum ada berita. Klik "Buat Berita" untuk mulai.
        </p>
    @else
        <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-md">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-white" style="background:#2c368b;">
                        <th class="px-4 py-3">Judul</th>
                        <th class="hidden px-4 py-3 md:table-cell">Kategori</th>
                        <th class="hidden px-4 py-3 md:table-cell">Status</th>
                        <th class="hidden px-4 py-3 lg:table-cell">Approval</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr class="border-b border-gray-100 align-middle">
                            <td class="px-4 py-3">
                                <a href="{{ route('berita.show', $post->slug) }}" class="line-clamp-1 font-semibold text-gray-800 hover:text-brand-indigo">{{ $post->title }}</a>
                                <p class="mt-0.5 text-xs text-gray-400">{{ $post->author?->name }} &middot; {{ $post->published_at?->format('d M Y') ?? 'Belum terjadwal' }}</p>
                            </td>
                            <td class="hidden px-4 py-3 md:table-cell">{{ $post->category?->name ?? '—' }}</td>
                            <td class="hidden px-4 py-3 md:table-cell">
                                <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $post->status === 'published' ? 'bg-brand-green/10 text-brand-green' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $post->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="hidden px-4 py-3 lg:table-cell">
                                @if ($post->needs_approval)
                                    <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $post->is_approved ? 'bg-brand-green/10 text-brand-green' : 'bg-red-100 text-red-700' }}">
                                        {{ $post->is_approved ? 'Disetujui' : 'Menunggu' }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Tidak perlu</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-indigo hover:bg-gray-100">Edit</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline" onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
