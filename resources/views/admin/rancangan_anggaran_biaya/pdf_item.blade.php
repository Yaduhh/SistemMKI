<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>RAB - {{ $rancanganAnggaranBiaya->proyek }}</title>
    <style>
        .header {
            text-align: left;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .header-table td {
            padding: 2px 6px;
            vertical-align: top;
        }

        .section-title {
            background: #567CBA;
            font-weight: bold;
            padding: 4px;
            margin-top: 18px;
            border: 1px solid #567CBA;
            color: white;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .no-border {
            border: none !important;
        }

        .highlight {
            background: #567CBA;
            font-weight: bold;
            color: white;
        }

        .highlightTotal {
            background: #567CBA;
            font-weight: bold;
            color: white;
        }

        .grand-total {
            background: #567CBA;
            font-size: 13px;
            font-weight: bold;
            color: white;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .small {
            font-size: 10px;
        }

        .table-none {
            padding: 2px;
            border: 0px solid #000000;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        th,
        td {
            border: 0.5px solid #424242;
            padding: 3px 5px;
        }

        th,
        .table-style {
            padding: 5px;
            border: 0.5px solid #000000;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .w-100 {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="header">
        <h3 style="padding-left: 5px;">WPC MAKMUR ABADI</h3>
        <table class="header-table">
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Proyek</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->proyek }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Pekerjaan</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->pekerjaan }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Kontraktor</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->kontraktor }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Lokasi</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->lokasi }}</td>
            </tr>
        </table>
    </div>
    @php
        $penawaran = $rancanganAnggaranBiaya->penawaran;
        // Gunakan grand_total dari penawaran karena sudah termasuk:
        // - Produk utama (setelah diskon)
        // - Additional condition (tidak kena diskon)
        // - PPN
        $totalUtama = $penawaran->grand_total ?? 0;
    @endphp
    <div class="header">
        <table class="header-table">
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Harga Material</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">Rp {{ number_format($totalUtama, 0, ',', '.') }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Harga Pemasangan</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">Rp
                    {{ number_format($rancanganAnggaranBiaya->pemasangan->grand_total ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Total Nilai Kontrak</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">Rp
                    {{ number_format($totalUtama + ($rancanganAnggaranBiaya->pemasangan->grand_total ?? 0), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    {{-- I. Pengeluaran Material Utama --}}
    <div class="section-title">I. PENGELUARAN MATERIAL UTAMA</div>

    @php
        // Check if this is a pintu penawaran by looking for section structure
        $isPintuPenawaran = false;
        if (is_array($rancanganAnggaranBiaya->json_pengeluaran_material_utama)) {
            foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_utama as $key => $value) {
                if (strpos($key, 'section_') === 0 && isset($value['products'])) {
                    $isPintuPenawaran = true;
                    break;
                }
            }
        }
    @endphp

    @if ($isPintuPenawaran)
        <!-- Tampilan untuk Penawaran Pintu -->
        @php
            $totalPintuPenawaran = 0; // Untuk menghitung total dari semua section
        @endphp
        
        @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_utama as $sectionKey => $section)
            @if (isset($section['judul_1']) && isset($section['products']))
                <!-- Header Section -->
                <div
                    style="padding: 8px; background: #f0f0f0; border-left: 4px solid #567CBA; font-weight: bold; font-size: 10px;">
                    {{ $section['judul_1'] }}
                    @if (isset($section['judul_2']))
                        - {{ $section['judul_2'] }}
                    @endif
                    @if (isset($section['jumlah']))
                        (Jumlah: {{ $section['jumlah'] }})
                    @endif
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 4%" class="text-center">No</th>
                            <th style="width: 15%" class="text-center">Item</th>
                            <th style="width: 20%" class="text-center">Nama Produk</th>
                            <th style="width: 8%" class="text-center">Lebar</th>
                            <th style="width: 8%" class="text-center">Tebal</th>
                            <th style="width: 8%" class="text-center">Tinggi</th>
                            <th style="width: 10%" class="text-center">Warna</th>
                            <th style="width: 12%" class="text-center">Harga</th>
                            <th style="width: 6%" class="text-center">Jumlah</th>
                            <th style="width: 9%" class="text-center">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotalSection = 0; // Untuk subtotal per section
                        @endphp
                        @foreach ($section['products'] as $i => $product)
                            @php
                                $totalHarga = (float) preg_replace('/[^\d]/', '', $product['total_harga'] ?? 0);
                                $jumlahPintu = (int) ($section['jumlah'] ?? 1);
                                $totalHargaDenganJumlah = $totalHarga * $jumlahPintu;
                                $subtotalSection += $totalHargaDenganJumlah;
                                $totalPintuPenawaran += $totalHargaDenganJumlah;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center">{{ $product['item'] ?? '-' }}</td>
                                <td>{{ $product['nama_produk'] ?? '-' }}</td>
                                <td class="text-center">
                                    @if (isset($product['lebar']) && $product['lebar'] > 0)
                                        {{ $product['lebar'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (isset($product['tebal']) && $product['tebal'] > 0)
                                        {{ $product['tebal'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (isset($product['tinggi']) && $product['tinggi'] > 0)
                                        {{ $product['tinggi'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">{{ $product['warna'] ?? '-' }}</td>
                                <td class="text-right">
                                    Rp
                                    {{ number_format((float) preg_replace('/[^\d]/', '', $product['harga'] ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if (isset($product['jumlah_individual']) && $product['jumlah_individual'] > 1)
                                        {{ $product['jumlah_individual'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right">
                                    Rp
                                    {{ number_format((float) $totalHargaDenganJumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                        
                        <!-- Subtotal per section -->
                        <tr class="highlightTotal">
                            <td colspan="9" class="text-right">SUBTOTAL {{ $section['judul_1'] }}</td>
                            <td class="text-right">
                                <table height="100%">
                                    <tr>
                                        <td class="table-none" style="width: 10%;">Rp</td>
                                        <td class="table-none" style="width: 50%; text-align: right;">
                                            {{ number_format($subtotalSection, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endforeach
        
        <!-- Grand Total untuk semua section penawaran pintu -->
        <table>
            <tbody>
                <tr class="highlightTotal">
                    <td colspan="9" class="text-right">GRAND TOTAL MATERIAL UTAMA</td>
                    <td class="text-right">
                        <table height="100%">
                            <tr>
                                <td class="table-none" style="width: 10%;">Rp</td>
                                <td class="table-none" style="width: 50%; text-align: right;">
                                    {{ number_format($totalPintuPenawaran, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <!-- Tampilan untuk Penawaran Biasa (tidak diubah) -->
        <table>
            <thead>
                <tr>
                    <th style="width: 4%" class="text-center">No</th>
                    <th style="width: 18%" class="text-center">Item Barang</th>
                    <th style="width: 10%" class="text-center">Kode</th>
                    <th style="width: 10%" class="text-center">Dimensi</th>
                    <th style="width: 10%" class="text-center">Panjang</th>
                    <th style="width: 6%" class="text-center">Qty</th>
                    <th style="width: 6%" class="text-center">Satuan</th>
                    <th style="width: 10%" class="text-center">Sub Total</th>
                    <th style="width: 10%" class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_utama ?? [] as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ !empty($item['item']) ? $item['item'] : '' }}</td>
                        <td class="text-center">{{ !empty($item['type']) ? $item['type'] : '' }}</td>
                        <td class="text-center">{{ !empty($item['dimensi']) ? $item['dimensi'] : '' }}</td>
                        <td class="text-center">{{ !empty($item['panjang']) ? $item['panjang'] : '' }}</td>
                        <td class="text-center">
                            {{ isset($item['qty']) && $item['qty'] !== null && $item['qty'] !== '' ? $item['qty'] : '' }}
                        </td>
                        <td class="text-center">{{ !empty($item['satuan']) ? $item['satuan'] : '' }}</td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                    </tr>
                @endforeach
                <tr class="highlightTotal">
                    <td colspan="8" class="text-right">GRAND TOTAL MATERIAL UTAMA</td>
                    <td class="text-right">
                        <table width="100%" height="100%">
                            <tr>
                                <td class="table-none" style="width: 50%;">Rp</td>
                                <td class="table-none" style="width: 50%; text-align: right;">
                                    {{ number_format($totalUtama, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    @php
        // Inisialisasi variabel untuk Sisa Anggaran
        $totalSectionMaterialPendukung = 0;
        $totalPemasangan = 0;
        $totalHargaTukang = 0;
    @endphp

    {{-- II. Section Material Pendukung --}}
    @if ($rancanganAnggaranBiaya->json_section_material_pendukung)
        <div class="section-title">II. SECTION MATERIAL PENDUKUNG</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%">No</th>
                    <th style="width: 20%">Item Barang</th>
                    <th style="width: 10%">Ukuran</th>
                    <th style="width: 10%">Panjang</th>
                    <th style="width: 8%">Qty</th>
                    <th style="width: 8%">Satuan</th>
                    <th style="width: 15%">Harga Satuan</th>
                    <th style="width: 15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSectionMaterialPendukung = 0;
                @endphp
                @foreach ($rancanganAnggaranBiaya->json_section_material_pendukung as $i => $item)
                    @php
                        $total = (float) preg_replace('/[^\d]/', '', $item['total'] ?? 0);
                        $totalSectionMaterialPendukung += $total;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $item['item_barang'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['ukuran'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['panjang'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['qty'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['satuan'] ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format((float) preg_replace('/[^\d]/', '', $item['harga_satuan'] ?? 0), 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="highlight">
                    <td colspan="7" class="text-right">TOTAL SECTION MATERIAL PENDUKUNG</td>
                    <td class="text-right">Rp {{ number_format($totalSectionMaterialPendukung, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- III. Pengeluaran Pemasangan --}}
    @if ($rancanganAnggaranBiaya->json_pengeluaran_pemasangan)
        <div class="section-title">III. PENGELUARAN PEMASANGAN</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%">No</th>
                    <th style="width: 30%">Item</th>
                    <th style="width: 10%">Satuan</th>
                    <th style="width: 10%">Qty</th>
                    <th style="width: 18%">Harga Satuan</th>
                    <th style="width: 18%">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPemasangan = 0;
                @endphp
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_pemasangan as $i => $item)
                    @php
                        $totalHarga = (float) preg_replace('/[^\d]/', '', $item['total_harga'] ?? 0);
                        $totalPemasangan += $totalHarga;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $item['item'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['satuan'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['qty'] ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format((float) preg_replace('/[^\d]/', '', $item['harga_satuan'] ?? 0), 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="highlight">
                    <td colspan="5" class="text-right">TOTAL PENGELUARAN PEMASANGAN</td>
                    <td class="text-right">Rp {{ number_format($totalPemasangan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- IV. Harga Tukang --}}
    @if ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang)
        <div class="section-title">IV. HARGA TUKANG</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 4%">No</th>
                    <th style="width: 30%">Item</th>
                    <th style="width: 10%">Satuan</th>
                    <th style="width: 10%">Qty</th>
                    <th style="width: 18%">Harga Satuan</th>
                    <th style="width: 18%">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalHargaTukang = 0;
                @endphp
                @foreach ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang as $i => $item)
                    @php
                        $totalHarga = (float) preg_replace('/[^\d]/', '', $item['total_harga'] ?? 0);
                        $totalHargaTukang += $totalHarga;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $item['item'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['satuan'] ?? '-' }}</td>
                        <td class="text-center">{{ $item['qty'] ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format((float) preg_replace('/[^\d]/', '', $item['harga_satuan'] ?? 0), 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="highlight">
                    <td colspan="5" class="text-right">TOTAL HARGA TUKANG</td>
                    <td class="text-right">Rp {{ number_format($totalHargaTukang, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- V. Pengeluaran Material Pendukung --}}
    <div class="section-title">V. PENGELUARAN MATERIAL PENDUKUNG</div>
    <table>
        <thead>
            <tr>
                <th style="width: 8%">MR</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Supplier</th>
                <th style="width: 18%">Item</th>
                <th style="width: 8%">Ukuran</th>
                <th style="width: 8%">Panjang</th>
                <th style="width: 6%">Qty</th>
                <th style="width: 6%">Satuan</th>
                <th style="width: 10%">Harga Satuan</th>
                <th style="width: 11%">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPendukung = 0;
                $lastMr = null;
                function formatTanggalIndo($tgl)
                {
                    if (!$tgl) {
                        return '-';
                    }
                    $bulan = [
                        1 => 'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                    ];
                    $exp = explode('-', $tgl);
                    if (count($exp) !== 3) {
                        return $tgl;
                    }
                    return ltrim($exp[2], '0') . ' ' . $bulan[(int) $exp[1]] . ' ' . $exp[0];
                }
            @endphp
            @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung ?? [] as $mrGroup)
                @php
                    $isFirst = true;
                    $subtotalMr = 0;
                    $materialCount = count($mrGroup['materials'] ?? []);
                    $materialIndex = 0;
                @endphp
                @foreach ($mrGroup['materials'] ?? [] as $material)
                    @php
                        if ($lastMr !== null && $lastMr !== ($mrGroup['mr'] ?? '-')) {
                            // Baris kosong biru muda antar MR
                            echo '<tr>';
                            for ($i = 0; $i < 10; $i++) {
                                echo '<td style="padding:10px 0; background:#e3e9f7;"></td>';
                            }
                            echo '</tr>';
                        }
                        $lastMr = $mrGroup['mr'] ?? '-';
                        $hargaSatuan = is_numeric($material['harga_satuan'] ?? null)
                            ? $material['harga_satuan']
                            : (int) preg_replace('/[^0-9]/', '', $material['harga_satuan'] ?? 0);
                        $subTotal = is_numeric($material['sub_total'] ?? null)
                            ? $material['sub_total']
                            : (int) preg_replace('/[^0-9]/', '', $material['sub_total'] ?? 0);
                        $itemName = strtolower(trim($material['item'] ?? ''));
                        if ($itemName === 'diskon') {
                            $totalPendukung -= $subTotal;
                            $subtotalMr -= $subTotal;
                        } else {
                            $totalPendukung += $subTotal;
                            $subtotalMr += $subTotal;
                        }
                        $materialIndex++;
                    @endphp
                    <tr>
                        <td class="text-center">
                            @if ($isFirst)
                                {{ !empty($mrGroup['mr']) ? $mrGroup['mr'] : '' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isFirst)
                                {{ !empty($mrGroup['tanggal']) ? formatTanggalIndo($mrGroup['tanggal']) : '' }}
                            @endif
                        </td>
                        <td>{{ !empty($material['supplier']) ? $material['supplier'] : '' }}</td>
                        <td>{{ !empty($material['item']) ? $material['item'] : '' }}</td>
                        <td class="text-center">{{ !empty($material['ukuran']) ? $material['ukuran'] : '' }}</td>
                        <td class="text-center">{{ !empty($material['panjang']) ? $material['panjang'] : '' }}</td>
                        <td class="text-center">
                            {{ isset($material['qty']) && $material['qty'] !== null && $material['qty'] !== '' ? $material['qty'] : '' }}
                        </td>
                        <td class="text-center">{{ !empty($material['satuan']) ? $material['satuan'] : '' }}</td>
                        <td class="text-right">
                            @php
                                $itemName = strtolower(trim($material['item'] ?? ''));
                            @endphp
                            @if (in_array($itemName, ['ppn', 'diskon', 'ongkir']))
                                {{-- kosong --}}
                            @else
                                Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="text-right">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                    </tr>
                    @php $isFirst = false; @endphp
                    @if ($materialIndex === $materialCount)
                        <tr class="highlightTotal">
                            <td colspan="10" style="text-align:center;">Total: Rp
                                {{ number_format($subtotalMr, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            <tr class="highlight">
                <td colspan="9" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalPendukung, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- VI. Pengeluaran Material Tambahan --}}
    <div class="section-title">VI. PENGELUARAN MATERIAL TAMBAHAN</div>
    <table>
        <thead>
            <tr>
                <th style="width: 8%">MR</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Supplier</th>
                <th style="width: 18%">Item</th>
                <th style="width: 8%">Ukuran</th>
                <th style="width: 8%">Panjang</th>
                <th style="width: 6%">Qty</th>
                <th style="width: 6%">Satuan</th>
                <th style="width: 10%">Harga Satuan</th>
                <th style="width: 11%">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTambahan = 0;
                $lastMr = null;
                $hasApprovedMaterialTambahan = false;
                foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_tambahan ?? [] as $mrGroup) {
                    $approvedMaterials = array_filter($mrGroup['materials'] ?? [], function ($material) {
                        return isset($material['status']) && $material['status'] === 'Disetujui';
                    });
                    if (!empty($approvedMaterials)) {
                        $hasApprovedMaterialTambahan = true;
                        break;
                    }
                }
            @endphp

            @if ($hasApprovedMaterialTambahan)
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_tambahan ?? [] as $mrGroup)
                    @php
                        // Filter hanya material dengan status Disetujui
                        $approvedMaterials = array_filter($mrGroup['materials'] ?? [], function ($material) {
                            return isset($material['status']) && $material['status'] === 'Disetujui';
                        });

                        // Skip MR jika tidak ada material yang disetujui
                        if (empty($approvedMaterials)) {
                            continue;
                        }
                    @endphp
                    @php
                        $isFirst = true;
                        $subtotalMr = 0;
                        $materialCount = count($approvedMaterials);
                        $materialIndex = 0;
                    @endphp
                    @foreach ($approvedMaterials as $material)
                    @php
                        if ($lastMr !== null && $lastMr !== ($mrGroup['mr'] ?? '-')) {
                            // Baris kosong biru muda antar MR
                            echo '<tr>';
                            for ($i = 0; $i < 10; $i++) {
                                echo '<td style="padding:10px 0; background:#e3e9f7;"></td>';
                            }
                            echo '</tr>';
                        }
                        $lastMr = $mrGroup['mr'] ?? '-';
                        $hargaSatuan = is_numeric($material['harga_satuan'] ?? null)
                            ? $material['harga_satuan']
                            : (int) preg_replace('/[^0-9]/', '', $material['harga_satuan'] ?? 0);
                        $subTotal = is_numeric($material['sub_total'] ?? null)
                            ? $material['sub_total']
                            : (int) preg_replace('/[^0-9]/', '', $material['sub_total'] ?? 0);
                        $itemName = strtolower(trim($material['item'] ?? ''));
                        if ($itemName === 'diskon') {
                            $totalTambahan -= $subTotal;
                            $subtotalMr -= $subTotal;
                        } else {
                            $totalTambahan += $subTotal;
                            $subtotalMr += $subTotal;
                        }
                        $materialIndex++;
                    @endphp
                    <tr>
                        <td class="text-center">
                            @if ($isFirst)
                                {{ !empty($mrGroup['mr']) ? $mrGroup['mr'] : '' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($isFirst)
                                {{ !empty($mrGroup['tanggal']) ? formatTanggalIndo($mrGroup['tanggal']) : '' }}
                            @endif
                        </td>
                        <td>{{ !empty($material['supplier']) ? $material['supplier'] : '' }}</td>
                        <td>{{ !empty($material['item']) ? $material['item'] : '' }}</td>
                        <td class="text-center">{{ !empty($material['ukuran']) ? $material['ukuran'] : '' }}</td>
                        <td class="text-center">{{ !empty($material['panjang']) ? $material['panjang'] : '' }}</td>
                        <td class="text-center">
                            {{ isset($material['qty']) && $material['qty'] !== null && $material['qty'] !== '' ? $material['qty'] : '' }}
                        </td>
                        <td class="text-center">{{ !empty($material['satuan']) ? $material['satuan'] : '' }}</td>
                        <td class="text-right">
                            @php
                                $itemName = strtolower(trim($material['item'] ?? ''));
                            @endphp
                            @if (in_array($itemName, ['ppn', 'diskon', 'ongkir']))
                                {{-- kosong --}}
                            @else
                                Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="text-right">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                    </tr>
                    @php $isFirst = false; @endphp
                    @if ($materialIndex === $materialCount)
                        <tr class="highlightTotal">
                            <td colspan="10" style="text-align:center;">Total: Rp
                                {{ number_format($subtotalMr, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center">-</td>
                </tr>
            @endif
            <tr class="highlight">
                <td colspan="9" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalTambahan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- VII. Pengeluaran Non Material --}}
    <div class="section-title">VII. PENGELUARAN NON MATERIAL</div>
    <table>
        <thead>
            <tr>
                <th style="width: 8%">MR</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Supplier</th>
                <th style="width: 18%">Item</th>
                <th style="width: 8%">Ukuran</th>
                <th style="width: 8%">Panjang</th>
                <th style="width: 6%">Qty</th>
                <th style="width: 6%">Satuan</th>
                <th style="width: 10%">Harga Satuan</th>
                <th style="width: 11%">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalEntertaiment = 0;
                $lastMr = null;
                function formatTanggalIndo2($tgl)
                {
                    if (!$tgl) {
                        return '';
                    }
                    $bulan = [
                        1 => 'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                    ];
                    $exp = explode('-', $tgl);
                    if (count($exp) !== 3) {
                        return $tgl;
                    }
                    return ltrim($exp[2], '0') . ' ' . $bulan[(int) $exp[1]] . ' ' . $exp[0];
                }
            @endphp
            @php
                $hasApprovedData = false;
                foreach ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment ?? [] as $mrGroup) {
                    $approvedMaterials = array_filter($mrGroup['materials'] ?? [], function ($material) {
                        return isset($material['status']) && $material['status'] === 'Disetujui';
                    });
                    if (!empty($approvedMaterials)) {
                        $hasApprovedData = true;
                        break;
                    }
                }
            @endphp

            @if ($hasApprovedData)
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment ?? [] as $mrGroup)
                    @php
                        // Filter hanya material dengan status Disetujui
                        $approvedMaterials = array_filter($mrGroup['materials'] ?? [], function ($material) {
                            return isset($material['status']) && $material['status'] === 'Disetujui';
                        });

                        // Skip MR jika tidak ada material yang disetujui
                        if (empty($approvedMaterials)) {
                            continue;
                        }

                        $isFirst = true;
                        $subtotalMr = 0;
                        $materialCount = count($approvedMaterials);
                        $materialIndex = 0;
                    @endphp
                    @foreach ($approvedMaterials as $material)
                        @php
                            if ($lastMr !== null && $lastMr !== ($mrGroup['mr'] ?? '')) {
                                echo '<tr>';
                                for ($i = 0; $i < 10; $i++) {
                                    echo '<td style="padding:10px 0; background:#e3e9f7;"></td>';
                                }
                                echo '</tr>';
                            }
                            $lastMr = $mrGroup['mr'] ?? '';
                            $hargaSatuan = is_numeric($material['harga_satuan'] ?? null)
                                ? $material['harga_satuan']
                                : (int) preg_replace('/[^0-9]/', '', $material['harga_satuan'] ?? 0);
                            $subTotal = is_numeric($material['sub_total'] ?? null)
                                ? $material['sub_total']
                                : (int) preg_replace('/[^0-9]/', '', $material['sub_total'] ?? 0);
                            $itemName = strtolower(trim($material['item'] ?? ''));
                            if ($itemName === 'diskon') {
                                $totalEntertaiment -= $subTotal;
                                $subtotalMr -= $subTotal;
                            } else {
                                $totalEntertaiment += $subTotal;
                                $subtotalMr += $subTotal;
                            }
                            $materialIndex++;
                        @endphp
                        <tr>
                            <td class="text-center">
                                @if ($isFirst)
                                    {{ !empty($mrGroup['mr']) ? $mrGroup['mr'] : '' }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($isFirst)
                                    {{ !empty($mrGroup['tanggal']) ? formatTanggalIndo2($mrGroup['tanggal']) : '' }}
                                @endif
                            </td>
                            <td>{{ !empty($material['supplier']) ? $material['supplier'] : '' }}</td>
                            <td>{{ !empty($material['item']) ? $material['item'] : '' }}</td>
                            <td class="text-center">{{ !empty($material['ukuran']) ? $material['ukuran'] : '' }}</td>
                            <td class="text-center">{{ !empty($material['panjang']) ? $material['panjang'] : '' }}
                            </td>
                            <td class="text-center">
                                {{ isset($material['qty']) && $material['qty'] !== null && $material['qty'] !== '' ? $material['qty'] : '' }}
                            </td>
                            <td class="text-center">{{ !empty($material['satuan']) ? $material['satuan'] : '' }}</td>
                            <td class="text-right">
                                @php $itemName = strtolower(trim($material['item'] ?? '')); @endphp
                                @if (in_array($itemName, ['ppn', 'diskon', 'ongkir']))
                                    {{-- kosong --}}
                                @else
                                    Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="text-right">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                        </tr>
                        @php $isFirst = false; @endphp
                        @if ($materialIndex === $materialCount)
                            <tr class="highlightTotal">
                                <td colspan="10" style="text-align:center;">Total: Rp
                                    {{ number_format($subtotalMr, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center">-</td>
                </tr>
            @endif
            <tr class="highlight">
                <td colspan="9" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalEntertaiment, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>



    {{-- VIII. Pengeluaran Tukang --}}
    <div class="section-title">VIII. PENGELUARAN TUKANG</div>
    @php
        $hasApprovedTukang = false;
        foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang ?? [] as $section) {
            $approvedTermins = array_filter($section['termin'] ?? [], function ($termin) {
                return isset($termin['status']) && $termin['status'] === 'Disetujui';
            });
            if (!empty($approvedTermins)) {
                $hasApprovedTukang = true;
                break;
            }
        }
    @endphp

    @if ($hasApprovedTukang)
        @foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang ?? [] as $section)
            @php
                // Filter hanya termin dengan status Disetujui
                $approvedTermins = array_filter($section['termin'] ?? [], function ($termin) {
                    return isset($termin['status']) && $termin['status'] === 'Disetujui';
                });

                // Skip section jika tidak ada termin yang disetujui
                if (empty($approvedTermins)) {
                    continue;
                }

                $debet = is_numeric($section['debet'] ?? null)
                    ? $section['debet']
                    : (int) preg_replace('/[^0-9]/', '', $section['debet'] ?? 0);
                $rowspan = count($approvedTermins);
            @endphp
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Progress (%)</th>
                        <th>Status</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotalTukang = 0; @endphp
                    @foreach ($approvedTermins as $terminIndex => $termin)
                        @php
                            $kredit = is_numeric($termin['kredit'] ?? null)
                                ? $termin['kredit']
                                : (int) preg_replace('/[^0-9]/', '', $termin['kredit'] ?? 0);
                            $sisa = is_numeric($termin['sisa'] ?? null)
                                ? $termin['sisa']
                                : (int) preg_replace('/[^0-9]/', '', $termin['sisa'] ?? 0);
                            $subtotalTukang += $kredit;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $termin['tanggal'] ?? '-' }}</td>
                            <td class="text-center">Termin {{ $terminIndex + 1 }}</td>
                            <td class="text-center">{{ $termin['persentase'] ?? '-' }}</td>
                            <td class="text-center">{{ $termin['status'] ?? 'Disetujui' }}</td>
                            @if ($terminIndex == 0)
                                <td class="text-right" rowspan="{{ $rowspan }}">
                                    <table>
                                        <tr>
                                            <td class="table-none" style="width: 50%;">
                                                Rp
                                            </td>
                                            <td class="table-none" style="width: 50%; text-align: right;">
                                                {{ number_format($debet, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            @endif
                            @if ($terminIndex != 0)
                                <!-- Kolom debet kosong di baris berikutnya -->
                            @endif
                            <td class="text-right">
                                <table>
                                    <tr>
                                        <td class="table-none" style="width: 50%;">Rp</td>
                                        <td class="table-none" style="width: 50%; text-align: right;">
                                            {{ number_format($kredit, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="text-right">
                                <table>
                                    <tr>
                                        <td class="table-none" style="width: 50%;">Rp</td>
                                        <td class="table-none" style="width: 50%; text-align: right;">
                                            {{ number_format($sisa, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="highlight">
                        <td colspan="5" class="text-right">SUB TOTAL</td>
                        <td class="text-right">
                            <table>
                                <tr>
                                    <td class="table-none" style="width: 50%;">Rp</td>
                                    <td class="table-none" style="width: 50%; text-align: right;">
                                        {{ number_format($subtotalTukang, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Item</th>
                    <th>Progress (%)</th>
                    <th>Status</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Sisa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center">-</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- IX. Kerja Tambah --}}
    <div class="section-title">IX. KERJA TAMBAH</div>
    @php
        $hasApprovedKerjaTambah = false;
        foreach ($rancanganAnggaranBiaya->json_kerja_tambah ?? [] as $section) {
            $approvedTermins = array_filter($section['termin'] ?? [], function ($termin) {
                return isset($termin['status']) && $termin['status'] === 'Disetujui';
            });
            if (!empty($approvedTermins)) {
                $hasApprovedKerjaTambah = true;
                break;
            }
        }
    @endphp

    @if ($hasApprovedKerjaTambah)
        @foreach ($rancanganAnggaranBiaya->json_kerja_tambah ?? [] as $section)
            @php
                // Filter hanya termin dengan status Disetujui
                $approvedTermins = array_filter($section['termin'] ?? [], function ($termin) {
                    return isset($termin['status']) && $termin['status'] === 'Disetujui';
                });

                // Skip section jika tidak ada termin yang disetujui
                if (empty($approvedTermins)) {
                    continue;
                }

                $debet = is_numeric($section['debet'] ?? null)
                    ? $section['debet']
                    : (int) preg_replace('/[^0-9]/', '', $section['debet'] ?? 0);
                $rowspan = count($approvedTermins);
            @endphp
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Progress (%)</th>
                        <th>Status</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotalKerjaTambah = 0; @endphp
                    @foreach ($approvedTermins as $terminIndex => $termin)
                        @php
                            $kredit = is_numeric($termin['kredit'] ?? null)
                                ? $termin['kredit']
                                : (int) preg_replace('/[^0-9]/', '', $termin['kredit'] ?? 0);
                            $sisa = is_numeric($termin['sisa'] ?? null)
                                ? $termin['sisa']
                                : (int) preg_replace('/[^0-9]/', '', $termin['sisa'] ?? 0);
                            $subtotalKerjaTambah += $kredit;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $termin['tanggal'] ?? '-' }}</td>
                            <td class="text-center">{{ $section['item'] ?? '-' }}</td>
                            <td class="text-center">{{ $termin['persentase'] ?? '-' }}</td>
                            <td class="text-center">{{ $termin['status'] ?? 'Disetujui' }}</td>
                            @if ($terminIndex == 0)
                                <td class="text-right" rowspan="{{ $rowspan }}">
                                    <table>
                                        <tr>
                                            <td class="table-none" style="width: 50%;">Rp</td>
                                            <td class="table-none" style="width: 50%; text-align: right;">
                                                {{ number_format($debet, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </td>
                            @endif
                            @if ($terminIndex != 0)
                                <!-- Kolom debet kosong di baris berikutnya -->
                            @endif
                            <td class="text-right">
                                <table>
                                    <tr>
                                        <td class="table-none" style="width: 50%;">Rp</td>
                                        <td class="table-none" style="width: 50%; text-align: right;">
                                            {{ number_format($kredit, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="text-right">
                                <table>
                                    <tr>
                                        <td class="table-none" style="width: 50%;">Rp</td>
                                        <td class="table-none" style="width: 50%; text-align: right;">
                                            {{ number_format($sisa, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="highlight">
                        <td colspan="5" class="text-right">SUB TOTAL</td>
                        <td class="text-right">
                            <table>
                                <tr>
                                    <td class="table-none" style="width: 50%;">Rp</td>
                                    <td class="table-none" style="width: 50%; text-align: right;">
                                        {{ number_format($subtotalKerjaTambah, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Item</th>
                    <th>Progress (%)</th>
                    <th>Status</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Sisa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center">-</td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- Sisa Anggaran --}}
    @php
        // Hitung total tukang dari kredit - hanya yang status Disetujui
        $totalTukangDebet = 0;
        foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang ?? [] as $section) {
            if (isset($section['termin']) && is_array($section['termin'])) {
                foreach ($section['termin'] as $termin) {
                    // Hanya hitung kredit dari termin yang statusnya Disetujui
                    if (($termin['status'] ?? '') === 'Disetujui') {
                        $kredit = is_numeric($termin['kredit'] ?? null)
                            ? $termin['kredit']
                            : (int) preg_replace('/[^0-9]/', '', $termin['kredit'] ?? 0);
                        $totalTukangDebet += $kredit;
                    }
                }
            }
        }

        // Hitung total kerja tambah dari kredit - hanya yang status Disetujui
        $totalKerjaTambahDebet = 0;
        foreach ($rancanganAnggaranBiaya->json_kerja_tambah ?? [] as $section) {
            if (isset($section['termin']) && is_array($section['termin'])) {
                foreach ($section['termin'] as $termin) {
                    // Hanya hitung kredit dari termin yang statusnya Disetujui
                    if (($termin['status'] ?? '') === 'Disetujui') {
                        $kredit = is_numeric($termin['kredit'] ?? null)
                            ? $termin['kredit']
                            : (int) preg_replace('/[^0-9]/', '', $termin['kredit'] ?? 0);
                        $totalKerjaTambahDebet += $kredit;
                    }
                }
            }
        }

        // SECTION 1: TOTAL MATERIAL PENDUKUNG - PENGELUARAN MATERIAL PENDUKUNG - PENGELUARAN MATERIAL TAMBAHAN
        $totalMaterialPendukung = $totalSectionMaterialPendukung ?? 0;
        $pengeluaranMaterialPendukung = $totalPendukung ?? 0;
        $pengeluaranMaterialTambahan = $totalTambahan ?? 0;
        $sisaAnggaranSection1 = $totalMaterialPendukung - $pengeluaranMaterialPendukung - $pengeluaranMaterialTambahan;

        // SECTION 2: TOTAL PENGELUARAN PEMASANGAN - HARGA TUKANG - PENGELUARAN ENTERTAIMENT
        $totalPengeluaranPemasangan = $totalPemasangan ?? 0;
        // Harga Tukang - hanya yang status Disetujui
        $hargaTukang = 0;
        if ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang) {
            foreach ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang as $item) {
                // Hanya hitung yang statusnya Disetujui
                if (($item['status'] ?? '') === 'Disetujui') {
                    $hargaTukang += (float) preg_replace('/[^\d]/', '', $item['total_harga'] ?? 0);
                }
            }
        }
        $pengeluaranEntertainment = $totalEntertaiment ?? 0;
        // Pengeluaran Kerja Tambah - hanya termin yang status Disetujui
        $pengeluaranKerjaTambah = 0;
        if ($rancanganAnggaranBiaya->json_kerja_tambah) {
            foreach ($rancanganAnggaranBiaya->json_kerja_tambah as $section) {
                if (isset($section['termin']) && is_array($section['termin'])) {
                    foreach ($section['termin'] as $termin) {
                        // Hanya hitung kredit dari termin yang statusnya Disetujui
                        if (($termin['status'] ?? '') === 'Disetujui') {
                            $pengeluaranKerjaTambah += (float) preg_replace('/[^\d]/', '', $termin['kredit'] ?? 0);
                        }
                    }
                }
            }
        }
        $sisaAnggaranSection2 = $totalPengeluaranPemasangan - $hargaTukang - $pengeluaranEntertainment - $pengeluaranKerjaTambah;

        // Total Sisa Anggaran
        $totalSisaAnggaran = $sisaAnggaranSection1 + $sisaAnggaranSection2;

        // Nilai Kontrak (Material + Pemasangan)
        $materialUtama = $totalUtama ?? 0;
        $materialPemasangan = $totalPendukung ?? 0;
        $materialTambahan = $totalTambahan ?? 0;
        $biayaEntertaint = $totalEntertaiment ?? 0;
        $biayaTukang = $totalTukangDebet ?? 0;
        $kerjaTambah = $totalKerjaTambahDebet ?? 0;
        $totalNilaiKontrak = $totalUtama + ($rancanganAnggaranBiaya->pemasangan->grand_total ?? 0);
        $totalPengeluaran =
            $materialUtama +
            $materialPemasangan +
            $materialTambahan +
            $biayaEntertaint +
            $biayaTukang +
            $kerjaTambah;
        $sisa = $totalNilaiKontrak - $totalPengeluaran;

        // Nilai Kontrak (Pemasangan Saja) - FIX sesuai permintaan user
        $nilaiKontrakPemasanganFix = $rancanganAnggaranBiaya->pemasangan->grand_total ?? 0;
        $totalPengeluaranPemasanganFix =
            $materialPemasangan + $materialTambahan + $biayaEntertaint + $biayaTukang + $kerjaTambah;
        $sisaPemasanganFix = $nilaiKontrakPemasanganFix - $totalPengeluaranPemasanganFix;
    @endphp
    <div class="section-title grand-total">SISA ANGGARAN : Rp {{ number_format($totalSisaAnggaran, 0, ',', '.') }}</div>

    {{-- REKAPITULASI KONTRAK (MATERIAL + PEMASANGAN & PEMASANGAN SAJA) --}}
    <div style="page-break-before: always;"></div>

    <div class="header" style="font-size: 12px !important;">
        <h3 style="padding-left: 5px;">WPC MAKMUR ABADI</h3>
        <table class="header-table">
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Proyek</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->proyek }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Pekerjaan</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->pekerjaan }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Kontraktor</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->kontraktor }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Lokasi</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">{{ $rancanganAnggaranBiaya->lokasi }}</td>
            </tr>
        </table>
    </div>
    @php
        $penawaran = $rancanganAnggaranBiaya->penawaran;
        // Gunakan grand_total dari penawaran karena sudah termasuk:
        // - Produk utama (setelah diskon)
        // - Additional condition (tidak kena diskon)
        // - PPN
        $totalUtama = $penawaran->grand_total ?? 0;
    @endphp
    <div class="header" style="font-size: 12px !important;">
        <table class="header-table">
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Harga Material</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">Rp {{ number_format($totalUtama, 0, ',', '.') }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Harga Pemasangan</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">Rp
                    {{ number_format($rancanganAnggaranBiaya->pemasangan->grand_total ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="no-border">
                <td class="no-border" style="width: 20%;">Total Nilai Kontrak</td>
                <td class="no-border" style="width: 10px;">:</td>
                <td class="no-border" style="width: 70%;">Rp
                    {{ number_format($totalUtama + ($rancanganAnggaranBiaya->pemasangan->grand_total ?? 0), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 30px; margin-bottom: 10px;">
        <div
            style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 6px 6px; font-weight: bold; font-size: 12px; letter-spacing: 1px; background-color: #567CBA; color:white;">
            SISA ANGGARAN</div>
        <table style="width: 100%; font-size: 13px; margin-bottom: 10px;">
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr>
                <td class="no-border" style="width:60%; font-weight: bold; background-color: #e3e9f7; padding: 6px;">RINCIAN MATERIAL</td>
                <td style="width:2%" class="no-border"></td>
                <td class="no-border"></td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 6px;"></td>
            </tr>
            <tr>
                <td class="no-border" style="width:60%;">Total Material Pendukung</td>
                <td style="width:2%" class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($totalMaterialPendukung, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">Pengeluaran Material Pendukung</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">- Rp {{ number_format($pengeluaranMaterialPendukung, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">Pengeluaran Material Tambahan</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">- Rp {{ number_format($pengeluaranMaterialTambahan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 6px;"></td>
            </tr>
            <tr style="font-weight:bold;">
                <td colspan="2" class="no-border">Sisa Anggaran Material</td>
                <td class="text-right no-border">Rp {{ number_format($sisaAnggaranSection1, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr>
                <td class="no-border" style="width:60%; font-weight: bold; background-color: #e3e9f7; padding: 6px;">RINCIAN PEMASANGAN</td>
                <td style="width:2%" class="no-border"></td>
                <td class="no-border"></td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 6px;"></td>
            </tr>
            <tr>
                <td class="no-border" style="width:60%;">Total Pengeluaran Pemasangan</td>
                <td style="width:2%" class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($totalPengeluaranPemasangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">Harga Tukang</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">- Rp {{ number_format($hargaTukang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">Pengeluaran Kerja Tambah</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">- Rp {{ number_format($pengeluaranKerjaTambah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">Pengeluaran Non Material</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">- Rp {{ number_format($pengeluaranEntertainment, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 6px;"></td>
            </tr>
            <tr style="font-weight:bold;">
                <td colspan="2" class="no-border">Sisa Anggaran Pemasangan</td>
                <td class="text-right no-border">Rp {{ number_format($sisaAnggaranSection2, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr style="font-weight:bold; background-color: #f2f2f2;">
                <td colspan="2" class="no-border">TOTAL SISA ANGGARAN</td>
                <td class="text-right no-border">Rp {{ number_format($totalSisaAnggaran, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
