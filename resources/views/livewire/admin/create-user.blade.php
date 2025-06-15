<div class="w-full">
    <div class="mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah User Baru</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Buat akun user baru untuk sistem MKI
                    </p>
                </div>
                <div class="flex items-center space-x-3 mt-4 md:mt-0">
                    <flux:button 
                        variant="outline" 
                        wire:click="resetForm"
                    >
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Reset</span>
                    </div>
                    </flux:button>
                    <flux:link 
                        :href="route('admin.akun.index')" 
                        variant="outline"
                    >
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Kembali</span>
                        </div>
                    </flux:link>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Form Card -->
        <div class="bg-white dark:bg-zinc-900/30 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi User</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Isi semua informasi yang diperlukan untuk membuat user baru
                </p>
            </div>

            <form wire:submit="createUser" class="p-6 space-y-6">
                <!-- Profile Image Upload -->
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            @if($profilePreview)
                                <img src="{{ $profilePreview }}" alt="Profile Preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center border-2 border-gray-200 dark:border-gray-600">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <flux:input
                            wire:model="profile"
                            type="file"
                            :label="__('Foto Profil')"
                            accept="image/*"
                            class="w-full"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Format: JPG, JPEG, PNG. Maksimal 2MB.
                        </p>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input
                        wire:model="name"
                        :label="__('Nama Lengkap')"
                        type="text"
                        required
                        autofocus
                        :placeholder="__('Masukkan nama lengkap')"
                    />

                    <flux:input
                        wire:model="email"
                        :label="__('Email')"
                        type="email"
                        required
                        :placeholder="__('email@example.com')"
                    />

                    <flux:input
                        wire:model="notelp"
                        :label="__('Nomor Telepon')"
                        type="number"
                        :placeholder="__('08123456789')"
                    />

                    <flux:select
                        wire:model="role"
                        :label="__('Role')"
                        required
                    >
                        <option value="">Pilih Role</option>
                        <option value="1">Admin</option>
                        <option value="2">Sales</option>
                        <option value="3">Finance</option>
                        <option value="4">Digital Marketing</option>
                    </flux:select>
                </div>

                <!-- Password Section -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Password</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:input
                            wire:model="password"
                            :label="__('Password')"
                            type="password"
                            required
                            :placeholder="__('Minimal 8 karakter')"
                            viewable
                        />

                        <flux:input
                            wire:model="password_confirmation"
                            :label="__('Konfirmasi Password')"
                            type="password"
                            required
                            :placeholder="__('Ulangi password')"
                            viewable
                        />
                    </div>
                </div>

                <!-- Status Section -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Status Akun</h4>
                    <div class="flex items-center">
                        <flux:checkbox
                            wire:model="status"
                            :label="__('Akun Aktif')"
                            class="mr-4"
                        />
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button 
                        type="button"
                        variant="outline" 
                        wire:click="resetForm"
                    >
                        Reset Form
                    </flux:button>
                    
                    <flux:button 
                        type="submit" 
                        variant="primary"
                    >
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Buat User</span>
                        </div>
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Informasi Penting</h4>
                    <ul class="mt-2 text-sm text-blue-700 dark:text-blue-300 space-y-1">
                        <li>• Password harus minimal 8 karakter dengan kombinasi huruf dan angka</li>
                        <li>• Email harus unik dan belum terdaftar di sistem</li>
                        <li>• Role Admin memiliki akses penuh ke semua fitur</li>
                        <li>• Role Sales memiliki akses terbatas sesuai kebutuhan</li>
                        <li>• Foto profil bersifat opsional dan dapat diubah nanti</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> 