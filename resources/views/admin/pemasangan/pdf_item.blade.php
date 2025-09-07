<!DOCTYPE html>
<html>
<head>
    <title>{{ $pemasangan->judul_pemasangan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }
        p { margin: 4px 0; line-height: 1; }
        h1, h3 { margin: 0px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 0px; }
        th, .table-style { padding: 5px; border: 1px solid #000000; }
        .table-none { padding: 5px; border: 0px solid #000000; }
        th { background-color: #f2f2f2; text-align: left; }
        div { margin-bottom: 10px; }
        .title-produk { font-size: 14px; font-weight: bold; margin-bottom: 0px; padding: 5px; text-transform: uppercase; color: black;border: 1px solid #000000; }
        .text-right { text-align: right; }
        .w-100 { width: 100%; }
    </style>
</head>
<body>
    <div class="w-100" style="position: relative; z-index: 0;">
        @if($pemasangan->logo == 'WPC MAKMUR ABADI')
            <div style="position: absolute; top: 0; right: 0; z-index: 1;">
                <img src="{{ $logo }}" alt="Logo Perusahaan" width="250">
            </div>
        @else
            <div style="position: absolute; top: 0; right: 0; z-index: 1;">
                <img src="{{ $logo }}" alt="Logo Perusahaan" width="250">
            </div>
        @endif
    </div>
    <div>
        <p>
            No : {{ $pemasangan->nomor_pemasangan }} <br>
        </p>
        <p>
            Tgl: {{ $pemasangan->tanggal_pemasangan ? \Carbon\Carbon::parse($pemasangan->tanggal_pemasangan)->format('d-M-y') : 'Belum ditentukan' }}
        </p>
    </div>
    <div style="margin-top:10px;">
        Kepada Yth, <br>
        <b>{{ $pemasangan->client->nama ?? 'Nama client tidak ditemukan' }}</b><br>
        Di tempat <br>
    </div>
    <div style="margin-top:40px;">
        <p>
            Hal : {{ $pemasangan->judul_pemasangan }}
        </p>
    </div>
    <div>
        <p>Dengan Hormat,</p>
        <p style="margin-bottom: 10px; padding: 0;">Bersama ini kami sampaikan penawaran harga pemasangan sebagai berikut :</p>
    </div>
    @if (is_array($json_pemasangan) && count($json_pemasangan) > 0)
        @php
            $grandTotal = 0; $total = 0; $totalQty = 0;
        @endphp
        <table>
            <thead>
                <tr>
                    <th colspan="6" class="title-produk" style="background: #577dbb; color: white;">Biaya Pemasangan</th>
                </tr>
                <tr>
                    <th style="width: 5%; text-align: center;">NO</th>
                    <th>ITEM</th>
                    <th style="width: 10%; text-align: center;">SATUAN</th>
                    <th style="width: 10%; text-align: center;">QTY</th>
                    <th>HARGA SATUAN</th>
                    <th>TOTAL HARGA</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($json_pemasangan as $section)
                    <tr>
                        <td colspan="6" class="title-produk" style="font-size:12px; font-weight: bold;">{{ $section['sub_judul'] ?? '-' }}</td>
                    </tr>
                    @foreach ($section['items'] as $item)
                        @php
                            $qty = is_numeric($item['qty']) ? $item['qty'] : floatval(str_replace([',', '.'], '.', preg_replace('/[^0-9.,]/', '', $item['qty'])));
                            $totalQty += $qty;
                        @endphp
                        <tr>
                            <td class="table-style" style="width: 5%; text-align: center;">{{ $no++ }}</td>
                            <td class="table-style" style="width: 35%;">{{ $item['item'] ?? '-' }}</td>
                            <td class="table-style" style="width: 10%; text-align: center;">{{ $item['satuan'] ?? '-' }}</td>
                            <td class="table-style" style="width: 10%; text-align: center; font-weight: bold;">{{ $item['qty'] ?? '-' }}</td>
                            <td class="table-style" style="width: 20%;">
                                <table>
                                    <tr>
                                        <td style="width: 50%;">Rp</td>
                                        <td style="width: 50%; text-align: right;">{{ isset($item['harga_satuan']) ? number_format((float)$item['harga_satuan'], 0, ',', '.') : '-' }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td class="table-style">
                                <table>
                                    <tr>
                                        <td style="width: 50%;">Rp</td>
                                        <td style="width: 50%; text-align: right;">
                                            @if(isset($item['total_harga']))
                                                @if(is_string($item['total_harga']) && str_contains($item['total_harga'], 'Rp'))
                                                    {{ str_replace('Rp ', '', $item['total_harga']) }}
                                                @else
                                                    {{ number_format((float)$item['total_harga'], 0, ',', '.') }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <table style="width: 100%;">
            <tr>
                <td class="table-style" style="width: 5%; text-align: center; border: 0px 2px solid #000000 !important; border-top: 0px; padding-top: 10px; padding-bottom: 10px;"></td>
                <td class="table-style" style="width: 35%; border: 0px 2px solid #000000 !important; border-top: 0px; padding-top: 10px; padding-bottom: 10px;"></td>
                <td class="table-style" style="width: 10%; border: 0px 2px solid #000000 !important; border-top: 0px; padding-top: 10px; padding-bottom: 10px;"></td>
                <td class="table-style" style="width: 10%; border: 0px 2px solid #000000 !important; border-top: 0px; padding-top: 5px; padding-bottom: 5px; text-align: center; font-weight: bold;">{{ $totalQty }}</td>
                <td class="table-style" style="width: 20%; border: 0px 2px solid #000000 !important; border-top: 0px; padding-top: 10px; padding-bottom: 10px;"></td>
                <td class="table-style" style="border: 0px 2px solid #000000 !important; border-top: 0px; padding-top: 10px; padding-bottom: 10px;"></td>
            </tr>
            <tr>
                <td class="table-none" style="width: 5%; text-align: center;"></td>
                <td class="table-none" style="width: 35%;"></td>
                <td class="table-none" style="width: 10%;"></td>
                <td class="table-none" style="width: 10%;"></td>
                <td class="table-style" style="width: 20%; text-align: right;"><strong>TOTAL</strong></td>
                <td class="table-style">
                    <table>
                        <tr>
                            <td style="width: 50%; font-weight: bold;">Rp</td>
                            <td style="width: 50%; text-align: right; font-weight: bold;">{{ number_format($pemasangan->total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table-none" style="width: 5%; text-align: center;"></td>
                <td class="table-none" style="width: 35%;"></td>
                <td class="table-none" style="width: 10%;"></td>
                <td class="table-none" style="width: 10%;"></td>
                <td class="table-style" style="width: 20%;">
                    <table>
                        <tr>
                            <td style="width: 50%; font-weight: bold;">DISC</td>
                            <td style="width: 50%; text-align: right; font-weight: bold;">{{ $pemasangan->diskon }}%</td>
                        </tr>
                    </table>
                </td>
                <td class="table-style">
                    <table>
                        <tr>
                            <td style="width: 50%; font-weight: bold;">Rp</td>
                            <td style="width: 50%; text-align: right; font-weight: bold;">{{ number_format($pemasangan->diskon*$pemasangan->total/100, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="table-none" style="width: 5%; text-align: center;"></td>
                <td class="table-none" style="width: 35%;"></td>
                <td class="table-none" style="width: 10%;"></td>
                <td class="table-none" style="width: 10%;"></td>
                <td class="table-style" style="width: 20%; text-align: right;"><strong>TOTAL</strong></td>
                <td class="table-style">
                    <table>
                        <tr>
                            <td style="width: 50%; font-weight: bold;">Rp</td>
                            <td style="width: 50%; text-align: right; font-weight: bold;">{{ number_format($pemasangan->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    @endif
    @if (is_array($json_syarat_kondisi) && count($json_syarat_kondisi) > 0)
        <div>
            <p><strong>Syarat & Kondisi :</strong></p>
        </div>
        <ul style="margin-top:-10px;">
            @foreach ($json_syarat_kondisi as $syarat)
                <li style="margin-bottom: 3px;">{!! nl2br(e($syarat)) !!}</li>
            @endforeach
        </ul>
    @endif
    <div>
        <p>Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>
    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 30%; vertical-align: top;">
                <div>
                    <p>Hormat Kami,</p>
                    @if ($pemasangan->penawaran->user && $pemasangan->penawaran->user->tandaTangan)
                        <img src="{{ public_path('assets/images/tanda-tangan/' . basename($pemasangan->penawaran->user->tandaTangan->ttd)) }}"
                            alt="Tanda Tangan"
                            style="width: 140px; height: 100px; object-fit: contain;">
                    @endif
                    <p>{{ $pemasangan->sales->name ?? 'Sales' }}</p>
                </div>
            </td>
            <td style="width: 70%; vertical-align: bottom; text-align: right; font-style: italic; padding-top:100px;">
                <div>
                    <p><span style="font-weight: bold; text-decoration: underline; color: #000000;">
                        PT. {{$pemasangan->logo}}
                    </span></p>
                    <p style="margin-top: -10px;">
                        @if ($pemasangan->logo ==="WPC MAKMUR ABADI")
                            <br>Ruko Boulevard Tekno Blok B No.21 Lt.3 <br>Jl. Tekno Widya, Setu, Tangerang Selatan <br> Banten 15314, Indonesia
                        @else
                            <br>Ruko Boulevard Tekno Block B No.21 <br>Jl.Tekno Widya, Setu, Tangerang Selatan, Banten 15314, Indonesia <br>Email : mega.komposit.indonesia@gmail.com - Website: www.megakomposit.com
                        @endif
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>
</html> 