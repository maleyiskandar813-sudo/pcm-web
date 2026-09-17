<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders_form(): void
    {
        $this->get(route('kontak'))
            ->assertOk()
            ->assertSee('Kirim Pesan')
            ->assertSee('Informasi Kontak');
    }

    public function test_contact_form_stores_message(): void
    {
        $this->post(route('kontak.store'), [
            'name' => 'Ahmad',
            'email' => 'ahmad@example.com',
            'phone' => '081234567',
            'message' => 'Assalamu\'alaikum, mohon info jadwal pengajian.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Ahmad',
            'email' => 'ahmad@example.com',
        ]);
    }

    public function test_contact_form_rejects_invalid_input(): void
    {
        $this->post(route('kontak.store'), [
            'name' => '',
            'email' => 'bukan-email',
            'message' => '',
        ])->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_form_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('kontak.store'), [
                'name' => 'Ahmad',
                'email' => "ahmad$i@example.com",
                'message' => 'pesan uji',
            ]);
        }

        $this->post(route('kontak.store'), [
            'name' => 'Spam',
            'email' => 'spam@example.com',
            'message' => 'pesan spam',
        ])->assertStatus(429);
    }

    public function test_admin_sees_inbox_and_can_mark_read(): void
    {
        $message = ContactMessage::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee($message->name);

        $this->actingAs($admin)
            ->post(route('admin.messages.read', $message))
            ->assertSessionHas('success');

        $this->assertNotNull($message->fresh()->read_at);
    }

    public function test_guest_cannot_access_inbox(): void
    {
        $this->get(route('admin.messages.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_delete_message(): void
    {
        $message = ContactMessage::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete(route('admin.messages.destroy', $message))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }
}
