<x-layouts.app :title="__('Detail Penawaran Pintu')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
                    <div class="mb-4 lg:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Detail Penawaran Pintu</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Informasi lengkap penawaran pintu
                            {{ $penawaran->nomor_penawaran }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Button Kembali -->
                        <a href="{{ route('admin.penawaran-pintu.index') }}"
                            class="flex items-center bg-gray-50 hover:bg-gray-100 dark:bg-gray-900/20 dark:hover:bg-gray-900/30 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informasi Utama -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informasi Revisi -->
                    @if ($penawaran->is_revisi)
                        <div
                            class="col-span-1 md:col-span-2 p-3 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Informasi
                                    Revisi</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-purple-700 dark:text-purple-300">Revisi dari:</span>
                                    <span class="text-purple-800 dark:text-purple-200">
                                        @if ($penawaran->penawaranAsli)
                                            <a href="{{ route('admin.penawaran-pintu.show', $penawaran->penawaranAsli->id) }}"
                                                class="hover:underline">
                                                {{ $penawaran->penawaranAsli->nomor_penawaran }}
                                            </a>
                                        @else
                                            {{ $penawaran->revisi_from ?? 'Tidak diketahui' }}
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium text-purple-700 dark:text-purple-300">Revisi:</span>
                                    <span class="text-purple-800 dark:text-purple-200">
                                        @php
                                            $revisionLevel = preg_match(
                                                '/R(\d+)$/',
                                                $penawaran->nomor_penawaran,
                                                $matches,
                                            )
                                                ? $matches[1]
                                                : '?';
                                        @endphp
                                        R{{ $revisionLevel }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Informasi Penawaran -->
                    <div
                        class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Informasi Penawaran
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                        Penawaran:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->nomor_penawaran ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                        Penawaran:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Project:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->project ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                    <span class="ml-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $penawaran->status == 1
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                : ($penawaran->status == 2
                                                    ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                                    : ($penawaran->status == 0
                                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'
                                                        : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200')) }}">
                                            {{ $penawaran->status == 1
                                                ? 'WIN'
                                                : ($penawaran->status == 2
                                                    ? 'LOSE'
                                                    : ($penawaran->status == 0
                                                        ? 'Draft'
                                                        : 'Draft')) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sales:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->user->name ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Dibuat
                                        Oleh:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->creator->name ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                        Dibuat:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->created_at ? $penawaran->created_at->format('d/m/Y H:i') : '-' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center col-span-1 md:col-span-2">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Judul
                                    Penawaran:</span>
                                <span
                                    class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->judul_penawaran ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Produk Pintu -->
                    <div class="w-full">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Detail Produk Pintu
                        </h2>

                        @if (is_array($penawaran->json_penawaran_pintu) && !empty($penawaran->json_penawaran_pintu))
                            @php $no = 1; @endphp
                            @foreach ($penawaran->json_penawaran_pintu as $sectionIndex => $section)
                                @if (strpos($sectionIndex, 'section_') === 0)
                                    <!-- Section Produk Pintu -->
                                    <div
                                        class="mb-8 border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-gray-50 dark:bg-zinc-800/50">
                                        <div class="mb-4">
                                            @if (!empty($section['judul_1']))
                                                <h3
                                                    class="text-lg font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                        </path>
                                                    </svg>
                                                    {{ $section['judul_1'] }}
                                                </h3>
                                            @endif
                                            <div class="grid grid-cols-1 md:grid-cols-2">
                                                @if (!empty($section['judul_2']))
                                                    <h4
                                                        class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3 ml-7">
                                                        {{ $section['judul_2'] }}
                                                    </h4>
                                                @endif
                                                @if (!empty($section['jumlah']))
                                                    <h4
                                                        class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3 ml-7">
                                                        Jumlah : {{ $section['jumlah'] }}
                                                    </h4>
                                                @endif
                                            </div>
                                        </div>

                                        @if (isset($section['products']) && is_array($section['products']) && !empty($section['products']))
                                            <div class="overflow-x-auto">
                                                <table
                                                    class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                    <thead class="bg-gray-100 dark:bg-zinc-700">
                                                        <tr>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                No</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                Item</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                Dimensi</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                Warna</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                Jumlah</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                Harga</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                Diskon</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                                Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                        class="bg-white dark:bg-zinc-900/30 divide-y divide-gray-200 dark:divide-gray-700">
                                                        @foreach ($section['products'] as $product)
                                                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                    {{ $no++ }}</td>
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                    {{ $product['item'] ?? '-' }}</td>
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                    @if (!empty($product['lebar']) || !empty($product['tinggi']) || !empty($product['tebal']))
                                                                        {{ $product['lebar'] ?? '' }}{{ !empty($product['lebar']) && (!empty($product['tinggi']) || !empty($product['tebal'])) ? ' x ' : '' }}{{ $product['tinggi'] ?? '' }}{{ !empty($product['tinggi']) && !empty($product['tebal']) ? ' x ' : '' }}{{ $product['tebal'] ?? '' }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                    {{ $product['warna'] ?? '-' }}</td>
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                    @if (isset($product['jumlah_individual']) && $product['jumlah_individual'] > 1)
                                                                        {{ $product['jumlah_individual'] }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                    {{ isset($product['harga']) ? (is_string($product['harga']) ? $product['harga'] : 'Rp ' . number_format($product['harga'], 0, ',', '.')) : '-' }}
                                                                </td>
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                    <table>
                                                                        <tr>
                                                                            <td>
                                                                                {{ isset($product['diskon']) ? (is_string($product['diskon']) ? $product['diskon'] : 'Rp ' . number_format($product['diskon'], 0, ',', '.')) . '%' : '-' }}
                                                                            </td>
                                                                            @if (isset($product['diskon_satu']) && (int) $product['diskon_satu'] > 0)
                                                                                <td>
                                                                                    {{ isset($product['diskon_satu']) ? (is_string($product['diskon_satu']) ? $product['diskon_satu'] : 'Rp ' . number_format($product['diskon_satu'], 0, ',', '.')) . '%' : '-' }}
                                                                                </td>
                                                                            @endif
                                                                            @if (isset($product['diskon_dua']) && (int) $product['diskon_dua'] > 0)
                                                                                <td>
                                                                                    {{ isset($product['diskon_dua']) ? (is_string($product['diskon_dua']) ? $product['diskon_dua'] : 'Rp ' . number_format($product['diskon_dua'], 0, ',', '.')) . '%' : '-' }}
                                                                                </td>
                                                                            @endif
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td
                                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                                    {{ isset($product['total_harga']) ? (is_string($product['total_harga']) ? $product['total_harga'] : 'Rp ' . number_format($product['total_harga'], 0, ',', '.')) : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <p class="text-gray-500 dark:text-gray-400">Tidak ada produk dalam
                                                    section ini</p>
                                            </div>
                                        @endif
                                    </div>
                                @elseif (is_numeric($sectionIndex))
                                    <!-- Produk Pintu Langsung (jika ada) -->
                                    <div
                                        class="mb-8 border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-gray-50 dark:bg-zinc-800/50">
                                        <div class="mb-4">
                                            @if (!empty($penawaran->json_penawaran_pintu['judul_1']))
                                                <h3
                                                    class="text-lg font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                        </path>
                                                    </svg>
                                                    {{ $penawaran->json_penawaran_pintu['judul_1'] }}
                                                </h3>
                                            @endif
                                            @if (!empty($penawaran->json_penawaran_pintu['judul_2']))
                                                <h4
                                                    class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3 ml-7">
                                                    {{ $penawaran->json_penawaran_pintu['judul_2'] }}
                                                </h4>
                                            @endif
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-100 dark:bg-zinc-700">
                                                    <tr>
                                                        <th
                                                            class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                            No</th>
                                                        <th
                                                            class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                            Item</th>
                                                        <th
                                                            class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                            Dimensi</th>
                                                        <th
                                                            class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                            Warna</th>
                                                        <th
                                                            class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                            Jumlah</th>
                                                        <th
                                                            class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                            Harga</th>
                                                        <th
                                                            class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                                            Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody
                                                    class="bg-white dark:bg-zinc-900/30 divide-y divide-gray-200 dark:divide-gray-700">
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">
                                                        <td
                                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                            {{ $no++ }}</td>
                                                        <td
                                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                            {{ $section['item'] ?? '-' }}</td>
                                                        <td
                                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                            @if (!empty($section['lebar']) || !empty($section['tinggi']) || !empty($section['tebal']))
                                                                {{ $section['lebar'] ?? '' }}{{ !empty($section['lebar']) && (!empty($section['tinggi']) || !empty($section['tebal'])) ? ' x ' : '' }}{{ $section['tinggi'] ?? '' }}{{ !empty($section['tinggi']) && !empty($section['tebal']) ? ' x ' : '' }}{{ $section['tebal'] ?? '' }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                            {{ $section['warna'] ?? '-' }}</td>
                                                        <td
                                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                            {{ $section['jumlah'] ?? '-' }}</td>
                                                        <td
                                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                            {{ isset($section['harga']) ? (is_string($section['harga']) ? $section['harga'] : 'Rp ' . number_format($section['harga'], 0, ',', '.')) : '-' }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ isset($section['total_harga']) ? (is_string($section['total_harga']) ? $section['total_harga'] : 'Rp ' . number_format($section['total_harga'], 0, ',', '.')) : '-' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Tidak ada data produk pintu</p>
                            </div>
                        @endif
                    </div>

                    <!-- Syarat & Kondisi -->
                    @if ($penawaran->syarat_kondisi)
                        <div
                            class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Syarat & Kondisi
                            </h2>
                            @if (is_array($penawaran->syarat_kondisi))
                                <ul class="list-disc ml-6 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    @foreach ($penawaran->syarat_kondisi as $syarat)
                                        <li>{{ $syarat }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                    {{ $penawaran->syarat_kondisi }}</div>
                            @endif
                        </div>
                    @endif

                    <!-- Catatan -->
                    @if ($penawaran->catatan)
                        <div
                            class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Catatan
                            </h2>
                            <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">
                                {{ $penawaran->catatan }}</div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Informasi Keuangan -->
                <div class="space-y-6">
                    <!-- Informasi Client -->
                    <div
                        class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Informasi Client
                        </h2>
                        <div class="w-full">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                        Client:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->client->nama ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Email
                                        Client:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->client->email ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Telepon
                                        Client:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->client->telepon ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Alamat
                                        Client:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->client->alamat ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Perusahaan
                                        Client:</span>
                                    <span
                                        class="ml-2 text-sm text-gray-900 dark:text-white">{{ $penawaran->client->perusahaan ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Keuangan -->
                    <div
                        class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                            Ringkasan Keuangan
                        </h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($penawaran->total ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">PPN
                                    ({{ $penawaran->ppn ?? 0 }}%):</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    Rp
                                    {{ number_format((($penawaran->total ?? 0) * ($penawaran->ppn ?? 0)) / 100, 0, ',', '.') }}
                                </span>
                            </div>
                            <hr class="border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Grand Total:</span>
                                <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                    Rp {{ number_format($penawaran->grand_total ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Pemasangan Terkait -->
                    @if ($penawaran->pemasangans && $penawaran->pemasangans->count())
                        <div
                            class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-lg p-4">
                            <div class="font-semibold text-emerald-700 dark:text-emerald-300 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Pemasangan Terkait Penawaran Ini:
                            </div>
                            <ul class="list-disc ml-6 space-y-1">
                                @foreach ($penawaran->pemasangans as $pemasangan)
                                    <li>
                                        <a href="{{ route('admin.pemasangan.show', $pemasangan->id) }}"
                                            class="text-blue-700 dark:text-blue-300 underline font-medium">
                                            {{ $pemasangan->nomor_pemasangan }}
                                            ({{ $pemasangan->tanggal_pemasangan ? $pemasangan->tanggal_pemasangan->format('d/m/Y') : '-' }})
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- RAB Terkait -->
                    @if ($penawaran->rancanganAnggaranBiayas && $penawaran->rancanganAnggaranBiayas->count())
                        <div
                            class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-lg p-4">
                            <div class="font-semibold text-purple-700 dark:text-purple-300 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 002 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                                RAB Terkait Penawaran Ini:
                            </div>
                            <ul class="list-disc ml-6 space-y-1">
                                @foreach ($penawaran->rancanganAnggaranBiayas as $rab)
                                    <li>
                                        <a href="{{ route('admin.rancangan-anggaran-biaya.show', $rab->id) }}"
                                            class="text-blue-700 dark:text-blue-300 underline font-medium">
                                            {{ $rab->proyek }} - {{ $rab->pekerjaan }}
                                            ({{ $rab->created_at ? $rab->created_at->format('d/m/Y') : '-' }})
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons Section -->
        <div
            class="mt-8 bg-white dark:bg-zinc-900/30 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Aksi Penawaran
            </h3>

            <div class="flex flex-wrap gap-3">
                <!-- Status Action Buttons -->
                @if ($penawaran->status != 1)
                    <form action="{{ route('admin.penawaran-pintu.update-status', $penawaran) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="1">
                        <button type="submit"
                            class="flex items-center bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/30 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            WIN
                        </button>
                    </form>
                @endif

                @if ($penawaran->status != 2 && (!$penawaran->pemasangans || $penawaran->pemasangans->count() == 0))
                    <form action="{{ route('admin.penawaran-pintu.update-status', $penawaran) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="2">
                        <button type="submit"
                            class="flex items-center bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            LOSE
                        </button>
                    </form>
                @endif

                @if ($penawaran->status != 0 && (!$penawaran->pemasangans || $penawaran->pemasangans->count() == 0))
                    <form action="{{ route('admin.penawaran-pintu.update-status', $penawaran) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="0">
                        <button type="submit"
                            class="flex items-center bg-yellow-50 hover:bg-yellow-100 dark:bg-yellow-900/20 dark:hover:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            BATALKAN
                        </button>
                    </form>
                @endif

                <!-- Action Buttons -->
                <a href="{{ route('admin.penawaran-pintu.cetak', $penawaran->id) }}"
                    class="flex items-center bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak PDF
                </a>

                <!-- Tombol Revisi -->
                @if ($penawaran->canCreateRevisi())
                    <a href="{{ route('admin.penawaran-pintu.create-revisi', $penawaran->id) }}"
                        class="flex items-center bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        @if ($penawaran->is_revisi)
                            Buat Revisi Lanjutan
                        @else
                            Buat Revisi
                        @endif
                    </a>
                @endif

                <a href="{{ route('admin.penawaran-pintu.edit', $penawaran) }}"
                    class="flex items-center bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 dark:hover:bg-amber-900/30 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Edit
                </a>

                <a href="{{ route('admin.pemasangan.create', ['penawaran_id' => $penawaran->id]) }}"
                    class="flex items-center bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Buat Pemasangan
                </a>

                @if ($penawaran->status == 1)
                    <a href="{{ route('admin.rancangan-anggaran-biaya.create', ['penawaran_id' => $penawaran->id]) }}"
                        class="flex items-center bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 002 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                        Buat RAB
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
