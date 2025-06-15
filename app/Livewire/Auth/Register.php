<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $notelp = ''; // Kolom untuk nomor telepon
    public int $role = 2; // Default role, bisa 1 untuk user atau 2 untuk admin
    public bool $status = true; // Default status aktif

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // Validasi input
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'notelp' => ['nullable', 'string'], // Validasi untuk nomor telepon
            'role' => ['required', 'integer'], // Validasi untuk role
            'status' => ['required', 'boolean'], // Validasi untuk status
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Tambahkan nilai kolom baru ke dalam data yang akan disimpan
        $validated['status_deleted'] = false; // Set default status_deleted sebagai false
        $validated['role'] = $this->role;
        $validated['notelp'] = $this->notelp;
        $validated['status'] = $this->status;

        // Buat user baru
        $user = User::create($validated);

        // Trigger event registered
        event(new Registered($user));

        // Redirect ke dashboard
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
