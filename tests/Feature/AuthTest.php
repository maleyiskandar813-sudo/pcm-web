<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_reach_dashboard(): void
    {
        $user = User::factory()->admin()->create([
            'email' => 'sekretaris@pcmpujon.or.id',
            'password' => 'secret123',
        ]);

        $this->post(route('login.attempt'), [
            'email' => 'sekretaris@pcmpujon.or.id',
            'password' => 'secret123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_login_with_wrong_password_shows_error(): void
    {
        User::factory()->admin()->create([
            'email' => 'sekretaris@pcmpujon.or.id',
        ]);

        $this->from(route('login'))
            ->post(route('login.attempt'), [
                'email' => 'sekretaris@pcmpujon.or.id',
                'password' => 'salah',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    public function test_login_with_unregistered_email_shows_error(): void
    {
        $this->post(route('login.attempt'), [
            'email' => 'tidak-ada@pcmpujon.or.id',
            'password' => 'password123',
        ])
            ->assertSessionHasErrors('email')
            ->assertSessionHas('errors', function ($errors) {
                return str_contains($errors->first('email'), 'tidak terdaftar');
            });

        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::factory()->inactive()->create([
            'email' => 'nonaktif@pcmpujon.or.id',
        ]);

        $this->post(route('login.attempt'), [
            'email' => 'nonaktif@pcmpujon.or.id',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_from_admin(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_logout_clears_session(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
