<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class StrukturSeeder extends Seeder
{
    public function run(): void
    {
        $struktur = [
            ['jabatan' => 'Penasehat', 'nama' => 'H. Mahmud'],
            ['jabatan' => 'Penasehat', 'nama' => 'Ponari'],
            ['jabatan' => 'Penasehat', 'nama' => 'Payar'],
            ['jabatan' => 'Penasehat', 'nama' => 'H. Suntoro'],
            ['jabatan' => 'Penasehat', 'nama' => 'Mahmud, M.R.'],
            ['jabatan' => 'Ketua Umum', 'nama' => 'Drs. Zunaidi, M.Pd.'],
            ['jabatan' => 'Wakil Ketua', 'nama' => 'Udi Hartoko, S.M.'],
            ['jabatan' => 'Sekretaris Umum', 'nama' => 'Ali Mahmud, S.Pt., M.Pt.'],
            ['jabatan' => 'Sekretaris', 'nama' => 'Amin Kurniawan, S.Pd.'],
            ['jabatan' => 'Bendahara', 'nama' => 'Bambang Suprayitno'],
            ['jabatan' => 'Majelis Tabligh, Tarjih dan Tajdid', 'nama' => 'Bagus Subagyo'],
            ['jabatan' => 'Majelis Tabligh, Tarjih dan Tajdid', 'nama' => 'Imran Sadewa'],
            ['jabatan' => 'Majelis Hukum dan Kemaslahatan', 'nama' => 'Shodiqul Amim'],
            ['jabatan' => 'Majelis Hukum dan Kemaslahatan', 'nama' => 'Haisyam Nuril, BA., S.Hum.'],
            ['jabatan' => 'Majelis Ekonomi dan UMKM', 'nama' => 'Muhammad Rosyid'],
            ['jabatan' => 'Majelis Ekonomi dan UMKM', 'nama' => 'Akhdarodin'],
            ['jabatan' => 'Majelis Wakaf dan Aset', 'nama' => 'Moh. Ismail Mahfudz Said'],
            ['jabatan' => 'Majelis Wakaf dan Aset', 'nama' => 'Mulyono'],
            ['jabatan' => 'Majelis Wakaf dan Aset', 'nama' => 'Abd. Rohman'],
            ['jabatan' => 'Majelis Pendidikan dan Kaderisasi', 'nama' => 'Agus Pranoto'],
            ['jabatan' => 'Majelis Pendidikan dan Kaderisasi', 'nama' => 'Suherman'],
            ['jabatan' => 'Majelis Pembinaan Kesehatan Umum', 'nama' => 'Dr. Nono Ifantono'],
            ['jabatan' => 'Majelis Pembinaan Kesehatan Umum', 'nama' => 'Ahmad Firdiansyah, S.Apt.'],
            ['jabatan' => 'Majelis Pemberdayaan Masyarakat', 'nama' => 'Muhammad Efendi Zarkasi, S.P.'],
            ['jabatan' => 'Majelis Pemberdayaan Masyarakat', 'nama' => 'Rofik Amirull Hamzah, S.P.'],
        ];

        Setting::set('struktur_organisasi', json_encode($struktur, JSON_UNESCAPED_UNICODE));
    }
}