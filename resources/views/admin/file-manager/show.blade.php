<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Detail File</h1>
            <div class="flex gap-2">
                <x-button as="a" href="{{ route('admin.file-manager.edit', $fileManager) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white">
                    <x-icon name="pencil" class="w-4 h-4 mr-2" />
                    Edit
                </x-button>
                <x-button as="a" href="{{ route('admin.file-manager.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                    Kembali
                </x-button>
            </div>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-4 mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- File Preview -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Preview File</h2>
                    
                    <div class="aspect-video bg-gray-100 dark:bg-zinc-800 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($fileManager->isImage())
                            <img src="{{ $fileManager->full_url }}" alt="{{ $fileManager->alt_text ?? $fileManager->original_name }}"
                                class="max-w-full max-h-full object-contain">
                        @elseif($fileManager->isVideo())
                            <video controls class="max-w-full max-h-full">
                                <source src="{{ $fileManager->full_url }}" type="{{ $fileManager->mime_type }}">
                                Browser Anda tidak mendukung video.
                            </video>
                        @elseif($fileManager->isAudio())
                            <div class="text-center">
                                <x-icon name="musical-note" class="w-16 h-16 text-green-500 mx-auto mb-4" />
                                <audio controls class="w-full max-w-md">
                                    <source src="{{ $fileManager->full_url }}" type="{{ $fileManager->mime_type }}">
                                    Browser Anda tidak mendukung audio.
                                </audio>
                            </div>
                        @else
                            <div class="text-center">
                                <x-icon name="{{ $fileManager->file_icon }}" class="w-16 h-16 text-gray-500 mx-auto mb-4" />
                                <p class="text-gray-500 dark:text-gray-400">{{ strtoupper($fileManager->file_extension) }} File</p>
                                <a href="{{ route('admin.file-manager.download', $fileManager) }}"
                                    class="inline-flex items-center px-4 py-2 mt-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <x-icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                                    Download File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- File Information -->
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi File</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama File</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white break-all">{{ $fileManager->original_name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $fileManager->title ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe File</label>
                            <div class="mt-1 flex items-center gap-2">
                                <x-icon name="{{ $fileManager->file_icon }}" class="w-4 h-4 text-gray-500" />
                                <span class="text-sm text-gray-900 dark:text-white capitalize">{{ $fileManager->file_type }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ukuran File</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $fileManager->human_file_size }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">MIME Type</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $fileManager->mime_type }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Folder</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $fileManager->folder_path ?? 'Root' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistik</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Dilihat</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $fileManager->view_count }} kali</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Download</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $fileManager->download_count }} kali</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Diupload</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $fileManager->created_at->format('d M Y H:i') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Terakhir diakses</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $fileManager->last_accessed_at ? $fileManager->last_accessed_at->format('d M Y H:i') : 'Belum pernah' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status & Aksi</h2>
                    
                    <div class="space-y-4">
                        <!-- Public Status -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Status Publik</span>
                            <form action="{{ route('admin.file-manager.toggle-public', $fileManager) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                    class="px-3 py-1 text-xs rounded-full transition-colors {{ $fileManager->is_public ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                    {{ $fileManager->is_public ? 'Publik' : 'Private' }}
                                </button>
                            </form>
                        </div>
                        
                        <!-- Featured Status -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Featured</span>
                            <form action="{{ route('admin.file-manager.toggle-featured', $fileManager) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                    class="px-3 py-1 text-xs rounded-full transition-colors {{ $fileManager->is_featured ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                    {{ $fileManager->is_featured ? 'Featured' : 'Normal' }}
                                </button>
                            </form>
                        </div>
                        
                        <!-- Uploader -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Diupload oleh</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $fileManager->uploader->name ?? 'Unknown' }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-2">
                        <a href="{{ route('admin.file-manager.download', $fileManager) }}"
                            class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <x-icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                            Download File
                        </a>
                        
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.file-manager.edit', $fileManager) }}"
                                class="flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                <x-icon name="pencil" class="w-4 h-4 mr-2" />
                                Edit
                            </a>
                            
                            <form action="{{ route('admin.file-manager.destroy', $fileManager) }}" method="POST" 
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                    <x-icon name="trash" class="w-4 h-4 mr-2" />
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($fileManager->description)
            <div class="mt-8">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deskripsi</h2>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $fileManager->description }}</p>
                </div>
            </div>
        @endif

        <!-- Metadata -->
        @if($fileManager->metadata && count($fileManager->metadata) > 0)
            <div class="mt-8">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Metadata</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($fileManager->metadata as $key => $value)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ str_replace('_', ' ', $key) }}</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
