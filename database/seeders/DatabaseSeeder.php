<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Aum;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ketua = User::updateOrCreate(
            ['email' => env('SUPERADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('SUPERADMIN_NAME', 'Administrator'),
                'password' => env('SUPERADMIN_PASSWORD', 'password'),
                'role' => User::ROLE_SUPERADMIN,
                'is_active' => true,
            ],
        );

        $sekretaris = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.org')],
            [
                'name' => env('ADMIN_NAME', 'Administrator'),
                'password' => env('ADMIN_PASSWORD', 'password'),
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
            ],
        );

        // GANTI: data nyata PCM Pujon (kategori, profil, AUM, kontak) saat tersedia.
        if (Category::query()->count() === 0) {
            $dakwah = Category::create(['name' => 'Dakwah', 'slug' => 'dakwah']);
            Category::create(['name' => 'Pendidikan', 'slug' => 'pendidikan']);
            Category::create(['name' => 'Sosial', 'slug' => 'sosial']);
            Category::create(['name' => 'Organisasi', 'slug' => 'organisasi']);

            Post::factory(3)->create([
                'author_id' => $sekretaris->id,
                'category_id' => $dakwah->id,
            ]);

            // CONTOH berita yang butuh approval Ketua
            Post::factory()->needsApproval()->create([
                'author_id' => $sekretaris->id,
                'category_id' => $dakwah->id,
                'title' => 'CONTOH — Jadwal Pengajian Rutin Cabang (GANTI dengan berita asli)',
                'slug' => 'contoh-jadwal-pengajian-rutin-cabang',
                'body' => 'Ini adalah data contoh yang WAJIB diganti. Silakan kelola melalui dashboard admin.',
            ]);

            Agenda::factory(4)->create();
            Announcement::factory(2)->create();

            Aum::factory()->create(['type' => 'sekolah', 'name' => 'CONTOH — SD/MI Muhammadiyah Pujon']);
            Aum::factory()->create(['type' => 'masjid', 'name' => 'CONTOH — Masjid Muhammadiyah Pujon']);
            Aum::factory()->create(['type' => 'panti', 'name' => 'CONTOH — Panti Asuhan Muhammadiyah Pujon']);
        }

        Setting::set('nama_cabang', 'Pimpinan Cabang Muhammadiyah Pujon');
        Setting::set('tagline', 'Cahaya Islam Berkemajuan — Membangun Umat, Menebar Kebaikan.');
        Setting::set('sambutan_ketua', "Assalamu'alaikum warahmatullahi wabarakatuh.\n\nSelamat datang di website resmi Pimpinan Cabang Muhammadiyah Pujon. Website ini kami hadirkan sebagai media informasi dan dokumentasi resmi kegiatan dakwah, pendidikan, dan sosial kemasyarakatan di lingkungan Persyarikatan.\n\nSemoga kehadiran portal ini bermanfaat bagi warga Muhammadiyah dan masyarakat luas.");
        Setting::set('alamat_kantor', 'GANTI — Sekretariat PCM Pujon, Kecamatan Pujon, Kabupaten Malang, Jawa Timur.');
        Setting::set('maps_url', 'https://www.google.com/maps?q=Pujon,+Kabupaten+Malang&output=embed');
        Setting::set('email', 'pcmpujon@gmail.com');
        Setting::set('whatsapp', '6281234567890');
        Setting::set('whatsapp_display', '+62 812-3456-7890');

        Setting::set('profil_visi_misi', "GANTI — Visi & Misi PCM Pujon.\n\nTerwujudnya masyarakat Islam yang berkemajuan di Kecamatan Pujon melalui dakwah, pendidikan, dan pelayanan sosial.");
        Setting::set('profil_sejarah', "GANTI — Sejarah singkat berdirinya Pimpinan Cabang Muhammadiyah Pujon.\n\nSilakan isi narasi sejarah cabang melalui dashboard admin.");
        Setting::set('struktur_organisasi', json_encode([
            ['jabatan' => 'Ketua', 'nama' => 'GANTI — Nama Ketua PCM Pujon'],
            ['jabatan' => 'Sekretaris', 'nama' => 'GANTI — Nama Sekretaris PCM Pujon'],
            ['jabatan' => 'Bendahara', 'nama' => 'GANTI — Nama Bendahara PCM Pujon'],
        ]));
        Setting::set('majelis_lembaga', json_encode([
            ['nama' => 'GANTI — Majelis Tabligh & Dakwah Komunitas', 'deskripsi' => 'Deskripsi singkat majelis.'],
            ['nama' => 'GANTI — Majelis Pendidikan', 'deskripsi' => 'Deskripsi singkat majelis.'],
            ['nama' => 'GANTI — Lembaga Amil Zakat Infaq Shodaqoh (LAZISMu)', 'deskripsi' => 'Deskripsi singkat lembaga.'],
        ]));
    }
}
