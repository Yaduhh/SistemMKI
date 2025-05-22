<!DOCTYPE html>
<html>

<head>
    <title>{{ $pengajuan->judul_pengajuan }}</title>
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
        }

        .title-aksesoris {
            font-size: 14px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom: 0px;
            background-color: #577dbb;
            padding: 5px;
            text-transform: uppercase;
        }

        .text-right {
            text-align: right;
        }

        .grid-content {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 300px;
            /* Kolom pertama fleksibel, kolom kedua lebarnya 300px (coba sesuaikan) */
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
            No {{ ' ' }}: {{ $pengajuan->nomor_pengajuan }} <br>
            Tgl: {{ $pengajuan->date_pengajuan->format('d-m-Y') }}
        </p>
    </div>

    <div>
        Kepada Yth, <br>
        <b>{{ $pengajuan->client }}</b><br>
        Di tempat <br>
    </div>

    <div>
        <p>
            Hal : {{ $pengajuan->judul_pengajuan }} <br>
            Up : {{ $pengajuan->nama_client }}
        </p>
    </div>
    <div>
        <p>
            Dengan Hormat,
        </p>
        <p style="margin-bottom: 0; padding: 0;">Bersama ini kami sampaikan penawaran harga produk WPC, sebagai berikut :
        </p>
    </div>

    <h3 class="title-produk" style="margin-top: -10px;">{{ $pengajuan->title_produk }}</h3>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>WPC</th>
                <th>TYPE</th>
                <th>LEBAR (cm)</th>
                <th>TINGGI (m)</th>
                <th>WARNA</th>
                <th>QTY WPC</th>
                <th>HARGA</th>
                <th>TOTAL HARGA</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($json_produk as $key => $produk)
                @php
                    $total = $produk['harga'] * $produk['quantity'];
                    $grandTotal += $total;
                @endphp
                <tr>
                    <td class="table-style">{{ $key + 1 }}</td>
                    <td class="table-style">{{ $produk['id'] }}</td>
                    <td class="table-style">{{ $produk['type'] }}</td>
                    <td class="table-style">{{ $produk['dimensi'] }}</td>
                    <td class="table-style">{{ $produk['dimensi'] }}</td>
                    <td class="table-style">{{ $produk['warna'] }}</td>
                    <td class="table-style">{{ $produk['quantity'] }}</td>
                    <td class="table-style">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                    <td class="table-style">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Baris total tanpa colspan --}}
            <tr>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style text-right"><strong>TOTAL</strong></td>
                <td class="table-style"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style"><strong>Discount I {{ $pengajuan->diskon_satu }}%</strong></td>
                <td class="table-style">Rp {{ number_format($grandTotal * 0.1, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style"><strong>Discount II {{ $pengajuan->diskon_dua }}%</strong></td>
                <td class="table-style">Rp {{ number_format($grandTotal * 0.05, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style"><strong>Discount III {{ $pengajuan->diskon_tiga }}%</strong></td>
                <td class="table-style">Rp {{ number_format($grandTotal * 0.05, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style text-right"><strong>TOTAL 1</strong></td>
                <td class="table-style">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>


    <h3 class="title-aksesoris">{{ $pengajuan->title_aksesoris }}</h3>
    <table>
        <thead>
            <tr>
                <th class="table-style">NO</th>
                <th colspan="3" class="table-style">ITEM</th>
                <th class="table-style">DESCRIPTION</th>
                <th class="table-style">QTY</th>
                <th class="table-style">HARGA</th>
                <th class="table-style">TOTAL HARGA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($json_aksesoris as $key => $aksesoris)
                <tr>
                    <td class="table-style">{{ $key + 1 }}</td>
                    <td colspan="3" class="table-style">{{ $aksesoris['type'] }}</td>
                    <td class="table-style">{{ $aksesoris['satuan'] }}</td>
                    <td class="table-style">{{ $aksesoris['quantity'] }}</td>
                    <td class="table-style">Rp {{ number_format($aksesoris['harga'], 0, ',', '.') }}</td>
                    <td class="table-style">Rp
                        {{ number_format($aksesoris['harga'] * $aksesoris['quantity'], 0, ',', '.') }}</td>
                </tr>
            @endforeach

            {{-- Baris total tanpa colspan --}}
            <tr>
                <td class="table-none"></td>
                <td colspan="3" class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style text-right"><strong>TOTAL 2</strong></td>
                <td class="table-style"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td colspan="3" class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style">&nbsp;</td>
                <td class="table-style">{{ ' ' }}</td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td colspan="3" class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style text-right"><strong>TOTAL 1 + 2</strong></td>
                <td class="table-style">Rp {{ number_format($grandTotal * 0.05, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td colspan="3" class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style text-right"><strong>PPN {{ $pengajuan->ppn }}%</strong></td>
                <td class="table-style">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="table-none"></td>
                <td colspan="3" class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-none"></td>
                <td class="table-style text-right"><strong>GRAND TOTAL</strong></td>
                <td class="table-style">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div>
        <p><strong>Syarat & Kondisi :</strong></p>
    </div>
    <ul style="margin-top:-10px;">
        @foreach ($json_syarat_ketentuan as $syarat)
            <li style="margin-bottom: 3px;">{{ $syarat }}</li>
        @endforeach
    </ul>

    <div>
        <p>Atas Perhatian dan kerjasamanya, kami ucapkan terimakasih.</p>
    </div>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 30%; vertical-align: top;">
                <div>
                    <p style="margin-bottom: 65px;">Hormat Kami,</p>
                    <p>Timotius</p>
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
