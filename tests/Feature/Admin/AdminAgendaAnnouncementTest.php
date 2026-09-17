<?php

namespace Tests\Feature\Admin;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAgendaAnnouncementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_guest_is_redirected(): void
    {
        $this->get(route('admin.agenda.index'))->assertRedirect(route('login'));
        $this->get(route('admin.announcements.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_agenda(): void
    {
        $this->actingAs($this->admin)->post(route('admin.agenda.store'), [
            'title' => 'Pengajian Ahad Pagi',
            'starts_at' => now()->addDays(3)->format('Y-m-d H:i'),
            'ends_at' => now()->addDays(3)->addHour()->format('Y-m-d H:i'),
            'location' => 'Masjid At-Taqwa',
            'description' => 'Kajian rutin.',
        ])->assertRedirect(route('admin.agenda.index'));

        $this->assertDatabaseHas('agenda', ['title' => 'Pengajian Ahad Pagi']);
    }

    public function test_agenda_validation_requires_title_and_starts_at(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.agenda.store'), [])
            ->assertSessionHasErrors(['title', 'starts_at']);
    }

    public function test_ends_at_cannot_be_before_starts_at(): void
    {
        $this->actingAs($this->admin)->post(route('admin.agenda.store'), [
            'title' => 'Agenda Salah',
            'starts_at' => now()->format('Y-m-d H:i'),
            'ends_at' => now()->subDay()->format('Y-m-d H:i'),
        ])->assertSessionHasErrors(['ends_at']);
    }

    public function test_admin_can_update_and_delete_agenda(): void
    {
        $agenda = Agenda::factory()->create();

        $this->actingAs($this->admin)
            ->put(route('admin.agenda.update', $agenda), [
                'title' => 'Agenda Revisi',
                'starts_at' => now()->addWeek()->format('Y-m-d H:i'),
                'location' => 'Gedung PCM',
            ])
            ->assertRedirect(route('admin.agenda.index'));

        $this->assertDatabaseHas('agenda', ['title' => 'Agenda Revisi']);

        $this->actingAs($this->admin)
            ->delete(route('admin.agenda.destroy', $agenda))
            ->assertRedirect(route('admin.agenda.index'));

        $this->assertDatabaseMissing('agenda', ['title' => 'Agenda Revisi']);
    }

    public function test_admin_can_create_announcement(): void
    {
        $this->actingAs($this->admin)->post(route('admin.announcements.store'), [
            'title' => 'Libur Bersama',
            'body' => 'Kantor PCM tutup sementara.',
        ])->assertRedirect(route('admin.announcements.index'));

        $this->assertDatabaseHas('announcements', ['title' => 'Libur Bersama']);
    }

    public function test_announcement_requires_title_and_body(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.announcements.store'), [])
            ->assertSessionHasErrors(['title', 'body']);
    }

    public function test_admin_can_update_and_delete_announcement(): void
    {
        $announcement = Announcement::factory()->create();

        $this->actingAs($this->admin)
            ->put(route('admin.announcements.update', $announcement), [
                'title' => 'Pengumuman Baru',
                'body' => 'Isi baru.',
            ])
            ->assertRedirect(route('admin.announcements.index'));

        $this->assertDatabaseHas('announcements', ['title' => 'Pengumuman Baru']);

        $this->actingAs($this->admin)
            ->delete(route('admin.announcements.destroy', $announcement))
            ->assertRedirect(route('admin.announcements.index'));

        $this->assertDatabaseMissing('announcements', ['title' => 'Pengumuman Baru']);
    }
}
