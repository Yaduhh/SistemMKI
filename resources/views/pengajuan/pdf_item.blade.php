<!DOCTYPE html>
<html>

<head>
    <title>{{ $pengajuan->judul_pengajuan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
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

    <h3>Pintuu Balkon</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>WPC</th>
                <th>Type</th>
                <th>Lebar (cm)</th>
                <th>Tinggi (m)</th>
                <th>Warna</th>
                <th>Qty WPC</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($json_produk as $key => $produk)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $produk['id'] }}</td>
                    <td>{{ $produk['dimensi'] }}</td>
                    <td>{{ $produk['warna'] }}</td>
                    <td>{{ $produk['quantity'] }}</td>
                    <td>Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($produk['harga'] * $produk['quantity'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Engsel</h3>
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
