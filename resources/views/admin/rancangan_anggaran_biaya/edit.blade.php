<x-layouts.app :title="__('Edit Rancangan Anggaran Biaya (RAB)')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <h1 class="text-2xl font-bold mb-4">Edit RAB {{ $rancanganAnggaranBiaya->proyek ?? '-' }}</h1>
            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                <div>
                    <span class="font-medium">Nomor Penawaran:</span> {{ $penawaran->nomor_penawaran ?? '-' }}<br>
                    <span class="font-medium">Nomor Pemasangan:</span> {{ $pemasangan->nomor_pemasangan ?? '-' }}
                </div>
            </div>
            <script>
                window.oldMaterialPendukung = @json(old('json_pengeluaran_material_pendukung', $rancanganAnggaranBiaya->json_pengeluaran_material_pendukung ?? []));
                window.oldEntertaiment = @json(old('json_pengeluaran_entertaiment', $rancanganAnggaranBiaya->json_pengeluaran_entertaiment ?? []));
                window.oldAkomodasi = @json(old('json_pengeluaran_akomodasi', $rancanganAnggaranBiaya->json_pengeluaran_akomodasi ?? []));
                window.oldLainnya = @json(old('json_pengeluaran_lainnya', $rancanganAnggaranBiaya->json_pengeluaran_lainnya ?? []));
                window.oldTukang = @json(old('json_pengeluaran_tukang', $rancanganAnggaranBiaya->json_pengeluaran_tukang ?? []));
                window.oldKerjaTambah = @json(old('json_kerja_tambah', $rancanganAnggaranBiaya->json_kerja_tambah ?? []));
            </script>
            <form action="{{ route('admin.rancangan-anggaran-biaya.update', $rancanganAnggaranBiaya) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Hidden inputs untuk penawaran_id dan pemasangan_id -->
                <input type="hidden" name="penawaran_id" value="{{ $rancanganAnggaranBiaya->penawaran_id ?? '' }}">
                <input type="hidden" name="pemasangan_id" value="{{ $rancanganAnggaranBiaya->pemasangan_id ?? '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:input name="proyek" label="Proyek" placeholder="Nama Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required 
                            value="{{ old('proyek', $rancanganAnggaranBiaya->proyek) }}" />
                    </div>
                    <div>
                        <flux:input name="pekerjaan" label="Pekerjaan" placeholder="Nama Pekerjaan" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required 
                            value="{{ old('pekerjaan', $rancanganAnggaranBiaya->pekerjaan) }}" />
                    </div>
                    <div>
                        <flux:input name="kontraktor" label="Kontraktor" placeholder="Nama Kontraktor" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required 
                            value="{{ old('kontraktor', $rancanganAnggaranBiaya->kontraktor) }}" />
                    </div>
                    <div>
                        <flux:input name="lokasi" label="Lokasi" placeholder="Lokasi Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required 
                            value="{{ old('lokasi', $rancanganAnggaranBiaya->lokasi) }}" />
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-2">Pengeluaran Material Utama</h2>
                    <x-rab.material-utama-table :produk="$produkPenawaran" :existing-data="$rancanganAnggaranBiaya->json_pengeluaran_material_utama" />
                    <!-- Hidden input untuk menyimpan data material utama -->
                    <input type="hidden" name="json_pengeluaran_material_utama" id="json_pengeluaran_material_utama" value="{{ json_encode($rancanganAnggaranBiaya->json_pengeluaran_material_utama ?? []) }}">
                    
                    <!-- Validasi Material Utama vs Penawaran -->
                    <div class="mt-4 p-4 rounded-lg border" id="material-utama-validation">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Material Utama (RAB):</span>
                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400" id="rab-material-utama-total">Rp 0</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Penawaran:</span>
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">Rp {{ number_format($penawaranTotal, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2" id="validation-status">
                                <div class="px-3 py-1 rounded-full text-sm font-medium" id="validation-badge">
                                    <span id="validation-text">Memvalidasi...</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 text-sm" id="validation-message"></div>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30"></div>
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30 mt-2"></div>
                        </div>
                        <h2 class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600/30 py-2 uppercase">Pengeluaran Material Pendukung</h2>
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
                        <h2 class="text-lg font-semibold w-full text-center bg-teal-600 dark:bg-teal-600/30 py-2 uppercase">Pengeluaran Entertaiment</h2>
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
                
                <!-- Grand Total Section -->
                <div class="mt-8 p-6 bg-gray-50 dark:bg-zinc-800/40 rounded-lg border border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-semibold mb-4 text-center text-gray-800 dark:text-gray-200">RINGKASAN GRAND TOTAL</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Material Utama</div>
                            <div class="text-lg font-bold text-blue-600 dark:text-blue-400" id="grand-total-material-utama">Rp 0</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Material Pendukung</div>
                            <div class="text-lg font-bold text-sky-600 dark:text-sky-400" id="grand-total-material-pendukung">Rp 0</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Entertaiment</div>
                            <div class="text-lg font-bold text-teal-600 dark:text-teal-400" id="grand-total-entertaiment">Rp 0</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Akomodasi</div>
                            <div class="text-lg font-bold text-yellow-600 dark:text-yellow-400" id="grand-total-akomodasi">Rp 0</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Lainnya</div>
                            <div class="text-lg font-bold text-pink-600 dark:text-pink-400" id="grand-total-lainnya">Rp 0</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Tukang</div>
                            <div class="text-lg font-bold text-purple-600 dark:text-purple-400" id="grand-total-tukang">Rp 0</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-700 p-4 rounded-lg border border-gray-200 dark:border-zinc-600">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Kerja Tambah</div>
                            <div class="text-lg font-bold text-orange-600 dark:text-orange-400" id="grand-total-kerja-tambah">Rp 0</div>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-700">
                        <div class="text-center">
                            <div class="text-lg font-medium text-emerald-800 dark:text-emerald-200">TOTAL KESELURUHAN</div>
                            <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400" id="grand-total-keseluruhan">Rp 0</div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya) }}"
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" onclick="prepareFormData()"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Update
                    </button>
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
                        const satuanInput = document.querySelector(`input[name="material_utama[${index}][satuan]"]`);
                        const hargaInput = document.querySelector(`input[name="material_utama[${index}][harga_satuan]"]`);
                        const totalInput = document.querySelector(`input[name="material_utama[${index}][total]"]`);
                        
                        if (itemInput && satuanInput) {
                            const typeInput = document.querySelector(`input[name="material_utama[${index}][type]"]`);
                            const dimensiInput = document.querySelector(`input[name="material_utama[${index}][dimensi]"]`);
                            const panjangInput = document.querySelector(`input[name="material_utama[${index}][panjang]"]`);
                            const warnaInput = document.querySelector(`input[name="material_utama[${index}][warna]"]`);
                            
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

        // Function to calculate and display grand totals
        function calculateGrandTotals() {
            // Material Utama - Use penawaran grand total
            const penawaranGrandTotal = {{ $penawaran->grand_total ?? 0 }};
            document.getElementById('grand-total-material-utama').textContent = 'Rp ' + penawaranGrandTotal.toLocaleString('id-ID');
            
            // Update Material Utama total for validation (use RAB data for validation)
            let totalMaterialUtama = 0;
            document.querySelectorAll('input[name^="material_utama"][name$="[total]"]').forEach(input => {
                totalMaterialUtama += parseFloat(input.value) || 0;
            });
            document.getElementById('rab-material-utama-total').textContent = 'Rp ' + totalMaterialUtama.toLocaleString('id-ID');
            
            // Validate Material Utama vs Penawaran
            validateMaterialUtama(totalMaterialUtama);

            // Material Pendukung
            let totalMaterialPendukung = 0;
            document.querySelectorAll('.material-pendukung-grand-total').forEach(el => {
                const text = el.textContent.replace(/[^\d]/g, '');
                totalMaterialPendukung += parseInt(text) || 0;
            });
            document.getElementById('grand-total-material-pendukung').textContent = 'Rp ' + totalMaterialPendukung.toLocaleString('id-ID');

            // Entertaiment
            let totalEntertaiment = 0;
            document.querySelectorAll('.entertaiment-grand-total').forEach(el => {
                const text = el.textContent.replace(/[^\d]/g, '');
                totalEntertaiment += parseInt(text) || 0;
            });
            document.getElementById('grand-total-entertaiment').textContent = 'Rp ' + totalEntertaiment.toLocaleString('id-ID');

            // Akomodasi
            let totalAkomodasi = 0;
            document.querySelectorAll('.akomodasi-grand-total').forEach(el => {
                const text = el.textContent.replace(/[^\d]/g, '');
                totalAkomodasi += parseInt(text) || 0;
            });
            document.getElementById('grand-total-akomodasi').textContent = 'Rp ' + totalAkomodasi.toLocaleString('id-ID');

            // Lainnya
            let totalLainnya = 0;
            document.querySelectorAll('.lainnya-grand-total').forEach(el => {
                const text = el.textContent.replace(/[^\d]/g, '');
                totalLainnya += parseInt(text) || 0;
            });
            document.getElementById('grand-total-lainnya').textContent = 'Rp ' + totalLainnya.toLocaleString('id-ID');

            // Tukang
            let totalTukang = 0;
            document.querySelectorAll('.tukang-grand-total').forEach(el => {
                const text = el.textContent.replace(/[^\d]/g, '');
                totalTukang += parseInt(text) || 0;
            });
            document.getElementById('grand-total-tukang').textContent = 'Rp ' + totalTukang.toLocaleString('id-ID');

            // Kerja Tambah
            let totalKerjaTambah = 0;
            document.querySelectorAll('.kerja-tambah-grand-total').forEach(el => {
                const text = el.textContent.replace(/[^\d]/g, '');
                totalKerjaTambah += parseInt(text) || 0;
            });
            document.getElementById('grand-total-kerja-tambah').textContent = 'Rp ' + totalKerjaTambah.toLocaleString('id-ID');

            // Total Keseluruhan - Use penawaran grand total for Material Utama
            const totalKeseluruhan = penawaranGrandTotal + totalMaterialPendukung + totalEntertaiment + 
                                    totalAkomodasi + totalLainnya + totalTukang + totalKerjaTambah;
            document.getElementById('grand-total-keseluruhan').textContent = 'Rp ' + totalKeseluruhan.toLocaleString('id-ID');
        }

        // Function to validate Material Utama vs Penawaran
        function validateMaterialUtama(rabTotal) {
            const penawaranTotal = {{ $penawaranTotal }};
            const difference = Math.abs(rabTotal - penawaranTotal);
            const tolerance = 1000; // Tolerance of Rp 1,000 for rounding differences
            
            const validationBadge = document.getElementById('validation-badge');
            const validationText = document.getElementById('validation-text');
            const validationMessage = document.getElementById('validation-message');
            
            if (difference <= tolerance) {
                // Valid - totals match
                validationBadge.className = 'px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400';
                validationText.textContent = '✓ Tervalidasi';
                validationMessage.innerHTML = '<span class="text-green-600 dark:text-green-400">✓ Data Material Utama sesuai dengan Penawaran</span>';
            } else {
                // Invalid - totals don't match
                validationBadge.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400';
                validationText.textContent = '⚠ Ada Ketidakcocokan';
                validationMessage.innerHTML = '<span class="text-red-600 dark:text-red-400">⚠ Ada ketidakcocokan data dengan Penawaran yang terhubung</span>';
            }
        }

        // Calculate grand totals when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(calculateGrandTotals, 500); // Delay to ensure all components are loaded
        });

        // Recalculate when any input changes
        document.addEventListener('input', function() {
            setTimeout(calculateGrandTotals, 100);
        });

        // Initialize validation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Calculate initial Material Utama total from existing data for validation
            let initialTotal = 0;
            @if(isset($rancanganAnggaranBiaya->json_pengeluaran_material_utama) && is_array($rancanganAnggaranBiaya->json_pengeluaran_material_utama))
                @foreach($rancanganAnggaranBiaya->json_pengeluaran_material_utama as $item)
                    initialTotal += {{ $item['total'] ?? 0 }};
                @endforeach
            @endif
            
            // Update the validation display and validate
            document.getElementById('rab-material-utama-total').textContent = 'Rp ' + initialTotal.toLocaleString('id-ID');
            validateMaterialUtama(initialTotal);
            
            // Set Material Utama grand total to penawaran grand total
            const penawaranGrandTotal = {{ $penawaran->grand_total ?? 0 }};
            document.getElementById('grand-total-material-utama').textContent = 'Rp ' + penawaranGrandTotal.toLocaleString('id-ID');
        });

    </script>
</x-layouts.app> 