<x-layouts.app :title="__('Edit Aktivitas Harian')">
    <div class="flex flex-col gap-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-100">{{ 'Edit Aktivitas Harian' }}</h1>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.daily-activity.update', $dailyActivity->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Dokumentasi -->
                <div>
                    <label for="dokumentasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Dokumentasi
                    </label>
                    <input type="text" name="dokumentasi" id="dokumentasi" value="{{ old('dokumentasi', $dailyActivity->dokumentasi) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent @error('dokumentasi') border-red-500 @enderror">
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
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent @error('perihal') border-red-500 @enderror">{{ old('perihal', $dailyActivity->perihal) }}</textarea>
                    @error('perihal')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pihak Bersangkutan -->
                <div>
                    <label for="pihak_bersangkutan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Pihak Bersangkutan
                    </label>
                    <input type="text" name="pihak_bersangkutan" id="pihak_bersangkutan" value="{{ old('pihak_bersangkutan', $dailyActivity->pihak_bersangkutan) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent @error('pihak_bersangkutan') border-red-500 @enderror">
                    @error('pihak_bersangkutan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Komentar -->
                <div>
                    <label for="komentar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Komentar (Opsional)
                    </label>
                    <textarea name="komentar" id="komentar" rows="3"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent @error('komentar') border-red-500 @enderror">{{ old('komentar', $dailyActivity->komentar) }}</textarea>
                    @error('komentar')
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
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app> 