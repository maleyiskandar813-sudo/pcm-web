<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class MajelisSeeder extends Seeder
{
    public function run(): void
    {
        $majelis = [
            [
                'nama' => 'Majelis Tabligh, Tarjih dan Tajdid',
                'deskripsi' => 'Ketua: Ust. Bagus Subayo',
            ],
            [
                'nama' => 'Majelis Hukum dan Kemaslahatan',
                'deskripsi' => 'Ketua: Haisyam Nuril, BA, S.Hum',
            ],
            [
                'nama' => 'Majelis Ekonomi dan UMKM',
                'deskripsi' => 'Ketua: Muhammad Rosyid',
            ],
            [
                'nama' => 'Majelis Wakaf dan Aset',
                'deskripsi' => 'Ketua: Muh. Islamil Mahfudz Said',
            ],
            [
                'nama' => 'Majelis Pendidikan dan Kaderisasi',
                'deskripsi' => 'Ketua: Agus Pranoto',
            ],
            [
                'nama' => 'Majelis Kesehatan Umum',
                'deskripsi' => 'Ketua: Ahmad Firdiansyah, S.Apt',
            ],
            [
                'nama' => 'Majelis Pemberdayaan Masyarakat',
                'deskripsi' => 'Ketua: Muh. Efendi Zarkasi, S.P.',
            ],
        ];

        Setting::set('majelis_lembaga', json_encode($majelis, JSON_UNESCAPED_UNICODE));
    }
}