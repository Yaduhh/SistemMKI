<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\CreateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_create_user_page()
    {
        $admin = User::factory()->create(['role' => 1]);
        $this->actingAs($admin);

        $response = $this->get(route('admin.akun.create'));
        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_create_user_page()
    {
        $sales = User::factory()->create(['role' => 2]);
        $this->actingAs($sales);

        $response = $this->get(route('admin.akun.create'));
        $response->assertStatus(403);
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create(['role' => 1]);
        $this->actingAs($admin);

        $response = Livewire::test(CreateUser::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('notelp', '08123456789')
            ->set('role', 2)
            ->set('status', true)
            ->call('createUser');

        $response->assertHasNoErrors();
        $response->assertRedirect(route('admin.akun.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 2,
            'notelp' => '08123456789',
            'status' => true,
        ]);
    }

    public function test_create_user_validates_required_fields()
    {
        $admin = User::factory()->create(['role' => 1]);
        $this->actingAs($admin);

        $response = Livewire::test(CreateUser::class)
            ->set('name', '')
            ->set('email', '')
            ->set('password', '')
            ->call('createUser');

        $response->assertHasErrors(['name', 'email', 'password']);
    }

    public function test_create_user_validates_email_uniqueness()
    {
        $admin = User::factory()->create(['role' => 1]);
        $existingUser = User::factory()->create(['email' => 'test@example.com']);
        $this->actingAs($admin);

        $response = Livewire::test(CreateUser::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('createUser');

        $response->assertHasErrors(['email']);
    }

    public function test_create_user_validates_password_confirmation()
    {
        $admin = User::factory()->create(['role' => 1]);
        $this->actingAs($admin);

        $response = Livewire::test(CreateUser::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'differentpassword')
            ->call('createUser');

        $response->assertHasErrors(['password']);
    }

    public function test_reset_form_clears_all_fields()
    {
        $admin = User::factory()->create(['role' => 1]);
        $this->actingAs($admin);

        $response = Livewire::test(CreateUser::class)
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('notelp', '08123456789')
            ->set('role', 2)
            ->set('status', true)
            ->call('resetForm');

        $response->assertSet('name', '');
        $response->assertSet('email', '');
        $response->assertSet('password', '');
        $response->assertSet('password_confirmation', '');
        $response->assertSet('notelp', '');
        $response->assertSet('role', 1);
        $response->assertSet('status', true);
    }
} 