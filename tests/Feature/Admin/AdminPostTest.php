<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Category::factory()->create(['name' => 'Kegiatan', 'slug' => 'kegiatan']);
    }

    public function test_guest_cannot_access_admin_posts(): void
    {
        $this->get(route('admin.posts.index'))->assertRedirect(route('login'));
        $this->get(route('admin.posts.create'))->assertRedirect(route('login'));
    }

    public function test_regular_user_is_forbidden(): void
    {
        $user = User::factory()->member()->create();

        $this->actingAs($user)
            ->get(route('admin.posts.index'))
            ->assertForbidden();
    }

    public function test_admin_can_see_posts_index(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.posts.index'))
            ->assertOk()
            ->assertSee('Kelola Berita');
    }

    public function test_admin_can_create_published_post_without_approval(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->from(route('admin.posts.create'))->post(route('admin.posts.store'), [
            'title' => 'Kajian Rutin Pekan Depan',
            'category_id' => Category::first()->id,
            'excerpt' => 'Ringkasan kajian.',
            'body' => '<p>Isi lengkap kajian.</p>',
            'status' => 'published',
            'needs_approval' => '0',
            'published_at' => now()->format('Y-m-d\TH:i'),
        ]);

        $response->assertRedirect(route('admin.posts.index'));

        $post = Post::first();
        $this->assertNotNull($post);
        $this->assertSame('kajian-rutin-pekan-depan', $post->slug);
        $this->assertSame($admin->id, $post->author_id);
        $this->assertSame('published', $post->status);
        $this->assertFalse($post->needs_approval);
        $this->assertTrue($post->is_approved);

        $this->assertDatabaseHas('posts', ['title' => 'Kajian Rutin Pekan Depan']);
    }

    public function test_post_marked_for_approval_is_not_publicly_approved(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Berita Perlu Persetujuan',
            'body' => '<p>Konten sensitif.</p>',
            'status' => 'published',
            'needs_approval' => '1',
        ]);

        $post = Post::first();
        $this->assertTrue($post->needs_approval);
        $this->assertFalse($post->is_approved);
        $this->assertNull($post->approved_at);

        $this->get(route('berita.show', $post->slug))->assertNotFound();
    }

    public function test_validation_requires_title_and_body(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.posts.store'), [])
            ->assertSessionHasErrors(['title', 'body']);
    }

    public function test_cover_image_upload_is_optimized(): void
    {
        $admin = User::factory()->admin()->create();

        $file = UploadedFile::fake()->image('cover.png', 2000, 1000);

        $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Postingan Dengan Gambar',
            'body' => '<p>Konten.</p>',
            'status' => 'published',
            'cover_image' => $file,
        ]);

        $post = Post::first();
        $this->assertNotNull($post->cover_image);
        Storage::disk('public')->assertExists($post->cover_image);
        $this->assertStringStartsWith('posts/', $post->cover_image);
    }

    public function test_invalid_image_is_rejected(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Gambar Salah',
            'body' => '<p>Konten.</p>',
            'status' => 'published',
            'cover_image' => UploadedFile::fake()->create('file.txt', 100),
        ])->assertSessionHasErrors(['cover_image']);
    }

    public function test_admin_can_update_post(): void
    {
        $admin = User::factory()->admin()->create();
        $post = Post::factory()->published()->create();

        $this->actingAs($admin)->put(route('admin.posts.update', $post), [
            'title' => 'Judul Baru',
            'category_id' => Category::first()->id,
            'excerpt' => 'Ringkasan.',
            'body' => '<p>Isi baru.</p>',
            'status' => 'draft',
            'needs_approval' => '0',
            'published_at' => now()->format('Y-m-d\TH:i'),
        ])->assertRedirect(route('admin.posts.index'));

        $post->refresh();
        $this->assertSame('Judul Baru', $post->title);
        $this->assertSame('draft', $post->status);
        $this->assertSame('judul-baru', $post->slug);
    }

    public function test_admin_can_soft_delete_post(): void
    {
        $admin = User::factory()->admin()->create();
        $post = Post::factory()->published()->create();

        $this->actingAs($admin)->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'));

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
        $this->assertCount(0, Post::published()->get());
    }

    public function test_slug_is_unique_when_title_duplicated(): void
    {
        $admin = User::factory()->admin()->create();
        Post::factory()->create(['slug' => 'judul-sama']);

        $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Judul Sama',
            'body' => '<p>Konten.</p>',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('posts', ['slug' => 'judul-sama-2']);
    }
}
