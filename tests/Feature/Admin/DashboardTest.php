<?php

namespace Tests\Feature\Admin;

use App\Models\Agenda;
use App\Models\Aum;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_dashboard_stats(): void
    {
        $admin = User::factory()->admin()->create();
        Post::factory()->count(3)->create();
        Agenda::factory()->create(['starts_at' => now()->addDay()]);
        Aum::factory()->count(2)->create();
        ContactMessage::factory()->create(['read_at' => null]);
        ContactMessage::factory()->create(['read_at' => now()]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('3')
            ->assertSee('Pesan Masuk');
    }

    public function test_superadmin_sees_pending_approval_card(): void
    {
        $super = User::factory()->superAdmin()->create();
        Post::factory()->published()->needsApproval()->create(['title' => 'Perlu Tinjauan']);

        $this->actingAs($super)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Perlu Tinjauan')
            ->assertSee('Menunggu Persetujuan');
    }

    public function test_admin_does_not_see_superadmin_cards(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('Menunggu Persetujuan')
            ->assertDontSee('User</p>');
    }
}
