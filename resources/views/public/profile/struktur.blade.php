@extends('layouts.app')

@section('title', 'Struktur Organisasi — ' . config('app.name'))

@section('meta_description', 'Struktur organisasi Pimpinan Cabang Muhammadiyah Pujon, Malang.')

@section('content')
    <section class="section-soft py-12">
        <div class="mx-auto w-[90%] max-w-5xl">
            <a href="{{ route('profil') }}" class="text-sm font-semibold text-brand-indigo hover:underline">&larr; Kembali ke Profil</a>

            <h1 class="page-title mt-4">Struktur Organisasi</h1>
            <p class="mt-2 text-gray-600">Susunan Pimpinan Cabang Muhammadiyah Pujon.</p>

            <div class="fade-up mt-8 rounded-2xl bg-white p-8 shadow-md">
                @if (count($struktur) === 0)
                    <p class="text-gray-500">Struktur organisasi belum diisi.</p>
                @else
                    <div class="mb-6">
                        <input
                            type="text"
                            id="strukturSearch"
                            placeholder="Cari nama atau jabatan..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-indigo focus:outline-none focus:ring-1 focus:ring-brand-indigo"
                            autocomplete="off">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="struktur-table" id="strukturTable">
                            <thead>
                                <tr>
                                    <th>Jabatan</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($struktur as $row)
                                    <tr>
                                        <td>{{ $row['jabatan'] ?? '' }}</td>
                                        <td>{{ $row['nama'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p id="strukturNoResult" class="mt-4 hidden text-center text-gray-500">
                        Tidak ada nama atau jabatan yang cocok.
                    </p>
                @endif
            </div>
        </div>
    </section>

    @push('scripts')
       <script>
    function initStrukturSearch() {
        const searchInput = document.getElementById('strukturSearch');
        const table = document.getElementById('strukturTable');
        const noResult = document.getElementById('strukturNoResult');

        if (!searchInput || !table || searchInput.dataset.bound === '1') return;
        searchInput.dataset.bound = '1';

        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                const isMatch = text.includes(keyword);
                row.style.display = isMatch ? '' : 'none';
                if (isMatch) visibleCount++;
            });

            noResult.classList.toggle('hidden', visibleCount > 0);
        });
    }

    document.addEventListener('DOMContentLoaded', initStrukturSearch);
    document.addEventListener('turbo:load', initStrukturSearch);
    initStrukturSearch();
</script>
    @endpush
@endsection