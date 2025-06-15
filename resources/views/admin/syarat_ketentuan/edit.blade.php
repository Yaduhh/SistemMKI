<x-layouts.app :title="__('Edit Syarat & Ketentuan')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <!-- Header Section -->
            <div class="mb-4">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Syarat & Ketentuan</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ubah syarat dan ketentuan yang ada</p>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Form Section -->
            <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form action="{{ route('admin.syarat_ketentuan.update', $syaratKetentuan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Syarat -->
                    <div>
                        <label for="syarat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Syarat & Ketentuan</label>
                        <textarea id="syarat" name="syarat" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:focus:ring-emerald-600 dark:focus:border-emerald-600"
                            placeholder="Masukkan syarat dan ketentuan..."
                            required>{{ old('syarat', $syaratKetentuan->syarat) }}</textarea>
                        @error('syarat')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.syarat_ketentuan.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
