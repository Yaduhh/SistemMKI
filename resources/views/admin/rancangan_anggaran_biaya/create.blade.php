<x-layouts.app :title="__('Buat Rancangan Anggaran Biaya (RAB)')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <h1 class="text-2xl font-bold mb-4">RAB {{ $penawaran->nomor_penawaran ?? '-' }}</h1>
            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                <div>
                    <span class="font-medium">Nomor Penawaran:</span> {{ $penawaran->nomor_penawaran ?? '-' }}<br>
                    <span class="font-medium">Nomor Pemasangan:</span> {{ $pemasangan->nomor_pemasangan ?? '-' }}
                </div>
            </div>

            <!-- Info Validasi -->
            <div class="mb-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">
                            Informasi Validasi Material Utama
                        </h3>
                        <div class="mt-2 text-sm text-amber-700 dark:text-amber-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Data material utama (item, type, dimensi, panjang, qty, harga, total) <strong>tidak
                                        dapat diubah</strong> dan akan tervalidasi otomatis dengan data penawaran</li>
                                <li>Hanya field <strong>satuan</strong> dan <strong>warna</strong> yang dapat
                                    diisi/diubah</li>
                                <li>Sistem akan memvalidasi kesesuaian total harga material utama dengan penawaran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                window.oldMaterialPendukung = @json(old('json_pengeluaran_material_pendukung'));
                window.oldEntertaiment = @json(old('json_pengeluaran_entertaiment'));
                window.oldAkomodasi = @json(old('json_pengeluaran_akomodasi'));
                window.oldLainnya = @json(old('json_pengeluaran_lainnya'));
                window.oldTukang = @json(old('json_pengeluaran_tukang'));
                window.oldKerjaTambah = @json(old('json_kerja_tambah'));

                // Data produk penawaran untuk validasi
                window.produkPenawaran = @json($produkPenawaran);
            </script>
            <form action="{{ route('admin.rancangan-anggaran-biaya.store') }}" method="POST">
                @csrf
                <!-- Hidden inputs untuk penawaran_id dan pemasangan_id -->
                <input type="hidden" name="penawaran_id" value="{{ $penawaran->id ?? '' }}">
                <input type="hidden" name="pemasangan_id" value="{{ $pemasangan->id ?? '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:input name="proyek" label="Proyek" placeholder="Nama Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                    <div>
                        <flux:input name="pekerjaan" label="Pekerjaan" placeholder="Nama Pekerjaan" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                    <div>
                        <flux:input name="kontraktor" label="Kontraktor" placeholder="Nama Kontraktor" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                    <div>
                        <flux:input name="lokasi" label="Lokasi" placeholder="Lokasi Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-2">Pengeluaran Material Utama</h2>
                    <x-rab.material-utama-table :produk="$produkPenawaran" />
                    <!-- Hidden input untuk menyimpan data material utama -->
                    <input type="hidden" name="json_pengeluaran_material_utama" id="json_pengeluaran_material_utama"
                        value="">

                    <!-- Validasi Material Utama vs Penawaran -->
                    <div class="mt-4 p-4 rounded-lg border bg-emerald-100 dark:bg-emerald-900/20 dark:border-emerald-800"
                        id="material-utama-validation">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Material
                                        Utama (RAB):</span>
                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400"
                                        id="rab-material-utama-total">Rp 0</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total
                                        Penawaran:</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400"
                                        id="penawaran-total">Rp 0</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2" id="validation-status">
                                <div class="px-3 py-1 rounded-full text-sm font-medium" id="validation-badge">
                                    <span id="validation-text">Memvalidasi...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30"></div>
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600/30 py-2 uppercase">
                            Pengeluaran Material Pendukung</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30"></div>
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.material-pendukung-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30"></div>
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-teal-600 dark:bg-teal-600/30 py-2 uppercase">
                            Pengeluaran Entertaiment</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30"></div>
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.entertaiment-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-yellow-600 dark:bg-yellow-600/30 py-2 uppercase">
                            Pengeluaran Akomodasi</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.akomodasi-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30"></div>
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-pink-600 dark:bg-pink-600/30 py-2 uppercase">
                            Pengeluaran Lainnya</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30"></div>
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.lainnya-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600/30 py-2 uppercase">
                            Pengeluaran Tukang</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.tukang-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30"></div>
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-orange-600 dark:bg-orange-600/30 py-2 uppercase">
                            Kerja Tambah</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30"></div>
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.kerja-tambah-table />
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="submit" onclick="prepareFormData()"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function prepareFormData() {
            // Collect material utama data from the form inputs
            const materialUtamaInputs = document.querySelectorAll('input[name^="material_utama"]');
            const materialUtamaData = [];
            const processedItems = new Set();

            materialUtamaInputs.forEach(input => {
                const name = input.name;
                const match = name.match(/material_utama\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const index = match[1];
                    const field = match[2];

                    if (!processedItems.has(index)) {
                        const itemInput = document.querySelector(`input[name="material_utama[${index}][item]"]`);
                        const qtyInput = document.querySelector(`input[name="material_utama[${index}][qty]"]`);
                        const satuanInput = document.querySelector(
                        `input[name="material_utama[${index}][satuan]"]`);
                        const hargaInput = document.querySelector(
                            `input[name="material_utama[${index}][harga_satuan]"]`);
                        const totalInput = document.querySelector(`input[name="material_utama[${index}][total]"]`);

                        if (itemInput && satuanInput) {
                            const typeInput = document.querySelector(
                            `input[name="material_utama[${index}][type]"]`);
                            const dimensiInput = document.querySelector(
                                `input[name="material_utama[${index}][dimensi]"]`);
                            const panjangInput = document.querySelector(
                                `input[name="material_utama[${index}][panjang]"]`);
                            const warnaInput = document.querySelector(
                                `input[name="material_utama[${index}][warna]"]`);

                            materialUtamaData.push({
                                item: itemInput.value,
                                type: typeInput ? typeInput.value : '',
                                dimensi: dimensiInput ? dimensiInput.value : '',
                                panjang: panjangInput ? panjangInput.value : '',
                                qty: parseFloat(qtyInput.value) || 0,
                                satuan: satuanInput.value,
                                warna: warnaInput ? warnaInput.value : '',
                                harga_satuan: parseFloat(hargaInput.value) || 0,
                                total: parseFloat(totalInput.value) || 0
                            });
                            processedItems.add(index);
                        }
                    }
                }
            });

            // Set the hidden input value
            document.getElementById('json_pengeluaran_material_utama').value = JSON.stringify(materialUtamaData);
        }

        // Function to format number to Indonesian Rupiah format
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Calculate total from produk penawaran
        function calculatePenawaranTotal() {
            let total = 0;
            if (window.produkPenawaran && Array.isArray(window.produkPenawaran)) {
                window.produkPenawaran.forEach(item => {
                    total += parseFloat(item.total_harga || 0);
                });
            }
            return total;
        }

        // Calculate total from current material utama inputs
        function calculateMaterialUtamaTotal() {
            let total = 0;
            const materialUtamaInputs = document.querySelectorAll('input[name^="material_utama"]');
            const processedItems = new Set();

            materialUtamaInputs.forEach(input => {
                const name = input.name;
                const match = name.match(/material_utama\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const index = match[1];
                    const field = match[2];

                    if (!processedItems.has(index)) {
                        const totalInput = document.querySelector(`input[name="material_utama[${index}][total]"]`);
                        if (totalInput) {
                            total += parseFloat(totalInput.value) || 0;
                        }
                        processedItems.add(index);
                    }
                }
            });
            return total;
        }

        // Validate material utama against penawaran
        function validateMaterialUtama() {
            const penawaranTotal = calculatePenawaranTotal();
            const rabTotal = calculateMaterialUtamaTotal();

            // Update totals display
            document.getElementById('penawaran-total').textContent = `Rp ${formatRupiah(penawaranTotal)}`;
            document.getElementById('rab-material-utama-total').textContent = `Rp ${formatRupiah(rabTotal)}`;

            const validationBadge = document.getElementById('validation-badge');
            const validationText = document.getElementById('validation-text');

            // Check if totals match
            if (Math.abs(penawaranTotal - rabTotal) < 0.01) { // Allow small floating point differences
                validationBadge.className =
                    'px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                validationText.textContent = '✓ Tervalidasi';

            } else {
                validationBadge.className =
                    'px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                validationText.textContent = '⚠ Tidak Sesuai';
            }
        }

        // Initialize validation on page load
        document.addEventListener('DOMContentLoaded', function() {
            validateMaterialUtama();

            // Add event listeners for satuan and warna inputs
            const satuanInputs = document.querySelectorAll('input[name*="[satuan]"]');
            const warnaInputs = document.querySelectorAll('input[name*="[warna]"]');

            satuanInputs.forEach(input => {
                input.addEventListener('input', validateMaterialUtama);
            });

            warnaInputs.forEach(input => {
                input.addEventListener('input', validateMaterialUtama);
            });
        });
    </script>
</x-layouts.app>
