<?php

namespace Tests\Feature\Admin;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDocumentTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        $this->admin = User::factory()->admin()->create();
    }

    public function test_public_and_guest_cannot_access_documents(): void
    {
        $this->get(route('admin.documents.index'))->assertRedirect(route('login'));

        $member = User::factory()->member()->create();
        $this->actingAs($member)
            ->get(route('admin.documents.index'))
            ->assertForbidden();
    }

    public function test_admin_can_upload_document(): void
    {
        $file = UploadedFile::fake()->create('surat-keputusan.pdf', 100, 'application/pdf');

        $this->actingAs($this->admin)->post(route('admin.documents.store'), [
            'title' => 'SK Pengurus 2026',
            'category' => 'sk',
            'file' => $file,
        ])->assertRedirect(route('admin.documents.index'));

        $this->assertDatabaseHas('documents', [
            'title' => 'SK Pengurus 2026',
            'category' => 'sk',
            'file_name' => 'surat-keputusan.pdf',
        ]);

        $document = Document::first();
        Storage::disk('local')->assertExists($document->file_path);
    }

    public function test_upload_requires_valid_type_and_size(): void
    {
        $this->actingAs($this->admin)->post(route('admin.documents.store'), [
            'title' => 'File Salah',
            'category' => 'sk',
            'file' => UploadedFile::fake()->create('virus.exe', 100, 'application/x-msdownload'),
        ])->assertSessionHasErrors(['file']);

        $this->actingAs($this->admin)->post(route('admin.documents.store'), [
            'title' => 'Tanpa File',
            'category' => 'sk',
        ])->assertSessionHasErrors(['file']);
    }

    public function test_admin_can_download_document(): void
    {
        $file = UploadedFile::fake()->create('edaran.pdf', 100, 'application/pdf');

        $this->actingAs($this->admin)->post(route('admin.documents.store'), [
            'title' => 'Edaran Rapat',
            'category' => 'edaran',
            'file' => $file,
        ]);

        $document = Document::first();

        $this->actingAs($this->admin)
            ->get(route('admin.documents.download', $document))
            ->assertOk();
    }

    public function test_member_cannot_download_document(): void
    {
        $document = Document::factory()->create();

        $member = User::factory()->member()->create();
        $this->actingAs($member)
            ->get(route('admin.documents.download', $document))
            ->assertForbidden();
    }

    public function test_admin_can_delete_document(): void
    {
        $file = UploadedFile::fake()->create('laporan.pdf', 100, 'application/pdf');

        $this->actingAs($this->admin)->post(route('admin.documents.store'), [
            'title' => 'Laporan Tahunan',
            'category' => 'laporan',
            'file' => $file,
        ]);

        $document = Document::first();

        $this->actingAs($this->admin)
            ->delete(route('admin.documents.destroy', $document))
            ->assertRedirect(route('admin.documents.index'));

        $this->assertDatabaseMissing('documents', ['id' => $document->id]);
        Storage::disk('local')->assertMissing($document->file_path);
    }
}
