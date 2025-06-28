<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Detail Penawaran</h1>
            <div class="flex gap-2">
                <x-button href="{{ route('admin.penawaran.cetak', $penawaran) }}" 
                         class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak PDF
                </x-button>
                <x-button as="a" href="{{ route('admin.penawaran.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                    Kembali
                </x-button>
            </div>
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
                <div class="mb-1"><b>Diskon:</b> {{ $penawaran->diskon ?? 0 }}%</div>
                <div class="mb-1"><b>Diskon Satu:</b> {{ $penawaran->diskon_satu ?? 0 }}%</div>
                <div class="mb-1"><b>Diskon Dua:</b> {{ $penawaran->diskon_dua ?? 0 }}%</div>
                <div class="mb-1"><b>Total Diskon:</b> Rp {{ number_format($penawaran->total_diskon ?? 0, 0, ',', '.') }}</div>
                <div class="mb-1"><b>Total Diskon Satu:</b> Rp {{ number_format($penawaran->total_diskon_1 ?? 0, 0, ',', '.') }}</div>
                <div class="mb-1"><b>Total Diskon Dua:</b> Rp {{ number_format($penawaran->total_diskon_2 ?? 0, 0, ',', '.') }}</div>
                <div class="mb-1"><b>PPN:</b> {{ $penawaran->ppn ?? 0 }}%</div>
                <div class="mb-1"><b>Total:</b> Rp {{ number_format($penawaran->total ?? 0,0,',','.') }}</div>
                <div class="mb-1"><b>Grand Total:</b> <span class="font-bold text-green-700">Rp {{ number_format($penawaran->grand_total ?? 0,0,',','.') }}</span></div>
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