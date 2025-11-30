<x-layouts.supervisi title="Detail RAB - {{ $rab->proyek }}">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail RAB') }}
                </h2>
                <p class=" text-gray-600 dark:text-gray-400 mt-1">
                    {{ $rab->proyek }} • {{ $rab->pekerjaan }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('supervisi.rab.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-zinc-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-zinc-600 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-900 disabled:opacity-25 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="w-full">
        <div class="max-w-7xl mx-auto">
            <!-- Informasi Proyek -->
            <div class="mb-6">
                <div class="uppercase">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informasi Proyek</h3>
                </div>
                <div class="w-full pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block  font-medium text-zinc-700 dark:text-zinc-300">Nama Proyek</label>
                            <p class="mt-1  text-zinc-900 dark:text-white">{{ $rab->proyek }}</p>
                        </div>
                        <div>
                            <label class="block  font-medium text-zinc-700 dark:text-zinc-300">Pekerjaan</label>
                            <p class="mt-1  text-zinc-900 dark:text-white">{{ $rab->pekerjaan }}</p>
                        </div>
                        <div>
                            <label class="block  font-medium text-zinc-700 dark:text-zinc-300">Lokasi</label>
                            <p class="mt-1  text-zinc-900 dark:text-white">{{ $rab->lokasi }}</p>
                        </div>
                        <div>
                            <label class="block  font-medium text-zinc-700 dark:text-zinc-300">Status</label>
                            <div class="mt-1">
                                @php
                                    $statusColors = [
                                        'draft' =>
                                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'approved' =>
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $statusText = [
                                        'draft' => 'Draft',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                    ];
                                    $color =
                                        $statusColors[$rab->status] ??
                                        'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                    $text = $statusText[$rab->status] ?? $rab->status;
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ $text }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="block  font-medium text-zinc-700 dark:text-zinc-300">Dibuat Oleh</label>
                            <p class="mt-1  text-zinc-900 dark:text-white">{{ $rab->user->name ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <label class="block  font-medium text-zinc-700 dark:text-zinc-300">Tanggal Dibuat</label>
                            <p class="mt-1  text-zinc-900 dark:text-white">{{ $rab->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Material Utama --}}
            @if ($rab->json_pengeluaran_material_utama)
                <div class="w-full mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pengeluaran Material Utama</h3>

                    @php
                        // Check if this is a pintu penawaran by looking for section structure
                        $isPintuPenawaran = false;
                        if (is_array($rab->json_pengeluaran_material_utama)) {
                            foreach ($rab->json_pengeluaran_material_utama as $key => $value) {
                                if (strpos($key, 'section_') === 0 && isset($value['products'])) {
                                    $isPintuPenawaran = true;
                                    break;
                                }
                            }
                        }
                    @endphp

                    @if ($isPintuPenawaran)
                        {{-- Tampilan untuk Penawaran Pintu --}}
                        @foreach ($rab->json_pengeluaran_material_utama as $sectionKey => $section)
                            @if (isset($section['judul_1']) && isset($section['products']))
                                <div class="mb-6">
                                    <div class="mb-4">
                                        <h4 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                            {{ $section['judul_1'] }}</h4>
                                        @if (isset($section['judul_2']))
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $section['judul_2'] }}</p>
                                        @endif
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                            <thead class="bg-zinc-50 dark:bg-zinc-700">
                                                <tr>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                        Item</th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                        Nama Produk</th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                        Lebar</th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                        Tebal</th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                        Tinggi</th>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                        Warna</th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                                @foreach ($section['products'] as $product)
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                            {{ $product['item'] ?? '-' }}</td>
                                                        <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                            {{ $product['nama_produk'] ?? '-' }}</td>
                                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                            {{ $product['lebar'] ?? '-' }}</td>
                                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                            {{ $product['tebal'] ?? '-' }}</td>
                                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                            {{ $product['tinggi'] ?? '-' }}</td>
                                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                            {{ $product['warna'] ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        {{-- Tampilan untuk Penawaran Biasa --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                <thead class="bg-zinc-50 dark:bg-zinc-700">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                            Item</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                            Type</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                            Dimensi</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                            Panjang</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                            Qty</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                            Satuan</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                            Warna</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach ($rab->json_pengeluaran_material_utama as $item)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                {{ $item['item'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                {{ $item['type'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                {{ $item['dimensi'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                {{ $item['panjang'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                {{ $item['qty'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                {{ $item['satuan'] ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                {{ $item['warna'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Pengeluaran Pemasangan --}}
            @if ($rab->json_pengeluaran_pemasangan)
                <div class="w-full mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pengeluaran Pemasangan</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                        Item</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                        Satuan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                        Qty</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                        Harga Satuan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                        Total Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($rab->json_pengeluaran_pemasangan as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                            {{ $item['item'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['satuan'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['qty'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            Rp {{ number_format((float) preg_replace('/[^\d]/', '', $item['harga_satuan'] ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            Rp {{ number_format((float) preg_replace('/[^\d]/', '', $item['total_harga'] ?? 0), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Total Pemasangan --}}
                    @php
                        $totalPemasangan = 0;
                        foreach ($rab->json_pengeluaran_pemasangan as $item) {
                            $totalPemasangan += (float) preg_replace('/[^\d]/', '', $item['total_harga'] ?? 0);
                        }
                    @endphp
                    <div class="mt-4 p-4 bg-gray-100 dark:bg-zinc-700 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Grand Total Pemasangan:</span>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($totalPemasangan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pengeluaran Entertainment -->
            <div class="w-full">
                <div class="pb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pengeluaran Non Material</h3>
                    @php
                        // Filter entertainment data to remove empty/null entries
                        $filteredEntertainment = [];
                        if (
                            isset($rab->json_pengeluaran_entertaiment) &&
                            is_array($rab->json_pengeluaran_entertaiment)
                        ) {
                            foreach ($rab->json_pengeluaran_entertaiment as $mr) {
                                // Check if MR has valid data
                                if (!empty($mr['mr']) || !empty($mr['tanggal'])) {
                                    $validMaterials = [];

                                    if (isset($mr['materials']) && is_array($mr['materials'])) {
                                        foreach ($mr['materials'] as $material) {
                                            // Only include material if it has at least one non-null field
                                            if (
                                                !empty($material['supplier']) ||
                                                !empty($material['item']) ||
                                                !empty($material['qty']) ||
                                                !empty($material['satuan']) ||
                                                !empty($material['harga_satuan']) ||
                                                !empty($material['sub_total'])
                                            ) {
                                                $validMaterials[] = $material;
                                            }
                                        }
                                    }

                                    // Only include MR if it has valid materials or valid MR data
                                    if (!empty($validMaterials) || !empty($mr['mr']) || !empty($mr['tanggal'])) {
                                        $filteredEntertainment[] = [
                                            'mr' => $mr['mr'] ?? '',
                                            'tanggal' => $mr['tanggal'] ?? '',
                                            'materials' => $validMaterials,
                                        ];
                                    }
                                }
                            }
                        }

                        // Check if any material has approved/rejected status
                        $hasApprovedMaterial = false;
                        $hasRejectedMaterial = false;
                        foreach ($filteredEntertainment as $mr) {
                            if (isset($mr['materials']) && is_array($mr['materials'])) {
                                foreach ($mr['materials'] as $material) {
                                    if (($material['status'] ?? '') === 'Disetujui') {
                                        $hasApprovedMaterial = true;
                                    }
                                    if (($material['status'] ?? '') === 'Ditolak') {
                                        $hasRejectedMaterial = true;
                                    }
                                }
                            }
                        }
                    @endphp

                    @if ($hasApprovedMaterial)
                        <div
                            class="mt-2 p-3 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg">
                            <div class="flex lg:items-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class=" text-green-800 dark:text-green-200 font-medium">
                                    Ada material yang sudah disetujui. Material tersebut tidak dapat diubah atau
                                    dihapus.
                                </span>
                            </div>
                        </div>
                    @elseif($hasRejectedMaterial)
                        <div
                            class="mt-2 p-3 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span class=" text-red-800 dark:text-red-200 font-medium">
                                    Ada material yang ditolak. Material tersebut tidak dapat diubah atau dihapus.
                                </span>
                            </div>
                        </div>
                    @else
                        <div
                            class="mt-2 p-3 bg-blue-100 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class=" text-blue-800 dark:text-blue-200 font-medium">
                                    Semua material dalam status pengajuan. Data dapat diubah dan dihapus.
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="py-4">
                    <!-- Tampilan Data Entertainment yang Sudah Ada -->

                    @if (count($filteredEntertainment) > 0)
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Data Non Material
                                yang Sudah Ada</h4>
                            <div class="space-y-6">
                                @foreach ($filteredEntertainment as $mrIndex => $mr)
                                    <div
                                        class="bg-white dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-600 rounded-lg overflow-hidden">
                                        <!-- Header MR -->
                                        <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-4 py-3">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div class="bg-white/20 rounded-full p-2">
                                                        <svg class="w-5 h-5 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-white font-semibold">{{ $mr['mr'] ?? 'MR -' }}
                                                        </h5>
                                                        <p class="text-teal-100 ">
                                                            {{ $mr['tanggal'] ?? 'Tanggal tidak tersedia' }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-white ">Total:
                                                        {{ count($mr['materials'] ?? []) }} Material</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Layout untuk Material -->
                                        @if (isset($mr['materials']) && is_array($mr['materials']) && count($mr['materials']) > 0)
                                            <div class="space-y-4">
                                                @foreach ($mr['materials'] as $matIndex => $material)
                                                    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-600 p-4">
                                                        <!-- Header Card -->
                                                        <div class="flex items-start justify-between mb-3">
                                                            <div class="flex items-center gap-3">
                                                                <div class="p-2 bg-teal-100 dark:bg-teal-900/20 rounded-lg">
                                                                    <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $material['item'] ?? '-' }}</h4>
                                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $material['supplier'] ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                            @php
                                                                $statusColors = [
                                                                    'Pengajuan' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                                                                    'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                                                    'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                                                                ];
                                                                $status = $material['status'] ?? 'Pengajuan';
                                                                $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300';
                                                            @endphp
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                                {{ $status }}
                                                            </span>
                                                        </div>

                                                        <!-- Detail Info Grid -->
                                                        <div class="grid grid-cols-2 gap-4 mb-3">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                                </svg>
                                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Qty:</span>
                                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $material['qty'] ?? '-' }} {{ $material['satuan'] ?? '' }}</span>
                                                            </div>
                                                        </div>

                                                        <!-- Harga Info -->
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                                <div class="flex items-center gap-2 mb-1">
                                                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                                    </svg>
                                                                    <span class="text-sm font-medium text-green-700 dark:text-green-300">Harga Satuan</span>
                                                                </div>
                                                                <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                                                                    @if (isset($material['harga_satuan']) && $material['harga_satuan'])
                                                                        Rp {{ number_format((float) preg_replace('/[^\d]/', '', $material['harga_satuan']), 0, ',', '.') }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                                                                <div class="flex items-center gap-2 mb-1">
                                                                    <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                    <span class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Sub Total</span>
                                                                </div>
                                                                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                                                    @if (isset($material['sub_total']) && $material['sub_total'])
                                                                        Rp {{ number_format((float) preg_replace('/[^\d]/', '', $material['sub_total']), 0, ',', '.') }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Total per MR -->
                                            @php
                                                $totalMR = 0;
                                                if (isset($mr['materials']) && is_array($mr['materials'])) {
                                                    foreach ($mr['materials'] as $material) {
                                                        if (isset($material['sub_total']) && $material['sub_total']) {
                                                            $totalMR += (float) preg_replace(
                                                                '/[^\d]/',
                                                                '',
                                                                $material['sub_total'],
                                                            );
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <div
                                                class="bg-gray-50 dark:bg-zinc-800/50 px-4 py-3 border-t border-gray-200 dark:border-zinc-600">
                                                <div class="flex justify-between items-center">
                                                    <span class=" font-medium text-gray-700 dark:text-gray-300">Total
                                                        {{ $mr['mr'] ?? '-' }}:</span>
                                                    <span
                                                        class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                                        Rp {{ number_format($totalMR, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                                <svg class="mx-auto h-8 w-8 mb-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                    </path>
                                                </svg>
                                                <p>Belum ada material untuk MR ini</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                <!-- Grand Total -->
                                @php
                                    $grandTotal = 0;
                                    foreach ($filteredEntertainment as $mr) {
                                        if (isset($mr['materials']) && is_array($mr['materials'])) {
                                            foreach ($mr['materials'] as $material) {
                                                if (
                                                    isset($material['sub_total']) &&
                                                    $material['sub_total'] &&
                                                    ($material['status'] ?? '') === 'Disetujui'
                                                ) {
                                                    $grandTotal += (float) preg_replace(
                                                        '/[^\d]/',
                                                        '',
                                                        $material['sub_total'],
                                                    );
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-lg p-2 text-white">
                                    <div class="flex flex-col md:flex-row items-center justify-between">
                                        <div class="flex items-center lg:space-x-3">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                                </path>
                                            </svg>
                                            <div>
                                                <h3 class="font-bold">Non Material</h3>
                                            </div>
                                        </div>
                                        <div class="text-center lg:text-right">
                                            <div class="font-bold truncate">Rp
                                                {{ number_format($grandTotal, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($rab->status !== 'selesai')
                        <div class="border-t border-gray-200 dark:border-zinc-600 pt-6">
                            <div class="flex flex-col lg:justify-between lg:items-center gap-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pengajuan Material &
                                    Dana</h4>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('supervisi.rab.edit-entertainment', $rab) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 dark:bg-teal-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-teal-700 dark:hover:bg-teal-600 focus:outline-none focus:border-teal-700 focus:ring focus:ring-teal-200 active:bg-teal-900 disabled:opacity-25 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Pengajuan Non Material
                                    </a>
                                    <a href="{{ route('supervisi.rab.edit-tukang', $rab) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 dark:bg-purple-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-purple-700 dark:hover:bg-purple-600 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-200 active:bg-purple-900 disabled:opacity-25 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Pengajuan Tukang
                                    </a>
                                    <a href="{{ route('supervisi.rab.edit-kerja-tambah', $rab) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 dark:bg-orange-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-orange-700 dark:hover:bg-orange-600 focus:outline-none focus:border-orange-700 focus:ring focus:ring-orange-200 active:bg-orange-900 disabled:opacity-25 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                                            </path>
                                        </svg>
                                        Pengajuan Kerja Tambah
                                    </a>
                                    <a href="{{ route('supervisi.rab.edit-material-tambahan', $rab) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-900 disabled:opacity-25 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        Pengajuan Material Tambahan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pengeluaran Material Tambahan -->
            @if (isset($rab->json_pengeluaran_material_tambahan) &&
                    is_array($rab->json_pengeluaran_material_tambahan) &&
                    count($rab->json_pengeluaran_material_tambahan) > 0)
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Pengeluaran Material Tambahan</h3>

                    <div class="space-y-6">
                        @foreach ($rab->json_pengeluaran_material_tambahan as $mrIndex => $mr)
                            <div
                                class="bg-white dark:bg-zinc-900/50 border border-indigo-200 dark:border-indigo-600 rounded-lg overflow-hidden">
                                <!-- Header MR -->
                                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-4 py-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-white/20 rounded-full p-2">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="text-white font-semibold">{{ $mr['mr'] ?? 'MR -' }}</h5>
                                                <p class="text-indigo-100 text-sm">
                                                    {{ $mr['tanggal'] ?? 'Tanggal tidak tersedia' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-white text-sm">{{ count($mr['materials'] ?? []) }}
                                                Material</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Layout untuk Material -->
                                @if (isset($mr['materials']) && is_array($mr['materials']) && count($mr['materials']) > 0)
                                    <div class="space-y-4">
                                        @foreach ($mr['materials'] as $matIndex => $material)
                                            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-600 p-4">
                                                <!-- Header Card -->
                                                <div class="flex items-start justify-between mb-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg">
                                                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $material['item'] ?? '-' }}</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $material['supplier'] ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $statusColors = [
                                                            'Pengajuan' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                                                            'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                                            'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                                                        ];
                                                        $status = $material['status'] ?? 'Pengajuan';
                                                        $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300';
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                        {{ $status }}
                                                    </span>
                                                </div>

                                                <!-- Detail Info Grid -->
                                                <div class="grid grid-cols-2 gap-4 mb-3">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                        </svg>
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Qty:</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $material['qty'] ?? '-' }} {{ $material['satuan'] ?? '' }}</span>
                                                    </div>
                                                </div>

                                                <!-- Harga Info -->
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                            </svg>
                                                            <span class="text-sm font-medium text-green-700 dark:text-green-300">Harga Satuan</span>
                                                        </div>
                                                        <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                                                            @if (isset($material['harga_satuan']) && $material['harga_satuan'])
                                                                Rp {{ number_format((float) preg_replace('/[^\d]/', '', $material['harga_satuan']), 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <span class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Sub Total</span>
                                                        </div>
                                                        <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                                            @if (isset($material['sub_total']) && $material['sub_total'])
                                                                Rp {{ number_format((float) preg_replace('/[^\d]/', '', $material['sub_total']), 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Total per MR -->
                                    @php
                                        $totalMR = 0;
                                        if (isset($mr['materials']) && is_array($mr['materials'])) {
                                            foreach ($mr['materials'] as $material) {
                                                if (isset($material['sub_total']) && $material['sub_total']) {
                                                    $totalMR += (float) preg_replace(
                                                        '/[^\d]/',
                                                        '',
                                                        $material['sub_total'],
                                                    );
                                                }
                                            }
                                        }
                                    @endphp
                                    <div
                                        class="bg-gray-50 dark:bg-zinc-800/50 px-4 py-3 border-t border-gray-200 dark:border-zinc-600">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total
                                                {{ $mr['mr'] ?? '-' }}:</span>
                                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($totalMR, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p>Belum ada material untuk MR ini</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <!-- Grand Total -->
                        @php
                            $grandTotal = 0;
                            foreach ($rab->json_pengeluaran_material_tambahan as $mr) {
                                if (isset($mr['materials']) && is_array($mr['materials'])) {
                                    foreach ($mr['materials'] as $material) {
                                        if (
                                            isset($material['sub_total']) &&
                                            $material['sub_total'] &&
                                            ($material['status'] ?? '') === 'Disetujui'
                                        ) {
                                            $grandTotal += (float) preg_replace('/[^\d]/', '', $material['sub_total']);
                                        }
                                    }
                                }
                            }
                        @endphp
                        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-lg p-2 text-white">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="flex items-center lg:space-x-3">
                                    <h3 class="font-bold">Material Tambahan</h3>
                                </div>
                                <div class="text-center lg:text-right">
                                    <div class="font-bold truncate">Rp
                                        {{ number_format($grandTotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Pengeluaran Material Pendukung -->
            @if (isset($rab->json_pengeluaran_material_pendukung) &&
                    is_array($rab->json_pengeluaran_material_pendukung) &&
                    count($rab->json_pengeluaran_material_pendukung) > 0)
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Pengeluaran Material Pendukung
                    </h3>
                    <div class="space-y-6">
                        @foreach ($rab->json_pengeluaran_material_pendukung as $mrIndex => $mr)
                            <div
                                class="bg-white dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-600 rounded-lg overflow-hidden shadow-sm">
                                <!-- Header MR -->
                                <div class="bg-white dark:bg-zinc-900/30 px-4 py-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-white/20 rounded-full p-2">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="text-white font-semibold">{{ $mr['mr'] ?? 'MR -' }}</h5>
                                                <p class="text-orange-100 ">
                                                    {{ $mr['tanggal'] ?? 'Tanggal tidak tersedia' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-white ">{{ count($mr['materials'] ?? []) }}
                                                Material</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Layout untuk Material -->
                                @if (isset($mr['materials']) && is_array($mr['materials']) && count($mr['materials']) > 0)
                                    <div class="space-y-4">
                                        @foreach ($mr['materials'] as $material)
                                            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-600 p-4">
                                                <!-- Header Card -->
                                                <div class="flex items-start justify-between mb-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $material['item'] ?? '-' }}</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $material['supplier'] ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Detail Info Grid -->
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                        </svg>
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Qty:</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $material['qty'] ?? '-' }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                        </svg>
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Satuan:</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $material['satuan'] ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p>Belum ada material untuk MR ini</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Pengeluaran Tukang -->
            @if (isset($rab->json_pengeluaran_tukang) &&
                    is_array($rab->json_pengeluaran_tukang) &&
                    count($rab->json_pengeluaran_tukang) > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pengeluaran Tukang</h3>
                    <div class="space-y-6">
                        @foreach ($rab->json_pengeluaran_tukang as $sectionIndex => $section)
                            <div
                                class="bg-white dark:bg-zinc-900/50 border border-purple-200 dark:border-purple-600 rounded-lg overflow-hidden shadow-sm">
                                <!-- Header Section -->
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-4 py-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-white/20 rounded-full p-2">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="text-white font-semibold">Pengeluaran Tukang</h5>
                                                <p class="text-purple-100 text-sm">
                                                    Debet: Rp
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $section['debet'] ?? 0), 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Layout untuk Termin -->
                                @if (isset($section['termin']) && is_array($section['termin']) && count($section['termin']) > 0)
                                    <div class="space-y-4">
                                        @foreach ($section['termin'] as $terminIndex => $termin)
                                            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-600 p-4">
                                                <!-- Header Card -->
                                                <div class="flex items-start justify-between mb-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="p-2 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white">Termin {{ $terminIndex + 1 }}</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $termin['tanggal'] ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $statusColors = [
                                                            'Pengajuan' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                                                            'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                                            'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                                                        ];
                                                        $status = $termin['status'] ?? 'Pengajuan';
                                                        $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300';
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                        {{ $status }}
                                                    </span>
                                                </div>

                                                <!-- Detail Info Grid -->
                                                <div class="grid grid-cols-1 gap-4 mb-3">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Persentase:</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $termin['persentase'] ?? '-' }}</span>
                                                    </div>
                                                </div>

                                                <!-- Financial Info -->
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                            </svg>
                                                            <span class="text-sm font-medium text-green-700 dark:text-green-300">Kredit</span>
                                                        </div>
                                                        <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                                                            @if (isset($termin['kredit']) && $termin['kredit'])
                                                                Rp {{ number_format((float) preg_replace('/[^\d]/', '', $termin['kredit']), 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                            </svg>
                                                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Sisa</span>
                                                        </div>
                                                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                                            @if (isset($termin['sisa']) && $termin['sisa'])
                                                                Rp {{ number_format((float) preg_replace('/[^\d]/', '', $termin['sisa']), 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Total per Section -->
                                    @php
                                        $totalKredit = 0;
                                        if (isset($section['termin']) && is_array($section['termin'])) {
                                            foreach ($section['termin'] as $termin) {
                                                if (isset($termin['kredit']) && $termin['kredit']) {
                                                    $totalKredit += (float) preg_replace(
                                                        '/[^\d]/',
                                                        '',
                                                        $termin['kredit'],
                                                    );
                                                }
                                            }
                                        }
                                    @endphp
                                    <div
                                        class="bg-gray-50 dark:bg-zinc-800/50 px-4 py-3 border-t border-gray-200 dark:border-zinc-600">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total
                                                Kredit:</span>
                                            <span class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                                Rp {{ number_format($totalKredit, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        <p>Belum ada termin untuk pengeluaran tukang ini</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Kerja Tambah -->
            @if (isset($rab->json_kerja_tambah) && is_array($rab->json_kerja_tambah) && count($rab->json_kerja_tambah) > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Kerja Tambah</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Data kerja tambah untuk proyek ini
                    </p>

                    <div class="space-y-6">
                        @foreach ($rab->json_kerja_tambah as $sectionIndex => $section)
                            <div
                                class="bg-white dark:bg-zinc-900/50 border border-orange-200 dark:border-orange-600 rounded-lg overflow-hidden shadow-sm">
                                <!-- Header Section -->
                                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-white/20 rounded-full p-2">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="text-white font-semibold">Kerja Tambah</h5>
                                                <p class="text-orange-100 text-sm">
                                                    Debet: Rp
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $section['debet'] ?? 0), 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Layout untuk Termin -->
                                @if (isset($section['termin']) && is_array($section['termin']) && count($section['termin']) > 0)
                                    <div class="space-y-4">
                                        @foreach ($section['termin'] as $terminIndex => $termin)
                                            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-600 p-4">
                                                <!-- Header Card -->
                                                <div class="flex items-start justify-between mb-3">
                                                    <div class="flex items-center gap-3">
                                                        <div class="p-2 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-gray-900 dark:text-white">Termin {{ $terminIndex + 1 }}</h4>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $termin['tanggal'] ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $statusColors = [
                                                            'Pengajuan' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                                                            'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                                            'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                                                        ];
                                                        $status = $termin['status'] ?? 'Pengajuan';
                                                        $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300';
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                        {{ $status }}
                                                    </span>
                                                </div>

                                                <!-- Detail Info Grid -->
                                                <div class="grid grid-cols-1 gap-4 mb-3">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Persentase:</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $termin['persentase'] ?? '-' }}</span>
                                                    </div>
                                                </div>

                                                <!-- Financial Info -->
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                            </svg>
                                                            <span class="text-sm font-medium text-green-700 dark:text-green-300">Kredit</span>
                                                        </div>
                                                        <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                                                            @if (isset($termin['kredit']) && $termin['kredit'])
                                                                Rp {{ number_format((float) preg_replace('/[^\d]/', '', $termin['kredit']), 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                            </svg>
                                                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Sisa</span>
                                                        </div>
                                                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                                            @if (isset($termin['sisa']) && $termin['sisa'])
                                                                Rp {{ number_format((float) preg_replace('/[^\d]/', '', $termin['sisa']), 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Total per Section -->
                                    @php
                                        $totalKredit = 0;
                                        if (isset($section['termin']) && is_array($section['termin'])) {
                                            foreach ($section['termin'] as $termin) {
                                                if (isset($termin['kredit']) && $termin['kredit']) {
                                                    $totalKredit += (float) preg_replace(
                                                        '/[^\d]/',
                                                        '',
                                                        $termin['kredit'],
                                                    );
                                                }
                                            }
                                        }
                                    @endphp
                                    <div
                                        class="bg-gray-50 dark:bg-zinc-800/50 px-4 py-3 border-t border-gray-200 dark:border-zinc-600">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total
                                                Kredit:</span>
                                            <span class="text-lg font-bold text-orange-600 dark:text-orange-400">
                                                Rp {{ number_format($totalKredit, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                                            </path>
                                        </svg>
                                        <p>Belum ada termin untuk kerja tambah ini</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>



            {{-- Kesimpulan / Summary --}}
            <div class="w-full mb-6 mt-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 uppercase">Kesimpulan</h3>

                @php
                    // 1. Total Pemasangan
                    $totalPemasangan = 0;
                    if ($rab->json_pengeluaran_pemasangan && is_array($rab->json_pengeluaran_pemasangan)) {
                        foreach ($rab->json_pengeluaran_pemasangan as $item) {
                            $totalPemasangan += (float) preg_replace('/[^\d]/', '', $item['total_harga'] ?? 0);
                        }
                    }

                    // 2. Material Pendukung (Total semua)
                    $totalMaterialPendukung = 0;
                    if ($rab->json_pengeluaran_material_pendukung && is_array($rab->json_pengeluaran_material_pendukung)) {
                        foreach ($rab->json_pengeluaran_material_pendukung as $mr) {
                            if (isset($mr['materials']) && is_array($mr['materials'])) {
                                foreach ($mr['materials'] as $material) {
                                    $totalMaterialPendukung += (float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0);
                                }
                            }
                        }
                    }

                    // 3. Entertainment (Disetujui)
                    $totalEntertainment = 0;
                    if ($rab->json_pengeluaran_entertaiment && is_array($rab->json_pengeluaran_entertaiment)) {
                        foreach ($rab->json_pengeluaran_entertaiment as $mr) {
                            if (isset($mr['materials']) && is_array($mr['materials'])) {
                                foreach ($mr['materials'] as $material) {
                                    if (($material['status'] ?? '') === 'Disetujui') {
                                        $totalEntertainment += (float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0);
                                    }
                                }
                            }
                        }
                    }

                    // 4. Material Tambahan (Disetujui)
                    $totalMaterialTambahan = 0;
                    if ($rab->json_pengeluaran_material_tambahan && is_array($rab->json_pengeluaran_material_tambahan)) {
                        foreach ($rab->json_pengeluaran_material_tambahan as $mr) {
                            if (isset($mr['materials']) && is_array($mr['materials'])) {
                                foreach ($mr['materials'] as $material) {
                                    if (($material['status'] ?? '') === 'Disetujui') {
                                        $totalMaterialTambahan += (float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0);
                                    }
                                }
                            }
                        }
                    }

                    // 5. Tukang (Disetujui)
                    $totalTukang = 0;
                    if ($rab->json_pengeluaran_tukang && is_array($rab->json_pengeluaran_tukang)) {
                        foreach ($rab->json_pengeluaran_tukang as $section) {
                            if (isset($section['termin']) && is_array($section['termin'])) {
                                foreach ($section['termin'] as $termin) {
                                    if (($termin['status'] ?? '') === 'Disetujui') {
                                        $totalTukang += (float) preg_replace('/[^\d]/', '', $termin['kredit'] ?? 0);
                                    }
                                }
                            }
                        }
                    }

                    // 6. Kerja Tambah (Disetujui)
                    $totalKerjaTambah = 0;
                    if ($rab->json_kerja_tambah && is_array($rab->json_kerja_tambah)) {
                        foreach ($rab->json_kerja_tambah as $section) {
                            if (isset($section['termin']) && is_array($section['termin'])) {
                                foreach ($section['termin'] as $termin) {
                                    if (($termin['status'] ?? '') === 'Disetujui') {
                                        $totalKerjaTambah += (float) preg_replace('/[^\d]/', '', $termin['kredit'] ?? 0);
                                    }
                                }
                            }
                        }
                    }

                    // Total Pengeluaran
                    $totalPengeluaran = $totalMaterialPendukung + $totalEntertainment + $totalMaterialTambahan + $totalTukang + $totalKerjaTambah;

                    // Sisa Kas
                    $sisaKas = $totalPemasangan - $totalPengeluaran;
                @endphp

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <div class="space-y-3">
                        {{-- Pemasangan --}}
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-zinc-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Pemasangan</span>
                            <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                                Rp {{ number_format($totalPemasangan, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Pengeluaran --}}
                        <div class="pl-4 space-y-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Material Pendukung</span>
                                <span class="text-red-600 dark:text-red-400">
                                    - Rp {{ number_format($totalMaterialPendukung, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Non Material (Disetujui)</span>
                                <span class="text-red-600 dark:text-red-400">
                                    - Rp {{ number_format($totalEntertainment, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Material Tambahan (Disetujui)</span>
                                <span class="text-red-600 dark:text-red-400">
                                    - Rp {{ number_format($totalMaterialTambahan, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Tukang (Disetujui)</span>
                                <span class="text-red-600 dark:text-red-400">
                                    - Rp {{ number_format($totalTukang, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Kerja Tambah (Disetujui)</span>
                                <span class="text-red-600 dark:text-red-400">
                                    - Rp {{ number_format($totalKerjaTambah, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Total Pengeluaran --}}
                        <div class="flex justify-between items-center pt-2 pb-3 border-b border-gray-200 dark:border-zinc-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Pengeluaran</span>
                            <span class="text-sm font-semibold text-red-600 dark:text-red-400">
                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Sisa Kas --}}
                        <div class="flex justify-between items-center pt-3 bg-{{ $sisaKas >= 0 ? 'green' : 'red' }}-50 dark:bg-{{ $sisaKas >= 0 ? 'green' : 'red' }}-900/20 p-4 rounded-lg">
                            <span class="text-base font-bold text-gray-900 dark:text-white">Sisa Kas</span>
                            <span class="text-xl font-bold text-{{ $sisaKas >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $sisaKas >= 0 ? 'green' : 'red' }}-400">
                                Rp {{ number_format($sisaKas, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.supervisi>
