<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_area(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_superadmin_can_access_admin_area(): void
    {
        $this->actingAs(User::factory()->superAdmin()->create())
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_admin_cannot_access_superadmin_only_area(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.approvals.index'))
            ->assertForbidden();
    }

    public function test_superadmin_can_access_superadmin_only_area(): void
    {
        $this->actingAs(User::factory()->superAdmin()->create())
            ->get(route('admin.users.index'))
            ->assertOk();

        $this->actingAs(User::factory()->superAdmin()->create())
            ->get(route('admin.approvals.index'))
            ->assertOk();
    }

    public function test_inactive_user_is_blocked_even_when_logged_in(): void
    {
        $user = User::factory()->inactive()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
