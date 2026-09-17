<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicAgendaTest extends TestCase
{
    use RefreshDatabase;

    public function test_agenda_page_lists_upcoming_events_sorted_ascending(): void
    {
        Agenda::factory()->create(['title' => 'Kegiatan Besok', 'starts_at' => now()->addDay()]);
        Agenda::factory()->create(['title' => 'Kegiatan Lusa', 'starts_at' => now()->addDays(2)]);

        $this->get(route('agenda.index'))
            ->assertOk()
            ->assertSee('Kegiatan Besok')
            ->assertSee('Kegiatan Lusa');
    }

    public function test_agenda_page_shows_empty_state(): void
    {
        $this->get(route('agenda.index'))
            ->assertOk()
            ->assertSee('Belum ada agenda mendatang')
            ->assertSee('Belum ada pengumuman');
    }

    public function test_announcements_are_listed(): void
    {
        Announcement::factory()->create(['title' => 'Edaran Resmi Cabang']);

        $this->get(route('agenda.index'))
            ->assertOk()
            ->assertSee('Edaran Resmi Cabang');
    }

    public function test_future_scheduled_announcement_is_hidden(): void
    {
        Announcement::factory()->create(['title' => 'Pengumuman Masa Depan', 'published_at' => now()->addDay()]);

        $this->get(route('agenda.index'))
            ->assertOk()
            ->assertDontSee('Pengumuman Masa Depan');
    }
}
