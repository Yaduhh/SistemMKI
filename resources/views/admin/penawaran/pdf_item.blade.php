<!DOCTYPE html>
<html>

<head>
    <title>{{ $penawaran->judul_penawaran }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
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
            text-align: left;
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
        <b>{{ $penawaran->client->nama ?? 'Nama client tidak ditemukan' }}</b><br>
        Di tempat <br>
    </div>

    <div>
        <p>
            Hal : {{ $penawaran->judul_penawaran }} <br>
        </p>
    </div>
    <div>
        <p>
            Dengan Hormat,
        </p>
        <p style="margin-bottom: 10ox; padding: 0;">Bersama ini kami sampaikan penawaran harga produk WPC, sebagai
            berikut :
        </p>
    </div>

    @if (is_array($json_produk) && count($json_produk) > 0)
        <h3 style="margin-top: 20px; margin-bottom: 10px; font-size: 12px; font-weight: bold; color: #000000;">DAFTAR
            PRODUK</h3>
        @php
            $no = 1;
            $totalKeseluruhan = 0;
            $totalQty = 0;
        @endphp

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th width="3%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        NO
                    </th>
                    <th width="10%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        PRODUK</th>
                    <th width="10%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        TYPE</th>
                    <th width="5%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        DIMENSI (mm)</th>
                    <th width="5%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        PANJANG (m)</th>
                    <th width="6%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        FINISHING</th>
                    <th width="4%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        VOL<br>m2</th>
                    <th width="5%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        QTY</th>
                    <th width="12.5%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        HARGA</th>
                    <th width="15%"
                        style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: center;">
                        TOTAL HARGA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($json_produk as $mainIndex => $mainSection)
                    @if (isset($mainSection['judul']))
                        <tr>
                            <td colspan="10"
                                style="padding: 5px; background-color: #567CBA; color: white; font-weight: bold; border: 1px solid #000000;">
                                {{ $mainSection['judul'] }}
                            </td>
                        </tr>
                    @endif
                    @if (isset($mainSection['product_sections']) && is_array($mainSection['product_sections']))
                        @php $kategoriKeys = array_keys($mainSection['product_sections']); @endphp
                        @foreach ($mainSection['product_sections'] as $kategoriIdx => $items)
                            @if (is_array($items) && !empty($items))
                                @foreach ($items as $item)
                                    @php
                                        $totalHarga = isset($item['total_harga']) ? $item['total_harga'] : 0;
                                        $totalKeseluruhan += $totalHarga;
                                        $totalQty += isset($item['qty']) ? (int) $item['qty'] : 0;
                                    @endphp
                                    <tr>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            {{ $no++ }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            {{ $item['item'] ?? '-' }}
                                        </td>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            {{ $item['type'] ?? '-' }}
                                        </td>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            {{ $item['dimensi'] ?? '-' }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            
                                            {{ $item['panjang'] ? rtrim(rtrim(number_format($item['panjang'] / 1000, 2), '0'), '.') : '-' }}
                                        </td>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            {{ $item['finishing'] ?? '-' }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            {{ $item['qty_area'] ?? '-' }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000; text-align: center;">
                                            {{ $item['qty'] ?? '-' }}
                                        </td>
                                        <td style="padding: 5px; border: 1px solid #000000;">
                                            <table>
                                                <tr>
                                                    <td>Rp</td>
                                                    <td style="text-align: right;">
                                                        {{ isset($item['harga']) ? number_format($item['harga'], 0, ',', '.') : '-' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="padding: 5px; border: 1px solid #000000;">
                                            <table>
                                                <tr>
                                                    <td>Rp</td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
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
                    <td class="table-style" style="text-align: center;"><strong>{{ $totalQty }}</strong></td>
                    <td class="table-style"></td>
                    <td class="table-style"></td>
                </tr>
                {{-- Summary rows --}}
                <tr>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-style text-right"><strong>TOTAL</strong></td>
                    <td class="table-style">
                        <table>
                            <tr>
                                <td>Rp</td>
                                <td style="text-align: right;">{{ number_format($penawaran->total, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @if (($penawaran->diskon ?? 0) > 0)
                    <tr>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Discount</td>
                                    <td style="text-align: right;">{{ $penawaran->diskon }}%</td>
                                </tr>
                            </table>
                        </td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Rp</td>
                                    <td style="text-align: right;">
                                        {{ number_format($penawaran->total_diskon ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif
                @if ($penawaran->diskon_satu > 0)
                    <tr>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Discount</td>
                                    <td style="text-align: right;">{{ $penawaran->diskon_satu }}%</td>
                                </tr>
                            </table>
                        </td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Rp</td>
                                    <td style="text-align: right;">
                                        {{ number_format($penawaran->total_diskon_1 ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif
                @if ($penawaran->diskon_dua > 0)
                    <tr>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Discount</td>
                                    <td style="text-align: right;">{{ $penawaran->diskon_dua }}%</td>
                                </tr>
                            </table>
                        </td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Rp</td>
                                    <td style="text-align: right;">
                                        {{ number_format($penawaran->total_diskon_2 ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif
                @if ($penawaran->ppn > 0)
                    <tr>
                        <td colspan="3" rowspan="3" class="table-none">
                            @if ($penawaran->catatan)
                                <div>
                                    <p><strong>Catatan :</strong></p>
                                    <p>{{ $penawaran->catatan }}</p>
                                </div>
                            @endif
                        </td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-style" style="font-weight: bold; text-align: right;">TOTAL</td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Rp</td>
                                    <td style="text-align: right;">
                                        {{ number_format($penawaran->total - ($penawaran->total_diskon ?? 0) - ($penawaran->total_diskon_1 ?? 0) - ($penawaran->total_diskon_2 ?? 0), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif
                @if ($penawaran->ppn > 0)
                    <tr>

                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-none"></td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>PPn</td>
                                    <td style="text-align: right;">{{ $penawaran->ppn }}%</td>
                                </tr>
                            </table>
                        </td>
                        <td class="table-style">
                            <table>
                                <tr>
                                    <td>Rp</td>
                                    <td style="text-align: right;">
                                        {{ number_format((($penawaran->total - ($penawaran->total_diskon ?? 0) - ($penawaran->total_diskon_1 ?? 0) - ($penawaran->total_diskon_2 ?? 0)) * ($penawaran->ppn ?? 0)) / 100, 0, ',', '.') }}
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
                    <td class="table-style text-right"><strong>GRAND TOTAL</strong></td>
                    <td class="table-style-grand-total">
                        <table>
                            <tr style="background-color: #567CBA;">
                                <td style="font-weight: bold;">Rp</td>
                                <td style="text-align: right; font-weight: bold;">
                                    {{ number_format($penawaran->grand_total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <!-- Fallback untuk struktur lama -->
        @foreach ($json_produk as $mainSection)
            @if (is_array($mainSection))
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                NO</th>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                ITEM</th>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                TYPE</th>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                DIMENSI</th>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                WARNA</th>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                QTY</th>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                HARGA</th>
                            <th
                                style="padding: 5px; border: 1px solid #000000; background-color: #f2f2f2; text-align: left;">
                                TOTAL HARGA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mainSection as $kategori => $items)
                            @if (is_array($items))
                                @foreach ($items as $item)
                                    @php
                                        $totalHarga = isset($item['total_harga']) ? $item['total_harga'] : 0;
                                        $totalKeseluruhan += $totalHarga;
                                    @endphp
                                    <tr>
                                        <td style="padding: 5px; border: 1px solid #000000;">{{ $no++ }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000;">
                                            {{ $item['item'] ?? '-' }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000;">
                                            {{ $item['type'] ?? '-' }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000;">
                                            {{ $item['dimensi'] ?? '-' }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000;">
                                            {{ $item['warna'] ?? '-' }}</td>
                                        <td style="padding: 5px; border: 1px solid #000000;">{{ $item['qty'] ?? '-' }}
                                        </td>
                                        <td style="padding: 5px; border: 1px solid #000000;">Rp
                                            {{ isset($item['harga']) ? number_format($item['harga'], 0, ',', '.') : '-' }}
                                        </td>
                                        <td style="padding: 5px; border: 1px solid #000000;">Rp
                                            {{ number_format($totalHarga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endif
    @if (is_array($syarat_kondisi) && count($syarat_kondisi) > 0)
        <div>
            <p><strong>Syarat & Kondisi :</strong></p>
        </div>
        <ul style="margin-top:-10px;">
            @foreach ($syarat_kondisi as $syarat)
                <li style="margin-bottom: 3px;">{{ $syarat }}</li>
            @endforeach
        </ul>
    @endif
    <div>
        <p>Atas Perhatian dan kerjasamanya, kami ucapkan terimakasih.</p>
    </div>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 30%; vertical-align: top;">
                <div>
                    <p>Hormat Kami,</p>
                    @if ($penawaran->user && $penawaran->user->tandaTangan)
                        <img src="{{ public_path('assets/images/tanda-tangan/' . basename($penawaran->user->tandaTangan->ttd)) }}"
                            alt="Tanda Tangan" style="width: 140px; height: 100px; object-fit: contain;">
                    @endif
                    <p style="text-decoration: underline;">{{ $penawaran->user->name ?? 'Sales' }}</p>
                </div>
            </td>
            <td style="width: 70%; vertical-align: bottom; text-align: right; font-style: italic; padding-top:140px;">
                <div>
                    <p><span style="font-weight: bold; text-decoration: underline; color: #000000;">PT. MEGA KOMPOSIT
                            INDONESIA</span></p>
                    <p style="margin-top: -10px;">
                        <br>Ruko Boulevard Tekno Block B No.21 <br>Jl.Tekno Widya, Setu, Tangerang Selatan, Banten
                        15314, Indonesia <br>Email : mega.komposit.indonesia@gmail.com -
                        Website: www.megakomposit.com
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
