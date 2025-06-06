<x-layouts.app :title="__('Tambah Aktivitas Harian')">
    <div class="flex flex-col gap-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-100">{{ 'Tambah Aktivitas Harian' }}</h1>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.daily-activity.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Dokumentasi -->
                <div>
                    <label for="dokumentasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Dokumentasi (Foto)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="dokumentasi" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload foto</span>
                                    <input id="dokumentasi" name="dokumentasi" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, JPEG sampai 2MB
                            </p>
                        </div>
                    </div>
                    @error('dokumentasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Perihal -->
                <div>
                    <label for="perihal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Perihal
                    </label>
                    <textarea name="perihal" id="perihal" rows="4"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent @error('perihal') border-red-500 @enderror">{{ old('perihal') }}</textarea>
                    @error('perihal')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pihak Bersangkutan -->
                <div>
                    <label for="pihak_bersangkutan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Pihak Bersangkutan
                    </label>
                    <input type="text" name="pihak_bersangkutan" id="pihak_bersangkutan" value="{{ old('pihak_bersangkutan') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent @error('pihak_bersangkutan') border-red-500 @enderror">
                    @error('pihak_bersangkutan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.daily-activity.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app> 