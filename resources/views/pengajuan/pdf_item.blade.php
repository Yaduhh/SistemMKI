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
            line-height: 1.2;
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
            padding: 6px;
            border: 1px solid #f2f2f2;
        }
        .table-none {
            padding: 6px;
            border: 0px solid #f2f2f2;
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
    </style>

</head>

<body>
    <div>
        <p>
            No {{ ' ' }}: {{ $pengajuan->nomor_pengajuan }} <br>
            Tgl: {{ $pengajuan->date_pengajuan->format('d-m-Y') }}
        </p>
    </div>

    <div>
        Kepada Yth. <br>
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
            Dengan Hormat,<br>
            Bersama ini kami sampaikan penawaran harga produk WPC, sebagai berikut :
        </p>
    </div>

    <h3 class="title-produk">{{ $pengajuan->title_produk }}</h3>
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
                <th>No</th>
                <th>Item</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($json_aksesoris as $key => $aksesoris)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $aksesoris['id'] }}</td>
                    <td>{{ $aksesoris['satuan'] }}</td>
                    <td>{{ $aksesoris['quantity'] }}</td>
                    <td>Rp {{ number_format($aksesoris['harga'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($aksesoris['harga'] * $aksesoris['quantity'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
