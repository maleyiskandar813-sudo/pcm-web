@extends('layouts.admin')

@section('title', 'Kelola Agenda — ' . config('app.name'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-brand-indigo">Kelola Agenda</h1>
        <a href="{{ route('admin.agenda.create') }}" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            <i class="fas fa-plus mr-1"></i>Tambah Agenda
        </a>
    </div>

    @if ($agenda->isEmpty())
        <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            Belum ada agenda kegiatan.
        </p>
    @else
        <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-md">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-white" style="background:#2c368b;">
                        <th class="px-4 py-3">Kegiatan</th>
                        <th class="hidden px-4 py-3 md:table-cell">Mulai</th>
                        <th class="hidden px-4 py-3 md:table-cell">Lokasi</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agenda as $item)
                        <tr class="border-b border-gray-100">
                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $item->title }}
                                @if ($item->starts_at->isPast())
                                    <span class="ml-2 rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-500">Selesai</span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 md:table-cell">
                                {{ $item->starts_at->format('d M Y, H:i') }}
                                @if ($item->ends_at)
                                    <span class="text-gray-400">&ndash; {{ $item->ends_at->format('d M Y, H:i') }}</span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 md:table-cell">{{ $item->location ?? '—' }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.agenda.edit', $item) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-indigo hover:bg-gray-100">Edit</a>
                                <form method="POST" action="{{ route('admin.agenda.destroy', $item) }}" class="inline" onsubmit="return confirm('Hapus agenda ini?');">
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
            {{ $agenda->links() }}
        </div>
    @endif
@endsection
