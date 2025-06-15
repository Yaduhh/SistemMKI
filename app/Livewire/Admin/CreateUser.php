<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Facades\Session;
use App\Services\ActivityLogService;

class CreateUser extends Component
{
    use WithFileUploads;

    // User Information
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $notelp = '';
    public int $role = 1;
    public bool $status = true;
    public $profile;
    public $profilePreview;

    /**
     * Update profile photo preview
     */
    public function updatedProfile()
    {
        $this->validate([
            'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($this->profile) {
            $this->profilePreview = $this->profile->temporaryUrl();
        }
    }

    /**
     * Create a new user
     */
    public function createUser(): void
    {
        // Validasi input
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'notelp' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'integer', 'in:1,2,3,4'],
            'status' => ['required', 'boolean'],
            'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Set default values
        $validated['status_deleted'] = false;

        // Handle profile image upload
        if ($this->profile) {
            $validated['profile'] = $this->profile->store('profiles', 'public');
        }

        // Buat user baru
        $user = User::create($validated);

        // Log aktivitas pembuatan user
        ActivityLogService::logCreate(
            'User',
            "Admin membuat user baru: {$user->name}",
            $user->toArray()
        );

        // Set success message
        Session::flash('success', 'User berhasil dibuat!');

        // Reset form
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'notelp', 'role', 'status', 'profile', 'profilePreview']);

        // Redirect ke halaman akun
        $this->redirect(route('admin.akun.index'), navigate: true);
    }

    /**
     * Reset form
     */
    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'notelp', 'role', 'status', 'profile', 'profilePreview']);
    }

    public function render()
    {
        return view('livewire.admin.create-user')
            ->layout('components.layouts.app');
    }
} 