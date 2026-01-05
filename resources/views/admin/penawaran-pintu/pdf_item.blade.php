<!DOCTYPE html>
<html>

<head>
    <title>{{ $penawaran->judul_penawaran }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        p {
            margin: 4px 0;
            line-height: 1;
        }

        h1,
        h3 {
            margin: 0px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        th,
        .table-style {
            padding: 5px;
            border: 1px solid #000000;
        }

        .table-style-grand-total {
            padding: 5px;
            border: 1px solid #000000;
            background-color: #567CBA;
            color: white;
        }

        .table-none {
            padding: 5px;
            border: 0px solid #000000;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        div {
            margin-bottom: 10px;
        }

        .title-produk {
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 0px;
            background-color: #577dbb;
            padding: 5px;
            text-transform: uppercase;
            color: white;
        }

        .text-right {
            text-align: right;
        }

        .grid-content {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: center;
        }

        .w-100 {
            width: 100%;
        }
    </style>

</head>

<body>
    <div style="position: relative; z-index: 0; width: 100%;">
        <div style="position: absolute; top: 0; right: 0; z-index: 1;">
            <img src="{{ public_path('assets/images/logoMki.png') }}" alt="Logo Perusahaan" width="250">
        </div>
    </div>
    <div>
        <p>
            No {{ ' ' }}: {{ $penawaran->nomor_penawaran }} <br>
            Tgl:
            @if ($penawaran->updated_at)
                @php
                    $bulanIndonesia = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ];
                    $tanggal = $penawaran->updated_at;
                    $bulan = $bulanIndonesia[$tanggal->month];
                    echo $tanggal->day . '-' . $bulan . '-' . $tanggal->year;
                @endphp
            @else
                Belum ditentukan
            @endif
        </p>
    </div>

    <div>
        Kepada Yth, <br>
        <b>{{ $penawaran->client->nama_perusahaan ?? ($penawaran->client->nama ?? 'Nama client tidak ditemukan') }}</b><br>
        {{ $penawaran->client->alamat ?? 'Alamat tidak tersedia' }}<br>
    </div>

    <div>
        <p>
            Up: {{ $penawaran->client->nama ?? 'Contact Person' }}<br>
            Hal : {{ $penawaran->judul_penawaran ?? 'Penawaran Harga Pintu WPC' }}<br>
        </p>
    </div>
    <div>
        <p>
            Dengan Hormat,
        </p>
        <p style="margin-bottom: 10px; padding: 0;">Bersama ini kami sampaikan penawaran harga produk Pintu WPC, sebagai
            berikut :
        </p>
    </div>

    @if (is_array($json_penawaran_pintu) && count($json_penawaran_pintu) > 0)
        @php
            $no = 1;
            $totalKeseluruhan = 0;
            $totalQty = 0;
            $totalHargaNettSatuan = 0;

            // Hitung total harga nett satuan terlebih dahulu
            foreach ($json_penawaran_pintu as $sectionIndex => $section) {
                if (strpos($sectionIndex, 'section_') === 0 && isset($section['products'])) {
                    foreach ($section['products'] as $product) {
                        $totalHargaNettSatuan += isset($product['harga']) ? (float) $product['harga'] : 0;
                    }
                }
            }
        @endphp

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th rowspan="2" width="3%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        NO</th>
                    <th rowspan="2" width="25%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        ITEM</th>
                    <th rowspan="2" width="10%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        TYPE</th>
                    <th colspan="3" width="8%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        DIMENSI</th>
                    <th rowspan="2" width="8%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        WARNA</th>
                    <th rowspan="2" width="12%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        HARGA SATUAN</th>
                    <th rowspan="2" width="5%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        DISC</th>
                    <th rowspan="2" width="15%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        HARGA NETT SATUAN</th>
                    <th rowspan="2" width="15%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        HARGA NETT (/unit)</th>
                    <th rowspan="2" width="5%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        QTY (unit)</th>
                    <th rowspan="2" width="100%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        TOTAL HARGA</th>
                </tr>
                <tr>
                    <th width="8%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        LEBAR</th>
                    <th width="8%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        TEBAL</th>
                    <th width="8%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        TINGGI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($json_penawaran_pintu as $sectionIndex => $section)
                    @if (strpos($sectionIndex, 'section_') === 0)
                        {{-- Section Header --}}
                        @if (!empty($section['judul_1']))
                            <tr>
                                <td colspan="3"
                                    style="padding: 5px; font-weight: bold; border: 1px solid #000000; text-align: left;">
                                    {{ $section['judul_1'] }}
                                </td>
                                <td colspan="10"
                                    style="padding: 5px; font-weight: bold; border: 1px solid #000000; text-align: left;">
                                    {{ $section['judul_2'] }}
                                </td>
                            </tr>
                        @endif

                        {{-- Products in Section --}}
                        @if (isset($section['products']) && is_array($section['products']))
                            @foreach ($section['products'] as $product)
                                @php
                                    $totalHargaProduct = 0;
                                    if (isset($product['total_harga'])) {
                                        // Ambil nilai langsung karena sudah dalam format angka
                                        $totalHargaProduct = (float) $product['total_harga'];
                                    }
                                    $totalKeseluruhan += $totalHargaProduct;
                                    // QTY dihitung per section, bukan per produk
                                    if ($loop->first) {
                                        $totalQty += isset($section['jumlah']) ? (int) $section['jumlah'] : 0;
                                    }

                                    // Hitung total harga nett satuan dan total harga untuk section ini
                                    $sectionHargaNettSatuan = 0;
                                    $sectionTotalHarga = 0;
                                    if (isset($section['products'])) {
                                        foreach ($section['products'] as $sectionProduct) {
                                            $sectionHargaNettSatuan += isset($sectionProduct['total_harga'])
                                                ? (float) $sectionProduct['total_harga']
                                                : 0;
                                            $sectionTotalHarga += isset($sectionProduct['total_harga'])
                                                ? (float) $sectionProduct['total_harga']
                                                : 0;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        {{ $no++ }}</td>
                                    <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        {{ $product['nama_produk'] ?? '-' }}</td>
                                    <td width="25%"
                                        style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        {{ $product['code'] ?? '-' }}</td>
                                    <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        {{ isset($product['lebar']) && (int) $product['lebar'] > 0 ? (int) $product['lebar'] . ' cm' : '-' }}
                                    </td>
                                    <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        {{ isset($product['tebal']) && (int) $product['tebal'] > 0 ? (int) $product['tebal'] . ' cm' : '-' }}
                                    </td>
                                    <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        {{ isset($product['tinggi']) && (int) $product['tinggi'] > 0 ? (int) $product['tinggi'] . ' cm' : '-' }}
                                    </td>
                                    <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        {{ $product['warna'] ?? '-' }}</td>
                                    <td style="padding: 5px; border: 1px solid #000000;">
                                        <table>
                                            <tr>
                                                <td>Rp</td>
                                                <td style="text-align: right;">
                                                    {{ isset($product['harga']) ? number_format($product['harga'], 0, ',', '.') : '-' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                        <table>
                                            <tr>
                                                <td style="text-align: center;">
                                                    {{ isset($product['diskon']) && (int) $product['diskon'] > 0 ? (int) $product['diskon'] . '%' : '-' }}
                                                </td>
                                                @if (isset($product['diskon_satu']) && (int) $product['diskon_satu'] > 0)
                                                    <td style="text-align: right; padding-left: 10px;">
                                                        {{ (int) $product['diskon_satu'] . '%' }}</td>
                                                @endif
                                                @if (isset($product['diskon_dua']) && (int) $product['diskon_dua'] > 0)
                                                    <td style="text-align: right; padding-left: 10px;">
                                                        {{ (int) $product['diskon_dua'] . '%' }}</td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 5px; border: 1px solid #000000;">
                                        <table>
                                            <tr>
                                                <td>Rp</td>
                                                <td style="text-align: right;">
                                                    {{ isset($product['total_harga']) ? number_format($product['total_harga'], 0, ',', '.') : '-' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    @if ($loop->first)
                                        <td style="padding: 5px; border: 1px solid #000000;"
                                            rowspan="{{ count($section['products']) }}">
                                            <table>
                                                <tr>
                                                    <td>Rp</td>
                                                    <td style="text-align: right;">
                                                        <strong>{{ number_format($sectionHargaNettSatuan, 0, ',', '.') }}</strong>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @endif
                                    @if ($loop->first)
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;"
                                            rowspan="{{ count($section['products']) }}">
                                            <table>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <strong>{{ $section['jumlah'] ?? '-' }}</strong>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @endif
                                    @if ($loop->first)
                                        <td style="padding: 5px; border: 1px solid #000000;"
                                            rowspan="{{ count($section['products']) }}">
                                            <table>
                                                <tr>
                                                    <td>Rp</td>
                                                    <td style="text-align: right;">
                                                        <strong>{{ number_format($sectionTotalHarga * $section['jumlah'], 0, ',', '.') }}</strong>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    @endif
                @endforeach

                {{-- Summary rows --}}
                <tr>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                    <td class="table-style" style="text-align: center;"><strong>{{ $totalQty }}</strong></td>
                    <td class="table-style"></td>
                </tr>
                <tr>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td colspan="2" class="table-none text-right"><strong>TOTAL</strong></td>
                    <td class="table-style">
                        <table>
                            <tr>
                                <td>Rp</td>
                                <td style="text-align: right;">{{ number_format($penawaran->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @if (($penawaran->ppn ?? 0) > 0)
                    <tr>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td colspan="2" class="table-none text-right"><strong>PPN {{ $penawaran->ppn }}%</strong>
                        </td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Rp</td>
                                    <td style="text-align: right;">
                                        {{ number_format(($penawaran->total * ($penawaran->ppn ?? 0)) / 100, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td colspan="2" class="table-none-grand-total text-right"><strong>GRAND TOTAL</strong></td>
                    <td class="table-style-grand-total">
                        <table>
                            <tr>
                                <td style="color: white; font-weight: bold;">Rp</td>
                                <td style="text-align: right; color: white; font-weight: bold;">
                                    {{ number_format($penawaran->grand_total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    <!-- Terms & Conditions Section -->
    <div style="margin-top: 20px;">
        <p style="text-decoration: underline;"><strong>Syarat & Kondisi:</strong></p>
        @if (is_array($syarat_kondisi) && count($syarat_kondisi) > 0)
            <ul style="margin-top: 5px; padding-left: 20px;">
                @foreach ($syarat_kondisi as $syarat)
                    <li style="margin-bottom: 3px;">{{ $syarat }}</li>
                @endforeach
            </ul>
        @else
            <ul style="margin-top: 5px; padding-left: 20px;">
                <li style="margin-bottom: 3px;">Harga bisa berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu
                </li>
                <li style="margin-bottom: 3px;">Syarat pembayaran 50% dari total kontrak sebagai uang muka (DP)</li>
                <li style="margin-bottom: 3px;">Harga diatas SUDAH termasuk PPN 11%</li>
                <li style="margin-bottom: 3px;">Harga material tersebut Franco JABODETABEK diatas Truk</li>
                <li style="margin-bottom: 3px;">Pengiriman diluar Area JABODETABEK dikenakan biaya Ekspedisi</li>
                <li style="margin-bottom: 3px;">Produksi 1 bulan setelah PO diterima</li>
                <li style="margin-bottom: 3px;">Harga diatas TIDAK termasuk biaya pemasangan</li>
                <li style="margin-bottom: 3px;">Harga diatas TIDAK termasuk aksesoris Handle Pintu & Silinder Kunci
                </li>
                <li style="margin-bottom: 3px;">Pembayaran ditransfer melalui rekening BCA 288 9696 961 a/n PT. MEGA
                    KOMPOSIT INDONESIA Cab. BCA Puri</li>
                <li style="margin-bottom: 3px;">Seluruh material adalah milik PT. MEGA KOMPOSIT INDONESIA selama pihak
                    Customer belum menyelesaikan pembayaran</li>
            </ul>
        @endif
    </div>

    <!-- Notes Section -->
    @if ($penawaran->catatan)
        <div style="margin-top: 20px;">
            <p><strong>Catatan:</strong></p>
            <p style="margin-top: 5px;">{{ $penawaran->catatan }}</p>
        </div>
    @endif

    <!-- Footer Section -->
    <div style="margin-top: 30px;">
        <p>Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    <!-- Signature Section -->
    <div style="margin-top: 0px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%; vertical-align: top;">
                    <p>Hormat kami,</p>
                    @if ($penawaran->user && $penawaran->user->tandaTangan)
                        <img src="{{ public_path('assets/images/tanda-tangan/' . basename($penawaran->user->tandaTangan->ttd)) }}"
                            alt="Tanda Tangan" style="width: 140px; height: 100px; object-fit: contain;">
                    @endif
                    <p style="text-decoration: underline;">{{ $penawaran->user->name ?? 'Sales' }}</p>
                </td>
                <td style="width: 70%; vertical-align: bottom; text-align: right; padding-top: 80px;">
                    <div>
                        <p><strong>PT. MEGA KOMPOSIT INDONESIA</strong></p>
                        <p style="margin-top: 5px;">
                            Ruko Boulevard Tekno Blok B No.21<br>
                            Jl. Tekno Widya, Setu, Tangerang Selatan<br>
                            Banten 15114 Indonesia<br>
                            Email: mega.komposit.indonesia@gmail.com
                            Website: www.megakomposit.com
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
