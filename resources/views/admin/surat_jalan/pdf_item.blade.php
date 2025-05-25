<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .subheader {
            text-align: center;
            font-size: 12px;
            margin-top: -10px;
        }

        .content {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .content div {
            width: 100%;
        }

        .content p {
            margin: 0;
            line-height: 1.5;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            padding: 8px;
            text-align: left;
        }

        .table th {
            border-left: none;
            border-right: none;
        }

        .table td {
            border-left: none;
            border-right: none;
        }


        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .lineUp {
            margin: 0;
            border-top: 1.5px solid black;
        }

        .lineDown {
            margin: 0;
            border-top: 4px solid black;
            margin-top: 3px;
        }

        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
        }

        .headerTab {
            width: 100%;
            margin-bottom: 0px;
            border-collapse: collapse;
        }

        .header td {
            vertical-align: top;
            padding: 5px;
        }

        .header img {
            width: 250px;
        }

        .company-info {
            color: rgb(4, 90, 160);
        }

        .company-info p {
            margin: 0;
            padding: 0;
            padding-left: 100px;
            font-size: 14px;
        }

        .company-info h3 {
            margin: 0;
            padding: 0;
            font-size: 16px;
            padding-left: 100px;
        }

        .isi-surat-jalan {
            text-align: left;
            width: 100%;
            line-height: 1.5;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- Header with Logo and Company Info -->
    <table class="header">
        <tr>
            <td>
                <img src="{{ public_path('assets/images/logomki.png') }}" alt="Logo Perusahaan">
            </td>
            <td class="company-info">
                <h3>PT.MEGA KOMPOSITE INDONESIA</h3>
                <p>Ruko Boulevard Tekno Blok B No.21</p>
                <p>Jl. Tekno Widya, Setu, Tangerang Selatan</p>
                <p>Banten 15314, Indonesia</p>
                <p>Telp : 021 - 7567 5403</p>
                <p>Email : <span style="font-style: italic;">mega.komposit.indonesia@gmail.com</span></p>
            </td>
        </tr>
    </table>

    <div class="header">
        <div class="lineUp"></div>
        <h2>SURAT JALAN</h2>
        <div class="lineDown"></div>
    </div>

    <table class="headerTab">
        <tr>
            <td>
                <!-- Kolom Left -->
                <div>
                    <table class="headerTab isi-surat-jalan" style="margin-top:-30px;">
                        <tr>
                            <td>No. Surat Jalan</td>
                            <td>: {{ $suratJalan->nomor_surat }}</td>
                        </tr>
                        <tr>
                            <td>No. PO</td>
                            <td>: {{ $suratJalan->no_po }}</td>
                        </tr>
                        <tr>
                            <td>No. SPP</td>
                            <td>: {{ $suratJalan->no_spp }}</td>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px;">Keterangan</td>
                            <td>: {{ $suratJalan->keterangan }}</td>
                        </tr>
                    </table>
                </div>
            </td>

            <td>
                <div>
                    <table class="headerTab isi-surat-jalan">
                        <tr style="text-transform: uppercase;">
                            <td>Tangerang, {{ $suratJalan->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px;">KEPADA Yth, <br> <span
                                    style="font-weight: bold;">{{ $suratJalan->tujuan }}</span></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="padding-top: 6px;">Proyek &nbsp;&nbsp;&nbsp; : <br>{{ $suratJalan->proyek }}</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="padding-top: 6px;">Penerima : <br>{{ $suratJalan->no_spp }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <table class="table" style="font-size: 14px;">
        <thead>
            <tr>
                <th>Item</th>
                <th>Kode</th>
                <th>Panjang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['item'] }}</td>
                    <td>{{ $item['kode'] }}</td>
                    <td>{{ $item['panjang'] }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>{{ $item['satuan'] }}</td>
                    <td>{{ $item['keterangan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="headerTab" style="margin-top: 30px; font-size: 14px;">
        <tr>
            <td style="text-align: center;">
                <p>Dibuat,</p>
                <p></p>
                <p></p>
                <p></p>
                <p>{{ $author->name }}</p>
            </td>
            <td style="text-align: center;">
                <p>Pengirim,</p>
                <p></p>
                <p></p>
                <p></p>
                <p>{{ $suratJalan->pengirim }}</p>
            </td>
            <td style="text-align: center;">
                <p>Security,</p>
                <p></p>
                <p></p>
                <p></p>
                <p>{{ $suratJalan->security }}</p>
            </td>
            <td style="text-align: center;">
                <p>Diketahui,</p>
                <p></p>
                <p></p>
                <p></p>
                <p>{{ $suratJalan->diketahui }}</p>
            </td>
            <td style="text-align: center;">
                <p>Disetujui,</p>
                <p></p>
                <p></p>
                <p></p>
                <p>{{ $suratJalan->disetujui }}</p>
            </td>
            <td style="text-align: center;">
                <p>Diterima,</p>
                <p></p>
                <p></p>
                <p></p>
                <p>{{ $suratJalan->diterima }}</p>
            </td>
        </tr>
    </table>

</body>

</html>
