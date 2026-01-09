<x-layouts.app :title="__('Edit Harga Tukang')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Edit Harga Tukang</h1>
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

            <form action="{{ route('admin.rancangan-anggaran-biaya.update-harga-tukang', $rancanganAnggaranBiaya) }}"
                method="POST">
                @csrf
                @method('PATCH')

                <!-- Harga Tukang -->
                @if (isset($rancanganAnggaranBiaya->pemasangan) && $rancanganAnggaranBiaya->pemasangan && isset($rancanganAnggaranBiaya->pemasangan->json_pemasangan) && $rancanganAnggaranBiaya->pemasangan->json_pemasangan)
                <div class="mt-8">
                        <div class="flex items-center justify-between gap-4">
                            <h2
                                class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600 py-2 uppercase text-white">
                                Harga Tukang
                            </h2>
                        </div>

                        <div class="w-full">
                            <div class="w-full">
                                @foreach ($rancanganAnggaranBiaya->pemasangan->json_pemasangan as $group)
                                    <div class="border border-gray-200 dark:border-gray-600 p-4 mb-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3 text-lg">
                                            {{ $group['sub_judul'] ?? 'Sub Judul' }}
                                        </h4>

                                        <div class="overflow-x-auto">
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                                        <th
                                                            class="px-3 py-2 text-left font-medium text-gray-700 dark:text-gray-300">
                                                            Item</th>
                                                        <th
                                                            class="px-3 py-2 text-center font-medium text-gray-700 dark:text-gray-300">
                                                            Satuan</th>
                                                        <th
                                                            class="px-3 py-2 text-center font-medium text-gray-700 dark:text-gray-300">
                                                            Qty</th>
                                                        <th
                                                            class="px-3 py-2 text-right font-medium text-gray-700 dark:text-gray-300">
                                                            Harga Satuan</th>
                                                        <th
                                                            class="px-3 py-2 text-right font-medium text-gray-700 dark:text-gray-300">
                                                            Total Harga</th>
                                                        <th
                                                            class="px-3 py-2 text-center font-medium text-gray-700 dark:text-gray-300">
                                                            Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($group['items'] as $index => $item)
                                                        @php
                                                            $satuan = strtolower(trim($item['satuan'] ?? ''));
                                                            $excludedSatuans = ['btg', 'pcs'];
                                                            // Cari harga satuan dari json_pengajuan_harga_tukang jika ada
                                                            // Gunakan kombinasi item + qty + satuan untuk identifikasi unik
                                                            $hargaSatuanTukang = 0;
                                                            $statusTukang = 'Disetujui'; // Default status
                                                            $itemQty = (float)($item['qty'] ?? 0);
                                                            $itemSatuan = $item['satuan'] ?? '';
                                                            $itemName = $item['item'] ?? '';
                                                            
                                                            if (isset($rancanganAnggaranBiaya->json_pengajuan_harga_tukang) && is_array($rancanganAnggaranBiaya->json_pengajuan_harga_tukang)) {
                                                                $foundItem = collect($rancanganAnggaranBiaya->json_pengajuan_harga_tukang)->first(function($tukangItem) use ($itemName, $itemQty, $itemSatuan) {
                                                                    $tukangItemName = $tukangItem['item'] ?? '';
                                                                    $tukangItemQty = (float)($tukangItem['qty'] ?? 0);
                                                                    $tukangItemSatuan = $tukangItem['satuan'] ?? '';
                                                                    
                                                                    // Match berdasarkan item + qty + satuan untuk identifikasi unik
                                                                    return $tukangItemName === $itemName 
                                                                        && abs($tukangItemQty - $itemQty) < 0.01 
                                                                        && $tukangItemSatuan === $itemSatuan;
                                                                });
                                                                if ($foundItem) {
                                                                    $hargaSatuanTukang = (float) preg_replace('/[^\d.]/', '', $foundItem['harga_satuan'] ?? 0);
                                                                    $statusTukang = $foundItem['status'] ?? 'Disetujui';
                                                                }
                                                            }
                                                        @endphp
                                                        @if (!in_array($satuan, $excludedSatuans))
                                                            <tr class="border-b border-gray-100 dark:border-gray-600">
                                                                <td class="px-3 py-2 text-gray-900 dark:text-white">
                                                                    {{ $item['item'] ?? '-' }}</td>
                                                                <td
                                                                    class="px-3 py-2 text-center text-gray-600 dark:text-gray-400">
                                                                    {{ $item['satuan'] ?? '-' }}</td>
                                                                <td
                                                                    class="px-3 py-2 text-center text-gray-600 dark:text-gray-400">
                                                                    {{ number_format((float)($item['qty'] ?? 0), 2, ',', '.') }}</td>
                                                                <td class="px-3 py-2 text-right">
                                                                    <input type="text"
                                                                        class="harga-tukang-input w-full text-right border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                                                                        value="{{ number_format($hargaSatuanTukang, 0, ',', '.') }}"
                                                                        data-qty="{{ number_format((float)($item['qty'] ?? 0), 2, '.', '') }}"
                                                                        data-group="{{ $loop->parent->index }}"
                                                                        data-item="{{ $index }}"
                                                                        placeholder="0"
                                                                        data-debug-item="{{ $item['item'] ?? 'unknown' }}"
                                                                        data-debug-satuan="{{ $item['satuan'] ?? '' }}"
                                                                        data-debug-harga="{{ $hargaSatuanTukang }}"
                                                                        data-debug-qty="{{ number_format((float)($item['qty'] ?? 0), 2, '.', '') }}" />
                                                                </td>
                                                                <td
                                                                    class="px-3 py-2 text-right font-medium text-purple-600 dark:text-purple-400 total-harga-tukang-cell">
                                                                    <span
                                                                        class="calculated-total-tukang">{{ $hargaSatuanTukang > 0 ? number_format($hargaSatuanTukang * (float)($item['qty'] ?? 0), 0, ',', '.') : '-' }}</span>
                                                                </td>
                                                                <td class="px-3 py-2 text-center">
                                                                    <select class="status-tukang-input w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                                                                        data-debug-item="{{ $item['item'] ?? 'unknown' }}"
                                                                        data-debug-satuan="{{ $item['satuan'] ?? '' }}"
                                                                        data-debug-qty="{{ number_format((float)($item['qty'] ?? 0), 2, '.', '') }}">
                                                                        <option value="Pengajuan" {{ $statusTukang === 'Pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                                                                        <option value="Disetujui" {{ $statusTukang === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                                                        <option value="Ditolak" {{ $statusTukang === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-purple-600 dark:bg-purple-600 p-4">
                                <p class="text-white dark:text-white text-right">
                                    Total Biaya Harga Tukang: <span class="font-semibold text-white"
                                        id="total-biaya-harga-tukang">Rp 0</span>
                                </p>
                            </div>

                            <!-- Hidden input untuk menyimpan data harga tukang -->
                            <input type="hidden" name="json_pengajuan_harga_tukang" id="json_pengajuan_harga_tukang"
                                value="{{ isset($rancanganAnggaranBiaya) ? json_encode($rancanganAnggaranBiaya->json_pengajuan_harga_tukang ?? []) : '' }}">
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded">
                        <p class="text-yellow-800 dark:text-yellow-200">Tidak ada data pemasangan yang terhubung.</p>
                    </div>
                @endif

                <div class="mt-8 flex justify-end">
                    <button type="submit" onclick="prepareFormData()"
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">
                        Simpan Harga Tukang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Format Rupiah function
        function formatRupiah(angka) {
            const roundedAngka = Math.round(angka);
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(roundedAngka);
        }

        // Calculate harga tukang total
        function calculateHargaTukangTotal() {
            let total = 0;
            let hargaTukangData = [];

            document.querySelectorAll('.harga-tukang-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    return;
                }
                
                // Parse harga satuan - handle both number and formatted string
                let hargaSatuan = 0;
                if (input.value) {
                    // Remove any formatting and parse as number
                    hargaSatuan = parseFloat(input.value.toString().replace(/[^\d]/g, '')) || 0;
                }

                const qty = parseFloat(input.dataset.qty) || 0;
                const totalHarga = hargaSatuan * qty;
                
                // Update total harga cell
                const row = input.closest('tr');
                if (row) {
                    const totalCell = row.querySelector('.calculated-total-tukang');
                    if (totalCell) {
                        totalCell.textContent = formatRupiah(totalHarga);
                    }
                }

                // Collect data for hidden input
                const itemName = input.dataset.debugItem || 'Unknown Item';
                const satuan = row ? row.querySelector('td:nth-child(2)').textContent.trim() : 'm2';
                
                // Get status from select dropdown
                const statusSelect = row ? row.querySelector('.status-tukang-input') : null;
                const status = statusSelect ? statusSelect.value : 'Disetujui';
                
                // Format qty dengan 2 desimal
                const qtyFormatted = parseFloat(qty).toFixed(2);
                
                // Format total_harga sebagai bilangan bulat (tanpa desimal)
                const totalHargaFormatted = Math.round(totalHarga).toString();
                
                // Only add to hargaTukangData if item has valid data
                if (itemName !== 'Unknown Item' && qty > 0) {
                    hargaTukangData.push({
                        item: itemName,
                        satuan: satuan,
                        qty: qtyFormatted,
                        harga_satuan: hargaSatuan.toString(),
                        total_harga: totalHargaFormatted,
                        status: status
                    });
                }

                total += totalHarga;
            });

            // Update total biaya display
            const totalBiayaElement = document.getElementById('total-biaya-harga-tukang');
            if (totalBiayaElement) {
                totalBiayaElement.textContent = 'Rp ' + formatRupiah(total);
            }

            // Update hidden input with filtered data
            const hiddenInput = document.getElementById('json_pengajuan_harga_tukang');
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(hargaTukangData);
            }
        }

        // Prepare form data before submit
        function prepareFormData() {
            // Update harga tukang data before submit
            calculateHargaTukangTotal();
            
            // Ensure hidden input is updated
            const hiddenInput = document.getElementById('json_pengajuan_harga_tukang');
            if (hiddenInput) {
                const data = hiddenInput.value;
                console.log('Submitting harga tukang data:', data);
            }
        }

        // Load existing harga tukang data
        function loadExistingHargaTukangData(hargaTukangData) {
            if (!Array.isArray(hargaTukangData)) return;

            document.querySelectorAll('.harga-tukang-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    return;
                }
                
                // Find matching existing data by item name + qty + satuan (identifikasi unik)
                const itemName = input.dataset.debugItem;
                const itemQty = parseFloat(input.dataset.qty || 0);
                const itemSatuan = input.dataset.debugSatuan || '';
                
                const existingData = hargaTukangData.find(item => {
                    const existingQty = parseFloat(item.qty || 0);
                    const existingSatuan = item.satuan || '';
                    return item.item === itemName 
                        && Math.abs(existingQty - itemQty) < 0.01 
                        && existingSatuan === itemSatuan;
                });
                
                if (existingData) {
                    const hargaSatuan = parseFloat(existingData.harga_satuan || 0);
                    input.value = hargaSatuan > 0 ? formatRupiah(hargaSatuan) : '';
                    
                    // Set status
                    const row = input.closest('tr');
                    if (row) {
                        const statusSelect = row.querySelector('.status-tukang-input');
                        if (statusSelect && existingData.status) {
                            statusSelect.value = existingData.status;
                        }
                    }
                }
            });

            // Recalculate total after loading data
            setTimeout(() => {
                calculateHargaTukangTotal();
            }, 100);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Format number helper
            function number_format(number, decimals, dec_point, thousands_sep) {
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                const n = !isFinite(+number) ? 0 : +number;
                const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
                const sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
                const dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
                const s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }

            function toFixedFix(n, prec) {
                const k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            }

            // Add event listeners to harga tukang inputs
            document.querySelectorAll('.harga-tukang-input').forEach((input) => {
                // Format existing value if any
                if (input.value) {
                    const value = parseFloat(input.value.toString().replace(/[^\d]/g, '')) || 0;
                    if (value > 0) {
                        input.value = number_format(value, 0, ',', '.');
                    }
                }

                input.addEventListener('input', function(e) {
                    // Format input value
                    const value = e.target.value.replace(/[^\d]/g, '');
                    if (value) {
                        e.target.value = number_format(parseInt(value), 0, ',', '.');
                    }
                    calculateHargaTukangTotal();
                });
            });

            // Load existing data
            const existingData = @json($rancanganAnggaranBiaya->json_pengajuan_harga_tukang ?? []);
            if (existingData && existingData.length > 0) {
                loadExistingHargaTukangData(existingData);
            } else {
                // Calculate initial total
                setTimeout(() => {
                    calculateHargaTukangTotal();
                }, 100);
            }

            // Add form submit listener as backup
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Ensure hidden input is updated before submit
                    calculateHargaTukangTotal();
                });
            }
        });
    </script>
</x-layouts.app>

