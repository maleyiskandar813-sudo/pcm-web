<?php

namespace Database\Seeders;

use App\Models\Aum;
use Illuminate\Database\Seeder;

class AumSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'type' => 'masjid',
                'name' => 'Masjid An Nur Pujon Kidul',
                'address' => 'Desa Pujon Kidul, Kecamatan Pujon, Kabupaten Malang',
            ],
            [
                'type' => 'masjid',
                'name' => 'Masjid Al Firdaus Pujon Lor',
                'address' => 'Desa Pujon Lor, Kecamatan Pujon, Kabupaten Malang',
            ],
            [
                'type' => 'masjid',
                'name' => 'Mushola Darul Muttaqin Pujon Kidul',
                'address' => 'Desa Pujon Kidul, Kecamatan Pujon, Kabupaten Malang',
            ],
            [
                'type' => 'masjid',
                'name' => "Mushola Da'watul Khoirot Pujon Kidul",
                'address' => 'Desa Pujon Kidul, Kecamatan Pujon, Kabupaten Malang',
            ],
            [
                'type' => 'sekolah',
                'name' => 'TK ABA 24 Pujon',
                'address' => 'Kecamatan Pujon, Kabupaten Malang',
            ],
            [
                'type' => 'lainnya',
                'name' => 'Lahan Hibah 3000 M²',
                'address' => 'Kecamatan Pujon, Kabupaten Malang',
                'description' => 'Lahan hibah milik Persyarikatan Muhammadiyah Pujon seluas 3.000 m².',
            ],
        ];

        foreach ($items as $item) {
            Aum::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}