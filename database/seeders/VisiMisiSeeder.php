<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class VisiMisiSeeder extends Seeder
{
    public function run(): void
    {
        $visiMisi = <<<'TEXT'
Visi

Terwujudnya masyarakat Islam yang berkemajuan di Kecamatan Pujon melalui dakwah amar ma'ruf nahi munkar berdasarkan Al-Qur'an dan As-Sunnah, sebagai gerakan yang sehat dan bermanfaat untuk umat.

Misi

1. Menegakkan dan memurnikan aqidah serta pengamalan syariat Islam sesuai tuntunan Al-Qur'an dan Hadis yang shahih, jauh dari paham tahayul, bid'ah, dan khurafat.

2. Menyelenggarakan dan mengembangkan pendidikan berkarakter Islami sejak usia dini melalui TK ABA, TPQ, dan lembaga pendidikan Muhammadiyah lainnya sebagai wadah kaderisasi generasi penerus.

3. Memberikan pelayanan kesehatan dan sosial kepada masyarakat melalui Balai Pengobatan PKU Muhammadiyah dan program-program kemanusiaan lainnya.

4. Mengelola dan mengembangkan amal usaha serta aset persyarikatan (masjid, mushola, lahan wakaf, dan lahan produktif) secara amanah, transparan, dan berkelanjutan demi kemaslahatan umat.

5. Memberdayakan ekonomi umat melalui pengembangan UMKM dan optimalisasi lahan produktif milik persyarikatan.

6. Memperkuat kelembagaan organisasi melalui pembinaan Pimpinan Ranting, Majelis, dan Organisasi Otonom (Pemuda Muhammadiyah, Nasyiatul Aisyiyah, Tapak Suci) di seluruh wilayah Pujon.

7. Menjadi mitra aktif pemerintah dan elemen masyarakat dalam membangun Kecamatan Pujon yang berkemajuan dan penuh kemanfaatan bagi seluruh umat.
TEXT;

        Setting::set('profil_visi_misi', $visiMisi);
    }
}