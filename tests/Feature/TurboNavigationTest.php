<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TurboNavigationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Elemen bersama (navbar, mobile drawer, footer) harus diberi tanda
     * data-turbo-permanent supaya tidak dimuat ulang saat navigasi antar halaman.
     */
    public function test_shared_chrome_is_turbo_permanent(): void
    {
        $html = $this->get(route('home'))->getContent();

        $this->assertSame(3, substr_count($html, 'data-turbo-permanent'));
    }

    public function test_app_js_boots_turbo_drive(): void
    {
        $source = file_get_contents(resource_path('js/app.js'));

        $this->assertStringContainsString("@hotwired/turbo", $source);
        $this->assertStringContainsString("turbo:render", $source);
    }
}