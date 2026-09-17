# Web Informasi Pimpinan Cabang Muhammadiyah (PCM) Pujon

Website resmi informasi Pimpinan Cabang Muhammadiyah Pujon yang dibangun menggunakan **Laravel 13** dengan **Blade + Tailwind CSS (Vite)**. Menyajikan profil organisasi, agenda kegiatan, berita/dakwah, direktori amal usaha Muhammadiyah (AUM), serta arsip dokumen, lengkap dengan panel admin yang aman.

## Fitur

**Sisi publik**
- Profil organisasi (visi misi, sejarah, struktur, majelis & lembaga)
- Agenda kegiatan mendatang
- Berita/dakwah dengan kategori
- Direktori Amal Usaha Muhammadiyah (AUM)
- Arsip dokumen
- Form kontak & peta lokasi

**Sisi admin**
- Dashboard statistik
- Manajemen berita dengan alur persetujuan (approval) oleh Ketua
- Manajemen agenda, AUM, dokumen, dan pengumuman
- Manajemen pengguna & peran (superadmin/admin)
- Kotak pesan kontak
- Pengaturan situs (profil, kontak, tagline) — ter-cache otomatis

## Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 13 |
| Frontend | Blade, Tailwind CSS, Alpine.js, Vite |
| Icon | Font Awesome 6 |
| Database | MySQL / SQLite (default test) |
| Auth | Laravel Auth + middleware peran |

## Persyaratan

- PHP ≥ 8.2 dengan ekstensi yang dibutuhkan Laravel
- Composer
- Node.js ≥ 20 & npm
- MySQL (atau SQLite untuk pengembangan ringan)

## Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/khoirulfaridz29/WEB-INFORMASI-PCMPUJON---KKNMAS30-2026.git
cd WEB-INFORMASI-PCMPUJON---KKNMAS30-2026

# 2. Install dependensi
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database di .env (DB_*), lalu jalankan migrasi + seeder
php artisan migrate --seed

# 5. Kompilasi aset frontend
npm run build

# 6. Jalankan server
php artisan serve
```

> Akun admin awal dibuat oleh seeder dan diambil dari variabel lingkungan `SUPERADMIN_*` dan `ADMIN_*` di file `.env`. Pastikan untuk mengganti kredensial tersebut sebelum production.

## Pengembangan

```bash
npm run dev          # Vite dev server (hot reload)
npm run build        # Kompilasi aset untuk production
php artisan test     # Menjalankan test suite (Pest/Unit + Feature)
vendor/bin/pint      # Format kode (Laravel Pint)
```

## Struktur Direktori

```
app/
├── Http/Controllers/    # Controller publik & admin
├── Models/              # Model Eloquent
├── Services/            # Logika bisnis (mis. Setting)
├── Policies/            # Otorisasi
database/
├── migrations/          # Skema database
├── factories/           # Factory untuk testing
└── seeders/             # Data awal
public/
├── build/               # Aset terkompilasi (Vite)
└── img/                 # Gambar statis
resources/
├── views/               # Blade views (publik, admin, auth, errors)
└── css|js/              # Aset sumber
routes/web.php           # Definisi route
tests/                   # Test suite
```

## Pengujian

Proyek ini memiliki test suite (feature & unit) yang mencakup autentikasi, alur approval berita, manajemen konten, dan halaman error. Jalankan dengan:

```bash
php artisan test
```

## Lisensi

Proyek ini menggunakan lisensi **MIT** — silakan gunakan, modifikasi, dan distribusikan sesuai ketentuan.
