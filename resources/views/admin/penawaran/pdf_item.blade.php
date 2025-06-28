<!DOCTYPE html>
<html>

<head>
    <title>{{ $penawaran->judul_penawaran }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
            font-size: 14px;
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
    <div class="w-100" style="position: relative; z-index: 0;">
        <div style="position: absolute; top: 0; right: 0; z-index: 1;">
            <img src="{{ public_path('assets/images/logomki.png') }}" alt="Logo Perusahaan" width="250">
        </div>
    </div> 
    <div>
        <p>
            No {{ ' ' }}: {{ $penawaran->nomor_penawaran }} <br>
            Tgl: {{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('d-m-Y') : 'Belum ditentukan' }}
        </p>
    </div>

    <div>
        Kepada Yth, <br>
        <b>{{ $penawaran->client->nama_perusahaan ?? $penawaran->client->nama ?? 'Client tidak ditemukan' }}</b><br>
        Di tempat <br>
    </div>

    <div>
        <p>
            Hal : {{ $penawaran->judul_penawaran }} <br>
            Up : {{ $penawaran->client->nama ?? 'Nama client tidak ditemukan' }}
        </p>
    </div>
    <div>
        <p>
            Dengan Hormat,
        </p>
        <p style="margin-bottom: 0; padding: 0;">Bersama ini kami sampaikan penawaran harga produk WPC, sebagai berikut :
        </p>
    </div>

    @if(is_array($json_produk) && count($json_produk) > 0)
        <h3 class="title-produk" style="margin-top: -10px;">DAFTAR PRODUK</h3>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ITEM</th>
                    <th>TYPE</th>
                    <th>DIMENSI</th>
                    <th>WARNA</th>
                    <th>QTY</th>
                    <th>HARGA</th>
                    <th>TOTAL HARGA</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; $totalKeseluruhan = 0; @endphp
                @foreach($json_produk as $kategori => $items)
                    @if(is_array($items))
                        @foreach($items as $item)
                            @php
                                $totalHarga = isset($item['total_harga']) ? $item['total_harga'] : 0;
                                $totalKeseluruhan += $totalHarga;
                            @endphp
                            <tr>
                                <td class="table-style">{{ $no++ }}</td>
                                <td class="table-style">{{ $item['item'] ?? '-' }}</td>
                                <td class="table-style">{{ $item['type'] ?? '-' }}</td>
                                <td class="table-style">{{ $item['dimensi'] ?? '-' }}</td>
                                <td class="table-style">{{ $item['warna'] ?? '-' }}</td>
                                <td class="table-style">{{ $item['qty'] ?? '-' }}</td>
                                <td class="table-style">Rp {{ isset($item['harga']) ? number_format($item['harga'], 0, ',', '.') : '-' }}</td>
                                <td class="table-style">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach

                {{-- Baris total --}}
                <tr>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-none"></td>
                    <td class="table-style text-right"><strong>TOTAL</strong></td>
                    <td class="table-style"><strong>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- Ringkasan Total Keseluruhan --}}
    <table style="margin-top: 20px;">
        <tbody>
            <tr>
                <td class="table-none" style="width: 70%;"></td>
                <td class="table-style text-right"><strong>TOTAL KESELURUHAN</strong></td>
                <td class="table-style"><strong>Rp {{ number_format($penawaran->total ?? 0, 0, ',', '.') }}</strong></td>
            </tr>
            
            @if($penawaran->diskon_satu > 0)
                <tr>
                    <td class="table-none"></td>
                    <td class="table-style"><strong>Diskon I {{ $penawaran->diskon_satu }}%</strong></td>
                    <td class="table-style">- Rp {{ number_format($penawaran->total_diskon_1 ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endif
            
            @if($penawaran->diskon_dua > 0)
                <tr>
                    <td class="table-none"></td>
                    <td class="table-style"><strong>Diskon II {{ $penawaran->diskon_dua }}%</strong></td>
                    <td class="table-style">- Rp {{ number_format($penawaran->total_diskon_2 ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endif
            
            @if($penawaran->ppn > 0)
                <tr>
                    <td class="table-none"></td>
                    <td class="table-style"><strong>PPN {{ $penawaran->ppn }}%</strong></td>
                    <td class="table-style">+ Rp {{ number_format(($penawaran->grand_total - ($penawaran->total - ($penawaran->total_diskon ?? 0))), 0, ',', '.') }}</td>
                </tr>
            @endif
            
            <tr>
                <td class="table-none"></td>
                <td class="table-style text-right"><strong>GRAND TOTAL</strong></td>
                <td class="table-style"><strong>Rp {{ number_format($penawaran->grand_total ?? 0, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    @if(is_array($syarat_kondisi) && count($syarat_kondisi) > 0)
        <div>
            <p><strong>Syarat & Kondisi :</strong></p>
        </div>
        <ul style="margin-top:-10px;">
            @foreach ($syarat_kondisi as $syarat)
                <li style="margin-bottom: 3px;">{{ $syarat }}</li>
            @endforeach
        </ul>
    @endif

    @if($penawaran->catatan)
        <div>
            <p><strong>Catatan :</strong></p>
            <p style="margin-top: 5px;">{{ $penawaran->catatan }}</p>
        </div>
    @endif

    <div>
        <p>Atas Perhatian dan kerjasamanya, kami ucapkan terimakasih.</p>
    </div>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 30%; vertical-align: top;">
                <div>
                    <p style="margin-bottom: 65px;">Hormat Kami,</p>
                    <p>{{ $penawaran->user->name ?? 'Sales' }}</p>
                </div>
            </td>
            <td style="width: 70%; vertical-align: bottom; text-align: right; font-style: italic;">
                <div>
                    <p><span style="font-weight: bold; text-decoration: underline; color: #000000;">PT. MEGA KOMPOSIT INDONESIA</span></p>
                    <p style="margin-top: -10px;">
                        <br>Ruko Boulevard Tekno Block B No.21 <br>Jl.Tekno Widya, Setu, Tangerang Selatan, Banten 15314, Indonesia <br>Email : mega.komposit.indonesia@gmail.com -
                        Website: www.megakomposit.com
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html> 