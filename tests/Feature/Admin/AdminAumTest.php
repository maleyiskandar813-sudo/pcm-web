<?php

namespace Tests\Feature\Admin;

use App\Models\Aum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAumTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->admin = User::factory()->admin()->create();
    }

    public function test_guest_is_redirected(): void
    {
        $this->get(route('admin.aum.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_aum(): void
    {
        $this->actingAs($this->admin)->post(route('admin.aum.store'), [
            'type' => 'masjid',
            'name' => 'Masjid At-Taqwa Pujon',
            'address' => 'Jl. Raya Pujon No. 1',
            'phone' => '0341-123456',
            'description' => 'Masjid utama cabang.',
            'maps_url' => 'https://www.google.com/maps/embed?pb=abc',
        ])->assertRedirect(route('admin.aum.index'));

        $this->assertDatabaseHas('aum', ['name' => 'Masjid At-Taqwa Pujon']);
    }

    public function test_aum_requires_type_and_name(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.aum.store'), [])
            ->assertSessionHasErrors(['type', 'name']);
    }

    public function test_invalid_type_is_rejected(): void
    {
        $this->actingAs($this->admin)->post(route('admin.aum.store'), [
            'type' => 'kantor',
            'name' => 'AUM Salah',
        ])->assertSessionHasErrors(['type']);
    }

    public function test_invalid_maps_url_is_rejected(): void
    {
        $this->actingAs($this->admin)->post(route('admin.aum.store'), [
            'type' => 'sekolah',
            'name' => 'SD Muhammadiyah',
            'maps_url' => 'bukan-url',
        ])->assertSessionHasErrors(['maps_url']);
    }

    public function test_photo_is_optimized_on_upload(): void
    {
        $file = UploadedFile::fake()->image('aum.png', 1000, 600);

        $this->actingAs($this->admin)->post(route('admin.aum.store'), [
            'type' => 'panti',
            'name' => 'Panti Asuhan Harapan',
            'photo' => $file,
        ]);

        $aum = Aum::first();
        $this->assertNotNull($aum->photo);
        Storage::disk('public')->assertExists($aum->photo);
        $this->assertStringStartsWith('aum/', $aum->photo);
    }

    public function test_admin_can_update_aum(): void
    {
        $aum = Aum::factory()->create(['name' => 'Nama Lama']);

        $this->actingAs($this->admin)->put(route('admin.aum.update', $aum), [
            'type' => 'sekolah',
            'name' => 'Nama Baru',
            'address' => 'Jl. Baru',
        ])->assertRedirect(route('admin.aum.index'));

        $this->assertDatabaseHas('aum', ['name' => 'Nama Baru']);
    }

    public function test_soft_delete_and_restore(): void
    {
        $aum = Aum::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.aum.destroy', $aum))
            ->assertRedirect(route('admin.aum.index'));

        $this->assertSoftDeleted('aum', ['id' => $aum->id]);

        $this->actingAs($this->admin)
            ->post(route('admin.aum.restore', $aum))
            ->assertRedirect(route('admin.aum.index'));

        $this->assertDatabaseHas('aum', ['id' => $aum->id, 'deleted_at' => null]);
    }

    public function test_public_aum_page_hides_deleted_items(): void
    {
        Aum::factory()->create(['name' => 'AUM Aktif']);
        Aum::factory()->create(['name' => 'AUM Terhapus'])->delete();

        $this->get(route('aum.index'))
            ->assertOk()
            ->assertSee('AUM Aktif')
            ->assertDontSee('AUM Terhapus');
    }
}
