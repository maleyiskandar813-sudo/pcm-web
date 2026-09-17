@extends('layouts.admin')

@section('title', 'Manajemen User — ' . config('app.name'))

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-brand-indigo">Manajemen User</h1>
        <a href="{{ route('admin.users.create') }}" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-4 py-2 text-sm font-semibold text-white hover:opacity-90">
            <i class="fas fa-plus mr-1"></i>Buat User
        </a>
    </div>

    @if ($users->isEmpty())
        <p class="mt-10 rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            Belum ada user.
        </p>
    @else
        <div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-md">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-white" style="background:#2c368b;">
                        <th class="px-4 py-3">Nama</th>
                        <th class="hidden px-4 py-3 md:table-cell">Email</th>
                        <th class="hidden px-4 py-3 md:table-cell">Role</th>
                        <th class="hidden px-4 py-3 md:table-cell">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-100">
                            <td class="px-4 py-3">
                                <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                                @if ($user->is(auth()->user()))
                                    <span class="ml-2 rounded-full bg-brand-soft px-2 py-0.5 text-xs font-semibold text-brand-indigo">Anda</span>
                                @endif
                            </td>
                            <td class="hidden px-4 py-3 md:table-cell">{{ $user->email }}</td>
                            <td class="hidden px-4 py-3 md:table-cell">
                                <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $user->isSuperAdmin() ? 'bg-amber-100 text-amber-700' : 'bg-brand-soft text-brand-indigo' }}">
                                    {{ $user->isSuperAdmin() ? 'Superadmin' : 'Admin' }}
                                </span>
                            </td>
                            <td class="hidden px-4 py-3 md:table-cell">
                                <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $user->is_active ? 'bg-brand-green/10 text-brand-green' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.users.edit', $user) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-indigo hover:bg-gray-100">Edit</a>
                                @if (! $user->is(auth()->user()))
                                    <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold {{ $user->is_active ? 'text-red-600 hover:bg-red-50' : 'text-brand-green hover:bg-green-50' }}">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
@endsection
