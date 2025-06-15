<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Mega Komposit Connect')" :description="__('Masukkan Email dan Katasandi Anda untuk Connect!')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Ingat Saya')" />
        
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>
    
    <div class="flex items-center justify-center space-x-4">
        <p class="text-gray-500 dark:text-gray-400">
            {{ __('Belum punya akun?') }}
        </p>
        <flux:link :href="route('register')" wire:navigate>
            {{ __('Daftar Sekarang') }}
        </flux:link>
    </div>
</div>
