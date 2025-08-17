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
        $total = $penawaran->total ?? 0;
        $total_diskon = ($penawaran->total_diskon ?? 0) > 0 ? $penawaran->total_diskon : 0;
        $total_diskon_1 = ($penawaran->total_diskon_1 ?? 0) > 0 ? $penawaran->total_diskon_1 : 0;
        $total_diskon_2 = ($penawaran->total_diskon_2 ?? 0) > 0 ? $penawaran->total_diskon_2 : 0;
        $totalUtama = $total - $total_diskon - $total_diskon_1 - $total_diskon_2;
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

    {{-- II. Pengeluaran Material Pendukung --}}
    <div class="section-title">II. PENGELUARAN MATERIAL PENDUKUNG</div>
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

    {{-- III. Pengeluaran Entertaiment --}}
    <div class="section-title">III. PENGELUARAN ENTERTAIMENT</div>
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

    {{-- IV. Pengeluaran Akomodasi --}}
    <div class="section-title">IV. PENGELUARAN AKOMODASI</div>
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
                $totalAkomodasi = 0;
                $lastMr = null;
                function formatTanggalIndo3($tgl)
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
            @foreach ($rancanganAnggaranBiaya->json_pengeluaran_akomodasi ?? [] as $mrGroup)
                @php
                    $isFirst = true;
                    $subtotalMr = 0;
                    $materialCount = count($mrGroup['materials'] ?? []);
                    $materialIndex = 0;
                @endphp
                @foreach ($mrGroup['materials'] ?? [] as $material)
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
                            $totalAkomodasi -= $subTotal;
                            $subtotalMr -= $subTotal;
                        } else {
                            $totalAkomodasi += $subTotal;
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
                                {{ !empty($mrGroup['tanggal']) ? formatTanggalIndo3($mrGroup['tanggal']) : '' }}
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
            <tr class="highlight">
                <td colspan="9" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalAkomodasi, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- V. Pengeluaran Lainnya --}}
    <div class="section-title">V. PENGELUARAN LAINNYA</div>
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
                $totalLainnya = 0;
                $lastMr = null;
                function formatTanggalIndo4($tgl)
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
            @foreach ($rancanganAnggaranBiaya->json_pengeluaran_lainnya ?? [] as $mrGroup)
                @php
                    $isFirst = true;
                    $subtotalMr = 0;
                    $materialCount = count($mrGroup['materials'] ?? []);
                    $materialIndex = 0;
                @endphp
                @foreach ($mrGroup['materials'] ?? [] as $material)
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
                            $totalLainnya -= $subTotal;
                            $subtotalMr -= $subTotal;
                        } else {
                            $totalLainnya += $subTotal;
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
                                {{ !empty($mrGroup['tanggal']) ? formatTanggalIndo4($mrGroup['tanggal']) : '' }}
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
            <tr class="highlight">
                <td colspan="9" class="text-right">GRAND TOTAL</td>
                <td class="text-right">Rp {{ number_format($totalLainnya, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- VI. Pengeluaran Tukang --}}
    <div class="section-title">VI. PENGELUARAN TUKANG</div>
    @foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang ?? [] as $section)
        @php
            $debet = is_numeric($section['debet'] ?? null)
                ? $section['debet']
                : (int) preg_replace('/[^0-9]/', '', $section['debet'] ?? 0);
            $rowspan = count($section['termin'] ?? []);
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Item</th>
                    <th>Progress (%)</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Sisa</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotalTukang = 0; @endphp
                @foreach ($section['termin'] ?? [] as $terminIndex => $termin)
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
                    <td colspan="4" class="text-right">SUB TOTAL</td>
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

    {{-- VII. Kerja Tambah --}}
    <div class="section-title">VII. KERJA TAMBAH</div>
    @foreach ($rancanganAnggaranBiaya->json_kerja_tambah ?? [] as $section)
        @php
            $debet = is_numeric($section['debet'] ?? null)
                ? $section['debet']
                : (int) preg_replace('/[^0-9]/', '', $section['debet'] ?? 0);
            $rowspan = count($section['termin'] ?? []);
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Item</th>
                    <th>Progress (%)</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                    <th>Sisa</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotalKerjaTambah = 0; @endphp
                @foreach ($section['termin'] ?? [] as $terminIndex => $termin)
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
                    <td colspan="4" class="text-right">SUB TOTAL</td>
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

    {{-- Grand Total --}}
    @php
        $grandTotal = 0;
        $grandTotal += $totalUtama;
        $grandTotal += $totalPendukung;
        $grandTotal += $totalEntertaiment;
        $grandTotal += $totalAkomodasi;
        $grandTotal += $totalLainnya;

        // Hitung total tukang dari debet (bukan dari kredit)
        $totalTukangDebet = 0;
        foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang ?? [] as $section) {
            $debet = is_numeric($section['debet'] ?? null)
                ? $section['debet']
                : (int) preg_replace('/[^0-9]/', '', $section['debet'] ?? 0);
            $totalTukangDebet += $debet;
        }
        $grandTotal += $totalTukangDebet;

        // Hitung total kerja tambah dari debet (bukan dari kredit)
        $totalKerjaTambahDebet = 0;
        foreach ($rancanganAnggaranBiaya->json_kerja_tambah ?? [] as $section) {
            $debet = is_numeric($section['debet'] ?? null)
                ? $section['debet']
                : (int) preg_replace('/[^0-9]/', '', $section['debet'] ?? 0);
            $totalKerjaTambahDebet += $debet;
        }
        $grandTotal += $totalKerjaTambahDebet;
    @endphp
    @php
        // Nilai Kontrak (Material + Pemasangan)
        $materialUtama = $totalUtama ?? 0;
        $materialPemasangan = $totalPendukung ?? 0;
        $biayaEntertaint = $totalEntertaiment ?? 0;
        $biayaAkomodasi = $totalAkomodasi ?? 0;
        $biayaLainLain = $totalLainnya ?? 0;
        $biayaTukang = $totalTukangDebet ?? 0;
        $kerjaTambah = $totalKerjaTambahDebet ?? 0;
        $totalNilaiKontrak = $totalUtama + ($rancanganAnggaranBiaya->pemasangan->grand_total ?? 0);
        $totalPengeluaran =
            $materialUtama +
            $materialPemasangan +
            $biayaEntertaint +
            $biayaAkomodasi +
            $biayaLainLain +
            $biayaTukang +
            $kerjaTambah;
        $sisa = $totalNilaiKontrak - $totalPengeluaran;

        // Nilai Kontrak (Pemasangan Saja) - FIX sesuai permintaan user
        $nilaiKontrakPemasanganFix = $rancanganAnggaranBiaya->pemasangan->grand_total ?? 0;
        $totalPengeluaranPemasangan =
            $materialPemasangan + $biayaEntertaint + $biayaAkomodasi + $biayaLainLain + $biayaTukang + $kerjaTambah;
        $sisaPemasanganFix = $nilaiKontrakPemasanganFix - $totalPengeluaranPemasangan;
    @endphp
    <div class="section-title grand-total">GRAND TOTAL : Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>

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
        $total = $penawaran->total ?? 0;
        $total_diskon = ($penawaran->total_diskon ?? 0) > 0 ? $penawaran->total_diskon : 0;
        $total_diskon_1 = ($penawaran->total_diskon_1 ?? 0) > 0 ? $penawaran->total_diskon_1 : 0;
        $total_diskon_2 = ($penawaran->total_diskon_2 ?? 0) > 0 ? $penawaran->total_diskon_2 : 0;
        $totalUtama = $total - $total_diskon - $total_diskon_1 - $total_diskon_2;
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
            NILAI KONTRAK (MATERIAL + PEMASANGAN)</div>
        <table style="width: 100%; font-size: 13px; margin-bottom: 10px;">
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr>
                <td class="no-border" style="width:60%;">NILAI KONTRAK</td>
                <td style="width:2%" class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr>
                <td class="no-border">MATERIAL UTAMA</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($materialUtama, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">MATERIAL PEMASANGAN</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($materialPemasangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA ENTERTAINT</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaEntertaint, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA AKOMODASI</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaAkomodasi, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA LAIN-LAIN</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaLainLain, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA TUKANG</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaTukang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">KERJA TAMBAH</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($kerjaTambah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr style="font-weight:bold;">
                <td colspan="2" class="no-border">SISA</td>
                <td class="text-right no-border">Rp {{ number_format($sisa, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 30px; margin-bottom: 10px;">
        <div
            style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 6px 6px; font-weight: bold; font-size: 12px; letter-spacing: 1px; background-color: #567CBA; color:white;">
            NILAI KONTRAK (PEMASANGAN)</div>
        <table style="width: 100%; font-size: 13px; margin-bottom: 10px;">
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr>
                <td class="no-border" style="width:60%">NILAI KONTRAK</td>
                <td style="width:2%" class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($nilaiKontrakPemasanganFix, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr>
                <td class="no-border">MATERIAL PEMASANGAN</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($materialPemasangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA ENTERTAINT</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaEntertaint, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA AKOMODASI</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaAkomodasi, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA LAIN-LAIN</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaLainLain, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">BIAYA TUKANG</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($biayaTukang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border">KERJA TAMBAH</td>
                <td class="no-border">:</td>
                <td class="text-right no-border">Rp {{ number_format($kerjaTambah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="no-border" style="padding: 12px;"></td>
                <td class="no-border" style="padding: 12px;"></td>
            </tr>
            <tr style="font-weight:bold;">
                <td colspan="2" class="no-border">SISA</td>
                <td class="text-right no-border">Rp {{ number_format($sisaPemasanganFix, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
