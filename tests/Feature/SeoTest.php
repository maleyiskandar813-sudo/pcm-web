<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_has_canonical_and_jsonld(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('rel="canonical"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('schema.org');
    }

    public function test_sitemap_xml_lists_pages_and_published_posts(): void
    {
        $post = Post::factory()->published()->create(['title' => 'Berita SEO']);

        $response = $this->get('/sitemap.xml');

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('<urlset', false)
            ->assertSee(route('home'), false)
            ->assertSee(route('berita.show', $post->slug), false);
    }

    public function test_sitemap_excludes_draft_and_pending_posts(): void
    {
        $draft = Post::factory()->draft()->create();
        Post::factory()->published()->needsApproval()->create();

        $response = $this->get('/sitemap.xml');

        $response->assertOk()->assertDontSee(route('berita.show', $draft->slug), false);
    }

    public function test_robots_txt_disallows_admin(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap:');
    }
}
