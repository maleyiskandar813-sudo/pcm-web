@extends('layouts.admin')

@section('title', 'Dashboard Admin — ' . config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-brand-indigo">Dashboard</h1>
    <p class="mt-2 text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}.</p>

    {{-- ===== STATISTIK ===== --}}
    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        <a href="{{ route('admin.posts.index') }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-3xl font-bold text-brand-indigo">{{ $stats['posts'] }}</p>
                    <p class="mt-1 text-sm text-gray-500">Berita</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-navy/10 text-xl text-brand-navy transition group-hover:bg-brand-navy group-hover:text-white">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.agenda.index') }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-3xl font-bold text-brand-green">{{ $stats['agenda'] }}</p>
                    <p class="mt-1 text-sm text-gray-500">Agenda Mendatang</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-green/10 text-xl text-brand-green transition group-hover:bg-brand-green group-hover:text-white">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.aum.index') }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-3xl font-bold text-amber-600">{{ $stats['aum'] }}</p>
                    <p class="mt-1 text-sm text-gray-500">AUM</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-xl text-amber-600 transition group-hover:bg-amber-500 group-hover:text-white">
                    <i class="fas fa-building-columns"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-3xl font-bold text-brand-teal">{{ $stats['unreadMessages'] }}</p>
                    <p class="mt-1 text-sm text-gray-500">Pesan Belum Dibaca</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-teal/10 text-xl text-brand-teal transition group-hover:bg-brand-teal group-hover:text-white">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </a>
        @if (auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.approvals.index') }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-3xl font-bold text-red-500">{{ $stats['pendingApproval'] ?? 0 }}</p>
                        <p class="mt-1 text-sm text-gray-500">Menunggu Persetujuan</p>
                    </div>
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-xl text-red-500 transition group-hover:bg-red-500 group-hover:text-white">
                        <i class="fas fa-check-double"></i>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.users.index') }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-3xl font-bold text-brand-teal">{{ $stats['users'] ?? 0 }}</p>
                        <p class="mt-1 text-sm text-gray-500">User</p>
                    </div>
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-brand-teal/10 text-xl text-brand-teal transition group-hover:bg-brand-teal group-hover:text-white">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </a>
        @endif
        <a href="{{ route('admin.documents.index') }}" class="group rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-3xl font-bold text-gray-600">{{ $stats['documents'] }}</p>
                    <p class="mt-1 text-sm text-gray-500">Dokumen Arsip</p>
                </div>
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-xl text-gray-600 transition group-hover:bg-gray-600 group-hover:text-white">
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        {{-- ===== BERITA TERBARU ===== --}}
        <div class="rounded-2xl bg-white p-6 shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-gray-800">Berita Terbaru</h2>
                <a href="{{ route('admin.posts.index') }}" class="text-sm font-semibold text-brand-indigo hover:underline">Lihat semua</a>
            </div>
            @if ($recentPosts->isEmpty())
                <p class="mt-4 text-sm text-gray-400">Belum ada berita.</p>
            @else
                <ul class="mt-4 divide-y divide-gray-100">
                    @foreach ($recentPosts as $post)
                        <li class="flex items-center justify-between gap-3 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-700">{{ $post->title }}</p>
                                <p class="text-xs text-gray-400">{{ $post->author?->name }} &middot; {{ $post->published_at?->diffForHumans() }}</p>
                            </div>
                            <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-semibold {{ $post->status === 'published' ? 'bg-brand-green/10 text-brand-green' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- ===== PESAN TERBARU ===== --}}
        <div class="rounded-2xl bg-white p-6 shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-gray-800">Pesan Masuk</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-semibold text-brand-indigo hover:underline">Lihat semua</a>
            </div>
            @if ($recentMessages->isEmpty())
                <p class="mt-4 text-sm text-gray-400">Belum ada pesan.</p>
            @else
                <ul class="mt-4 divide-y divide-gray-100">
                    @foreach ($recentMessages as $message)
                        <li class="flex items-center justify-between gap-3 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-gray-700">{{ $message->name }}</p>
                                <p class="truncate text-xs text-gray-400">{{ $message->message }}</p>
                            </div>
                            @if (! $message->read_at)
                                <span class="shrink-0 rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-600">Baru</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- ===== ANTREAN PERSETUJUAN (superadmin) ===== --}}
    @if (auth()->user()->isSuperAdmin() && $pendingQueue->isNotEmpty())
        <div class="mt-8 rounded-2xl bg-white p-6 shadow-md">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-gray-800">Antrean Persetujuan Berita</h2>
                <a href="{{ route('admin.approvals.index') }}" class="text-sm font-semibold text-brand-indigo hover:underline">Kelola</a>
            </div>
            <ul class="mt-4 divide-y divide-gray-100">
                @foreach ($pendingQueue as $post)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-gray-700">{{ $post->title }}</p>
                            <p class="text-xs text-gray-400">oleh {{ $post->author?->name }} &middot; {{ $post->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.approvals.index') }}" class="shrink-0 rounded-lg bg-brand-soft px-3 py-1 text-xs font-semibold text-brand-indigo hover:bg-brand-gold/20">Tinjau</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
