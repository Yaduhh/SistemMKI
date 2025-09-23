<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit File</h1>
            <x-button as="a" href="{{ route('admin.file-manager.show', $fileManager) }}"
                class="bg-gray-600 hover:bg-gray-700 text-white">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Kembali ke Detail
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-4 mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- File Preview -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Preview File</h2>
                    
                    <div class="aspect-square bg-gray-100 dark:bg-zinc-800 rounded-lg flex items-center justify-center overflow-hidden mb-4">
                        @if($fileManager->isImage())
                            <img src="{{ $fileManager->full_url }}" alt="{{ $fileManager->alt_text ?? $fileManager->original_name }}"
                                class="max-w-full max-h-full object-contain">
                        @elseif($fileManager->isVideo())
                            <div class="text-center">
                                <x-icon name="video-camera" class="w-12 h-12 text-orange-500 mx-auto mb-2" />
                                <span class="text-sm text-gray-500">Video File</span>
                            </div>
                        @elseif($fileManager->isAudio())
                            <div class="text-center">
                                <x-icon name="musical-note" class="w-12 h-12 text-green-500 mx-auto mb-2" />
                                <span class="text-sm text-gray-500">Audio File</span>
                            </div>
                        @else
                            <div class="text-center">
                                <x-icon name="{{ $fileManager->file_icon }}" class="w-12 h-12 text-gray-500 mx-auto mb-2" />
                                <span class="text-sm text-gray-500">{{ strtoupper($fileManager->file_extension) }} File</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $fileManager->original_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500">{{ $fileManager->human_file_size }}</p>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('admin.file-manager.update', $fileManager) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi File</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <flux:input name="title" label="Judul File" 
                                    value="{{ old('title', $fileManager->title) }}" 
                                    placeholder="Masukkan judul file" 
                                    type="text" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                            </div>
                            
                            <div>
                                <flux:input name="alt_text" label="Alt Text" 
                                    value="{{ old('alt_text', $fileManager->alt_text) }}" 
                                    placeholder="Masukkan alt text untuk aksesibilitas" 
                                    type="text" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Alt text membantu screen reader untuk mendeskripsikan file</p>
                            </div>
                            
                            <div>
                                <flux:input name="folder_path" label="Folder" 
                                    value="{{ old('folder_path', $fileManager->folder_path) }}" 
                                    placeholder="Nama folder" 
                                    type="text" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                            </div>
                            
                            <div>
                                <flux:textarea name="description" label="Deskripsi" 
                                    placeholder="Masukkan deskripsi file" 
                                    rows="4" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">{{ old('description', $fileManager->description) }}</flux:textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">File Publik</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">File dapat diakses oleh semua orang</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_public" value="1" 
                                        {{ old('is_public', $fileManager->is_public) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">Featured</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tandai file sebagai featured/pin</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1" 
                                        {{ old('is_featured', $fileManager->is_featured) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- File Information (Read Only) -->
                    <div class="bg-gray-50 dark:bg-zinc-800 rounded-xl p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Sistem</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama File Asli</label>
                                <p class="mt-1 text-gray-900 dark:text-white break-all">{{ $fileManager->original_name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe File</label>
                                <p class="mt-1 text-gray-900 dark:text-white capitalize">{{ $fileManager->file_type }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran File</label>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fileManager->human_file_size }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">MIME Type</label>
                                <p class="mt-1 text-gray-900 dark:text-white font-mono">{{ $fileManager->mime_type }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diupload oleh</label>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fileManager->uploader->name ?? 'Unknown' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Upload</label>
                                <p class="mt-1 text-gray-900 dark:text-white">{{ $fileManager->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-3">
                        <x-button as="a" href="{{ route('admin.file-manager.show', $fileManager) }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white">
                            Batal
                        </x-button>
                        <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white">
                            <x-icon name="check" class="w-4 h-4 mr-2" />
                            Simpan Perubahan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
