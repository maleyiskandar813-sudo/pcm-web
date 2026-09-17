@extends('layouts.admin')

@section('title', 'Kelola AUM — ' . config('app.name'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-brand-indigo">Kelola AUM</h1>
        <a href="{{ route('admin.aum.create') }}" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            <i class="fas fa-plus mr-1"></i>Tambah AUM
        </a>
    </div>

    @if ($aumList->isEmpty())
        <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            Belum ada data AUM.
        </p>
    @else
        <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-md">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-white" style="background:#2c368b;">
                        <th class="px-4 py-3">Nama</th>
                        <th class="hidden px-4 py-3 md:table-cell">Jenis</th>
                        <th class="hidden px-4 py-3 md:table-cell">Alamat</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aumList as $item)
                        <tr class="border-b border-gray-100 {{ $item->trashed() ? 'bg-gray-50 opacity-60' : '' }}">
                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $item->name }}
                                @if ($item->trashed())
                                    <span class="ml-2 rounded-full bg-gray-200 px-2 py-0.5 text-xs text-gray-600">Dihapus</span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 md:table-cell">
                                <span class="rounded-full bg-brand-soft px-2 py-0.5 text-xs font-semibold text-brand-indigo">{{ ucfirst($item->type) }}</span>
                            </td>
                            <td class="hidden max-w-xs truncate px-4 py-3 md:table-cell">{{ $item->address ?? '—' }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                @if ($item->trashed())
                                    <form method="POST" action="{{ route('admin.aum.restore', $item) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-green hover:bg-green-50">Kembalikan</button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.aum.edit', $item) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-indigo hover:bg-gray-100">Edit</a>
                                    <form method="POST" action="{{ route('admin.aum.destroy', $item) }}" class="inline" onsubmit="return confirm('Hapus AUM ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $aumList->links() }}
        </div>
    @endif
@endsection
