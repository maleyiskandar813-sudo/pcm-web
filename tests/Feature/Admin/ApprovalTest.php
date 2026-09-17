<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_access_approval_queue(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.approvals.index'))
            ->assertForbidden();
    }

    public function test_superadmin_sees_pending_posts(): void
    {
        $super = User::factory()->superAdmin()->create();
        $pending = Post::factory()->published()->needsApproval()->create(['title' => 'Menunggu Ketua']);

        $this->actingAs($super)
            ->get(route('admin.approvals.index'))
            ->assertOk()
            ->assertSee('Menunggu Ketua');
    }

    public function test_superadmin_can_approve_post_and_it_becomes_public(): void
    {
        $super = User::factory()->superAdmin()->create();
        $post = Post::factory()->published()->needsApproval()->create();

        $this->get(route('berita.show', $post->slug))->assertNotFound();

        $this->actingAs($super)
            ->post(route('admin.approvals.approve', $post))
            ->assertRedirect();

        $post->refresh();
        $this->assertTrue($post->is_approved);
        $this->assertNotNull($post->approved_at);

        $this->get(route('berita.show', $post->slug))->assertOk();
    }

    public function test_reject_requires_note(): void
    {
        $super = User::factory()->superAdmin()->create();
        $post = Post::factory()->published()->needsApproval()->create();

        $this->actingAs($super)
            ->post(route('admin.approvals.reject', $post))
            ->assertSessionHasErrors(['rejection_note']);

        $this->assertFalse($post->refresh()->is_approved);
    }

    public function test_rejected_post_stays_hidden_from_public(): void
    {
        $super = User::factory()->superAdmin()->create();
        $post = Post::factory()->published()->needsApproval()->create();

        $this->actingAs($super)->post(route('admin.approvals.reject', $post), [
            'rejection_note' => 'Mohon tambahkan sumber data.',
        ]);

        $post->refresh();
        $this->assertFalse($post->is_approved);
        $this->assertSame('Mohon tambahkan sumber data.', $post->rejection_note);

        $this->get(route('berita.show', $post->slug))->assertNotFound();
        $this->get(route('berita.index'))->assertDontSee($post->title);
    }

    public function test_rejected_tab_lists_rejected_posts(): void
    {
        $super = User::factory()->superAdmin()->create();
        Post::factory()->published()->needsApproval()->create([
            'rejection_note' => 'Kurang lengkap.',
        ]);

        $this->actingAs($super)
            ->get(route('admin.approvals.index', ['rejected' => 1]))
            ->assertOk()
            ->assertSee('Kurang lengkap.');
    }
}
