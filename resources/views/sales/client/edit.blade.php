<x-layouts.sales :title="__('Edit Client')">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="w-full mx-auto">
            <div class="bg-white dark:bg-accent-foreground rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Client</h3>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="px-6 py-4 bg-green-100 dark:bg-green-900 border-b border-green-200 dark:border-green-700">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="px-6 py-4 bg-red-100 dark:bg-red-900 border-b border-red-200 dark:border-red-700">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <div class="p-6">
                    <form action="{{ route('sales.client.update', $client->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <flux:input 
                                name="nama" 
                                :label="__('Nama')" 
                                type="text" 
                                required 
                                autocomplete="off"
                                :placeholder="__('Masukkan nama client')" 
                                :value="old('nama', $client->nama)" 
                            />

                            <flux:input 
                                name="email" 
                                :label="__('Email')" 
                                type="email"
                                autocomplete="off"
                                :placeholder="__('Masukkan email client')" 
                                :value="old('email', $client->email)" 
                            />

                            <flux:input 
                                name="notelp" 
                                :label="__('No. Telp')" 
                                type="number" 
                                required 
                                autocomplete="off"
                                :placeholder="__('Masukkan nomor telepon client')" 
                                :value="old('notelp', $client->notelp)" 
                            />

                            <flux:input 
                                name="nama_perusahaan" 
                                :label="__('Nama Perusahaan')" 
                                type="text" 
                                autocomplete="off"
                                :placeholder="__('Masukkan nama perusahaan')" 
                                :value="old('nama_perusahaan', $client->nama_perusahaan)" 
                            />

                            <flux:textarea 
                                name="alamat" 
                                :label="__('Alamat')" 
                                rows="3"
                                :placeholder="__('Masukkan alamat lengkap...')"
                            >{{ old('alamat', $client->alamat) }}</flux:textarea>

                            <!-- Description List -->
                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Proyek
                                </label>
                                <div id="descriptionList" class="space-y-3">
                                    @foreach($client->description as $index => $desc)
                                    <div class="description-item flex items-start gap-2">
                                        <div class="flex-grow">
                                            <input type="text" 
                                                name="descriptions[]" 
                                                class="block w-full rounded-xl py-3 px-3 border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm"
                                                placeholder="Masukkan proyek..."
                                                value="{{ old('descriptions.'.$index, $desc) }}"
                                                required
                                            >
                                        </div>
                                        <button type="button" 
                                            class="remove-description p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                            onclick="removeDescription(this)"
                                            style="{{ count($client->description) > 1 ? '' : 'display: none;' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" 
                                    onclick="addDescription()"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Proyek
                                </button>
                            </div>

                            <div>
                                <label for="file_input"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    File
                                </label>
                                @if($client->file_input)
                                    <div class="mt-2 mb-4">
                                        @if(in_array(pathinfo($client->file_input, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                            <img src="{{ Storage::url($client->file_input) }}" 
                                                 alt="Current File" 
                                                 class="h-32 w-32 object-cover rounded-lg">
                                        @else
                                            <a href="{{ Storage::url($client->file_input) }}" 
                                               target="_blank"
                                               class="text-blue-600 dark:text-blue-400 hover:underline">
                                                Lihat File
                                            </a>
                                        @endif
                                    </div>
                                @endif
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
                                        class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:checked:bg-blue-600"
                                        {{ old('status', $client->status) ? 'checked' : '' }}>
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

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('sales.client.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function addDescription() {
            const list = document.getElementById('descriptionList');
            const items = list.getElementsByClassName('description-item');
            
            // Show remove buttons if there's more than one item
            if (items.length > 0) {
                items[0].querySelector('.remove-description').style.display = 'block';
            }

            const newItem = document.createElement('div');
            newItem.className = 'description-item flex items-center gap-2';
            newItem.innerHTML = `
                <div class="flex-grow">
                    <input type="text" 
                        name="descriptions[]" 
                        class="block w-full rounded-xl py-3 px-3 border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm"
                        placeholder="Masukkan deskripsi..."
                        required
                    >
                </div>
                <button type="button" 
                    class="remove-description p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                    onclick="removeDescription(this)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;
            list.appendChild(newItem);
        }

        function removeDescription(button) {
            const list = document.getElementById('descriptionList');
            const items = list.getElementsByClassName('description-item');
            
            if (items.length > 1) {
                button.closest('.description-item').remove();
                
                // Hide remove button if only one item left
                if (items.length === 2) {
                    items[0].querySelector('.remove-description').style.display = 'none';
                }
            }
        }
    </script>
    @endpush
</x-layouts.sales> 