<x-layouts.app :title="__('Edit Section Material Pendukung')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Edit Section Material Pendukung</h1>
                    <p class="text-zinc-600 dark:text-zinc-400">RAB: {{ $rancanganAnggaranBiaya->proyek }} -
                        {{ $rancanganAnggaranBiaya->pekerjaan }}</p>
                </div>
                <a href="{{ route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya) }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Kembali ke Detail RAB
                </a>
            </div>

            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="font-medium">Nomor Penawaran:</div>
                    <div class="font-medium">Nomor Pemasangan:</div>
                    <div class="font-medium">{{ $rancanganAnggaranBiaya->penawaran->nomor_penawaran ?? '-' }}</div>
                    <div class="font-medium">{{ $rancanganAnggaranBiaya->pemasangan->nomor_pemasangan ?? '-' }}</div>
                </div>
            </div>

            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded">
                    <h3 class="text-red-800 dark:text-red-200 font-semibold mb-2">Error Validasi:</h3>
                    <ul class="list-disc list-inside text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rancangan-anggaran-biaya.update-section-material-pendukung', $rancanganAnggaranBiaya) }}"
                method="POST">
                @csrf
                @method('PATCH')

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600 py-2 uppercase">
                            Section Material Pendukung
                        </h2>
                    </div>
                    
                    <div class="w-full mt-4">
                        <div class="mb-4">
                            <button type="button" id="add-section-material-pendukung" class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">
                                + Tambah Item
                            </button>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm border border-gray-200 dark:border-gray-600">
                                <thead>
                                    <tr class="bg-sky-50 dark:bg-sky-900/20">
                                        <th class="px-3 py-2 text-left font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Item Barang</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Ukuran</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Panjang</th>
                                        <th class="px-3 py-2 text-center font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Qty</th>
                                        <th class="px-3 py-2 text-center font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Satuan</th>
                                        <th class="px-3 py-2 text-right font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Harga Satuan</th>
                                        <th class="px-3 py-2 text-right font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Total</th>
                                        <th class="px-3 py-2 text-center font-medium text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="section-material-pendukung-tbody" class="bg-white dark:bg-zinc-800">
                                    @if(isset($rancanganAnggaranBiaya->json_section_material_pendukung) && is_array($rancanganAnggaranBiaya->json_section_material_pendukung) && count($rancanganAnggaranBiaya->json_section_material_pendukung) > 0)
                                        @foreach($rancanganAnggaranBiaya->json_section_material_pendukung as $index => $item)
                                            @php
                                                // Format harga_satuan dan total jika sudah ada
                                                $hargaSatuan = $item['harga_satuan'] ?? '';
                                                if ($hargaSatuan && is_numeric(str_replace(['Rp', ' ', '.', ','], '', $hargaSatuan))) {
                                                    $hargaSatuanNum = (float) str_replace(['Rp', ' ', '.', ','], '', $hargaSatuan);
                                                    $hargaSatuan = number_format($hargaSatuanNum, 0, ',', '.');
                                                }
                                                $total = $item['total'] ?? '';
                                                if ($total && is_numeric(str_replace(['Rp', ' ', '.', ','], '', $total))) {
                                                    $totalNum = (float) str_replace(['Rp', ' ', '.', ','], '', $total);
                                                    $total = number_format($totalNum, 0, ',', '.');
                                                }
                                            @endphp
                                            <tr class="section-material-row border-b border-gray-100 dark:border-gray-600">
                                                <td class="px-3 py-2">
                                                    <input type="text" name="section_material_pendukung[{{ $index }}][item_barang]" value="{{ $item['item_barang'] ?? '' }}" placeholder="Item Barang" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="text" name="section_material_pendukung[{{ $index }}][ukuran]" value="{{ $item['ukuran'] ?? '' }}" placeholder="Ukuran" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="text" name="section_material_pendukung[{{ $index }}][panjang]" value="{{ $item['panjang'] ?? '' }}" placeholder="Panjang" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="number" min="0" step="0.01" name="section_material_pendukung[{{ $index }}][qty]" value="{{ isset($item['qty']) ? number_format((float)$item['qty'], 2, '.', '') : '' }}" placeholder="Qty" class="section-material-qty w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="text" name="section_material_pendukung[{{ $index }}][satuan]" value="{{ $item['satuan'] ?? '' }}" placeholder="Satuan" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="text" name="section_material_pendukung[{{ $index }}][harga_satuan]" value="{{ $hargaSatuan }}" placeholder="Harga Satuan" class="section-material-harga-satuan w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white text-right" />
                                                </td>
                                                <td class="px-3 py-2">
                                                    <input type="text" name="section_material_pendukung[{{ $index }}][total]" value="{{ $total }}" placeholder="Total" class="section-material-total w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white text-right" readonly />
                                                </td>
                                                <td class="px-3 py-2 text-center">
                                                    <button type="button" class="remove-section-material text-red-600 hover:text-red-800 font-bold">Hapus</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Hidden input untuk menyimpan data -->
                        <input type="hidden" name="json_section_material_pendukung" id="json_section_material_pendukung" value="{{ isset($rancanganAnggaranBiaya) ? json_encode($rancanganAnggaranBiaya->json_section_material_pendukung ?? []) : '[]' }}">
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" onclick="prepareFormData()"
                        class="px-6 py-2 bg-sky-600 text-white rounded-lg font-semibold hover:bg-sky-700 transition">
                        Simpan Section Material Pendukung
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Prepare form data before submit
        function prepareFormData() {
            // Update section material pendukung data before submit
            if (typeof updateSectionMaterialHiddenInput === 'function') {
                updateSectionMaterialHiddenInput();
            }
        }

        // Section Material Pendukung Functions
        (function() {
            let sectionMaterialIndex = {{ isset($rancanganAnggaranBiaya->json_section_material_pendukung) && is_array($rancanganAnggaranBiaya->json_section_material_pendukung) ? count($rancanganAnggaranBiaya->json_section_material_pendukung) : 0 }};
            const tbody = document.getElementById('section-material-pendukung-tbody');
            const addBtn = document.getElementById('add-section-material-pendukung');

            if (!tbody || !addBtn) return;

            // Helper functions
            function parseRupiah(value) {
                if (!value) return 0;
                return parseFloat(value.toString().replace(/[^\d]/g, '')) || 0;
            }

            function formatRupiah(amount) {
                return new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(Math.round(amount));
            }

            // Add new row
            function addSectionMaterialRow() {
                const row = document.createElement('tr');
                row.className = 'section-material-row border-b border-gray-100 dark:border-gray-600';
                row.innerHTML = `
                    <td class="px-3 py-2">
                        <input type="text" name="section_material_pendukung[${sectionMaterialIndex}][item_barang]" placeholder="Item Barang" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    </td>
                    <td class="px-3 py-2">
                        <input type="text" name="section_material_pendukung[${sectionMaterialIndex}][ukuran]" placeholder="Ukuran" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    </td>
                    <td class="px-3 py-2">
                        <input type="text" name="section_material_pendukung[${sectionMaterialIndex}][panjang]" placeholder="Panjang" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    </td>
                    <td class="px-3 py-2">
                        <input type="number" min="0" step="0.01" name="section_material_pendukung[${sectionMaterialIndex}][qty]" placeholder="Qty" class="section-material-qty w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    </td>
                    <td class="px-3 py-2">
                        <input type="text" name="section_material_pendukung[${sectionMaterialIndex}][satuan]" placeholder="Satuan" class="w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    </td>
                    <td class="px-3 py-2">
                        <input type="text" name="section_material_pendukung[${sectionMaterialIndex}][harga_satuan]" placeholder="Harga Satuan" class="section-material-harga-satuan w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white text-right" />
                    </td>
                    <td class="px-3 py-2">
                        <input type="text" name="section_material_pendukung[${sectionMaterialIndex}][total]" placeholder="Total" class="section-material-total w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white text-right" readonly />
                    </td>
                    <td class="px-3 py-2 text-center">
                        <button type="button" class="remove-section-material text-red-600 hover:text-red-800 font-bold">Hapus</button>
                    </td>
                `;
                tbody.appendChild(row);
                sectionMaterialIndex++;
                
                // Attach event listeners to new row
                attachSectionMaterialListeners(row);
            }

            // Calculate total for a row
            function calculateSectionMaterialTotal(row) {
                const qtyInput = row.querySelector('.section-material-qty');
                const hargaInput = row.querySelector('.section-material-harga-satuan');
                const totalInput = row.querySelector('.section-material-total');

                if (!qtyInput || !hargaInput || !totalInput) return;

                const qty = parseFloat(qtyInput.value) || 0;
                let harga = parseRupiah(hargaInput.value) || 0;
                const total = qty * harga;

                totalInput.value = formatRupiah(total);
                updateSectionMaterialHiddenInput();
            }

            // Update hidden input with all section material data
            function updateSectionMaterialHiddenInput() {
                const allRows = document.querySelectorAll('#section-material-pendukung-tbody .section-material-row');
                const data = [];
                allRows.forEach(row => {
                    const itemBarang = row.querySelector('input[name$="[item_barang]"]').value;
                    const ukuran = row.querySelector('input[name$="[ukuran]"]').value;
                    const panjang = row.querySelector('input[name$="[panjang]"]').value;
                    const qtyValue = row.querySelector('input[name$="[qty]"]').value;
                    // Format qty dengan 2 desimal
                    const qty = qtyValue ? parseFloat(qtyValue).toFixed(2) : '0.00';
                    const satuan = row.querySelector('input[name$="[satuan]"]').value;
                    const hargaSatuan = parseRupiah(row.querySelector('input[name$="[harga_satuan]"]').value);
                    const total = parseRupiah(row.querySelector('input[name$="[total]"]').value);
                    // Format total sebagai bilangan bulat (tanpa desimal)
                    const totalFormatted = Math.round(total).toString();

                    data.push({
                        item_barang: itemBarang,
                        ukuran: ukuran,
                        panjang: panjang,
                        qty: qty,
                        satuan: satuan,
                        harga_satuan: hargaSatuan.toString(),
                        total: totalFormatted,
                    });
                });
                document.getElementById('json_section_material_pendukung').value = JSON.stringify(data);
            }

            // Attach listeners to a row
            function attachSectionMaterialListeners(row) {
                const qtyInput = row.querySelector('.section-material-qty');
                const hargaInput = row.querySelector('.section-material-harga-satuan');
                const removeBtn = row.querySelector('.remove-section-material');

                if (qtyInput) {
                    qtyInput.addEventListener('input', () => calculateSectionMaterialTotal(row));
                }
                if (hargaInput) {
                    hargaInput.addEventListener('input', function() {
                        const value = this.value.replace(/[^\d]/g, '');
                        if (value) {
                            this.value = formatRupiah(parseInt(value));
                        }
                        calculateSectionMaterialTotal(row);
                    });
                }
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        row.remove();
                        updateSectionMaterialHiddenInput();
                    });
                }
            }

            // Initial setup: attach listeners to existing rows
            document.querySelectorAll('#section-material-pendukung-tbody .section-material-row').forEach(row => {
                attachSectionMaterialListeners(row);
                calculateSectionMaterialTotal(row); // Calculate initial totals for existing rows
            });

            // Add button event listener
            addBtn.addEventListener('click', addSectionMaterialRow);

            // Update hidden input on page load
            setTimeout(() => {
                updateSectionMaterialHiddenInput();
            }, 100);

            // Add form submit listener as backup
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Ensure hidden input is updated before submit
                    if (typeof updateSectionMaterialHiddenInput === 'function') {
                        updateSectionMaterialHiddenInput();
                    }
                });
            }
        })();
    </script>
</x-layouts.app>

