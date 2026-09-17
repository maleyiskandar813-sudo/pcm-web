<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_with_theme(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Pimpinan Cabang Muhammadiyah Pujon');
        $response->assertSee('Cahaya Islam Berkemajuan');
        $response->assertSee('Hidup-hidupilah Muhammadiyah');
        $response->assertSee('hero-tagline');
        $response->assertSee('Fastabiqul Khairat');
    }

    public function test_home_shows_only_published_approved_posts(): void
    {
        Post::factory()->published()->create(['title' => 'Berita Tampil']);
        Post::factory()->draft()->create(['title' => 'Draft Rahasia']);
        Post::factory()->needsApproval()->create(['title' => 'Pending Rahasia']);

        $response = $this->get(route('home'));

        $response->assertSee('Berita Tampil');
        $response->assertDontSee('Draft Rahasia');
        $response->assertDontSee('Pending Rahasia');
    }

    public function test_home_shows_empty_state_when_no_posts(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Belum ada berita');
    }

    public function test_navbar_contains_main_menu_links(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(route('profil'), false);
        $response->assertSee(route('berita.index'), false);
        $response->assertSee(route('aum.index'), false);
        $response->assertSee(route('agenda.index'), false);
        $response->assertSee(route('kontak'), false);
    }

    public function test_footer_shows_copyright_and_contact(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Pimpinan Cabang Muhammadiyah Pujon');
        $response->assertSee('All Rights Reserved.');
    }

    public function test_placeholder_pages_render(): void
    {
        foreach (['profil', 'majelis', 'berita.index', 'aum.index', 'agenda.index', 'kontak'] as $routeName) {
            $this->get(route($routeName))->assertOk();
        }
    }
}
