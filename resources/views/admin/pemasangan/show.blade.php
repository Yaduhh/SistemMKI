<x-layouts.app :title="__('Detail Pemasangan')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="mb-6 flex flex-col lg:flex-row lg:justify-between lg:items-center">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Detail Pemasangan</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Informasi lengkap pemasangan <span class="font-semibold">{{ $pemasangan->nomor_pemasangan }}</span></p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.pemasangan.edit', $pemasangan->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ $pemasangan->penawaran && $pemasangan->penawaran->penawaran_pintu ? route('admin.penawaran-pintu.show', $pemasangan->id_penawaran) : route('admin.penawaran.show', $pemasangan->id_penawaran) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Lihat Penawaran Terkait
                    </a>
                    <a href="{{ route('admin.pemasangan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <form action="{{ route('admin.pemasangan.destroy', $pemasangan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pemasangan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-red-700 dark:hover:bg-red-600 focus:bg-red-700 dark:focus:bg-red-600 active:bg-red-900 dark:active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                    @if($pemasangan->status != 1)
                    <form action="{{ route('admin.pemasangan.update-status', $pemasangan->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="1">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 dark:hover:bg-green-600 focus:bg-green-700 dark:focus:bg-green-600 active:bg-green-900 dark:active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Selesai
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('admin.pemasangan.cetak', $pemasangan->id) ?? url('admin/pemasangan/cetak/' . $pemasangan->id) }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak PDF
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Informasi Pemasangan
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="4" y="4" width="16" height="16" rx="2" stroke-width="2" />
                                        <path d="M8 2v4M16 2v4" stroke-width="2" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Pemasangan:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $pemasangan->nomor_pemasangan }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2" />
                                        <path d="M8 2v4M16 2v4" stroke-width="2" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemasangan:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $pemasangan->tanggal_pemasangan ? $pemasangan->tanggal_pemasangan->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Judul Pemasangan:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $pemasangan->judul_pemasangan }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <rect x="4" y="4" width="16" height="16" rx="2" stroke-width="2" />
                                        <circle cx="12" cy="12" r="4" stroke-width="2" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Logo:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $pemasangan->logo }}</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Client:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $pemasangan->client->nama ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sales:</span>
                                    <span class="ml-2 text-sm text-gray-900 dark:text-white">{{ $pemasangan->sales->name ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke-width="2" />
                                        <path d="M12 8v4l3 3" stroke-width="2" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                    <span class="ml-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $pemasangan->status == 1 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                               ($pemasangan->status == 2 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                               ($pemasangan->status == 0 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200')) }}">
                                            {{ $pemasangan->status == 1 ? 'Aktif' : 
                                               ($pemasangan->status == 2 ? 'Nonaktif' : 
                                               ($pemasangan->status == 0 ? 'Draft' : 'Draft')) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Detail Pemasangan
                        </h2>
                        @if(is_array($pemasangan->json_pemasangan))
                            @foreach($pemasangan->json_pemasangan as $section)
                                <div class="mb-6">
                                    <div class="font-semibold text-base text-gray-900 dark:text-white mb-2">{{ $section['sub_judul'] ?? '-' }}</div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-zinc-800">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Item</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Satuan</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Qty</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga/Satuan</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-zinc-900/30 divide-y divide-gray-200 dark:divide-gray-700">
                                                @php $no = 1; @endphp
                                                @foreach($section['items'] as $item)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $no++ }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $item['item'] ?? '-' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $item['satuan'] ?? '-' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $item['qty'] ?? '-' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ isset($item['harga_satuan']) ? 'Rp ' . number_format((float)$item['harga_satuan'], 0, ',', '.') : '-' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                            @if(isset($item['total_harga']))
                                                                @if(is_string($item['total_harga']) && strpos($item['total_harga'], 'Rp') !== false)
                                                                    {{ $item['total_harga'] }}
                                                                @else
                                                                    Rp {{ number_format((float)$item['total_harga'], 0, ',', '.') }}
                                                                @endif
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
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Tidak ada data pemasangan</p>
                            </div>
                        @endif
                    </div>
                    <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21c4.97 0 9-3.58 9-8 0-2.21-1.79-4-4-4H7c-2.21 0-4 1.79-4 4 0 4.42 4.03 8 9 8zm0-10V3m0 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                            </svg>
                            Ringkasan Keuangan
                        </h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Total:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format((float)($pemasangan->total ?? 0), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Diskon ({{ $pemasangan->diskon ?? 0 }}%):</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format((float)($pemasangan->total ?? 0) * (float)($pemasangan->diskon ?? 0) / 100, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Grand Total:</span>
                                <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format((float)($pemasangan->grand_total ?? 0), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @if($pemasangan->json_syarat_kondisi)
                        <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Syarat & Kondisi Pemasangan
                            </h2>
                            @if(is_array($pemasangan->json_syarat_kondisi))
                                <ul class="list-disc ml-6 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    @foreach($pemasangan->json_syarat_kondisi as $syarat)
                                        <li>{{ $syarat }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $pemasangan->json_syarat_kondisi }}</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 