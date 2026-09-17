@extends('layouts.admin')

@section('title', 'Pesan Masuk — ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-brand-indigo">Pesan Masuk</h1>
        @if ($unreadCount > 0)
            <span class="rounded-full bg-brand-green px-3 py-1 text-sm font-semibold text-white">{{ $unreadCount }} belum dibaca</span>
        @endif
    </div>

    @if ($messages->isEmpty())
        <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            Belum ada pesan masuk.
        </p>
    @else
        <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-md">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-white" style="background:#2c368b;">
                        <th class="px-4 py-3">Nama</th>
                        <th class="hidden px-4 py-3 md:table-cell">Email</th>
                        <th class="px-4 py-3">Pesan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr class="{{ $message->read_at ? 'bg-white text-gray-500' : 'bg-brand-soft font-medium' }} border-b border-gray-100 align-top">
                            <td class="px-4 py-3">
                                {{ $message->name }}
                                @if (! $message->read_at)
                                    <span class="ml-1 inline-block h-2 w-2 rounded-full bg-brand-green"></span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 md:table-cell">{{ $message->email }}</td>
                            <td class="max-w-md px-4 py-3">
                                <p class="line-clamp-2 text-xs text-gray-600">{{ $message->message }}</p>
                                <p class="mt-1 text-xs text-gray-400">{{ $message->created_at->format('d M Y H:i') }}</p>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <details class="group relative inline-block">
                                    <summary class="cursor-pointer list-none rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-indigo hover:bg-gray-100">
                                        Lihat
                                    </summary>
                                    <div class="absolute right-0 z-10 mt-2 w-80 rounded-xl bg-white p-4 shadow-xl">
                                        <p class="font-semibold text-gray-800">{{ $message->name }} <span class="text-xs font-normal text-gray-500">({{ $message->email }})</span></p>
                                        @if ($message->phone)
                                            <p class="mt-1 text-xs text-gray-500">{{ $message->phone }}</p>
                                        @endif
                                        <p class="mt-3 whitespace-pre-line text-sm text-gray-700">{{ $message->message }}</p>
                                        <div class="mt-4 flex justify-end gap-2">
                                            @if (! $message->read_at)
                                                <form method="POST" action="{{ route('admin.messages.read', $message) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg bg-brand-green px-3 py-1.5 text-xs font-semibold text-white hover:opacity-90">Tandai dibaca</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Hapus pesan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:opacity-90">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </details>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    @endif
@endsection
