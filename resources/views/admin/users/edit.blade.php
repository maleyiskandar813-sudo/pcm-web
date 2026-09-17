@extends('layouts.admin')

@section('title', 'Edit User — ' . config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-brand-indigo">Edit User</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Kembali</a>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mt-6 max-w-2xl space-y-5 rounded-2xl bg-white p-8 shadow-md">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-1 block text-sm font-semibold text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="role" class="mb-1 block text-sm font-semibold text-gray-700">Role</label>
            <select name="role" id="role" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none">
                <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                <option value="superadmin" @selected(old('role', $user->role) === 'superadmin')>Superadmin (Ketua)</option>
            </select>
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-semibold text-gray-700">Password Baru (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" id="password"
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-navy focus:outline-none focus:ring-2 focus:ring-brand-navy/20">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active)) class="h-4 w-4 rounded border-gray-300 text-brand-navy">
            Akun aktif (bisa login)
        </label>

        <button type="submit" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white hover:opacity-90">
            Simpan Perubahan
        </button>
    </form>

    <div class="mt-6 max-w-2xl rounded-2xl bg-white p-6 shadow-md">
        <h2 class="text-sm font-bold text-gray-700">Reset Password Cepat</h2>
        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" class="mt-3 flex flex-wrap items-center gap-3">
            @csrf
            <input type="password" name="password" placeholder="Password baru (min. 8 karakter)" required minlength="8"
                class="min-w-56 flex-1 rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-brand-navy focus:outline-none">
            <button type="submit" class="rounded-lg border border-brand-navy px-5 py-2 text-sm font-semibold text-brand-navy hover:bg-brand-soft">
                Reset Password
            </button>
        </form>
    </div>
@endsection
