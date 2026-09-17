<?php

namespace Tests\Feature;

use App\Models\Aum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicAumTest extends TestCase
{
    use RefreshDatabase;

    public function test_aum_index_lists_all_aums(): void
    {
        Aum::factory()->create(['name' => 'SD Muhammadiyah Pujon', 'type' => 'sekolah']);
        Aum::factory()->create(['name' => 'Masjid Muhammadiyah', 'type' => 'masjid']);

        $this->get(route('aum.index'))
            ->assertOk()
            ->assertSee('SD Muhammadiyah Pujon')
            ->assertSee('Masjid Muhammadiyah');
    }

    public function test_aum_index_filters_by_type(): void
    {
        Aum::factory()->create(['name' => 'SD Muhammadiyah', 'type' => 'sekolah']);
        Aum::factory()->create(['name' => 'Panti Asuhan Al-Amin', 'type' => 'panti']);

        $this->get(route('aum.index', ['type' => 'sekolah']))
            ->assertOk()
            ->assertSee('SD Muhammadiyah')
            ->assertDontSee('Panti Asuhan Al-Amin');
    }

    public function test_aum_show_displays_details(): void
    {
        $aum = Aum::factory()->create(['name' => 'SD Muhammadiyah Pujon', 'address' => 'Jl. Raya Pujon 1', 'maps_url' => 'https://maps.example/embed']);

        $this->get(route('aum.show', $aum->id))
            ->assertOk()
            ->assertSee('SD Muhammadiyah Pujon')
            ->assertSee('Jl. Raya Pujon 1')
            ->assertSee('maps.example');
    }

    public function test_aum_show_hides_maps_when_empty(): void
    {
        $aum = Aum::factory()->create(['maps_url' => null]);

        $this->get(route('aum.show', $aum->id))
            ->assertOk()
            ->assertDontSee('aum-map');
    }

    public function test_aum_show_returns_404_for_missing(): void
    {
        $this->get(route('aum.show', 999))->assertNotFound();
    }

    public function test_aum_empty_state(): void
    {
        $this->get(route('aum.index'))->assertOk()->assertSee('Belum ada data Amal Usaha Muhammadiyah');
    }
}
