<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Detail Penawaran</h1>
            <x-button as="a" href="{{ route('admin.penawaran.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Kembali
            </x-button>
        </div>
    </x-slot>
    <div class="py-4 max-w-5xl mx-auto">
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="mb-1"><b>Nomor:</b> {{ $penawaran->nomor_penawaran }}</div>
                <div class="mb-1"><b>Tanggal:</b> {{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('d-m-Y') : '-' }}</div>
                <div class="mb-1"><b>Client:</b> {{ $penawaran->client->nama ?? '-' }}</div>
                <div class="mb-1"><b>Judul:</b> {{ $penawaran->judul_penawaran }}</div>
            </div>
            <div>
                <div class="mb-1"><b>Diskon:</b> {{ $penawaran->diskon }}%</div>
                <div class="mb-1"><b>PPN:</b> {{ $penawaran->ppn }}%</div>
                <div class="mb-1"><b>Total:</b> Rp {{ number_format($penawaran->total,0,',','.') }}</div>
                <div class="mb-1"><b>Grand Total:</b> <span class="font-bold text-green-700">Rp {{ number_format($penawaran->grand_total,0,',','.') }}</span></div>
            </div>
        </div>
        <div class="mb-4">
            <h2 class="font-semibold mb-2">Produk</h2>
            <flux:table class="w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Dimensi</th>
                        <th>Warna</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @if(is_array($penawaran->json_produk))
                        @foreach($penawaran->json_produk as $kategori => $items)
                            @if(is_array($items))
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item['item'] ?? '-' }}</td>
                                        <td>{{ $item['type'] ?? '-' }}</td>
                                        <td>{{ $item['dimensi'] ?? '-' }}</td>
                                        <td>{{ $item['warna'] ?? '-' }}</td>
                                        <td>{{ $item['qty'] ?? '-' }}</td>
                                        <td>Rp {{ isset($item['harga']) ? number_format($item['harga'],0,',','.') : '-' }}</td>
                                        <td>Rp {{ isset($item['total_harga']) ? number_format($item['total_harga'],0,',','.') : '-' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </flux:table>
        </div>
        <div class="mb-4">
            <h2 class="font-semibold mb-1">Syarat & Kondisi</h2>
            <ul class="list-disc ml-6 text-sm text-gray-700 dark:text-gray-300">
                @if(is_array($penawaran->syarat_kondisi))
                    @foreach($penawaran->syarat_kondisi as $syarat)
                        <li>{{ $syarat }}</li>
                    @endforeach
                @else
                    <li>{{ $penawaran->syarat_kondisi }}</li>
                @endif
            </ul>
        </div>
        <div class="mb-4">
            <h2 class="font-semibold mb-1">Catatan</h2>
            <div class="text-sm text-gray-700 dark:text-gray-300">{{ $penawaran->catatan }}</div>
        </div>
    </div>
</x-layouts.app> 