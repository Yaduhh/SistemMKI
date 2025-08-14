<!DOCTYPE html>
<html>

<head>
    <title>{{ $penawaran->judul_penawaran }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
            line-height: 1.2;
        }

        p {
            margin: 4px 0;
            line-height: 1.2;
        }

        h1, h3 {
            margin: 0px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 5px;
            border: 1px solid #000000;
            text-align: center;
            font-size: 9px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .company-info {
            text-align: right;
            margin-bottom: 20px;
        }

        .recipient-info {
            margin-bottom: 20px;
        }

        .subject-info {
            margin-bottom: 20px;
        }

        .product-title {
            background-color: #567CBA;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            margin: 15px 0 10px 0;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .currency-table {
            width: 100%;
            border: none;
        }

        .currency-table td {
            border: none;
            padding: 0;
            text-align: right;
        }

        .summary-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .grand-total {
            background-color: #567CBA;
            color: white;
            font-weight: bold;
        }

        .terms-section {
            margin-top: 20px;
        }

        .footer-section {
            margin-top: 30px;
        }

        .signature-section {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="company-info">
            <img src="{{ public_path('assets/images/logomki.png') }}" alt="Logo" width="200" style="float: right;">
            <h1 style="margin: 0; font-size: 18px; font-weight: bold;">MEGA KOMPOSIT</h1>
        </div>
        
        <div style="clear: both; margin-top: 10px;">
            <p><strong>No:</strong> {{ $penawaran->nomor_penawaran }}</p>
            <p><strong>Tgl:</strong> {{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('d-M-y') : 'Belum ditentukan' }}</p>
        </div>
    </div>

    <!-- Recipient Section -->
    <div class="recipient-info">
        <p><strong>Kepada Yth,</strong></p>
        <p><strong>{{ $penawaran->client->nama_perusahaan ?? $penawaran->client->nama ?? 'Nama client tidak ditemukan' }}</strong></p>
        <p>{{ $penawaran->client->alamat ?? 'Alamat tidak tersedia' }}</p>
        <p>Di tempat</p>
    </div>

    <!-- Subject Section -->
    <div class="subject-info">
        <p><strong>Hal:</strong> {{ $penawaran->judul_penawaran }}</p>
    </div>

    <!-- Greeting -->
    <div>
        <p><strong>Dengan hormat,</strong></p>
        <p>Bersama ini kami sampaikan penawaran harga produk Pintu WPC, sebagai berikut:</p>
    </div>

    <!-- Product Title -->
    <div class="product-title">
        PINTU WPC + KUSEN MKK-B
    </div>

    <!-- Product Table -->
    <table>
        <thead>
            <tr>
                <th width="3%">NO</th>
                <th width="15%">ITEM</th>
                <th width="10%">TYPE</th>
                <th width="8%">DIMENSI</th>
                <th width="8%">WARNA</th>
                <th width="12%">HARGA SATUAN</th>
                <th width="5%">DISC</th>
                <th width="12%">HARGA NETT SATUAN</th>
                <th width="12%">HARGA NETT (/unit)</th>
                <th width="5%">QTY (unit)</th>
                <th width="12%">TOTAL HARGA</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>
                    <table style="width: 100%; border: none;">
                        <tr>
                            <th style="border: none; padding: 2px;">LEBAR</th>
                        </tr>
                        <tr>
                            <th style="border: none; padding: 2px;">TEBAL</th>
                        </tr>
                        <tr>
                            <th style="border: none; padding: 2px;">TINGGI</th>
                        </tr>
                    </table>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $totalKeseluruhan = 0;
                $totalQty = 0;
            @endphp

            {{-- Produk Pintu Section --}}
            @if (is_array($json_penawaran_pintu) && count($json_penawaran_pintu) > 0)
                @foreach ($json_penawaran_pintu as $pintuIndex => $pintuItem)
                    @php
                        // Ambil data pintu dari database berdasarkan slug
                        $pintuData = null;
                        if (isset($pintuItem['item'])) {
                            $pintuData = \App\Models\Pintu::where('slug', $pintuItem['item'])->first();
                        }
                        
                        $totalHargaPintu = isset($pintuItem['harga']) && isset($pintuItem['jumlah']) ? ($pintuItem['harga'] * $pintuItem['jumlah']) : 0;
                        $totalKeseluruhan += $totalHargaPintu;
                        $totalQty += isset($pintuItem['jumlah']) ? (int) $pintuItem['jumlah'] : 0;
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="text-left">{{ $pintuData ? $pintuData->nama_produk : ($pintuItem['item'] ?? '-') }}</td>
                        <td>{{ $pintuData ? $pintuData->code : '-' }}</td>
                        <td>
                            <table style="width: 100%; border: none;">
                                <tr>
                                    <td style="border: none; padding: 1px;">{{ $pintuData ? $pintuData->lebar . ' cm' : '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 1px;">{{ $pintuData ? $pintuData->tebal . ' cm' : '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 1px;">{{ $pintuData ? $pintuData->tinggi . ' cm' : '-' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td>{{ $pintuData ? $pintuData->warna : '-' }}</td>
                        <td class="text-right">
                            <table class="currency-table">
                                <tr>
                                    <td>Rp</td>
                                    <td>{{ isset($pintuItem['harga']) ? number_format($pintuItem['harga'], 0, ',', '.') : '-' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td>-</td>
                        <td class="text-right">
                            <table class="currency-table">
                                <tr>
                                    <td>Rp</td>
                                    <td>{{ isset($pintuItem['harga']) ? number_format($pintuItem['harga'], 0, ',', '.') : '-' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="text-right">
                            <table class="currency-table">
                                <tr>
                                    <td>Rp</td>
                                    <td>{{ isset($pintuItem['harga']) ? number_format($pintuItem['harga'], 0, ',', '.') : '-' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td>{{ $pintuItem['jumlah'] ?? '-' }}</td>
                        <td class="text-right">
                            <table class="currency-table">
                                <tr>
                                    <td>Rp</td>
                                    <td>{{ number_format($totalHargaPintu, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endif

            {{-- Summary Section --}}
            <tr class="summary-row">
                <td colspan="9" class="text-right"><strong>QTY (unit)</strong></td>
                <td><strong>{{ $totalQty }}</strong></td>
                <td></td>
            </tr>
            <tr class="summary-row">
                <td colspan="9" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right">
                    <table class="currency-table">
                        <tr>
                            <td>Rp</td>
                            <td>{{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
                <td></td>
            </tr>
            @if (($penawaran->ppn ?? 0) > 0)
                <tr class="summary-row">
                    <td colspan="9" class="text-right"><strong>PPN {{ $penawaran->ppn }}%</strong></td>
                    <td class="text-right">
                        <table class="currency-table">
                            <tr>
                                <td>Rp</td>
                                <td>{{ number_format(($totalKeseluruhan * ($penawaran->ppn ?? 0)) / 100, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
            @endif
            <tr class="grand-total">
                <td colspan="9" class="text-right"><strong>GRAND TOTAL</strong></td>
                <td class="text-right">
                    <table class="currency-table">
                        <tr>
                            <td style="color: white; font-weight: bold;">Rp</td>
                            <td style="color: white; font-weight: bold;">{{ number_format($totalKeseluruhan + (($totalKeseluruhan * ($penawaran->ppn ?? 0)) / 100), 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Terms & Conditions Section -->
    @if (is_array($syarat_kondisi) && count($syarat_kondisi) > 0)
        <div class="terms-section">
            <p><strong>Syarat & Kondisi:</strong></p>
            <ul style="margin-top: 5px; padding-left: 20px;">
                @foreach ($syarat_kondisi as $syarat)
                    <li style="margin-bottom: 3px;">{{ $syarat }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Notes Section -->
    @if ($penawaran->catatan)
        <div class="terms-section">
            <p><strong>Catatan:</strong></p>
            <p style="margin-top: 5px;">{{ $penawaran->catatan }}</p>
        </div>
    @endif

    <!-- Footer Section -->
    <div class="footer-section">
        <p>Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%; vertical-align: top;">
                    <p style="margin-bottom: 60px;">Hormat kami,</p>
                    <p style="margin-top: 40px;">{{ $penawaran->user->name ?? 'Sales' }}</p>
                </td>
                <td style="width: 70%; vertical-align: bottom; text-align: right;">
                    <div>
                        <p><strong>PT. MEGA KOMPOSIT INDONESIA</strong></p>
                        <p style="margin-top: 5px;">
                            Ruko Boulevard Tekno E. 1 No 21<br>
                            Jl. Tekno Widya, Setu, Tangerang Selatan, Banten 15114 Indonesia<br>
                            Email: megakomposit.indonesia@gmail.com<br>
                            Website: www.megakomposit.com
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
