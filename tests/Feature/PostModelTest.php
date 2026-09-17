<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_scope_returns_only_visible_posts(): void
    {
        Post::factory()->published()->create(['title' => 'Tampil']);
        Post::factory()->draft()->create(['title' => 'Draft Sembunyi']);
        Post::factory()->needsApproval()->create(['title' => 'Pending Sembunyi']);
        Post::factory()->needsApproval()->approved()->create(['title' => 'Disetujui Tampil']);

        $titles = Post::published()->pluck('title')->all();

        $this->assertContains('Tampil', $titles);
        $this->assertContains('Disetujui Tampil', $titles);
        $this->assertNotContains('Draft Sembunyi', $titles);
        $this->assertNotContains('Pending Sembunyi', $titles);
    }

    public function test_scheduled_post_is_hidden_until_date(): void
    {
        Post::factory()->published()->scheduled(now()->addDay())->create(['title' => 'Mendatang']);

        $this->assertEmpty(Post::published()->get());
    }

    public function test_post_belongs_to_category_and_author(): void
    {
        $author = User::factory()->create();
        $category = Category::factory()->create(['name' => 'Dakwah', 'slug' => 'dakwah']);
        $post = Post::factory()->create(['author_id' => $author->id, 'category_id' => $category->id]);

        $this->assertTrue($post->author->is($author));
        $this->assertTrue($post->category->is($category));
    }

    public function test_setting_get_and_set(): void
    {
        Setting::set('nama_cabang', 'PCM Pujon');

        $this->assertSame('PCM Pujon', Setting::get('nama_cabang'));
        $this->assertSame('default', Setting::get('tidak_ada', 'default'));
    }
}
