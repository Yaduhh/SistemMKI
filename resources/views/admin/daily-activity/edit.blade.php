<x-layouts.app :title="__('Edit Aktivitas Harian')">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center sm:items-center mb-8">
            <div class="p-2 rounded-xl bg-emerald-800/10 text-primary dark:bg-emerald-800/20 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <h1 class="text-xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    {{ __('Edit Aktivitas Harian') }}
                </h1>
            </div>
            <p class="mt-2 sm:mt-0 text-gray-600 dark:text-gray-400">
                Perbarui detail aktivitas harian Anda.
            </p>
        </div>

        <!-- Flash Messages -->
        <div class="mb-6">
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />
        </div>

        <!-- Form -->
        <div class="">
            <form action="{{ route('admin.daily-activity.update', $dailyActivity->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Perihal -->
                <div>
                    <flux:input
                        type="text"
                        name="perihal"
                        id="perihal"
                        label="Tujuan Kegiatan"
                        placeholder="Masukkan perihal aktivitas..."
                        :value="old('perihal', $dailyActivity->perihal)"
                        :has-error="$errors->has('perihal')"
                    />
                    @error('perihal')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pihak Bersangkutan -->
                <div>
                    <flux:input
                        type="text"
                        name="pihak_bersangkutan"
                        id="pihak_bersangkutan"
                        label="Client"
                        placeholder="Masukkan pihak yang bersangkutan..."
                        :value="old('pihak_bersangkutan', $dailyActivity->pihak_bersangkutan)"
                        :has-error="$errors->has('pihak_bersangkutan')"
                    />
                    @error('pihak_bersangkutan')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Summary -->
                <div>
                    <flux:textarea
                        name="summary"
                        id="summary"
                        label="Pembahasan"
                        placeholder="Masukkan summary aktivitas..."
                        rows="4"
                    >{{ old('summary', $dailyActivity->summary) }}</flux:textarea>
                    @error('summary')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dokumentasi -->
                <div>
                    <label for="dokumentasi" class="block text-sm font-semibold text-gray-800 dark:text-gray-200">
                        Dokumentasi
                    </label>
                    <p class="text-gray-500 text-xs mb-2">(bisa lebih dari satu, format: gambar)</p>

                    <input type="file" 
                           name="dokumentasi[]" 
                           id="dokumentasi" 
                           multiple 
                           accept="image/*"
                           class="block w-full text-sm text-gray-900 dark:text-gray-100
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-emerald-50 file:text-emerald-700
                                  hover:file:bg-emerald-100 dark:file:bg-emerald-900 dark:file:text-emerald-300 dark:hover:file:bg-emerald-800
                                  border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600
                                  focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('dokumentasi') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Upload gambar baru untuk menambahkan ke dokumentasi yang ada. Biarkan kosong jika tidak ingin mengubah dokumentasi.
                    </p>
                    @error('dokumentasi')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('dokumentasi.*')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dokumentasi yang sudah ada -->
                @php
                    $dokumentasi = is_array($dailyActivity->dokumentasi) ? $dailyActivity->dokumentasi : json_decode($dailyActivity->dokumentasi, true) ?? [];
                @endphp
                <!-- Dokumentasi yang sudah ada -->
                @if(!empty($dokumentasi))
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dokumentasi yang sudah ada:</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="existing-images">
                        @foreach($dokumentasi as $index => $image)
                            <div class="relative group" id="image-{{ $index }}">
                                <img src="{{ asset('storage/' . $image) }}" 
                                    alt="Dokumentasi {{ $index + 1 }}" 
                                    class="w-full h-32 object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black/30 bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                    <button type="button" 
                                            onclick="window.open('{{ asset('storage/' . $image) }}', '_blank')"
                                            class="p-2 text-white hover:text-primary-400 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <button type="button"
                                        onclick="deleteExistingImage('{{ $image }}', {{ $index }})"
                                        class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="deleted_images" id="deleted-images-input" value="[]">
                </div>
                @endif

                <!-- Modal Konfirmasi Hapus -->
                <flux:modal id="deleteImageModal" title="Konfirmasi Hapus" class="md:w-96 mx-4">
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Yakin ingin menghapus gambar ini?</p>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">Gambar yang dihapus tidak akan bisa dikembalikan.</p>
                    </div>

                    <div name="footer" class="flex justify-end gap-3 mt-10">
                        <flux:button variant="danger" id="confirmDeleteBtn">
                            {{ __('Hapus') }}
                        </flux:button>
                    </div>
                </flux:modal>

                <!-- Tombol Aksi -->
                <div class="mt-6 flex justify-end gap-3">
                    <flux:button
                        type="button"
                        variant="filled"
                        onclick="window.history.back()"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('Batal') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Simpan Perubahan') }}
                        </div>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Array untuk menyimpan path gambar yang dihapus
        let deletedImages = [];
        let currentImageToDelete = null;
        let currentImageIndex = null;

        // Fungsi untuk menghapus gambar
        function deleteExistingImage(imagePath, index) {
            // Simpan data gambar yang akan dihapus
            currentImageToDelete = imagePath;
            currentImageIndex = index;
            
            // Buka modal konfirmasi
            const modal = document.getElementById('deleteImageModal');
            if (modal) {
                modal.showModal();
            }
        }

        // Event listener untuk tombol konfirmasi di modal
        document.addEventListener('DOMContentLoaded', function() {
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    if (currentImageToDelete && currentImageIndex !== null) {
                        // Tambahkan path gambar ke array deletedImages
                        deletedImages.push(currentImageToDelete);
                        
                        // Update nilai input hidden
                        document.getElementById('deleted-images-input').value = JSON.stringify(deletedImages);
                        
                        // Hapus elemen gambar dari DOM
                        const imageContainer = document.getElementById(`image-${currentImageIndex}`);
                        if (imageContainer) {
                            imageContainer.style.display = 'none';
                        }

                        // Tutup modal
                        const modal = document.getElementById('deleteImageModal');
                        if (modal) {
                            modal.hideModal();
                        }

                        // Reset variabel
                        currentImageToDelete = null;
                        currentImageIndex = null;
                    }
                });
            }

            // Pastikan input hidden ada
            const deletedImagesInput = document.getElementById('deleted-images-input');
            if (!deletedImagesInput) {
                console.error('Input untuk gambar yang dihapus tidak ditemukan');
                return;
            }

            // Tambahkan event listener untuk input file
            const fileInput = document.getElementById('dokumentasi');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    previewImages(this);
                });
            }
        });

        // Fungsi untuk preview gambar baru
        function previewImages(input) {
            const previewContainer = document.getElementById('imagePreview');
            if (!previewContainer) return;
            
            previewContainer.innerHTML = '';
            
            if (input.files) {
                Array.from(input.files).forEach((file, index) => {
                    if (!file.type.startsWith('image/')) {
                        alert('File harus berupa gambar');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                            <button type="button" 
                                    onclick="removePreview(${index})" 
                                    class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        `;
                        previewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        // Fungsi untuk menghapus preview gambar baru
        function removePreview(index) {
            const input = document.getElementById('dokumentasi');
            if (!input) return;

            const dt = new DataTransfer();
            const { files } = input;

            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }

            input.files = dt.files;
            previewImages(input);
        }
    </script>
    @endpush
</x-layouts.sales> 