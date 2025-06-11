<x-layouts.app :title="__('Edit Distributor')">
    <div class="w-full">
        <div class="mx-auto max-w-4xl">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Distributor</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Perbarui informasi distributor dalam sistem MKI
                        </p>
                    </div>
                    <a href="{{ route('admin.distributor.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Form Card -->
            <div class="bg-white dark:bg-zinc-900/30 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Informasi Distributor</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui data distributor {{ $distributor->nama_distributor }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.distributor.update', $distributor->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Nama Distributor -->
                            <div>
                                <flux:input 
                                    name="nama_distributor" 
                                    :label="__('Nama Distributor')" 
                                    type="text" 
                                    required 
                                    autocomplete="off" 
                                    :placeholder="__('Masukkan nama distributor')"
                                    :value="$distributor->nama_distributor"
                                    class="pl-10"
                                />
                            </div>

                            <!-- Lokasi -->
                            <div>
                                <flux:input 
                                    name="lokasi" 
                                    :label="__('Lokasi')" 
                                    type="text" 
                                    required 
                                    autocomplete="off" 
                                    :placeholder="__('Masukkan lokasi distributor')"
                                    :value="$distributor->lokasi"
                                    class="pl-10"
                                />
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Current Profile Image -->
                            @if($distributor->profile)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Foto Profil Saat Ini
                                    </label>
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ Storage::url($distributor->profile) }}" 
                                             alt="Current Profile" 
                                             class="h-20 w-20 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600">
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Foto profil distributor</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">Upload foto baru untuk mengganti</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Profile Image Upload -->
                            <div>
                                <label for="profile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ $distributor->profile ? 'Ganti Foto Profil' : 'Foto Profil' }}
                                </label>
                                <div class="mt-1">
                                    <label for="profile" class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-gray-400 dark:hover:border-gray-500 transition-colors duration-200 cursor-pointer">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                <span class="relative bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                                                    Upload file
                                                </span>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PNG, JPG, JPEG hingga 2MB
                                            </p>
                                        </div>
                                        <input id="profile" name="profile" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                @error('profile')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" 
                                            name="status" 
                                            id="status" 
                                            value="1"
                                            {{ $distributor->status ? 'checked' : '' }}
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                                    </div>
                                    <div class="ml-3">
                                        <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Status Aktif
                                        </label>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            Distributor akan ditampilkan dan dapat diakses jika status aktif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.distributor.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Distributor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('profile');
            const uploadArea = fileInput.closest('label');
            
            // Handle drag and drop
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            });
            
            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect(files[0]);
                }
            });
            
            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    handleFileSelect(e.target.files[0]);
                }
            });
            
            function handleFileSelect(file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Hanya file JPG, JPEG, dan PNG yang diperbolehkan.');
                    fileInput.value = '';
                    return;
                }
                
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB.');
                    fileInput.value = '';
                    return;
                }
                
                // Show selected file name
                const uploadText = uploadArea.querySelector('.text-sm');
                if (uploadText) {
                    uploadText.innerHTML = `
                        <span class="text-green-600 dark:text-green-400 font-medium">
                            ✓ ${file.name}
                        </span>
                    `;
                }
            }
        });
    </script>
</x-layouts.app> 