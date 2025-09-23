<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Upload File</h1>
            <x-button as="a" href="{{ route('admin.file-manager.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke File Manager
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-4 mx-auto w-full">
        <form action="{{ route('admin.file-manager.store') }}" method="POST" enctype="multipart/form-data" 
            class="space-y-8" id="upload-form">
            @csrf
            
            <!-- Upload Area -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih File</h2>
                <div class="border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg p-8 text-center hover:border-blue-400 transition-colors"
                    id="drop-zone">
                    <div class="space-y-4">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <div>
                            <p class="text-lg font-medium text-gray-900 dark:text-white">Upload file atau drag & drop</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Maksimal 10MB per file</p>
                        </div>
                        <input type="file" name="files[]" id="file-input" multiple 
                            accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv"
                            class="hidden">
                        <button type="button" onclick="document.getElementById('file-input').click()"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            Pilih File
                        </button>
                    </div>
                </div>
                
                <!-- Selected Files Preview -->
                <div id="selected-files" class="mt-4 space-y-2 hidden">
                    <h3 class="font-medium text-gray-900 dark:text-white">File Terpilih:</h3>
                    <div id="files-list" class="space-y-2"></div>
                </div>
            </div>

            <!-- File Information -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi File</h2>
                <div>
                    <flux:input name="title" label="Judul File" placeholder="Masukkan judul file (opsional)" 
                        type="text" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
                
                <div class="mt-6">
                    <flux:textarea name="description" label="Deskripsi" 
                        placeholder="Masukkan deskripsi file (opsional)" rows="4" 
                        class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
            </div>

            <!-- Settings -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan</h2>
                <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">File Publik</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">File dapat diakses oleh semua orang</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_public" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Featured</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tandai file sebagai featured/pin</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <x-button type="submit" id="submit-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3" disabled>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload File
                </x-button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-input');
            const selectedFiles = document.getElementById('selected-files');
            const filesList = document.getElementById('files-list');
            const submitBtn = document.getElementById('submit-btn');
            const form = document.getElementById('upload-form');

            let selectedFilesArray = [];

            // Drag and drop functionality
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropZone.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
                
                const files = Array.from(e.dataTransfer.files);
                handleFiles(files);
            });

            // File input change
            fileInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);
                handleFiles(files);
            });

            // Handle selected files
            function handleFiles(files) {
                selectedFilesArray = [...selectedFilesArray, ...files];
                updateFilesList();
                updateSubmitButton();
            }

            // Update files list display
            function updateFilesList() {
                if (selectedFilesArray.length === 0) {
                    selectedFiles.classList.add('hidden');
                    return;
                }

                selectedFiles.classList.remove('hidden');
                filesList.innerHTML = '';

                selectedFilesArray.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between p-3 bg-white dark:bg-zinc-700 rounded-lg border border-gray-200 dark:border-zinc-600';
                    
                    const fileInfo = document.createElement('div');
                    fileInfo.className = 'flex items-center space-x-3';
                    
                    const icon = getFileIcon(file.type);
                    const fileSize = formatFileSize(file.size);
                    
                    fileInfo.innerHTML = `
                        ${getFileIconSVG(icon)}
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">${file.name}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">${fileSize}</p>
                        </div>
                    `;
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'text-red-500 hover:text-red-700 transition-colors';
                    removeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    removeBtn.onclick = () => removeFile(index);
                    
                    fileItem.appendChild(fileInfo);
                    fileItem.appendChild(removeBtn);
                    filesList.appendChild(fileItem);
                });
            }

            // Remove file from selection
            function removeFile(index) {
                selectedFilesArray.splice(index, 1);
                updateFilesList();
                updateSubmitButton();
            }

            // Update submit button state
            function updateSubmitButton() {
                if (selectedFilesArray.length > 0) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = `Upload ${selectedFilesArray.length} File`;
                } else {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>Upload File';
                }
            }

            // Get file icon based on type
            function getFileIcon(type) {
                if (type.startsWith('image/')) return 'image';
                if (type.startsWith('video/')) return 'video-camera';
                if (type.startsWith('audio/')) return 'musical-note';
                if (type.includes('pdf') || type.includes('document')) return 'document-text';
                return 'document';
            }

            // Get SVG icon
            function getFileIconSVG(iconType) {
                const icons = {
                    'image': '<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
                    'video-camera': '<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>',
                    'musical-note': '<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>',
                    'document-text': '<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                    'document': '<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'
                };
                return icons[iconType] || icons['document'];
            }

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                if (selectedFilesArray.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu file untuk diupload.');
                    return;
                }

                // Update file input with selected files
                const dt = new DataTransfer();
                selectedFilesArray.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengupload...';
            });
        });
    </script>
</x-layouts.app>
