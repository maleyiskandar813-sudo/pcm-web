<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SambutanSeeder extends Seeder
{
    public function run(): void
    {
        $sambutan = <<<'TEXT'
Assalamu'alaikum warahmatullahi wabarakatuh.

Yang saya hormati, para sesepuh dan tokoh Muhammadiyah Pujon, para pengurus Pimpinan Cabang Muhammadiyah (PCM), Pimpinan Cabang 'Aisyiyah (PCA), serta seluruh warga persyarikatan yang saya banggakan. Hadirin yang berbahagia.

Pertama-tama, marilah kita panjatkan puji syukur ke hadirat Allah Subhanahu wa Ta'ala. Atas rahmat dan hidayah-Nya, kita masih diberikan kesempatan untuk berkumpul dalam keadaan sehat, beriman, dan terus mengabdi melalui gerakan Muhammadiyah di bumi Pujon yang kita cintai ini. Shalawat serta salam semoga tetap tercurah kepada junjungan kita, Nabi Muhammad shallallahu 'alaihi wasallam, beserta keluarga dan para sahabatnya.

Hadirin yang dimuliakan Allah,

Pujon bukanlah daerah yang asing bagi perjuangan Muhammadiyah. Kita tahu, Pujon, yang dulu dikenal sebagai daerah yang minim sentuhan keagamaan, kini telah bertransformasi. Semangat "Desa Berkemajuan" benar-benar terwujud di sini. Para kader kita telah berhasil menyulap desa ini menjadi destinasi wisata edukasi berbasis pertanian dan peternakan. Ini bukan sekadar prestasi fisik, tetapi bukti bahwa Muhammadiyah hadir sebagai solusi untuk mencerahkan dan memajukan masyarakat.

Kita patut bersyukur, amal usaha Muhammadiyah di bidang pendidikan terus berkembang di Pujon. Keberadaan TK Aisyiyah Bustanul Athfal (ABA) Mutiara Iman yang telah berdiri sejak tahun 2006 menjadi saksi komitmen kita dalam mencerdaskan anak-anak generasi penerus sejak dini. Juga berbagai kegiatan keagamaan dan sosial yang kita lakukan, termasuk pemeriksaan kesehatan dalam rangka Hari Anak, yang melibatkan seluruh elemen PCM dan PCA Pujon.

Hadirin yang saya hormati,

Hari ini, saya ingin mengajak kita semua untuk melihat satu hal yang sangat menggembirakan sekaligus menjadi tantangan besar bagi kita ke depan, yaitu keberhasilan konservasi lingkungan di kawasan Pujon Hill. Universitas Muhammadiyah Malang (UMM), sebagai bagian dari keluarga besar Muhammadiyah, telah berhasil mengembalikan fungsi ekologis hutan di sana. Mata air yang dulu mati kini kembali mengalir, dan empat dusun kini menikmati manfaatnya.

Keberhasilan ini saya maknai sebagai wujud nyata dari ajaran Islam yang memerintahkan kita untuk menjaga alam. Ini sejalan dengan perjuangan kita di Muhammadiyah: gerakan yang tidak hanya berbicara tentang ibadah ritual, tetapi juga ibadah sosial dan ekologis.

Hadirin yang berbahagia,

Dengan segala pencapaian yang ada, izinkan saya menyampaikan beberapa harapan ke depan bagi Muhammadiyah Pujon:

1. Terus Rawat dan Kembangkan Amal Usaha. Kita harus terus memastikan pendidikan di sekolah-sekolah Muhammadiyah terus berkembang dan memberikan layanan terbaik bagi masyarakat.
2. Jaga dan Lestarikan Lingkungan. Keberhasilan di Pujon Hill harus menjadi momentum bagi kita untuk terus terlibat dalam menjaga kelestarian alam.
3. Tingkatkan Kualitas Kader dan Dakwah. Kita perlu terus melahirkan kader-kader muda yang berilmu, berakhlak, dan siap mengabdi.
4. Perkuat Ukhuwah dan Kolaborasi. Mari kita jaga dan perkuat kolaborasi antara PCM, PCA, UMM, pemerintah desa, dan masyarakat.

Kesimpulannya, Pujon telah menjadi bukti bahwa Muhammadiyah adalah gerakan yang dinamis, adaptif, dan solutif. Ke depan, tantangan akan semakin berat, tetapi dengan semangat "Islam Berkemajuan", saya yakin Muhammadiyah Pujon akan terus menjadi mercusuar yang menerangi dan memberi manfaat bagi semua.

Akhirul kalam, marilah kita terus berdoa dan berikhtiar. Semoga Allah meridai setiap langkah kita dan menjadikan Muhammadiyah Pujon sebagai organisasi yang selalu berada di jalan-Nya.

Billahi taufiq wal hidayah, wassalamu'alaikum warahmatullahi wabarakatuh.
TEXT;

        Setting::updateOrCreate(['key' => 'sambutan_ketua'], ['value' => $sambutan]);
    }
}