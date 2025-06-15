<x-layouts.finance :title="__('Tambah Client')">
    <div class="container mx-auto ">
        <div class="w-full mx-auto">
            <div
                class="bg-white dark:bg-accent-foreground rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Client Baru</h3>
                </div>

                <!-- Flash Messages -->
                <x-flash-message type="success" :message="session('success')" />
                <x-flash-message type="error" :message="session('error')" />

                <div class="p-6">
                    <form action="{{ route('finance.client.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div class="space-y-4">
                            <flux:input name="nama" :label="__('Nama')" type="text" required autocomplete="off"
                                :placeholder="__('Masukkan nama client')" />

                            <flux:input name="email" :label="__('Email')" type="email" required autocomplete="off"
                                :placeholder="__('Masukkan email client')" />

                            <flux:input name="notelp" :label="__('No. Telp')" type="number" required
                                autocomplete="off" :placeholder="__('Masukkan nomor telepon client')" />

                            <flux:input name="nama_perusahaan" :label="__('Nama Perusahaan')" type="text" 
                                autocomplete="off" :placeholder="__('Masukkan nama perusahaan')" />

                            <flux:textarea name="alamat" :label="__('Alamat')" rows="3"
                                placeholder="Masukkan alamat...">{{ old('alamat') }}</flux:textarea>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Deskripsi
                                </label>
                                <div id="descriptions-container">
                                    <div class="description-item mb-2">
                                        <input type="text" name="descriptions[]" class="block w-full rounded-md px-3 py-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm" placeholder="Masukkan deskripsi..." required>
                                    </div>
                                </div>
                                <button type="button" onclick="addDescription()" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    + Tambah Deskripsi
                                </button>
                            </div>

                            <div>
                                <label for="file_input"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    File
                                </label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" name="file_input" id="file_input"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                               file:mr-4 file:py-2 file:px-4
                                               file:rounded-md file:border-0
                                               file:text-sm file:font-semibold
                                               file:bg-blue-50 file:text-blue-700
                                               dark:file:bg-blue-900 dark:file:text-blue-300
                                               hover:file:bg-blue-100 dark:hover:file:bg-blue-800
                                               @error('file_input') border-red-500 dark:border-red-500 @enderror">
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Format yang didukung: JPG, JPEG, PNG, PDF. Maksimal 2MB
                                </p>
                                @error('file_input')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="status" id="status" value="1"
                                        class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-zinc-700 dark:checked:bg-blue-600"
                                        checked>
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="status" class="font-medium text-gray-700 dark:text-gray-300">
                                        Status Aktif
                                    </label>
                                    <p class="text-gray-500 dark:text-gray-400">
                                        Client akan ditampilkan jika status aktif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('finance.client.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
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
</x-layouts.finance>

<script>
function addDescription() {
    const container = document.getElementById('descriptions-container');
    const newItem = document.createElement('div');
    newItem.className = 'description-item mb-2 flex items-center';
    newItem.innerHTML = `
        <input type="text" name="descriptions[]" class="block w-full rounded-md px-3 py-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm" placeholder="Masukkan deskripsi..." required>
        <button type="button" onclick="this.parentElement.remove()" class="ml-2 inline-flex items-center p-1 border border-transparent rounded-full text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    container.appendChild(newItem);
}
</script>
