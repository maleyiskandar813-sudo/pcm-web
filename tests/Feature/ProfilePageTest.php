<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profil_page_renders_with_content(): void
    {
        Setting::set('profil_visi_misi', 'Mewujudkan masyarakat Islam berkemajuan');
        Setting::set('profil_sejarah', 'Sejarah cabang Pujon');
        Setting::set('struktur_organisasi', json_encode([
            ['jabatan' => 'Ketua', 'nama' => 'H. Contoh'],
        ]));

        $this->get(route('profil'))
            ->assertOk()
            ->assertSee('Profil PCM Pujon')
            ->assertSee('Mewujudkan masyarakat Islam berkemajuan')
            ->assertSee('Sejarah cabang Pujon')
            ->assertSee('H. Contoh');
    }

    public function test_profil_page_shows_empty_state(): void
    {
        $this->get(route('profil'))
            ->assertOk()
            ->assertSee('Visi dan misi cabang belum diisi')
            ->assertSee('Struktur organisasi belum diisi');
    }

    public function test_majelis_page_lists_lembaga(): void
    {
        Setting::set('majelis_lembaga', json_encode([
            ['nama' => 'Majelis Tabligh', 'deskripsi' => 'Fokus dakwah komunitas'],
        ]));

        $this->get(route('majelis'))
            ->assertOk()
            ->assertSee('Majelis & Lembaga')
            ->assertSee('Majelis Tabligh')
            ->assertSee('Fokus dakwah komunitas');
    }

    public function test_majelis_page_shows_empty_state(): void
    {
        $this->get(route('majelis'))
            ->assertOk()
            ->assertSee('Daftar majelis dan lembaga belum diisi');
    }
}
