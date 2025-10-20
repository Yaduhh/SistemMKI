<x-layouts.supervisi :title="__('Edit Aktivitas Harian')">
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
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
                        Edit detail aktivitas harian Anda.
                    </p>
                </div>

                <!-- Flash Messages -->
                <div class="mb-6">
                    <x-flash-message type="success" :message="session('success')" />
                    <x-flash-message type="error" :message="session('error')" />
                </div>

                <!-- Form -->
                <div class="">
                    <form action="{{ route('supervisi.daily-activity.update', $dailyActivity) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Perihal -->
                        <div>
                            <flux:select
                                name="perihal"
                                id="perihal"
                                label="Tujuan Kegiatan"
                                placeholder="Pilih tujuan kegiatan..."
                                :value="$dailyActivity->perihal"
                                :has-error="$errors->has('perihal')"
                            >
                                <option value="Perkenalan" {{ $dailyActivity->perihal == 'Perkenalan' ? 'selected' : '' }}>Perkenalan</option>
                                <option value="Presentasi" {{ $dailyActivity->perihal == 'Presentasi' ? 'selected' : '' }}>Presentasi</option>
                                <option value="Penawaran" {{ $dailyActivity->perihal == 'Penawaran' ? 'selected' : '' }}>Penawaran</option>
                                <option value="Negosiasi" {{ $dailyActivity->perihal == 'Negosiasi' ? 'selected' : '' }}>Negosiasi</option>
                                <option value="Penagihan" {{ $dailyActivity->perihal == 'Penagihan' ? 'selected' : '' }}>Penagihan</option>
                                <option value="Deal" {{ $dailyActivity->perihal == 'Deal' ? 'selected' : '' }}>Deal</option>
                                <option value="Komplen" {{ $dailyActivity->perihal == 'Komplen' ? 'selected' : '' }}>Komplen</option>
                                <option value="Entertaint" {{ $dailyActivity->perihal == 'Entertaint' ? 'selected' : '' }}>Entertaint</option>
                                <option value="Supervisi" {{ $dailyActivity->perihal == 'Supervisi' ? 'selected' : '' }}>Supervisi</option>
                                <option value="Maintenance" {{ $dailyActivity->perihal == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Kunjungan Rutin" {{ $dailyActivity->perihal == 'Kunjungan Rutin' ? 'selected' : '' }}>Kunjungan Rutin</option>
                                <option value="Meeting" {{ $dailyActivity->perihal == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                                <option value="Pengambilan Invoice atau Giro" {{ $dailyActivity->perihal == 'Pengambilan Invoice atau Giro' ? 'selected' : '' }}>Pengambilan Invoice atau Giro</option>
                                <option value="Berita Acara" {{ $dailyActivity->perihal == 'Berita Acara' ? 'selected' : '' }}>Berita Acara</option>
                                <option value="Survey Lokasi" {{ $dailyActivity->perihal == 'Survey Lokasi' ? 'selected' : '' }}>Survey Lokasi</option>
                            </flux:select>
                            @error('perihal')
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
                            >{{ $dailyActivity->summary }}</flux:textarea>
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

                        <!-- Modal Konfirmasi Hapus Gambar -->
                        <div id="deleteImageModal" class="fixed inset-0 z-50 hidden items-center h-screen justify-center bg-black/30 backdrop-blur-sm">
                            <div class="bg-white dark:bg-zinc-900 backdrop-blur-sm rounded-lg shadow-lg p-6 w-full max-w-md">
                                <!-- Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Konfirmasi Hapus</h2>
                                    <button type="button" onclick="closeDeleteModal()" class="text-gray-500 hover:text-red-600 text-xl font-bold">&times;</button>
                                </div>

                                <!-- Body -->
                                <p class="text-gray-700 dark:text-gray-300">Yakin ingin menghapus gambar ini?</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Gambar yang dihapus tidak akan bisa dikembalikan.</p>

                                <!-- Footer -->
                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-white">Batal</button>
                                    <button type="button" onclick="confirmDelete()" class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('supervisi.daily-activity.index') }}">
                                <flux:button variant="filled">
                                    {{ __('Batal') }}
                                </flux:button>
                            </a>
                            <flux:button type="submit" variant="primary">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 -ml-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ __('Simpan') }}
                                </div>
                            </flux:button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Script jalan bos 🔥");

            const lokasiElements = document.querySelectorAll("[id^=address-]");

            lokasiElements.forEach((addressSpan) => {
                const id = addressSpan.id.split("-")[1];
                const lokasiElement = addressSpan.previousElementSibling;
                if (!lokasiElement) return;

                const lokasiText = lokasiElement.textContent.trim();
                const [latitude, longitude] = lokasiText.split(",").map(parseFloat);

                if (isNaN(latitude) || isNaN(longitude)) {
                    addressSpan.textContent = "Format lokasi tidak valid";
                    return;
                }

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`, {
                    headers: {
                        'User-Agent': 'AktivitasApp/1.0 (your@email.com)'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        addressSpan.textContent = data.display_name || "Alamat tidak ditemukan";
                    })
                    .catch(() => {
                        addressSpan.textContent = "Gagal memuat alamat";
                    });
            });

            // Array untuk menyimpan path gambar yang dihapus
            window.deletedImages = [];
            window.currentImageToDelete = null;
            window.currentImageIndex = null;
        });

        function openDeleteModal() {
            const modal = document.getElementById('deleteImageModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteImageModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
            // Reset variabel
            window.currentImageToDelete = null;
            window.currentImageIndex = null;
        }

        window.deleteExistingImage = function(imagePath, index) {
            window.currentImageToDelete = imagePath;
            window.currentImageIndex = index;
            openDeleteModal();
        }

        function confirmDelete() {
            if (window.currentImageToDelete && window.currentImageIndex !== null) {
                window.deletedImages.push(window.currentImageToDelete);
                document.getElementById('deleted-images-input').value = JSON.stringify(window.deletedImages);

                const imageContainer = document.getElementById(`image-${window.currentImageIndex}`);
                if (imageContainer) {
                    imageContainer.style.display = 'none';
                }

                closeDeleteModal();
            }
        }
    </script>
    @endpush
</x-layouts.supervisi>
