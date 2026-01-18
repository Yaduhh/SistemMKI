<x-layouts.app :title="__('Edit Rancangan Anggaran Biaya (RAB)')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <h1 class="text-2xl font-bold mb-4">RAB {{ $penawaran->nomor_penawaran ?? '-' }}</h1>
            <div class="mb-4 p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="font-medium">Nomor Penawaran:</div>
                    <div class="font-medium">Nomor Pemasangan:</div>
                    <div class="font-medium">{{ $penawaran->nomor_penawaran ?? '-' }}</div>
                    <div class="font-medium">{{ $pemasangan->nomor_pemasangan ?? '-' }}</div>
                </div>
            </div>

            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Info Validasi -->
            <div
                class="mb-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded">
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
                window.oldMaterialTambahan = @json(old('json_pengeluaran_material_tambahan'));
                window.oldEntertaiment = @json(old('json_pengeluaran_entertaiment'));
                window.oldTukang = @json(old('json_pengeluaran_tukang'));
                window.oldKerjaTambah = @json(old('json_kerja_tambah'));
                window.oldPemasangan = @json(old('json_pengeluaran_pemasangan'));
                window.oldPengajuanHargaTukang = @json(old('json_pengajuan_harga_tukang'));

                // Data existing untuk edit mode
                window.existingMaterialPendukung = @json(isset($rab) ? $rab->json_pengeluaran_material_pendukung ?? [] : []);
                window.existingMaterialTambahan = @json(isset($rab) ? $rab->json_pengeluaran_material_tambahan ?? [] : []);
                window.existingEntertaiment = @json(isset($rab) ? $rab->json_pengeluaran_entertaiment ?? [] : []);
                window.existingTukang = @json(isset($rab) ? $rab->json_pengeluaran_tukang ?? [] : []);
                window.existingKerjaTambah = @json(isset($rab) ? $rab->json_kerja_tambah ?? [] : []);
                window.existingPemasangan = @json(isset($rab) ? $rab->json_pengeluaran_pemasangan ?? [] : []);
                window.existingPengajuanHargaTukang = @json(isset($rab) ? $rab->json_pengajuan_harga_tukang ?? [] : []);
                window.existingSectionMaterialPendukung = @json(isset($rab) ? $rab->json_section_material_pendukung ?? [] : []);

                // Flag untuk menandai bahwa ini halaman edit, jadi data bisa diedit
                window.isEditPage = true;

                // Data produk penawaran untuk validasi
                window.produkPenawaran = @json($produkPenawaran);
            </script>
            <form action="{{ route('admin.rancangan-anggaran-biaya.update', $rab->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Hidden inputs untuk penawaran_id dan pemasangan_id -->
                <input type="hidden" name="penawaran_id" value="{{ $penawaran->id ?? '' }}">
                <input type="hidden" name="pemasangan_id" value="{{ $pemasangan->id ?? '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:input name="proyek" label="Proyek" placeholder="Nama Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" 
                            value="{{ old('proyek', $rab->proyek ?? '') }}" required />
                    </div>
                    <div>
                        <flux:input name="pekerjaan" label="Pekerjaan" placeholder="Nama Pekerjaan" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" 
                            value="{{ old('pekerjaan', $rab->pekerjaan ?? '') }}" required />
                    </div>
                    <div>
                        <flux:input name="kontraktor" label="Kontraktor" placeholder="Nama Kontraktor" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" 
                            value="{{ old('kontraktor', $rab->kontraktor ?? '') }}" required />
                    </div>
                    <div>
                        <flux:input name="lokasi" label="Lokasi" placeholder="Lokasi Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" 
                            value="{{ old('lokasi', $rab->lokasi ?? '') }}" required />
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-2">Pengeluaran Material Utama</h2>
                    
                    @if (isset($penawaran->json_penawaran_pintu) && !empty($penawaran->json_penawaran_pintu))
                        <!-- Tampilkan komponen khusus untuk penawaran pintu -->
                        <x-rab-material-utama-pintu :penawaranPintu="$penawaran->json_penawaran_pintu" />
                        <!-- Hidden input untuk menyimpan data material utama pintu -->
                        <input type="hidden" name="json_pengeluaran_material_utama"
                            id="json_pengeluaran_material_utama"
                            value="{{ json_encode($penawaran->json_penawaran_pintu) }}">
                    @else
                        <!-- Tampilkan komponen biasa untuk penawaran non-pintu -->
                        <x-rab.material-utama-table :produk="$produkPenawaran" :existingData="$rab->json_pengeluaran_material_utama ?? []" />
                        <!-- Hidden input untuk menyimpan data material utama -->
                        <input type="hidden" name="json_pengeluaran_material_utama"
                            id="json_pengeluaran_material_utama" value="{{ isset($rab) ? json_encode($rab->json_pengeluaran_material_utama ?? []) : '' }}">
                    @endif

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

                <!-- Section Material Pendukung -->
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
                                    @if(isset($rab->json_section_material_pendukung) && is_array($rab->json_section_material_pendukung) && count($rab->json_section_material_pendukung) > 0)
                                        @foreach($rab->json_section_material_pendukung as $index => $item)
                                            @php
                                                // Format harga_satuan dan total jika sudah ada
                                                $hargaSatuan = $item['harga_satuan'] ?? '';
                                                if ($hargaSatuan && is_numeric(str_replace(['Rp', ' ', '.', ','], '', $hargaSatuan))) {
                                                    $hargaSatuanNum = (float) str_replace(['Rp', ' ', '.', ','], '', $hargaSatuan);
                                                    $hargaSatuan = 'Rp ' . number_format($hargaSatuanNum, 0, ',', '.');
                                                }
                                                $total = $item['total'] ?? '';
                                                if ($total && is_numeric(str_replace(['Rp', ' ', '.', ','], '', $total))) {
                                                    $totalNum = (float) str_replace(['Rp', ' ', '.', ','], '', $total);
                                                    $total = 'Rp ' . number_format($totalNum, 0, ',', '.');
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
                                                    <input type="number" min="0" step="0.01" name="section_material_pendukung[{{ $index }}][qty]" value="{{ $item['qty'] ?? '' }}" placeholder="Qty" class="section-material-qty w-full border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
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
                        <input type="hidden" name="json_section_material_pendukung" id="json_section_material_pendukung" value="{{ isset($rab) ? json_encode($rab->json_section_material_pendukung ?? []) : '[]' }}">
                    </div>
                </div>

                <!-- Data Pemasangan yang Terhubung -->
                @if (isset($pemasangan) && $pemasangan && isset($pemasangan->json_pemasangan) && $pemasangan->json_pemasangan)
                <div class="mt-8">
                        <div class="flex items-center justify-between gap-4">
                            <h2
                                class="text-lg font-semibold w-full text-center bg-amber-600 dark:bg-amber-600 py-2 uppercase text-white">
                                Data Pemasangan Terhubung
                            </h2>
                        </div>

                        <div class="w-full">
                            <div class="w-full">
                                @foreach ($pemasangan->json_pemasangan as $group)
                                    <div class="border border-gray-200 dark:border-gray-600 p-4">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($group['items'] as $index => $item)
                                                        @php
                                                            $satuan = strtolower(trim($item['satuan'] ?? ''));
                                                            $excludedSatuans = ['btg', 'pcs'];
                                                            // Cari harga satuan dari json_pengeluaran_pemasangan jika ada
                                                            // Gunakan kombinasi item + qty + satuan untuk identifikasi unik
                                                            $hargaSatuanPemasangan = 0;
                                                            $itemQty = (float)($item['qty'] ?? 0);
                                                            $itemSatuan = $item['satuan'] ?? '';
                                                            $itemName = $item['item'] ?? '';
                                                            
                                                            if (isset($rab->json_pengeluaran_pemasangan) && is_array($rab->json_pengeluaran_pemasangan)) {
                                                                $foundItem = collect($rab->json_pengeluaran_pemasangan)->first(function($pemasanganItem) use ($itemName, $itemQty, $itemSatuan) {
                                                                    $pemasanganItemName = $pemasanganItem['item'] ?? '';
                                                                    $pemasanganItemQty = (float)($pemasanganItem['qty'] ?? 0);
                                                                    $pemasanganItemSatuan = $pemasanganItem['satuan'] ?? '';
                                                                    
                                                                    // Match berdasarkan item + qty + satuan untuk identifikasi unik
                                                                    return $pemasanganItemName === $itemName 
                                                                        && abs($pemasanganItemQty - $itemQty) < 0.01 
                                                                        && $pemasanganItemSatuan === $itemSatuan;
                                                                });
                                                                if ($foundItem) {
                                                                    $hargaSatuanPemasangan = (float) preg_replace('/[^\d.]/', '', $foundItem['harga_satuan'] ?? 0);
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
                                                                        class="harga-satuan-input w-full text-right border rounded px-2 py-1 text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                                                                        value="{{ $hargaSatuanPemasangan > 0 ? number_format($hargaSatuanPemasangan, 0, ',', '.') : '' }}"
                                                                        data-qty="{{ number_format((float)($item['qty'] ?? 0), 2, '.', '') }}"
                                                                        data-group="{{ $loop->parent->index }}"
                                                                        data-item="{{ $index }}"
                                                                        placeholder="0"
                                                                        data-debug-item="{{ $item['item'] ?? 'unknown' }}"
                                                                        data-debug-satuan="{{ $item['satuan'] ?? '' }}"
                                                                        data-debug-harga="{{ $hargaSatuanPemasangan }}"
                                                                        data-debug-qty="{{ number_format((float)($item['qty'] ?? 0), 2, '.', '') }}" />
                                                                </td>
                                                                <td
                                                                    class="px-3 py-2 text-right font-medium text-amber-600 dark:text-amber-400 total-harga-cell">
                                                                    <span
                                                                        class="calculated-total">{{ $hargaSatuanPemasangan > 0 ? 'Rp ' . number_format($hargaSatuanPemasangan * (float)($item['qty'] ?? 0), 0, ',', '.') : '-' }}</span>
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

                            <div class="bg-amber-600 dark:bg-amber-600 p-4">
                                <p class="text-white dark:text-white text-right">
                                    Total Biaya Pemasangan Rp <span class="font-semibold text-white"
                                        id="total-biaya-pemasangan">Rp 0</span>
                                </p>
                            </div>

                            <!-- Hidden input untuk menyimpan data pemasangan yang sudah difilter -->
                            <input type="hidden" name="json_pengeluaran_pemasangan" id="json_pengeluaran_pemasangan"
                                value="{{ isset($rab) ? json_encode($rab->json_pengeluaran_pemasangan ?? []) : '' }}">
                        </div>
                    </div>
                @endif

                <!-- Harga Tukang -->
                @if (isset($pemasangan) && $pemasangan && isset($pemasangan->json_pemasangan) && $pemasangan->json_pemasangan)
                <div class="mt-8">
                        <div class="flex items-center justify-between gap-4">
                            <h2
                                class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600 py-2 uppercase text-white">
                                Harga Tukang
                            </h2>
                        </div>

                        <div class="w-full">
                            <div class="w-full">
                                @foreach ($pemasangan->json_pemasangan as $group)
                                    <div class="border border-gray-200 dark:border-gray-600 p-4">
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
                                                            
                                                            if (isset($rab->json_pengajuan_harga_tukang) && is_array($rab->json_pengajuan_harga_tukang)) {
                                                                $foundItem = collect($rab->json_pengajuan_harga_tukang)->first(function($tukangItem) use ($itemName, $itemQty, $itemSatuan) {
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
                                                                        value="{{ $hargaSatuanTukang > 0 ? number_format($hargaSatuanTukang, 0, ',', '.') : '' }}"
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
                                                                        class="calculated-total-tukang">{{ $hargaSatuanTukang > 0 ? 'Rp ' . number_format($hargaSatuanTukang * (float)($item['qty'] ?? 0), 0, ',', '.') : '-' }}</span>
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
                                    Total Biaya Harga Tukang Rp <span class="font-semibold text-white"
                                        id="total-biaya-harga-tukang">Rp 0</span>
                                </p>
                            </div>

                            <!-- Hidden input untuk menyimpan data harga tukang -->
                            <input type="hidden" name="json_pengajuan_harga_tukang" id="json_pengajuan_harga_tukang"
                                value="{{ isset($rab) ? json_encode($rab->json_pengajuan_harga_tukang ?? []) : '' }}">
                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600 py-2 uppercase">
                            Pengeluaran Material Pendukung
                        </h2>
                    </div>
                    
                    <!-- Filter Pemasangan Sisa -->
                    @if(isset($pemasanganSisa) && $pemasanganSisa->count() > 0)
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
                        <h3 class="text-md font-semibold mb-3 text-blue-800 dark:text-blue-200">Pilih Data Pemasangan Sisa</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Pemasangan yang Tersedia:</label>
                                <select id="pemasangan-sisa-select" class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Pemasangan --</option>
                                    @foreach($pemasanganSisa as $pemasanganItem)
                                        <option value="{{ $pemasanganItem->id }}" data-json="{{ json_encode($pemasanganItem->json_pemasangan) }}">
                                            {{ $pemasanganItem->nomor_pemasangan }} - {{ $pemasanganItem->judul_pemasangan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end w-full">
                                <button type="button" id="tambah-pemasangan-btn" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                                    Tambahkan ke Material Pendukung
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <x-rab.material-pendukung-table />
                </div>

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2
                            class="text-lg font-semibold w-full text-center bg-indigo-600 dark:bg-indigo-600 py-2 uppercase">
                            Pengeluaran Material Tambahan
                        </h2>
                    </div>
                    <x-rab.material-tambahan-table />
                        </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2
                            class="text-lg font-semibold w-full text-center bg-teal-600 dark:bg-teal-600 py-2 uppercase">
                            Pengeluaran Non Material
                        </h2>
                    </div>
                    <x-rab.entertaiment-table />
                    <!-- Hidden input untuk menyimpan data entertainment -->
                    <input type="hidden" name="json_pengeluaran_entertaiment" id="json_pengeluaran_entertaiment"
                        value="{{ isset($rab) ? json_encode($rab->json_pengeluaran_entertaiment ?? []) : '[]' }}">
                </div>

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2
                            class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600 py-2 uppercase">
                            Pengeluaran Tukang
                        </h2>
                    </div>
                    <x-rab.tukang-table />
                    <!-- Hidden input untuk menyimpan data tukang -->
                    <input type="hidden" name="json_pengeluaran_tukang" id="json_pengeluaran_tukang"
                        value="{{ isset($rab) ? json_encode($rab->json_pengeluaran_tukang ?? []) : '[]' }}">
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2
                            class="text-lg font-semibold w-full text-center bg-orange-600 dark:bg-orange-600 py-2 uppercase">
                            Kerja Tambah
                        </h2>
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
        // Initialize pemasangan calculation
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing pemasangan...');

            // Debug: Check input values and data attributes
            document.querySelectorAll('.harga-satuan-input').forEach((input, index) => {
                console.log(`Input ${index}:`, {
                    value: input.value,
                    qty: input.dataset.qty,
                    item: input.dataset.debugItem,
                    harga: input.dataset.debugHarga
                });
            });

            // Add event listeners to harga satuan inputs
            document.querySelectorAll('.harga-satuan-input').forEach((input, index) => {
                console.log(`Adding listener to input ${index}`);
                
                // Format existing value if any
                if (input.value) {
                    const value = parseFloat(input.value.toString().replace(/[^\d]/g, '')) || 0;
                    if (value > 0) {
                        input.value = formatRupiah(value);
                    }
                }
                
                input.addEventListener('input', function(e) {
                    // Format input value
                    const value = e.target.value.replace(/[^\d]/g, '');
                    if (value) {
                        e.target.value = formatRupiah(parseInt(value));
                    }
                    console.log(`Input ${index} changed to:`, e.target.value);
                    calculatePemasanganTotal();
                });
            });

            // Calculate initial total based on existing values
            setTimeout(() => {
                // Restore old pemasangan data if form failed
                if (window.oldPemasangan && window.oldPemasangan.length > 0) {
                    restoreOldPemasanganData();
                    // Recalculate after restore
                    setTimeout(() => {
                        calculateInitialPemasanganTotal();
                    }, 50);
                } else {
                    calculateInitialPemasanganTotal();
                }
            }, 100);

            // Initialize harga tukang calculation
            console.log('DOM loaded, initializing harga tukang...');

            // Add event listeners to harga tukang inputs
            document.querySelectorAll('.harga-tukang-input').forEach((input, index) => {
                console.log(`Adding listener to harga tukang input ${index}`);
                
                // Format existing value if any
                if (input.value) {
                    const value = parseFloat(input.value.toString().replace(/[^\d]/g, '')) || 0;
                    if (value > 0) {
                        input.value = formatRupiah(value);
                    }
                }
                
                input.addEventListener('input', function(e) {
                    // Format input value
                    const value = e.target.value.replace(/[^\d]/g, '');
                    if (value) {
                        e.target.value = formatRupiah(parseInt(value));
                    }
                    console.log(`Harga tukang input ${index} changed to:`, e.target.value);
                    calculateHargaTukangTotal();
                });
            });
            
            // Add event listeners to status select
            document.querySelectorAll('.status-tukang-input').forEach((select) => {
                select.addEventListener('change', function() {
                    calculateHargaTukangTotal();
                });
            });

            // Calculate initial total harga tukang based on existing values
            setTimeout(() => {
                // Restore old harga tukang data if form failed
                if (window.oldPengajuanHargaTukang && window.oldPengajuanHargaTukang.length > 0) {
                    restoreOldHargaTukangData();
                    // Recalculate after restore
                    setTimeout(() => {
                        calculateInitialHargaTukangTotal();
                    }, 50);
                } else {
                    calculateInitialHargaTukangTotal();
                }
            }, 150);
        });

        function restoreOldPemasanganData() {
            console.log('Restoring old pemasangan data:', window.oldPemasangan);
            
            document.querySelectorAll('.harga-satuan-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    return;
                }
                
                // Find matching existing data by item name + qty + satuan (identifikasi unik)
                const itemName = input.dataset.debugItem;
                const itemQty = parseFloat(input.dataset.qty || 0);
                const itemSatuan = input.dataset.debugSatuan || '';
                
                const oldData = window.oldPemasangan.find(item => {
                    const existingQty = parseFloat(item.qty || 0);
                    const existingSatuan = item.satuan || '';
                    return item.item === itemName 
                        && Math.abs(existingQty - itemQty) < 0.01 
                        && existingSatuan === itemSatuan;
                });
                
                if (oldData) {
                    const hargaSatuan = parseFloat(oldData.harga_satuan || 0);
                    input.value = hargaSatuan > 0 ? formatRupiah(hargaSatuan) : '';
                    console.log(`Restored input ${index} (${itemName}):`, oldData);
                }
            });
        }

        function calculateInitialPemasanganTotal() {
            console.log('Calculating initial total...');
            let total = 0;

            document.querySelectorAll('.harga-satuan-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    console.log(`Skipping invalid input ${index} in initial calculation`);
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

                console.log(
                    `Input ${index}: value="${input.value}", harga=${hargaSatuan}, qty=${qty}, total=${totalHarga}`
                );

                // Update total harga cell - with error handling
                const row = input.closest('tr');
                if (row) {
                    const totalCell = row.querySelector('.calculated-total');
                    if (totalCell) {
                        totalCell.textContent = formatRupiah(totalHarga);
                        console.log(`Updated total cell for input ${index}:`, formatRupiah(totalHarga));
                    }
                }

                total += totalHarga;
            });

            console.log('Total calculated:', total);

            // Update total biaya display
            const totalBiayaElement = document.getElementById('total-biaya-pemasangan');
            if (totalBiayaElement) {
                totalBiayaElement.textContent = formatRupiah(total);
                console.log('Updated total biaya:', formatRupiah(total));
            }
        }

        function calculatePemasanganTotal() {
            let total = 0;
            let pemasanganData = [];

            document.querySelectorAll('.harga-satuan-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    console.log(`Skipping invalid input ${index}:`, {
                        qty: input.dataset.qty,
                        item: input.dataset.debugItem
                    });
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
                
                // Debug each input
                console.log(`Input ${index}:`, {
                    item: input.dataset.debugItem,
                    qty: input.dataset.qty,
                    debugQty: input.dataset.debugQty,
                    hargaSatuan: hargaSatuan,
                    totalHarga: totalHarga
                });

                // Update total harga cell
                const row = input.closest('tr');
                if (row) {
                    const totalCell = row.querySelector('.calculated-total');
                    if (totalCell) {
                        totalCell.textContent = formatRupiah(totalHarga);
                    }
                }

                // Collect data for hidden input
                const itemName = input.dataset.debugItem || 'Unknown Item';
                const satuan = row ? row.querySelector('td:nth-child(2)').textContent.trim() : 'm2';
                
                // Format qty dengan 2 desimal
                const qtyFormatted = parseFloat(qty).toFixed(2);
                
                // Format total_harga sebagai bilangan bulat (tanpa desimal)
                const totalHargaFormatted = Math.round(totalHarga).toString();
                
                // Only add to pemasanganData if item has valid data
                if (itemName !== 'Unknown Item' && qty > 0) {
                    pemasanganData.push({
                        item: itemName,
                        satuan: satuan,
                        qty: qtyFormatted,
                        harga_satuan: hargaSatuan.toString(),
                        total_harga: totalHargaFormatted
                    });
                }

                total += totalHarga;
            });

            // Update total biaya display
            const totalBiayaElement = document.getElementById('total-biaya-pemasangan');
            if (totalBiayaElement) {
                totalBiayaElement.textContent = formatRupiah(total);
            }

            // Update hidden input with filtered data
            const hiddenInput = document.getElementById('json_pengeluaran_pemasangan');
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(pemasanganData);
                console.log('Updated json_pengeluaran_pemasangan:', pemasanganData);
                console.log('Hidden input value:', hiddenInput.value);
            } else {
                console.error('Hidden input json_pengeluaran_pemasangan not found!');
            }
        }

        // Function to parse existing total_harga from database format
        function parseExistingTotal(totalHargaString) {
            if (!totalHargaString || totalHargaString === '-') return 0;
            // Remove "Rp", spaces, and dots, keep only numbers and commas
            const cleanString = totalHargaString.replace(/[Rp\s\.]/g, '').replace(/,/g, '');
            return parseFloat(cleanString) || 0;
        }

        function formatRupiah(amount) {
            const roundedAmount = Math.round(amount);
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(roundedAmount);
        }

        function prepareFormData() {
            console.log('=== PREPARE FORM DATA STARTED ===');
            
            // Debug: Check pemasangan data before submit
            const pemasanganInput = document.getElementById('json_pengeluaran_pemasangan');
            console.log('Pemasangan data before submit:', pemasanganInput ? pemasanganInput.value : 'NOT FOUND');
            
            // Debug: Data sudah benar, lanjut submit
            
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

            // Clean up entertainment data - set to null if no data entered
            cleanupEntertainmentData();
            
            // Clean up tukang data - set to null if no data entered
            cleanupTukangData();
            
            // Clean up kerja tambah data - set to null if no data entered
            cleanupKerjaTambahData();
            
            // Update pemasangan data before submit
            calculatePemasanganTotal();
            
            // Update harga tukang data before submit
            calculateHargaTukangTotal();
            
            // Update section material pendukung data before submit
            if (typeof updateSectionMaterialHiddenInput === 'function') {
                updateSectionMaterialHiddenInput();
            }
            
            // Update tukang data before submit
            if (typeof window.updateTukangHiddenInput === 'function') {
                window.updateTukangHiddenInput();
            }
            
            // Update entertainment data before submit
            if (typeof updateEntertainmentHiddenInput === 'function') {
                updateEntertainmentHiddenInput();
            }
            
            console.log('=== PREPARE FORM DATA COMPLETED ===');
        }

        // Function to collect and update entertainment data
        function updateEntertainmentHiddenInput() {
            const entertainmentData = [];
            const mrGroups = document.querySelectorAll('#entertaiment-mr-list .mr-group');
            
            mrGroups.forEach((mrGroup, mrIdx) => {
                const mrInput = mrGroup.querySelector('[data-mr-field="mr"]');
                const tanggalInput = mrGroup.querySelector('[data-mr-field="tanggal"]');
                const materialRows = mrGroup.querySelectorAll('.entertaiment-material-row');
                
                const mr = mrInput ? mrInput.value.trim() : '';
                const tanggal = tanggalInput ? tanggalInput.value : '';
                
                const materials = [];
                materialRows.forEach((row) => {
                    const supplier = row.querySelector('[data-material-field="supplier"]')?.value.trim() || '';
                    const item = row.querySelector('[data-material-field="item"]')?.value.trim() || '';
                    const qty = parseFloat(row.querySelector('[data-material-field="qty"]')?.value || 0);
                    const satuan = row.querySelector('[data-material-field="satuan"]')?.value.trim() || '';
                    const hargaSatuanInput = row.querySelector('[data-material-field="harga_satuan"]');
                    const hargaSatuan = hargaSatuanInput ? parseInt(hargaSatuanInput.value.replace(/\D/g, '')) || 0 : 0;
                    const subTotalInput = row.querySelector('[data-material-field="sub_total"]');
                    const subTotal = subTotalInput ? parseInt(subTotalInput.value.replace(/\D/g, '')) || 0 : 0;
                    const status = row.querySelector('[data-material-field="status"]')?.value || 'Disetujui';
                    
                    // Only add material if it has at least supplier, item, or harga_satuan
                    if (supplier || item || hargaSatuan > 0) {
                        materials.push({
                            supplier: supplier || null,
                            item: item || null,
                            qty: qty > 0 ? qty : null,
                            satuan: satuan || null,
                            harga_satuan: hargaSatuan > 0 ? hargaSatuan : null,
                            sub_total: subTotal > 0 ? subTotal : null,
                            status: status
                        });
                }
            });

                // Only add MR group if it has MR or materials
                if (mr || materials.length > 0) {
                    entertainmentData.push({
                        mr: mr || null,
                        tanggal: tanggal || null,
                        materials: materials
                    });
                }
            });
            
            // Update hidden input - always send array, even if empty
                const hiddenInput = document.querySelector('input[name="json_pengeluaran_entertaiment"]');
                if (hiddenInput) {
                hiddenInput.value = JSON.stringify(entertainmentData);
                console.log('Updated json_pengeluaran_entertaiment:', entertainmentData);
            } else {
                console.warn('Hidden input json_pengeluaran_entertaiment not found');
                }
            }

        // Function to clean up entertainment data (deprecated - use updateEntertainmentHiddenInput instead)
        function cleanupEntertainmentData() {
            // This function is now replaced by updateEntertainmentHiddenInput
            // But keep it for backward compatibility
            updateEntertainmentHiddenInput();
        }

        // Function to clean up tukang data
        function cleanupTukangData() {
            const tukangInputs = document.querySelectorAll('input[name*="json_pengeluaran_tukang"]');
            if (tukangInputs.length === 0) return;

            // Check if any tukang data has been entered
            let hasData = false;
            tukangInputs.forEach(input => {
                if (input.value && input.value.trim() !== '') {
                    hasData = true;
                }
            });

            // If no data entered, set the hidden input to null
            if (!hasData) {
                const hiddenInput = document.querySelector('input[name="json_pengeluaran_tukang"]');
                if (hiddenInput) {
                    hiddenInput.value = 'null';
                }
            }
        }

        // Function to clean up kerja tambah data
        function cleanupKerjaTambahData() {
            const kerjaTambahInputs = document.querySelectorAll('input[name*="json_kerja_tambah"]');
            if (kerjaTambahInputs.length === 0) return;

            // Check if any kerja tambah data has been entered
            let hasData = false;
            kerjaTambahInputs.forEach(input => {
                if (input.value && input.value.trim() !== '') {
                    hasData = true;
                }
            });

            // If no data entered, set the hidden input to null
            if (!hasData) {
                const hiddenInput = document.querySelector('input[name="json_kerja_tambah"]');
                if (hiddenInput) {
                    hiddenInput.value = 'null';
                }
            }
        }



        // Function to format number to Indonesian Rupiah format
        function formatRupiah(angka) {
            const roundedAngka = Math.round(angka);
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(roundedAngka);
        }

        // Calculate total from produk penawaran
        function calculatePenawaranTotal() {
            let total = 0;
            
            // Check if this is a pintu penawaran
            const isPintuPenawaran = document.querySelector('input[name="json_pengeluaran_material_utama"]').value.includes(
                '"judul_1"');
            
            if (isPintuPenawaran) {
                // For pintu penawaran, calculate directly from JSON data
                try {
                    const jsonData = JSON.parse(document.querySelector('input[name="json_pengeluaran_material_utama"]')
                        .value);
                    Object.values(jsonData).forEach(section => {
                        if (section.products && Array.isArray(section.products)) {
                            section.products.forEach(product => {
                                if (product.total_harga) {
                                    total += parseFloat(product.total_harga) || 0;
                                }
                            });
                        }
                    });
                } catch (e) {
                    console.error('Error parsing pintu JSON:', e);
                }
            } else {
                // For regular penawaran, use existing logic
                if (window.produkPenawaran && Array.isArray(window.produkPenawaran)) {
                    window.produkPenawaran.forEach(item => {
                        total += parseFloat(item.total_harga || 0);
                    });
                }
            }
            
            return total;
        }

        // Calculate total from current material utama inputs
        function calculateMaterialUtamaTotal() {
            let total = 0;
            
            // Check if this is a pintu penawaran
            const isPintuPenawaran = document.querySelector('input[name="json_pengeluaran_material_utama"]').value.includes(
                '"judul_1"');
            
            if (isPintuPenawaran) {
                // For pintu penawaran, calculate directly from JSON data (same as penawaran total)
                try {
                    const jsonData = JSON.parse(document.querySelector('input[name="json_pengeluaran_material_utama"]')
                        .value);
                    Object.values(jsonData).forEach(section => {
                        if (section.products && Array.isArray(section.products)) {
                            section.products.forEach(product => {
                                if (product.total_harga) {
                                    total += parseFloat(product.total_harga) || 0;
                                }
                            });
                        }
                    });
                } catch (e) {
                    console.error('Error parsing pintu JSON:', e);
                }
            } else {
                // For regular penawaran, use existing logic
                const materialUtamaInputs = document.querySelectorAll('input[name^="material_utama"]');
                const processedItems = new Set();

                materialUtamaInputs.forEach(input => {
                    const name = input.name;
                    const match = name.match(/material_utama\[(\d+)\]\[(\w+)\]/);
                    if (match) {
                        const index = match[1];
                        const field = match[2];

                        if (!processedItems.has(index)) {
                            const totalInput = document.querySelector(
                                `input[name="material_utama[${index}][total]"]`);
                            if (totalInput) {
                                total += parseFloat(totalInput.value) || 0;
                            }
                            processedItems.add(index);
                        }
                    }
                });
            }
            
            return total;
        }

        // Validate material utama against penawaran
        function validateMaterialUtama() {
            const penawaranTotal = calculatePenawaranTotal();
            const rabTotal = calculateMaterialUtamaTotal();

            // Debug logging
            console.log('Penawaran Total:', penawaranTotal);
            console.log('RAB Total:', rabTotal);
            console.log('Is Pintu Penawaran:', document.querySelector('input[name="json_pengeluaran_material_utama"]').value
                .includes('"judul_1"'));

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
            // Add a small delay to ensure the pintu component is fully rendered
            setTimeout(() => {
                validateMaterialUtama();
            }, 100);

            // Add event listeners for satuan and warna inputs
            const satuanInputs = document.querySelectorAll('input[name*="[satuan]"]');
            const warnaInputs = document.querySelectorAll('input[name*="[warna]"]');

            satuanInputs.forEach(input => {
                input.addEventListener('input', validateMaterialUtama);
            });

            warnaInputs.forEach(input => {
                input.addEventListener('input', validateMaterialUtama);
            });

            // Initialize pemasangan sisa functionality
            initializePemasanganSisa();
            
            // Load existing data for edit mode
            loadExistingData();
        });

        // Function to initialize pemasangan sisa functionality
        function initializePemasanganSisa() {
            const pemasanganSelect = document.getElementById('pemasangan-sisa-select');
            const tambahBtn = document.getElementById('tambah-pemasangan-btn');
            
            if (!pemasanganSelect || !tambahBtn) return;

            // Enable/disable button based on selection
            pemasanganSelect.addEventListener('change', function() {
                tambahBtn.disabled = !this.value;
            });

            // Handle tambah button click
            tambahBtn.addEventListener('click', function() {
                const selectedOption = pemasanganSelect.options[pemasanganSelect.selectedIndex];
                if (!selectedOption.value) return;

                const jsonData = selectedOption.dataset.json;
                if (!jsonData) return;

                try {
                    const pemasanganData = JSON.parse(jsonData);
                    
                    // Count items that will be added (after filtering)
                    let totalItems = 0;
                    pemasanganData.forEach(group => {
                        if (Array.isArray(group.items)) {
                            group.items.forEach(item => {
                                if (isSatuanAllowed(item.satuan)) {
                                    totalItems++;
                                }
                            });
                        }
                    });
                    
                    if (totalItems === 0) {
                        alert('Tidak ada item dengan satuan yang sesuai (btg, pcs, BTG, PCS, BATANG) dalam pemasangan ini.');
                        return;
                    }
                    
                    // Confirm before adding
                    const confirmMessage = `Akan menambahkan ${totalItems} item dari pemasangan ini ke material pendukung. Lanjutkan?`;
                    if (confirm(confirmMessage)) {
                        tambahkanPemasanganKeMaterialPendukung(pemasanganData);
                        
                        // Reset selection
                        pemasanganSelect.value = '';
                        tambahBtn.disabled = true;
                    }
                } catch (e) {
                    console.error('Error parsing pemasangan data:', e);
                    alert('Error: Data pemasangan tidak valid');
                }
            });
        }

        // Function to add pemasangan data to material pendukung
        function tambahkanPemasanganKeMaterialPendukung(pemasanganData) {
            if (!Array.isArray(pemasanganData)) {
                console.error('Pemasangan data is not an array');
                return;
            }

            // Get the material pendukung component
            const mrList = document.getElementById('mr-list');
            if (!mrList) {
                console.error('Material pendukung list not found');
                return;
            }

            // Create a new MR group for each pemasangan group
            pemasanganData.forEach((group, groupIndex) => {
                const mrGroup = createMrGroupFromPemasangan(group, groupIndex);
                mrList.appendChild(mrGroup);
            });

            // Re-render all names and update totals
            if (window.materialPendukungFunctions && window.materialPendukungFunctions.renderAllNames) {
                window.materialPendukungFunctions.renderAllNames();
            }

            // Setup formatting for newly added materials
            setTimeout(() => {
                if (window.materialPendukungFunctions && window.materialPendukungFunctions.setupRupiahFormatting) {
                    window.materialPendukungFunctions.setupRupiahFormatting();
                }
            }, 100);
        }

        // Function to create MR group from pemasangan data
        function createMrGroupFromPemasangan(group, groupIndex) {
            const mrGroupTemplate = document.getElementById('mr-group-template');
            if (!mrGroupTemplate) return null;

            const mrIdx = document.querySelectorAll('.mr-group').length;
            const html = mrGroupTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx);
            const temp = document.createElement('div');
            temp.innerHTML = html;
            const mrGroup = temp.firstElementChild;

            // Set MR info
            const mrInput = mrGroup.querySelector('[data-mr-field="mr"]');
            const tanggalInput = mrGroup.querySelector('[data-mr-field="tanggal"]');
            
            if (mrInput) {
                mrInput.value = `MR ${String(mrIdx + 1).padStart(3, '0')} - ${group.sub_judul || 'Pemasangan'}`;
            }
            if (tanggalInput) {
                tanggalInput.value = new Date().toISOString().split('T')[0];
            }

            // Add materials from pemasangan (filter by satuan)
            const matList = mrGroup.querySelector('.material-list');
            if (matList && Array.isArray(group.items)) {
                let filteredItemIndex = 0;
                group.items.forEach((item, itemIndex) => {
                    // Filter hanya item dengan satuan btg, pcs, BTG, PCS, BATANG
                    if (isSatuanAllowed(item.satuan)) {
                        const materialRow = createMaterialRowFromPemasangan(item, mrIdx, filteredItemIndex);
                        if (materialRow) {
                            matList.appendChild(materialRow);
                            filteredItemIndex++;
                        }
                    }
                });
            }

            return mrGroup;
        }

        // Function to create material row from pemasangan item
        function createMaterialRowFromPemasangan(item, mrIdx, matIdx) {
            const materialRowTemplate = document.getElementById('material-row-template');
            if (!materialRowTemplate) return null;

            const html = materialRowTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx).replace(/__MATIDX__/g, matIdx);
            const temp = document.createElement('div');
            temp.innerHTML = html;
            const row = temp.firstElementChild;

            // Fill data from pemasangan item
            const itemInput = row.querySelector('[data-material-field="item"]');
            const qtyInput = row.querySelector('[data-material-field="qty"]');
            const satuanInput = row.querySelector('[data-material-field="satuan"]');
            const hargaInput = row.querySelector('[data-material-field="harga_satuan"]');
            const subTotalInput = row.querySelector('[data-material-field="sub_total"]');

            if (itemInput) itemInput.value = item.item || '';
            if (qtyInput) qtyInput.value = item.qty || '';
            if (satuanInput) satuanInput.value = item.satuan || '';
            if (hargaInput) {
                const harga = parseFloat(item.harga_satuan || 0);
                hargaInput.value = harga > 0 ? 'Rp ' + harga.toLocaleString('id-ID') : '';
            }
            if (subTotalInput) {
                const qty = parseFloat(item.qty || 0);
                const harga = parseFloat(item.harga_satuan || 0);
                const subTotal = qty * harga;
                subTotalInput.value = subTotal > 0 ? 'Rp ' + subTotal.toLocaleString('id-ID') : '';
            }

            return row;
        }

        // Function to check if satuan is allowed (btg, pcs, BTG, PCS, BATANG)
        function isSatuanAllowed(satuan) {
            if (!satuan) return false;
            const allowedSatuans = ['btg', 'pcs', 'BTG', 'PCS', 'BATANG'];
            return allowedSatuans.includes(satuan.toString().trim());
        }

        // Load existing data for edit mode
        function loadExistingData() {
            // Load existing material pendukung data
            // Hanya load jika tidak ada oldMaterialPendukung (form validation error)
            if (!window.oldMaterialPendukung || !Array.isArray(window.oldMaterialPendukung) || window.oldMaterialPendukung.length === 0) {
            if (window.existingMaterialPendukung && window.existingMaterialPendukung.length > 0) {
                if (window.materialPendukungFunctions && window.materialPendukungFunctions.loadExistingData) {
                    window.materialPendukungFunctions.loadExistingData(window.existingMaterialPendukung);
                    }
                }
            }

            // Load existing material tambahan data
            if (window.existingMaterialTambahan && window.existingMaterialTambahan.length > 0) {
                if (window.materialTambahanFunctions && window.materialTambahanFunctions.loadExistingData) {
                    window.materialTambahanFunctions.loadExistingData(window.existingMaterialTambahan);
                }
            }

            // Load existing entertainment data
            if (window.existingEntertaiment && window.existingEntertaiment.length > 0) {
                if (window.entertainmentFunctions && window.entertainmentFunctions.loadExistingData) {
                    window.entertainmentFunctions.loadExistingData(window.existingEntertaiment);
                }
            }

            // Load existing tukang data
            if (window.existingTukang && window.existingTukang.length > 0) {
                if (window.tukangFunctions && window.tukangFunctions.loadExistingData) {
                    window.tukangFunctions.loadExistingData(window.existingTukang);
                }
            }

            // Load existing kerja tambah data
            if (window.existingKerjaTambah && window.existingKerjaTambah.length > 0) {
                if (window.kerjaTambahFunctions && window.kerjaTambahFunctions.loadExistingData) {
                    window.kerjaTambahFunctions.loadExistingData(window.existingKerjaTambah);
                }
            }

            // Load existing pemasangan data
            if (window.existingPemasangan && window.existingPemasangan.length > 0) {
                loadExistingPemasanganData(window.existingPemasangan);
            }

            // Load existing harga tukang data
            if (window.existingPengajuanHargaTukang && window.existingPengajuanHargaTukang.length > 0) {
                loadExistingHargaTukangData(window.existingPengajuanHargaTukang);
            }
        }

        // Load existing pemasangan data
        function loadExistingPemasanganData(pemasanganData) {
            if (!Array.isArray(pemasanganData)) return;

            document.querySelectorAll('.harga-satuan-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    return;
                }
                
                // Find matching existing data by item name + qty + satuan (identifikasi unik)
                const itemName = input.dataset.debugItem;
                const itemQty = parseFloat(input.dataset.qty || 0);
                const itemSatuan = input.dataset.debugSatuan || '';
                
                const existingData = pemasanganData.find(item => {
                    const existingQty = parseFloat(item.qty || 0);
                    const existingSatuan = item.satuan || '';
                    return item.item === itemName 
                        && Math.abs(existingQty - itemQty) < 0.01 
                        && existingSatuan === itemSatuan;
                });
                
                if (existingData) {
                    const hargaSatuan = parseFloat(existingData.harga_satuan || 0);
                    input.value = hargaSatuan > 0 ? formatRupiah(hargaSatuan) : '';
                    console.log(`Loaded existing data for input ${index} (${itemName}):`, existingData);
                }
            });

            // Recalculate total after loading data
            setTimeout(() => {
                calculatePemasanganTotal();
            }, 100);
        }

        // Calculate initial harga tukang total
        function calculateInitialHargaTukangTotal() {
            console.log('Calculating initial harga tukang total...');
            let total = 0;

            document.querySelectorAll('.harga-tukang-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    console.log(`Skipping invalid harga tukang input ${index} in initial calculation`);
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

                console.log(
                    `Harga tukang input ${index}: value="${input.value}", harga=${hargaSatuan}, qty=${qty}, total=${totalHarga}`
                );

                // Update total harga cell - with error handling
                const row = input.closest('tr');
                if (row) {
                    const totalCell = row.querySelector('.calculated-total-tukang');
                    if (totalCell) {
                        totalCell.textContent = formatRupiah(totalHarga);
                        console.log(`Updated total cell for harga tukang input ${index}:`, formatRupiah(totalHarga));
                    }
                }

                total += totalHarga;
            });

            console.log('Total harga tukang calculated:', total);

            // Update total biaya display
            const totalBiayaElement = document.getElementById('total-biaya-harga-tukang');
            if (totalBiayaElement) {
                totalBiayaElement.textContent = formatRupiah(total);
                console.log('Updated total biaya harga tukang:', formatRupiah(total));
            }
        }

        function calculateHargaTukangTotal() {
            let total = 0;
            let hargaTukangData = [];

            document.querySelectorAll('.harga-tukang-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    console.log(`Skipping invalid harga tukang input ${index}:`, {
                        qty: input.dataset.qty,
                        item: input.dataset.debugItem
                    });
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
                
                // Debug each input
                console.log(`Harga tukang input ${index}:`, {
                    item: input.dataset.debugItem,
                    qty: input.dataset.qty,
                    debugQty: input.dataset.debugQty,
                    hargaSatuan: hargaSatuan,
                    totalHarga: totalHarga
                });

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
                totalBiayaElement.textContent = formatRupiah(total);
            }

            // Update hidden input with filtered data
            const hiddenInput = document.getElementById('json_pengajuan_harga_tukang');
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(hargaTukangData);
                console.log('Updated json_pengajuan_harga_tukang:', hargaTukangData);
                console.log('Hidden input value:', hiddenInput.value);
            } else {
                console.error('Hidden input json_pengajuan_harga_tukang not found!');
            }
        }

        function restoreOldHargaTukangData() {
            console.log('Restoring old harga tukang data:', window.oldPengajuanHargaTukang);
            
            document.querySelectorAll('.harga-tukang-input').forEach((input, index) => {
                // Skip invalid inputs
                if (!input.dataset.qty || !input.dataset.debugItem) {
                    return;
                }
                
                // Find matching existing data by item name + qty + satuan (identifikasi unik)
                const itemName = input.dataset.debugItem;
                const itemQty = parseFloat(input.dataset.qty || 0);
                const itemSatuan = input.dataset.debugSatuan || '';
                
                const oldData = window.oldPengajuanHargaTukang.find(item => {
                    const existingQty = parseFloat(item.qty || 0);
                    const existingSatuan = item.satuan || '';
                    return item.item === itemName 
                        && Math.abs(existingQty - itemQty) < 0.01 
                        && existingSatuan === itemSatuan;
                });
                
                if (oldData) {
                    const hargaSatuan = parseFloat(oldData.harga_satuan || 0);
                    input.value = hargaSatuan > 0 ? formatRupiah(hargaSatuan) : '';
                    
                    // Set status
                    const row = input.closest('tr');
                    if (row) {
                        const statusSelect = row.querySelector('.status-tukang-input');
                        if (statusSelect && oldData.status) {
                            statusSelect.value = oldData.status;
                        }
                    }
                    
                    console.log(`Restored harga tukang input ${index} (${itemName}):`, oldData);
                }
            });
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
                    
                    console.log(`Loaded existing harga tukang data for input ${index} (${itemName}):`, existingData);
                }
            });

            // Recalculate total after loading data
            setTimeout(() => {
                calculateHargaTukangTotal();
            }, 100);
        }

        // Section Material Pendukung Functions
        (function() {
            let sectionMaterialIndex = {{ isset($rab->json_section_material_pendukung) && is_array($rab->json_section_material_pendukung) ? count($rab->json_section_material_pendukung) : 0 }};
            const tbody = document.getElementById('section-material-pendukung-tbody');
            const addBtn = document.getElementById('add-section-material-pendukung');

            if (!tbody || !addBtn) return;

            // Update hidden input with all data (make it global)
            window.updateSectionMaterialHiddenInput = function() {
                const rows = tbody.querySelectorAll('.section-material-row');
                const data = [];

                rows.forEach(row => {
                    const itemBarang = row.querySelector('input[name*="[item_barang]"]')?.value || '';
                    const ukuran = row.querySelector('input[name*="[ukuran]"]')?.value || '';
                    const panjang = row.querySelector('input[name*="[panjang]"]')?.value || '';
                    const qty = row.querySelector('input[name*="[qty]"]')?.value || '';
                    const satuan = row.querySelector('input[name*="[satuan]"]')?.value || '';
                    const hargaSatuan = row.querySelector('input[name*="[harga_satuan]"]')?.value || '';
                    const total = row.querySelector('input[name*="[total]"]')?.value || '';

                    // Only add if at least item_barang is filled
                    if (itemBarang.trim() !== '') {
                        data.push({
                            item_barang: itemBarang,
                            ukuran: ukuran,
                            panjang: panjang,
                            qty: qty,
                            satuan: satuan,
                            harga_satuan: hargaSatuan,
                            total: total
                        });
                    }
                });

                const hiddenInput = document.getElementById('json_section_material_pendukung');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(data);
                }
            };

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
                let harga = 0;
                
                if (hargaInput.value) {
                    // Remove currency formatting if present
                    const hargaStr = hargaInput.value.toString().replace(/[Rp\s\.]/g, '').replace(/,/g, '');
                    harga = parseFloat(hargaStr) || 0;
                }

                const total = qty * harga;
                totalInput.value = total > 0 ? formatRupiah(total) : '';
                
                // Update hidden input
                window.updateSectionMaterialHiddenInput();
            }

            // Attach event listeners to row
            function attachSectionMaterialListeners(row) {
                const qtyInput = row.querySelector('.section-material-qty');
                const hargaInput = row.querySelector('.section-material-harga-satuan');

                if (qtyInput) {
                    qtyInput.addEventListener('input', () => calculateSectionMaterialTotal(row));
                }
                if (hargaInput) {
                    hargaInput.addEventListener('input', () => {
                        // Format as currency while typing
                        const value = hargaInput.value.replace(/[^\d]/g, '');
                        if (value) {
                            hargaInput.value = formatRupiah(parseFloat(value));
                        }
                        calculateSectionMaterialTotal(row);
                    });
                }
            }

            // Event listeners
            addBtn.addEventListener('click', addSectionMaterialRow);

            tbody.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-section-material')) {
                    if (confirm('Yakin mau hapus item ini?')) {
                        e.target.closest('.section-material-row').remove();
                        window.updateSectionMaterialHiddenInput();
                    }
                }
            });

            // Attach listeners to existing rows
            document.addEventListener('DOMContentLoaded', function() {
                const existingRows = tbody.querySelectorAll('.section-material-row');
                existingRows.forEach(row => {
                    attachSectionMaterialListeners(row);
                });
                
                // Initial calculation for existing rows
                existingRows.forEach(row => {
                    calculateSectionMaterialTotal(row);
                });
            });
        })();
    </script>
</x-layouts.app>
