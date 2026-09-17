@extends('layouts.app')

@section('title', 'Login Admin — ' . config('app.name'))

@section('content')
    <section class="section-soft py-16 min-h-[70vh] flex items-center justify-center">
        <div class="fade-up w-full max-w-md">
            <div class="rounded-2xl bg-white p-8 shadow-md">
                <div class="text-center">
                    <img src="{{ asset('img/new-logo.webp') }}" alt="Logo Muhammadiyah" class="mx-auto h-16 object-contain">
                    <h1 class="mt-4 text-2xl font-bold text-brand-indigo">Login Admin</h1>
                    <p class="mt-1 text-sm text-gray-500">Akses dashboard Pimpinan Cabang Muhammadiyah Pujon</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf

                    @if ($errors->any())
                        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <p class="flex items-center gap-2 font-semibold">
                                <i class="fas fa-circle-exclamation" aria-hidden="true"></i> Gagal masuk
                            </p>
                            <p class="mt-1">Periksa kembali email dan password Anda, lalu coba lagi.</p>
                        </div>
                    @endif

                    <div>
                        <label for="email" class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required autofocus autocomplete="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-lg border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 {{ $errors->has('email') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-brand-navy focus:ring-brand-navy/20' }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-semibold text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required autocomplete="current-password"
                            class="w-full rounded-lg border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 {{ $errors->has('password') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-brand-navy focus:ring-brand-navy/20' }}">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-gray-300 text-brand-navy">
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-gradient-to-r from-brand-navy to-brand-green py-2.5 font-semibold text-white transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-navy">
                        Masuk
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-400">
                    Kembali ke <a href="{{ route('home') }}" class="text-brand-indigo hover:underline">Beranda</a>
                </p>
            </div>
        </div>
    </section>
@endsection
