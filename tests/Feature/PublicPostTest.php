<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_berita_index_lists_published_posts(): void
    {
        Post::factory()->published()->create(['title' => 'Artikel Publik']);
        Post::factory()->draft()->create(['title' => 'Draft Tersembunyi']);

        $this->get(route('berita.index'))
            ->assertOk()
            ->assertSee('Artikel Publik')
            ->assertDontSee('Draft Tersembunyi');
    }

    public function test_berita_index_filters_by_category(): void
    {
        $dakwah = Category::factory()->create(['name' => 'Dakwah', 'slug' => 'dakwah']);
        Post::factory()->published()->create(['title' => 'Konten Dakwah', 'category_id' => $dakwah->id]);
        Post::factory()->published()->create(['title' => 'Konten Sosial']);

        $this->get(route('berita.category', 'dakwah'))
            ->assertOk()
            ->assertSee('Konten Dakwah')
            ->assertDontSee('Konten Sosial');
    }

    public function test_berita_show_displays_post_detail(): void
    {
        $post = Post::factory()->published()->create(['title' => 'Judul Detail', 'body' => 'Isi paragraf detail berita']);

        $this->get(route('berita.show', $post->slug))
            ->assertOk()
            ->assertSee('Judul Detail')
            ->assertSee('Isi paragraf detail berita');
    }

    public function test_unpublished_post_is_not_accessible(): void
    {
        $post = Post::factory()->draft()->create();

        $this->get(route('berita.show', $post->slug))->assertNotFound();
    }

    public function test_pending_approval_post_is_not_accessible(): void
    {
        $post = Post::factory()->needsApproval()->published()->create();

        $this->get(route('berita.show', $post->slug))->assertNotFound();
    }

    public function test_nonexistent_slug_returns_404(): void
    {
        $this->get(route('berita.show', 'tidak-ada'))->assertNotFound();
    }
}
