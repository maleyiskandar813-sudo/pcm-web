<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_404_uses_themed_custom_page(): void
    {
        $response = $this->get('/halaman-yang-tidak-ada');

        $response->assertNotFound();
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('Kembali ke Beranda');
        $response->assertSee('PCM Pujon');
    }

    public function test_405_uses_themed_custom_page(): void
    {
        $response = $this->post(route('home'));

        $response->assertMethodNotAllowed();
        $response->assertSee('Metode Tidak Diizinkan');
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_403_uses_themed_custom_page(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->get(route('admin.users.index'));

        $response->assertForbidden();
        $response->assertSee('Akses Ditolak');
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_all_other_error_views_render(): void
    {
        foreach ([419, 429, 500] as $code) {
            $html = view("errors.{$code}")->render();
            $this->assertStringContainsString('Kembali ke Beranda', $html);
            $this->assertStringContainsString((string) $code, $html);
        }
    }
}
