@extends('layouts.admin')

@section('title', 'Persetujuan Berita — ' . config('app.name'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-brand-indigo">Persetujuan Berita</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.approvals.index') }}" class="rounded-full px-3 py-1 text-xs font-medium {{ ! $showRejected ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700' }}">Antrean</a>
            <a href="{{ route('admin.approvals.index', ['rejected' => 1]) }}" class="rounded-full px-3 py-1 text-xs font-medium {{ $showRejected ? 'bg-brand-navy text-white' : 'bg-gray-100 text-gray-700' }}">Ditolak</a>
        </div>
    </div>

    @if ($posts->isEmpty())
        <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            {{ $showRejected ? 'Belum ada berita yang ditolak.' : 'Tidak ada berita yang menunggu persetujuan. Semua aman.' }}
        </p>
    @else
        <div class="mt-6 space-y-4">
            @foreach ($posts as $post)
                <article class="rounded-2xl bg-white p-6 shadow-md">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">{{ $post->title }}</h2>
                            <p class="mt-1 text-xs text-gray-400">
                                oleh <span class="font-semibold text-gray-600">{{ $post->author?->name }}</span>
                                &middot; {{ $post->category?->name ?? 'Tanpa kategori' }}
                                &middot; diajukan {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if ($post->rejection_note)
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                        @endif
                    </div>

                    <details class="mt-4">
                        <summary class="cursor-pointer text-sm font-semibold text-brand-indigo">Lihat isi berita</summary>
                        <div class="prose prose-sm mt-3 max-h-80 overflow-y-auto rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
                            {!! nl2br(e($post->excerpt)) !!}
                            <div class="mt-3 border-t border-gray-200 pt-3">{!! $post->body !!}</div>
                        </div>
                    </details>

                    @if ($post->rejection_note)
                        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm">
                            <p class="font-semibold text-red-700">Catatan Ketua:</p>
                            <p class="mt-1 text-red-700">{{ $post->rejection_note }}</p>
                        </div>
                    @else
                        <div class="mt-5 flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('admin.approvals.approve', $post) }}">
                                @csrf
                                <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-5 py-2 text-sm font-semibold text-white hover:opacity-90">
                                    <i class="fas fa-check mr-1"></i>Setujui &amp; Terbitkan
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.approvals.reject', $post) }}" class="flex flex-1 flex-wrap items-center gap-2">
                                @csrf
                                <input type="text" name="rejection_note" placeholder="Alasan penolakan (wajib)" required maxlength="255"
                                    class="min-w-52 flex-1 rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-red-500 focus:outline-none">
                                <button type="submit" class="rounded-lg border border-red-200 px-5 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">
                                    Tolak
                                </button>
                            </form>
                        </div>
                        @error('rejection_note')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    @endif
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    @endif
@endsection
