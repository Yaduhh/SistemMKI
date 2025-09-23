<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">File Manager</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola semua file yang telah diupload</p>
            </div>
            <x-button href="{{ route('admin.file-manager.create') }}"
                class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload File
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="pb-6 space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 dark:text-blue-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Total File
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $files->total() }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 dark:text-green-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Gambar
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $files->where('file_type', 'image')->count() }}
                        </p>
                    </div>
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 dark:text-purple-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Dokumen
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $files->where('file_type', 'document')->count() }}
                        </p>
                    </div>
                    <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-600 dark:text-orange-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Video
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $files->where('file_type', 'video')->count() }}
                        </p>
                    </div>
                    <div class="p-3 rounded-lg bg-orange-100 dark:bg-orange-900/30">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari File</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama file, judul, atau deskripsi..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white">
                        </div>
                    </div>

                    <!-- File Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipe File</label>
                        <select name="file_type"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white">
                            <option value="">Semua Tipe</option>
                            <option value="image" {{ request('file_type') == 'image' ? 'selected' : '' }}>Gambar</option>
                            <option value="document" {{ request('file_type') == 'document' ? 'selected' : '' }}>Dokumen</option>
                            <option value="video" {{ request('file_type') == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="audio" {{ request('file_type') == 'audio' ? 'selected' : '' }}>Audio</option>
                            <option value="other" {{ request('file_type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Uploader</label>
                        <select name="user"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white">
                            <option value="">Semua User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Public Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="is_public"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('is_public') === '1' ? 'selected' : '' }}>Publik</option>
                            <option value="0" {{ request('is_public') === '0' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.file-manager.index') }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Files Grid -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700">
            @if($files->count() > 0)
                <div class="p-6">
                    <!-- Folder View Toggle -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">File & Folder</h3>
                        <div class="flex gap-2">
                            <button id="grid-view" class="p-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button id="list-view" class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Grid View -->
                    <div id="files-grid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($files as $file)
                            <div class="group relative bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700 overflow-hidden hover:shadow-lg transition-all duration-300">
                                <!-- File Preview -->
                                <div class="aspect-square bg-gray-100 dark:bg-zinc-700 flex items-center justify-center relative overflow-hidden">
                                    @if($file->isImage())
                                        <img src="{{ $file->full_url }}" alt="{{ $file->alt_text ?? $file->original_name }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @elseif($file->isVideo())
                                        <div class="flex flex-col items-center justify-center text-orange-500">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-xs font-medium">Video</span>
                                        </div>
                                    @elseif($file->isDocument())
                                        <div class="flex flex-col items-center justify-center text-purple-500">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-xs font-medium">{{ strtoupper($file->file_extension) }}</span>
                                        </div>
                                    @elseif($file->isAudio())
                                        <div class="flex flex-col items-center justify-center text-green-500">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                            </svg>
                                            <span class="text-xs font-medium">Audio</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-xs font-medium">{{ strtoupper($file->file_extension) }}</span>
                                        </div>
                                    @endif

                                    <!-- Status Badges -->
                                    <div class="absolute top-2 left-2 flex flex-col gap-1">
                                        @if($file->is_public)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Publik</span>
                                        @endif
                                        @if($file->is_featured)
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Featured</span>
                                        @endif
                                    </div>

                                    <!-- Action Menu -->
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="flex gap-1">
                                            <a href="{{ route('admin.file-manager.show', $file) }}"
                                                class="p-2 bg-white dark:bg-zinc-700 text-gray-600 dark:text-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-600 transition-colors"
                                                title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.file-manager.edit', $file) }}"
                                                class="p-2 bg-white dark:bg-zinc-700 text-gray-600 dark:text-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-600 transition-colors"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.file-manager.download', $file) }}"
                                                class="p-2 bg-white dark:bg-zinc-700 text-gray-600 dark:text-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-600 transition-colors"
                                                title="Download">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Info -->
                                <div class="p-4">
                                    <h3 class="font-medium text-gray-900 dark:text-white truncate" title="{{ $file->title ?? $file->original_name }}">
                                        {{ $file->title ?? $file->original_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $file->human_file_size }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        {{ $file->uploader->name ?? 'Unknown' }} • {{ $file->created_at->format('d M Y') }}
                                    </p>
                                    
                                    <!-- Quick Actions -->
                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{ $file->view_count }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                {{ $file->download_count }}
                                            </span>
                                        </div>
                                        
                                        <form action="{{ route('admin.file-manager.destroy', $file) }}" method="POST" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- List View (Default visible) -->
                    <div id="files-list" class="space-y-2">
                        @foreach($files as $file)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700 hover:bg-gray-100 dark:hover:bg-zinc-700 transition-colors">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 flex items-center justify-center">
                                        @if($file->isImage())
                                            <img src="{{ $file->full_url }}" alt="{{ $file->alt_text ?? $file->original_name }}" class="w-8 h-8 object-cover rounded">
                                        @else
                                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $file->title ?? $file->original_name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $file->human_file_size }} • {{ $file->uploader->name ?? 'Unknown' }} • {{ $file->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.file-manager.show', $file) }}" class="p-2 text-gray-500 hover:text-blue-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.file-manager.edit', $file) }}" class="p-2 text-gray-500 hover:text-blue-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.file-manager.download', $file) }}" class="p-2 text-gray-500 hover:text-green-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.file-manager.destroy', $file) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $files->links() }}
                    </div>
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada file</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Mulai upload file pertama Anda</p>
                    <a href="{{ route('admin.file-manager.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload File
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gridViewBtn = document.getElementById('grid-view');
            const listViewBtn = document.getElementById('list-view');
            const filesGrid = document.getElementById('files-grid');
            const filesList = document.getElementById('files-list');

            // Load saved view preference
            const savedView = localStorage.getItem('fileManagerView') || 'list';
            
            // Apply saved view on page load
            if (savedView === 'list') {
                showListView();
            } else {
                showGridView();
            }

            function showGridView() {
                filesGrid.classList.remove('hidden');
                filesList.classList.add('hidden');
                gridViewBtn.classList.add('bg-blue-100', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                gridViewBtn.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                listViewBtn.classList.remove('bg-blue-100', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                listViewBtn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                localStorage.setItem('fileManagerView', 'grid');
            }

            function showListView() {
                filesGrid.classList.add('hidden');
                filesList.classList.remove('hidden');
                listViewBtn.classList.add('bg-blue-100', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                listViewBtn.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                gridViewBtn.classList.remove('bg-blue-100', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
                gridViewBtn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                localStorage.setItem('fileManagerView', 'list');
            }

            gridViewBtn.addEventListener('click', showGridView);
            listViewBtn.addEventListener('click', showListView);
        });
    </script>
</x-layouts.app>