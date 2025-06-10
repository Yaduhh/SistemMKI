<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_access_settings_page()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 1, // Admin role
        ]);

        // Act as the admin user
        $this->actingAs($admin);

        // Visit the admin settings page
        $response = $this->get(route('admin.setting.index'));

        // Assert the page loads successfully
        $response->assertStatus(200);
        $response->assertViewIs('admin.setting.index');
    }

    public function test_non_admin_cannot_access_admin_settings()
    {
        // Create a sales user
        $sales = User::factory()->create([
            'role' => 2, // Sales role
        ]);

        // Act as the sales user
        $this->actingAs($sales);

        // Try to visit the admin settings page
        $response = $this->get(route('admin.setting.index'));

        // Assert access is denied (should redirect or show 403)
        $response->assertStatus(403);
    }

    public function test_admin_settings_page_contains_required_sections()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 1,
        ]);

        // Act as the admin user
        $this->actingAs($admin);

        // Visit the admin settings page
        $response = $this->get(route('admin.setting.index'));

        // Assert the page contains required sections
        $response->assertSee('Informasi Profil');
        $response->assertSee('Ubah Password');
        $response->assertSee('Tampilan');
        $response->assertSee('Status Akun');
        $response->assertSee('Hak Akses Admin');
        $response->assertSee('Informasi Sistem');
    }
}
