<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Session;

class AccountSettings extends Component
{
    use WithFileUploads;

    // Profile Information
    public string $name = '';
    public string $email = '';
    public string $notelp = '';
    public $profile;
    public $profilePreview;

    // Password Change
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Account Status
    public bool $status = true;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->notelp = $user->notelp ?? '';
        $this->status = $user->status ?? true;
    }

    /**
     * Update profile photo
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
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'notelp' => ['nullable', 'string', 'max:20'],
            'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Log aktivitas sebelum update
        $oldData = $user->toArray();

        // Handle profile image upload
        if ($this->profile) {
            // Delete old profile if exists
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }
            $validated['profile'] = $this->profile->store('profiles', 'public');
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Log aktivitas setelah update
        ActivityLogService::logUpdate(
            'User',
            "Admin mengupdate profil",
            $oldData,
            $user->fresh()->toArray()
        );

        $this->profile = null;
        $this->profilePreview = null;

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        // Log aktivitas sebelum update password
        ActivityLogService::log(
            'update_password',
            'User',
            "Admin mengupdate password",
            ['user_id' => $user->id],
            ['user_id' => $user->id]
        );

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        $this->dispatch('password-updated');
    }

    /**
     * Update account status
     */
    public function updateAccountStatus(): void
    {
        $user = Auth::user();
        
        // Log aktivitas sebelum update status
        $oldData = $user->toArray();

        $user->update(['status' => $this->status]);

        // Log aktivitas setelah update status
        ActivityLogService::logUpdate(
            'User',
            "Admin mengupdate status akun",
            $oldData,
            $user->fresh()->toArray()
        );

        $this->dispatch('status-updated');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    public function render()
    {
        return view('livewire.admin.account-settings');
    }
} 