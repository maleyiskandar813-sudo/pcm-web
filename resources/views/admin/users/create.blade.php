@extends('layouts.admin')

@section('title', 'Buat User — ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-brand-indigo">Buat User</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 max-w-2xl space-y-5 rounded-2xl bg-white p-8 shadow-md">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-semibold text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="role" class="mb-1 block text-sm font-semibold text-gray-700">Role</label>
                <select name="role" id="role" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                    <option value="admin" @selected(old('role', 'admin') === 'admin')>Admin</option>
                    <option value="superadmin" @selected(old('role') === 'superadmin')>Superadmin (Ketua)</option>
                </select>
            </div>
            <div>
                <label for="password" class="mb-1 block text-sm font-semibold text-gray-700">Password (min. 8 karakter)</label>
                <input type="password" name="password" id="password" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="h-4 w-4 rounded border-gray-300 text-brand-navy">
            Akun aktif (bisa login)
        </label>

        <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white hover:opacity-90">
            Simpan User
        </button>
    </form>
@endsection
