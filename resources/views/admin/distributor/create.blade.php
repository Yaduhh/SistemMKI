<x-layouts.app :title="__('Tambah Distributor')">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="w-full mx-auto">
            <div
                class="bg-white dark:bg-accent-foreground rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Distributor Baru</h3>
                </div>

                <!-- Flash Messages -->
                <x-flash-message type="success" :message="session('success')" />
                <x-flash-message type="error" :message="session('error')" />

                <div class="p-6">
                    <form action="{{ route('admin.distributor.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div class="space-y-4">
                            <flux:input name="nama_distributor" :label="__('Nama Distributor')" type="text" required
                                autocomplete="off" :placeholder="__('Masukkan nama distributor')" />

                            <flux:input name="lokasi" :label="__('Lokasi')" type="text" required autocomplete="off"
                                :placeholder="__('Masukkan lokasi distributor')" />

                            <div>
                                <label for="profile"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Profile
                                </label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" name="profile" id="profile"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  dark:file:bg-blue-900 dark:file:text-blue-300
                                                  hover:file:bg-blue-100 dark:hover:file:bg-blue-800
                                                  @error('profile') border-red-500 dark:border-red-500 @enderror">
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB
                                </p>
                                @error('profile')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="status" id="status" value="1"
                                        class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:checked:bg-blue-600"
                                        checked>
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="status" class="font-medium text-gray-700 dark:text-gray-300">
                                        Status Aktif
                                    </label>
                                    <p class="text-gray-500 dark:text-gray-400">
                                        Distributor akan ditampilkan jika status aktif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('admin.distributor.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
