<section class="w-full space-y-6">
    <!-- Profile Information Section -->
    <div class="w-full">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Informasi Profil') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Update informasi profil dan foto Anda') }}</p>
        </div>
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="my-3 bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="my-3 bg-red-100 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="updateProfileInformation" class="space-y-6">
            <!-- Profile Photo -->
            <div class="space-y-4">
                <flux:text class="text-sm font-medium">{{ __('Foto Profil') }}</flux:text>
                
                <div class="flex items-center space-x-4">
                    @if($profilePreview)
                        <img src="{{ $profilePreview }}" alt="Preview" class="w-20 h-20 rounded-lg object-cover border-2 border-gray-200">
                    @elseif(auth()->user()->profile)
                        <img src="{{ Storage::url(auth()->user()->profile) }}" alt="Profile" class="w-20 h-20 rounded-lg object-cover border-2 border-gray-200">
                    @else
                        <div class="w-20 h-20 rounded-lg bg-gray-200 flex items-center justify-center">
                            <span class="text-2xl font-bold text-gray-500">{{ auth()->user()->initials() }}</span>
                        </div>
                    @endif
                    
                    <div>
                        <input 
                            type="file" 
                            wire:model="profile" 
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300"
                        />
                        <flux:text class="text-xs text-gray-500 mt-1">
                            {{ __('Format: JPG, JPEG, PNG. Maksimal 2MB.') }}
                        </flux:text>
                    </div>
                </div>
            </div>

            <!-- Name -->
            <flux:input 
                wire:model="name" 
                :label="__('Nama')" 
                type="text" 
                required 
                autofocus 
                autocomplete="name" 
            />

            <!-- Email -->
            <div>
                <flux:input 
                    wire:model="email" 
                    :label="__('Email')" 
                    type="email" 
                    required 
                    autocomplete="email" 
                />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div class="mt-4">
                        <flux:text class="text-sm text-yellow-600">
                            {{ __('Email Anda belum diverifikasi.') }}

                            <flux:link class="text-sm cursor-pointer text-blue-600" wire:click.prevent="resendVerificationNotification">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium text-green-600">
                                {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Phone Number -->
            <flux:input 
                wire:model="notelp" 
                :label="__('Nomor Telepon')" 
                type="tel" 
                autocomplete="tel"
                placeholder="+62 812-3456-7890"
            />

            <!-- Save Button -->
            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('Simpan Perubahan') }}
                </flux:button>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Tersimpan.') }}
                </x-action-message>
            </div>
        </form>
    </div>

    <!-- Password Section -->
    <div class="w-full">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Ubah Password') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Pastikan akun Anda menggunakan password yang panjang dan aman.') }}</p>
        </div>
        
        <!-- Flash Message for Password Success -->
        @if(session('password_success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-md">
                {{ session('password_success') }}
            </div>
        @endif
        
        <form wire:submit="updatePassword" class="space-y-6">
            <div class="relative">
                <flux:input 
                    wire:model="current_password" 
                    :label="__('Password Saat Ini')" 
                    :type="$showCurrentPassword ? 'text' : 'password'" 
                    required 
                    autocomplete="current-password" 
                />
                <button 
                    type="button" 
                    wire:click="$toggle('showCurrentPassword')" 
                    class="absolute right-3 top-8 text-gray-500 hover:text-gray-700"
                >
                    @if($showCurrentPassword)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    @endif
                </button>
            </div>

            <div class="relative">
                <flux:input 
                    wire:model="password" 
                    :label="__('Password Baru')" 
                    :type="$showPassword ? 'text' : 'password'" 
                    required 
                    autocomplete="new-password" 
                />
                <button 
                    type="button" 
                    wire:click="$toggle('showPassword')" 
                    class="absolute right-3 top-8 text-gray-500 hover:text-gray-700"
                >
                    @if($showPassword)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    @endif
                </button>
            </div>

            <div class="relative">
                <flux:input 
                    wire:model="password_confirmation" 
                    :label="__('Konfirmasi Password Baru')" 
                    :type="$showPasswordConfirmation ? 'text' : 'password'" 
                    required 
                    autocomplete="new-password" 
                />
                <button 
                    type="button" 
                    wire:click="$toggle('showPasswordConfirmation')" 
                    class="absolute right-3 top-8 text-gray-500 hover:text-gray-700"
                >
                    @if($showPasswordConfirmation)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    @endif
                </button>
            </div>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('Ubah Password') }}
                </flux:button>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Password berhasil diubah.') }}
                </x-action-message>
            </div>
        </form>
    </div>

    <!-- Appearance Section -->
    <div class="w-full">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Tampilan') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Pilih tema tampilan yang Anda inginkan.') }}</p>
        </div>
        
        <div class="space-y-6">
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun">{{ __('Terang') }}</flux:radio>
                <flux:radio value="dark" icon="moon">{{ __('Gelap') }}</flux:radio>
                <flux:radio value="system" icon="computer-desktop">{{ __('Sistem') }}</flux:radio>
            </flux:radio.group>
            
            <flux:text class="text-sm text-gray-500">
                {{ __('Pilih "Sistem" untuk mengikuti pengaturan sistem operasi Anda.') }}
            </flux:text>
        </div>
    </div>
</section>