@php
    $code = $code ?? 'Error';
    $icon = $icon ?? 'fas fa-triangle-exclamation';
    $title = $title ?? 'Terjadi Kesalahan';
    $message = $message ?? 'Maaf, terjadi kesalahan. Silakan coba lagi.';
@endphp

<div class="fade-up mx-auto w-[90%] max-w-xl text-center">
    <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-full bg-white shadow-md">
        <i class="{{ $icon }} text-5xl text-brand-indigo" aria-hidden="true"></i>
    </div>

    <p class="mt-8 bg-gradient-to-r from-brand-navy to-brand-green bg-clip-text text-8xl font-bold text-transparent" aria-hidden="true">
        {{ $code }}
    </p>

    <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ $title }}</h1>
    <p class="mx-auto mt-3 max-w-md text-gray-500">{{ $message }}</p>

    <div class="mt-10 flex flex-wrap justify-center gap-3">
        <a href="{{ route('home') }}" class="rounded-lg bg-gradient-to-r from-brand-navy to-brand-green px-6 py-2.5 font-semibold text-white transition hover:opacity-90">
            <i class="fas fa-home mr-1"></i>Kembali ke Beranda
        </a>
        <button type="button" onclick="history.length > 1 ? history.back() : location.href = '{{ route('home') }}'"
            class="rounded-lg border border-brand-navy px-6 py-2.5 font-semibold text-brand-indigo transition hover:bg-brand-soft">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </button>
    </div>

    @if (isset($extra))
        <p class="mt-8 text-sm text-gray-400">{{ $extra }}</p>
    @endif
</div>
