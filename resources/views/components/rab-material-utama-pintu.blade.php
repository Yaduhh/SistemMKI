@props(['penawaranPintu'])

<div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700">
    <div class="flex items-center gap-3 p-6">
        <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Material Utama Pintu</h3>
            <p class="text-zinc-600 dark:text-zinc-400">Daftar material utama dari penawaran pintu</p>
        </div>
    </div>

    @if($penawaranPintu && is_array($penawaranPintu))
        @foreach($penawaranPintu as $sectionKey => $section)
            @if(isset($section['judul_1']) && isset($section['products']))
                <div class="">
                    <div class="bg-zinc-50 dark:bg-zinc-700 px-4 py-3 border-b border-zinc-200 dark:border-zinc-600">
                        <h4 class="font-medium text-zinc-900 dark:text-white">{{ $section['judul_1'] }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @if(isset($section['judul_2']))
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $section['judul_2'] }}</p>
                            @endif
                            @if(isset($section['jumlah']))
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Jumlah: {{ $section['jumlah'] }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-100 dark:bg-zinc-600">
                                <tr>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Item
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Nama Produk
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Ukuran
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Warna
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Harga Satuan
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Jumlah
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Diskon (%)
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        Total Harga
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($section['products'] as $product)
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm text-zinc-900 dark:text-white font-medium">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white font-medium">
                                            {{ $product['item'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            {{ $product['nama_produk'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            @if(isset($product['lebar']) && isset($product['tebal']) && isset($product['tinggi']))
                                                @if($product['lebar'] > 0 && $product['tebal'] > 0 && $product['tinggi'] > 0)
                                                    {{ $product['lebar'] }} x {{ $product['tebal'] }} x {{ $product['tinggi'] }}
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            {{ $product['warna'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            @if(isset($product['harga']) && $product['harga'] > 0)
                                                Rp {{ number_format($product['harga'], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            @if(isset($product['jumlah_individual']) && $product['jumlah_individual'] > 1)
                                                {{ $product['jumlah_individual'] }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            @if(isset($product['diskon']) && $product['diskon'] > 0)
                                                {{ $product['diskon'] }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-zinc-900 dark:text-white font-semibold">
                                            @if(isset($product['total_harga']) && $product['total_harga'] > 0)
                                                Rp {{ number_format($product['total_harga'], 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="text-center py-8">
            <div class="text-zinc-500 dark:text-zinc-400">
                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">Tidak ada data material</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Data material utama pintu belum tersedia.</p>
            </div>
        </div>
    @endif
</div>
