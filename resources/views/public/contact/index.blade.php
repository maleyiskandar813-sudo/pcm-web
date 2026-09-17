@extends('layouts.app')

@section('title', 'Kontak & Peta — ' . config('app.name'))

@section('meta_description', 'Hubungi Pimpinan Cabang Muhammadiyah Pujon: alamat kantor, email, WhatsApp, dan peta lokasi.')

@section('content')
    <section class="section-soft py-12">
        <div class="mx-auto w-[90%] max-w-6xl">
            <h1 class="page-title">Kontak &amp; Peta</h1>
            <p class="mt-2 text-gray-600">Hubungi kami melalui formulir atau kanal kontak resmi di bawah.</p>

            <div class="mt-10 grid gap-10 lg:grid-cols-2">
                {{-- ===== FORM ===== --}}
                <div class="fade-up rounded-2xl bg-white p-8 shadow-md">
                    <h2 class="sub-title-sm">Kirim Pesan</h2>
                    <form method="POST" action="{{ route('kontak.store') }}" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="mb-1 block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                class="w-full rounded-lg border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 {{ $errors->has('name') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-brand-navy focus:ring-brand-navy/20' }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-1 block text-sm font-semibold text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                class="w-full rounded-lg border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 {{ $errors->has('email') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-brand-navy focus:ring-brand-navy/20' }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="mb-1 block text-sm font-semibold text-gray-700">No. HP (opsional)</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full rounded-lg border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 {{ $errors->has('phone') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-brand-navy focus:ring-brand-navy/20' }}">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="mb-1 block text-sm font-semibold text-gray-700">Pesan</label>
                            <textarea name="message" id="message" rows="5" required
                                class="w-full rounded-lg border px-4 py-2.5 text-sm focus:outline-none focus:ring-2 {{ $errors->has('message') ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-brand-navy focus:ring-brand-navy/20' }}">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full rounded-lg bg-gradient-to-r from-brand-navy to-brand-green py-2.5 font-semibold text-white transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-navy">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                {{-- ===== INFO KONTAK ===== --}}
                <div class="space-y-6">
                    <div class="fade-up rounded-2xl bg-white p-8 shadow-md">
                        <h2 class="sub-title-sm">Informasi Kontak</h2>
                        <ul class="mt-6 space-y-4 text-gray-700">
                            @if ($address)
                                <li class="flex gap-3">
                                    <i class="fas fa-location-dot mt-1 w-5 text-brand-green"></i>
                                    <span>{{ $address }}</span>
                                </li>
                            @endif
                            <li class="flex gap-3">
                                <i class="fas fa-envelope mt-1 w-5 text-brand-green"></i>
                                <a href="mailto:{{ $email }}" class="hover:text-brand-indigo hover:underline">{{ $email }}</a>
                            </li>
                            <li class="flex gap-3">
                                <i class="fa-brands fa-whatsapp mt-1 w-5 text-brand-green"></i>
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="hover:text-brand-indigo hover:underline">{{ $whatsappDisplay }}</a>
                            </li>
                        </ul>
                    </div>

                    @if ($mapsUrl)
                        <div class="fade-up overflow-hidden rounded-2xl shadow-md">
                            <iframe
                                title="Peta lokasi PCM Pujon"
                                src="{{ $mapsUrl }}"
                                class="h-[320px] w-full border-0"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
