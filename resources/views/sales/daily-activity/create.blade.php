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
                    <flux:select
                        name="perihal"
                        id="perihal"
                        label="Tujuan Kegiatan"
                        placeholder="Pilih tujuan kegiatan..."
                        :value="old('perihal')"
                        :has-error="$errors->has('perihal')"
                    >
                        <option value="Perkenalan">Perkenalan</option>
                        <option value="Presentasi">Presentasi</option>
                        <option value="Penawaran">Penawaran</option>
                        <option value="Negosiasi">Negosiasi</option>
                        <option value="Penagihan">Penagihan</option>
                        <option value="Deal">Deal</option>
                        <option value="Komplen">Komplen</option>
                        <option value="Entertaint">Entertaint</option>
                    </flux:select>
                    @error('perihal')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:select
                        name="pihak_bersangkutan"
                        id="pihak_bersangkutan"
                        label="Pelanggan"
                        placeholder="Pilih client..."
                        :value="old('pihak_bersangkutan')"
                        :has-error="$errors->has('pihak_bersangkutan')"
                    >
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" :selected="old('pihak_bersangkutan') == $client->id">{{ $client->nama }}</option>
                        @endforeach
                    </flux:select>
                    @error('pihak_bersangkutan')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <flux:textarea
                        name="summary"
                        id="summary"
                        label="Pembahasan"
                        placeholder="Masukkan summary aktivitas..."
                        :value="old('summary')"
                        :has-error="$errors->has('summary')"
                    />
                    @error('summary')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <input type="hidden" name="lokasi" id="lokasi" value="">
                    <div id="lokasi-status" class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500 animate-spin" id="lokasi-loading" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Mendapatkan lokasi Anda...</span>
                        </div>
                    </div>
                    <div id="lokasi-details" class="text-sm text-gray-600 dark:text-gray-400 mb-4 hidden">
                        <div class="bg-gray-50 dark:bg-zinc-900/30 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-2">
                                <div>Akurasi:</div>
                                <div id="accuracy" class="font-mono"></div>
                                <div>Alamat:</div>
                                <div id="address" class="font-mono"></div>
                            </div>
                            <div class="mt-3">
                                <a id="maps-link" href="#" target="_blank" class="text-blue-500 hover:underline flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Buka di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('sales.daily-activity.index') }}">
                        <flux:button variant="filled">
                            {{ __('Batal') }}
                        </flux:button>
                    </a>
                    <flux:button type="submit" variant="primary" class="flex items-center gap-2" id="submit-button" disabled>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 -ml-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Simpan') }}
                        </div>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lokasiInput = document.getElementById('lokasi');
            const lokasiStatus = document.getElementById('lokasi-status');
            const lokasiDetails = document.getElementById('lokasi-details');
            const submitButton = document.getElementById('submit-button');
            
            // Fungsi untuk mendapatkan alamat dari koordinat
            async function getAddressFromCoords(latitude, longitude) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`);
                    const data = await response.json();
                    return data.display_name;
                } catch (error) {
                    console.error('Error getting address:', error);
                    return 'Alamat tidak tersedia';
                }
            }

            // Fungsi untuk memaksa browser menampilkan prompt lokasi
            function forceLocationPrompt() {
                // Tampilkan loading state
                lokasiStatus.innerHTML = `<div class='flex items-center gap-2'>
                    <svg class='w-5 h-5 text-gray-500 animate-spin' fill='none' viewBox='0 0 24 24'>
                        <circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle>
                        <path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z'></path>
                    </svg>
                    <span>Mendapatkan lokasi Anda...</span>
                </div>`;
                lokasiDetails.classList.add('hidden');
                
                // Coba gunakan Permissions API jika didukung
                if (navigator.permissions && navigator.permissions.query) {
                    navigator.permissions.query({ name: 'geolocation' })
                        .then(function(permissionStatus) {
                            if (permissionStatus.state === 'prompt') {
                                // Jika masih dalam status prompt, coba paksa dengan getCurrentPosition
                                navigator.geolocation.getCurrentPosition(
                                    showPosition,
                                    showError,
                                    {
                                        enableHighAccuracy: true,
                                        timeout: 10000,
                                        maximumAge: 0
                                    }
                                );
                            } else if (permissionStatus.state === 'granted') {
                                // Jika sudah diizinkan, langsung dapatkan lokasi
                                navigator.geolocation.getCurrentPosition(
                                    showPosition,
                                    showError,
                                    {
                                        enableHighAccuracy: true,
                                        timeout: 10000,
                                        maximumAge: 0
                                    }
                                );
                            } else {
                                // Jika ditolak, tampilkan instruksi
                                showPermissionDenied();
                            }
                        })
                        .catch(function() {
                            // Jika Permissions API gagal, gunakan cara langsung
                            navigator.geolocation.getCurrentPosition(
                                showPosition,
                                showError,
                                {
                                    enableHighAccuracy: true,
                                    timeout: 10000,
                                    maximumAge: 0
                                }
                            );
                        });
                } else {
                    // Jika Permissions API tidak didukung, gunakan cara langsung
                    navigator.geolocation.getCurrentPosition(
                        showPosition,
                        showError,
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                }
            }

            // Fungsi untuk menampilkan posisi
            async function showPosition(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                
                const locationString = `${latitude},${longitude}`;
                
                // Update input hidden
                lokasiInput.value = locationString;
                
                // Update status
                lokasiStatus.innerHTML = `<div class='text-green-500 flex items-center gap-2'>
                    <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>
                    </svg>
                    <span>Lokasi berhasil didapatkan</span>
                    <button type='button' id='refresh-location' class='text-blue-500 hover:underline ml-2'>Perbarui</button>
                </div>`;
                
                // Get address
                const address = await getAddressFromCoords(latitude, longitude);
                
                // Update details
                document.getElementById('accuracy').textContent = `${Math.round(accuracy)} meter`;
                document.getElementById('address').textContent = address;
                
                // Update Google Maps link
                const mapsLink = document.getElementById('maps-link');
                mapsLink.href = `https://www.google.com/maps?q=${latitude},${longitude}`;
                
                // Show details
                lokasiDetails.classList.remove('hidden');
                
                // Add event listener untuk tombol refresh
                document.getElementById('refresh-location')?.addEventListener('click', forceLocationPrompt);
                
                // Enable submit button
                submitButton.disabled = false;
            }

            // Fungsi untuk menampilkan error
            function showError(error) {
                let errorMessage = '';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Akses lokasi ditolak. Silakan izinkan akses lokasi di pengaturan browser Anda.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Informasi lokasi tidak tersedia.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Permintaan lokasi timeout.';
                        break;
                    case error.UNKNOWN_ERROR:
                        errorMessage = 'Terjadi kesalahan saat mendapatkan lokasi.';
                        break;
                }
                
                lokasiStatus.innerHTML = `<div class='text-red-500 flex items-center gap-2'>
                    <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'></path>
                    </svg>
                    <span>${errorMessage}</span>
                    <button type='button' id='refresh-location' class='text-blue-500 hover:underline ml-2'>Coba Lagi</button>
                </div>`;
                lokasiDetails.classList.add('hidden');
                submitButton.disabled = true;
                
                // Add event listener untuk tombol refresh
                document.getElementById('refresh-location')?.addEventListener('click', forceLocationPrompt);
            }

            // Fungsi untuk menampilkan pesan ketika izin ditolak
            function showPermissionDenied() {
                lokasiStatus.innerHTML = `
                    <div class='text-red-500 flex flex-col gap-2'>
                        <div class='flex items-center gap-2'>
                            <svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                            </svg>
                            <span>Akses lokasi ditolak</span>
                        </div>
                        <div class='ml-7 text-sm'>
                            <p>Untuk mengizinkan lokasi:</p>
                            <ul class='list-disc ml-4 mt-1'>
                                <li>Chrome: Klik ikon 🔒 atau ⓘ di sebelah kiri URL → Situs Settings → Lokasi → Izinkan</li>
                                <li>Firefox: Klik ikon 🛡️ di sebelah kiri URL → Izinkan</li>
                                <li>Edge: Klik ikon 🔒 di sebelah kiri URL → Izin Situs → Lokasi → Izinkan</li>
                                <li>Safari: Buka Preferensi → Privasi → Layanan Lokasi → Aktifkan</li>
                            </ul>
                            <button type='button' id='retry-location' class='text-blue-500 hover:underline mt-2'>Coba lagi setelah mengizinkan lokasi</button>
                        </div>
                    </div>`;
                
                // Hide details
                lokasiDetails.classList.add('hidden');
                
                // Add event listener untuk tombol retry
                document.getElementById('retry-location')?.addEventListener('click', forceLocationPrompt);
                
                // Disable submit button
                submitButton.disabled = true;
            }

            // Mulai proses mendapatkan lokasi
            forceLocationPrompt();
        });
    </script>
    @endpush
</x-layouts.sales>