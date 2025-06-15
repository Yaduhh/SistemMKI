<x-layouts.app :title="__('Edit Akun')">
    <div class="container">
        <div class="w-full">
            <div class="bg-white dark:bg-accent-foreground rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Akun</h3>
                </div>

                <!-- Flash Messages -->
                <x-flash-message type="success" :message="session('success')" />
                <x-flash-message type="error" :message="session('error')" />

                <form action="{{ route('admin.akun.update', $akun) }}" method="POST" enctype="multipart/form-data"
                    class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image -->
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            @if ($akun->profile)
                                <img class="h-16 w-16 rounded-full object-cover"
                                    src="{{ Storage::url($akun->profile) }}"
                                    alt="{{ $akun->name }}">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400 text-lg">
                                        {{ strtoupper(substr($akun->name, 0, 2)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Foto Profile
                            </label>
                            <div class="mt-1 flex items-center">
                                <input type="file" name="profile" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    dark:file:bg-blue-900 dark:file:text-blue-300
                                    hover:file:bg-blue-100 dark:hover:file:bg-blue-800">
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                JPG, JPEG atau PNG. Maksimal 2MB.
                            </p>
                        </div>
                    </div>

                    <!-- Name -->
                    <flux:input name="name" :label="__('Nama')" type="text" required autocomplete="off"
                        :value="old('name', $akun->name)" :placeholder="__('Masukkan nama lengkap')" />

                    <!-- Email -->
                    <flux:input name="email" :label="__('Email')" type="email" required autocomplete="off"
                        :value="old('email', $akun->email)" :placeholder="__('Masukkan email')" />

                    <!-- Password -->
                    <flux:input name="password" :label="__('Password Baru')" type="password" autocomplete="new-password"
                        :placeholder="__('Masukkan password baru (opsional)')" />

                    <!-- Confirm Password -->
                    <flux:input name="password_confirmation" :label="__('Konfirmasi Password')" type="password"
                        autocomplete="new-password" :placeholder="__('Konfirmasi password baru')" />

                    <!-- Role -->
                    <flux:select
                        wire:model="role"
                        :label="__('Role')"
                        required
                    >
                        <option value="1" {{ old('role', $akun->role) == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ old('role', $akun->role) == 2 ? 'selected' : '' }}>User</option>
                        <option value="3" {{ old('role', $akun->role) == 3 ? 'selected' : '' }}>Finance</option>
                        <option value="4" {{ old('role', $akun->role) == 4 ? 'selected' : '' }}>Digital Marketing</option>
                    </flux:select>


                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('admin.akun.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Batal
                        </a>
                        <x-primary-button>
                            {{ __('Simpan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app> 