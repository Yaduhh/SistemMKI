<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Check if user exists
        $user = User::where('email', $this->email)->first();
        
        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'email' => 'Akun tidak ditemukan.',
            ]);
        }
        
        // Check if account is active
        if ($user->status == 0) {
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif, silahkan hubungi administrator.',
            ]);
        }
        
        // Check password
        if (!Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());
            
            throw ValidationException::withMessages([
                'password' => 'Kata sandi salah.',
            ]);
        }
        
        // Attempt login
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Terjadi kesalahan saat login.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Redirect based on user role
        $user = Auth::user();
        if ($user->role === 2) {
            $this->redirectIntended(default: route('sales.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
