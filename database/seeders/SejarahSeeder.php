<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SejarahSeeder extends Seeder
{
    public function run(): void
    {
        $sejarah = <<<'TEXT'
Cikal Bakal (1953)

Muhammadiyah di Kecamatan Pujon tumbuh sejalan dengan pengamalan syariat Islam berdasarkan Al-Qur'an dan Hadis shahih yang dibawa oleh Bapak H. Asmuni, seorang petani sukses dan dermawan asal Desa Pujon Kidul. Kepeduliannya mendorong beliau mendirikan Musholla "An Nuur" pada tahun 1953 di lahan pekarangannya sendiri, satu-satunya musholla di Pujon Kidul saat itu. Melalui pengajian yang mendatangkan mubaligh dari Batu, pemahaman masyarakat terhadap syariat Islam yang murni dari Al-Qur'an dan Hadis semakin berkembang, mengurangi paham tahayul, bid'ah, dan khurafat.

Masa Sulit dan Perlindungan (1965)

Menjelang tahun 1965, banyak warga Pujon Kidul yang terlibat dalam pergerakan PKI. Saat peristiwa G30S/PKI, banyak warga meminta perlindungan kepada Bapak H. Asmuni, berkumpul di rumah beliau untuk belajar agama dan melaksanakan shalat, sehingga terhindar dari penangkapan aparat.

Pendirian Masjid An Nuur dan Drum Band Hizbul Wathan (1965–1967)

Musholla An Nuur dirombak menjadi Masjid An Nuur karena jamaah yang terus bertambah. Muballigh dari Surabaya didatangkan untuk memperdalam pemahaman keislaman warga. Pada masa yang sama, berdiri pula klub Drum Band "Hizbul Wathan" yang menarik minat generasi muda, sekaligus menjadi sarana dakwah bagi kader-kader muda Muhammadiyah.

Sekolah Dasar Islam Pujonkidul (1966)

Untuk menyiapkan kader masa depan, Bapak H. Asmuni mendirikan Sekolah Dasar Islam Pujonkidul di lahan miliknya sendiri, dengan mendatangkan guru-guru dari luar daerah yang berafiliasi Muhammadiyah. Sekolah ini tidak beroperasi lagi setelah berdirinya SD Inpres pada era pemerintahan Orde Baru.

Masa Vakum (1978–1990)

Wafatnya Bapak H. Asmuni pada 1978 membuat kegiatan Muhammadiyah di Pujon kehilangan figur sentral dan mengalami kevakuman panjang. Pada periode ini, Masjid An Nuur bahkan sempat dikelola oleh warga Nahdhiyyin karena tidak adanya struktur kepengurusan Muhammadiyah yang aktif.

Berdirinya Pimpinan Cabang Muhammadiyah Pujon (1991)

Maraknya rencana pendirian gereja di Pujon pada tahun 1991 menggerakkan beberapa alumni Universitas Muhammadiyah Malang untuk mendirikan Pimpinan Cabang Muhammadiyah Pujon secara resmi. Kepengurusan pertama diketuai oleh Bapak MS. Fadeli, dengan susunan lengkap Wakil Ketua, Sekretaris, Bendahara, dan berbagai Majelis (Tabligh, Ekonomi, Wakaf, PKU, dan Dikdas).

Shalat Jumat Mandiri dan Pengelolaan Penuh Masjid An Nuur (1992–1993)

Warga Muhammadiyah mulai melaksanakan shalat Jumat secara mandiri, mula-mula hanya diikuti 6 orang jamaah. Seiring waktu, setelah warga Nahdhiyyin membangun masjid sendiri, Masjid An Nuur Pujonkidul sepenuhnya dikelola oleh warga Muhammadiyah sejak 1993.

Balai Pengobatan PKU Muhammadiyah (1993)

Majelis PKU mendirikan Balai Pengobatan PKU Muhammadiyah Pujon sebagai layanan kesehatan bagi masyarakat, yang sempat mengalami masa kejayaan sebelum akhirnya tidak beroperasi lagi karena berkurangnya pasien akibat munculnya layanan kesehatan lain di wilayah tersebut.

Penggagalan Pendirian Gereja dan Berdirinya Masjid Al Firdaus (1997–2008)

Warga Muhammadiyah bersama tokoh masyarakat berhasil menggagalkan rencana pendirian Gereja Pantekosta di Pujonlor. Sebagai gantinya, tanah wakaf dari Bapak Ir. Suhari digunakan untuk membangun Masjid Al Firdaus. Pembangunan berlangsung bertahap selama lebih dari satu dekade, termasuk perjuangan mencari dana hingga ke Jakarta, hingga akhirnya rampung sepenuhnya pada 2008.

Berdirinya TK ABA "Mutiara Iman" (2005/2006)

PCM bekerja sama dengan PCA Pujon mendirikan TK ABA "Mutiara Iman" sebagai amal usaha pendidikan untuk kaderisasi generasi penerus. TK ini terus beroperasi hingga sekarang dan menjadi salah satu aset pendidikan utama Muhammadiyah Pujon.

Pembangunan Kembali Masjid An Nuur (2005–2017)

Masjid An Nuur dibangun ulang di lokasi yang sedikit bergeser dari bangunan lama. Bangunan induk selesai pada 2009 dengan bantuan wakaf dari donatur Arab Saudi, dan penyelesaian teras serta fasilitas lainnya baru rampung pada 2017.

Penggagalan Pendirian Gereja Jawi Wetan (2009)

PCM Pujon bersama remaja muslim setempat berhasil menggagalkan rencana pendirian Gereja Jawi Wetan di Dukuh Sebaluh, Desa Pandesari, melalui pengumpulan dukungan warga sekitar.

Penguatan Sarana dan Prasarana (2014–2020)

Pembangunan ruang kantor permanen TK ABA "Mutiara Iman" (2014), penyelesaian fasilitas MCK dan tempat wudu wanita di Masjid Al Firdaus (2018–2020), serta berbagai renovasi lainnya terus dilakukan untuk meningkatkan kualitas layanan dakwah, pendidikan, dan ibadah bagi warga Muhammadiyah Pujon.

Estafet Kepengurusan

Sejak berdiri pada 1991 hingga 2020, kepengurusan PCM Pujon telah mengalami beberapa kali regenerasi, dengan tokoh-tokoh seperti MS. Fadeli, Nur Khotib, dan Drs. Zunaidi, M.Pd. yang pernah memimpin organisasi ini melewati berbagai tantangan zaman, dari isu politik hingga pembangunan amal usaha, hingga terus berkembang sampai saat ini.
TEXT;

        Setting::set('profil_sejarah', $sejarah);
    }
}