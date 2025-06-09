<x-layouts.sales :title="__('Tambah Aktivitas Harian')">
    <div class="container mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-center sm:items-center mb-8">
            <div class="p-2 rounded-xl bg-emerald-800/10 text-primary dark:bg-emerald-800/20 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <h1 class="text-xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    {{ __('Tambah Aktivitas Harian') }}
                </h1>
            </div>
            <p class="mt-2 sm:mt-0 text-gray-600 dark:text-gray-400">
                Isi detail aktivitas harian baru Anda.
            </p>
        </div>

        <div class="mb-6">
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />
        </div>

        <div class="">
            <form action="{{ route('sales.daily-activity.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="dokumentasi" class="block text-sm font-semibold text-gray-800 dark:text-gray-200">
                        Dokumentasi
                    </label>
                    <p class="text-gray-500 text-xs mb-2">(bisa lebih dari satu, format: gambar)</p>
                    <input type="file" name="dokumentasi[]" id="dokumentasi" multiple accept="image/*"
                           class="block w-full text-sm text-gray-900 dark:text-gray-100
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-emerald-700
                                  hover:file:bg-emerald-100 dark:file:bg-emerald-900 dark:file:text-emerald-300 dark:hover:file:bg-emerald-800
                                  border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('dokumentasi') border-red-500 @enderror">
                    @error('dokumentasi')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('dokumentasi.*')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:textarea
                        name="perihal"
                        id="perihal"
                        label="Perihal"
                        placeholder="Masukkan perihal aktivitas..."
                        :value="old('perihal')"
                        :has-error="$errors->has('perihal')"
                    />
                    @error('perihal')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:input
                        type="text"
                        name="pihak_bersangkutan"
                        id="pihak_bersangkutan"
                        label="Pihak Bersangkutan"
                        placeholder="Masukkan pihak yang bersangkutan..."
                        :value="old('pihak_bersangkutan')"
                        :has-error="$errors->has('pihak_bersangkutan')"
                    />
                    @error('pihak_bersangkutan')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('sales.daily-activity.index') }}">
                        <flux:button variant="filled">
                            {{ __('Batal') }}
                        </flux:button>
                    </a>
                    <flux:button type="submit" variant="primary" class="flex items-center gap-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 -ml-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Simpan') }}
                        </div>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.sales>