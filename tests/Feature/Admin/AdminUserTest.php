<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    private User $super;

    protected function setUp(): void
    {
        parent::setUp();

        $this->super = User::factory()->superAdmin()->create();
    }

    public function test_admin_cannot_access_user_management(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_superadmin_sees_user_list(): void
    {
        $this->actingAs($this->super)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Manajemen User');
    }

    public function test_superadmin_can_create_admin(): void
    {
        $this->actingAs($this->super)->post(route('admin.users.store'), [
            'name' => 'Sekretaris Baru',
            'email' => 'sekretaris2@pcmpujon.or.id',
            'role' => 'admin',
            'password' => 'rahasia123',
            'is_active' => '1',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Sekretaris Baru',
            'email' => 'sekretaris2@pcmpujon.or.id',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_creating_user_requires_unique_email(): void
    {
        $this->actingAs($this->super)->post(route('admin.users.store'), [
            'name' => 'Duplikat',
            'email' => $this->super->email,
            'role' => 'admin',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors(['email']);
    }

    public function test_superadmin_can_deactivate_other_user(): void
    {
        $target = User::factory()->admin()->create();

        $this->actingAs($this->super)
            ->post(route('admin.users.toggle-active', $target))
            ->assertRedirect();

        $this->assertFalse($target->refresh()->is_active);
    }

    public function test_superadmin_cannot_deactivate_self(): void
    {
        $this->actingAs($this->super)
            ->post(route('admin.users.toggle-active', $this->super))
            ->assertRedirect();

        $this->assertTrue($this->super->refresh()->is_active);
    }

    public function test_deactivated_user_cannot_login(): void
    {
        $target = User::factory()->admin()->create(['password' => 'rahasia123']);
        $target->update(['is_active' => false]);

        $this->from(route('login'))->post(route('login.attempt'), [
            'email' => $target->email,
            'password' => 'rahasia123',
        ])->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_superadmin_can_reset_password(): void
    {
        $target = User::factory()->admin()->create();

        $this->actingAs($this->super)
            ->post(route('admin.users.reset-password', $target), [
                'password' => 'passwordBaru1',
            ])
            ->assertRedirect();

        $this->assertTrue(Hash::check('passwordBaru1', $target->refresh()->password));
    }
}
