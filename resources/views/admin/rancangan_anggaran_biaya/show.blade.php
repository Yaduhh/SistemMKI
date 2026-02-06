<x-layouts.app :title="__('Detail Rancangan Anggaran Biaya')">
    <div class="container mx-auto">
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />
        
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6">
            <h1 class="text-2xl font-bold">Detail Rancangan Anggaran Biaya (RAB)</h1>
            <div class="flex space-x-2 mt-4 lg:mt-0">
                <a href="{{ route('admin.rancangan-anggaran-biaya.export-pdf', $rancanganAnggaranBiaya) }}"
                    class="px-4 py-2 bg-green-50 dark:bg-green-900 text-green-600 dark:text-green-400 rounded-md hover:bg-green-100 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Cetak PDF
                </a>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit', $rancanganAnggaranBiaya) }}"
                    class="px-4 py-2 bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit
                </a>
                <a href="{{ route('admin.rancangan-anggaran-biaya.index') }}"
                    class="px-4 py-2 bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Project Information -->
        <div
            class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Informasi Proyek</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Proyek</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rancanganAnggaranBiaya->proyek }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pekerjaan</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rancanganAnggaranBiaya->pekerjaan }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Kontraktor</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rancanganAnggaranBiaya->kontraktor }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Lokasi</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rancanganAnggaranBiaya->lokasi }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status</label>
                    <div class="mt-1">
                        @php
                            $statusColors = [
                                'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                'on_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                'selesai' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            ];
                            $statusText = [
                                'draft' => 'Draft',
                                'on_progress' => 'On Progress',
                                'selesai' => 'Selesai',
                            ];
                            $color =
                                $statusColors[$rancanganAnggaranBiaya->status] ??
                                'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                            $text = $statusText[$rancanganAnggaranBiaya->status] ?? $rancanganAnggaranBiaya->status;
                        @endphp
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                            {{ $text }}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Dibuat Oleh</label>
                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                        {{ $rancanganAnggaranBiaya->user->name ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Supervisi</label>
                    <div class="mt-1">
                        @if ($rancanganAnggaranBiaya->supervisi)
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $rancanganAnggaranBiaya->supervisi->name }}
                            </p>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Belum ditugaskan</p>
                        @endif

                        <!-- Form untuk mengubah supervisi -->
                        <form
                            action="{{ route('admin.rancangan-anggaran-biaya.update-supervisi', $rancanganAnggaranBiaya) }}"
                            method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center space-x-2">
                                <select name="supervisi_id"
                                    class="text-sm border border-zinc-300 dark:border-zinc-600 rounded-md px-3 py-1 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Supervisi</option>
                                    @foreach (\App\Models\User::where('role', 4)->get() as $supervisi)
                                        <option value="{{ $supervisi->id }}"
                                            {{ $rancanganAnggaranBiaya->supervisi_id == $supervisi->id ? 'selected' : '' }}>
                                            {{ $supervisi->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Information -->
        @if ($rancanganAnggaranBiaya->penawaran || $rancanganAnggaranBiaya->pemasangan)
            <div
                class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Informasi Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if ($rancanganAnggaranBiaya->penawaran)
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nomor
                                Penawaran</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                                {{ $rancanganAnggaranBiaya->penawaran->nomor_penawaran }}</p>
                        </div>
                    @endif
                    @if ($rancanganAnggaranBiaya->pemasangan)
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nomor
                                Pemasangan</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                                {{ $rancanganAnggaranBiaya->pemasangan->nomor_pemasangan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Material Utama -->
        <div class="w-full mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Pengeluaran Material Utama</h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>

            @if ($rancanganAnggaranBiaya->json_pengeluaran_material_utama)

                <!-- Informasi Penawaran Terkait -->
                @if ($rancanganAnggaranBiaya->penawaran)
                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-6">
                        <h3 class="text-md font-semibold text-blue-700 dark:text-blue-300 mb-3">Informasi Penawaran
                            Terkait</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-blue-600 dark:text-blue-400">Nomor
                                    Penawaran</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white font-medium">
                                    {{ $rancanganAnggaranBiaya->penawaran->nomor_penawaran }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-blue-600 dark:text-blue-400">Total
                                    Penawaran</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white font-medium">Rp
                                    {{ number_format($rancanganAnggaranBiaya->penawaran->total ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-blue-600 dark:text-blue-400">Grand Total
                                    Penawaran</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white font-medium">Rp
                                    {{ number_format($rancanganAnggaranBiaya->penawaran->grand_total ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-blue-600 dark:text-blue-400">Diskon</label>
                                <div class="grid grid-cols-3 gap-4">
                                    @if ($rancanganAnggaranBiaya->penawaran->diskon)
                                        <p class="mt-1 text-sm text-zinc-900 dark:text-white font-medium">
                                            {{ number_format($rancanganAnggaranBiaya->penawaran->diskon, 2, ',', '.') }}%
                                        </p>
                                    @endif
                                    @if ($rancanganAnggaranBiaya->penawaran->diskon_satu)
                                        <p class="mt-1 text-sm text-zinc-900 dark:text-white font-medium">
                                            {{ number_format($rancanganAnggaranBiaya->penawaran->diskon_satu, 2, ',', '.') }}%
                                        </p>
                                    @endif
                                    @if ($rancanganAnggaranBiaya->penawaran->diskon_dua)
                                        <p class="mt-1 text-sm text-zinc-900 dark:text-white font-medium">
                                            {{ number_format($rancanganAnggaranBiaya->penawaran->diskon_dua, 2, ',', '.') }}%
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @if ($rancanganAnggaranBiaya->penawaran->ppn)
                                <div>
                                    <label
                                        class="block text-sm font-medium text-blue-600 dark:text-blue-400">PPN</label>
                                    <p class="mt-1 text-sm text-zinc-900 dark:text-white font-medium">
                                        {{ number_format($rancanganAnggaranBiaya->penawaran->ppn, 2, ',', '.') }}%</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @php
                    // Check if this is a pintu penawaran by looking for section structure
                    $isPintuPenawaran = false;
                    if (is_array($rancanganAnggaranBiaya->json_pengeluaran_material_utama)) {
                        foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_utama as $key => $value) {
                            if (strpos($key, 'section_') === 0 && isset($value['products'])) {
                                $isPintuPenawaran = true;
                                break;
                            }
                        }
                    }
                @endphp

                @if ($isPintuPenawaran)
                    <!-- Tampilan untuk Penawaran Pintu -->
                    @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_utama as $sectionKey => $section)
                        @if (isset($section['judul_1']) && isset($section['products']))
                            <div class="mb-6">
                                <div class="mb-4">
                                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                        {{ $section['judul_1'] }}</h3>
                                    <div class="grid grid-cols-2">
                                        @if (isset($section['judul_2']))
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ $section['judul_2'] }}</p>
                                        @endif
                                        @if (isset($section['jumlah']))
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">Jumlah:
                                                {{ $section['jumlah'] }}</p>
                                        @endif
                                    </div>
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
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                    Harga</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                    Jumlah</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                    Diskon</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                                    Total Harga</th>
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
                                                        @if (isset($product['lebar']) && $product['lebar'] > 0)
                                                            {{ $product['lebar'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        @if (isset($product['tebal']) && $product['tebal'] > 0)
                                                            {{ $product['tebal'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        @if (isset($product['tinggi']) && $product['tinggi'] > 0)
                                                            {{ $product['tinggi'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ $product['warna'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        Rp
                                                        {{ number_format((float) preg_replace('/[^\d.]/', '', $product['harga'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        @if (isset($product['jumlah_individual']) && $product['jumlah_individual'] > 1)
                                                            {{ $product['jumlah_individual'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        @if (isset($product['diskon']) && $product['diskon'] > 0)
                                                            {{ number_format((float) $product['diskon'], 0, ',', '.') }}%
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        Rp
                                                        {{ number_format((float) preg_replace('/[^\d.]/', '', $product['total_harga'] ?? 0), 0, ',', '.') }}
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
                    <!-- Tampilan untuk Penawaran Biasa (tidak diubah) -->
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
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                        Harga Satuan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_utama as $item)
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
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ number_format((float) preg_replace('/[^\d.]/', '', $item['harga_satuan'] ?? 0), 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ number_format((float) preg_replace('/[^\d.]/', '', $item['total'] ?? 0), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <p>Tidak ada data material utama</p>
                </div>
            @endif
        </div>

        <!-- Section Material Pendukung -->
        <div class="w-full mb-6 border border-sky-200 dark:border-sky-700 dark:bg-zinc-900/30">
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600/30 py-2 uppercase text-white">
                    Section Material Pendukung
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-section-material-pendukung', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-sky-600 text-white text-sm rounded-md hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_section_material_pendukung)
                <div class="w-full">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-sky-50 dark:bg-sky-900/20">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        Item Barang</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        Ukuran</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        Panjang</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        Qty</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        Satuan</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        Harga Satuan</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        PPN (%)</th>
                                    <th
                                        class="px-4 py-3 text-right text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($rancanganAnggaranBiaya->json_section_material_pendukung as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                            {{ $item['item_barang'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['ukuran'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['panjang'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300 text-center">
                                            {{ $item['qty'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300 text-center">
                                            {{ $item['satuan'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300 text-right">
                                            Rp {{ number_format((float) preg_replace('/[^\d.]/', '', $item['harga_satuan'] ?? 0), 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300 text-center">
                                            {{ $item['ppn'] ?? '0' }}%
                                        </td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300 text-right">
                                            Rp {{ number_format((float) preg_replace('/[^\d.]/', '', $item['total'] ?? 0), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Total Section Material Pendukung -->
                    @php
                        $totalSectionMaterialPendukung = 0;
                        $totalDppSectionMaterialPendukung = 0;
                        $totalPpnSectionMaterialPendukung = 0;
                        
                        foreach ($rancanganAnggaranBiaya->json_section_material_pendukung as $item) {
                            $total = (float) preg_replace('/[^\d.]/', '', $item['total'] ?? 0);
                            $ppnPersen = (float) ($item['ppn'] ?? 0);
                            
                            if ($ppnPersen > 0) {
                                $dpp = $total / (1 + ($ppnPersen / 100));
                                $ppnAmount = $total - $dpp;
                                $totalDppSectionMaterialPendukung += $dpp;
                                $totalPpnSectionMaterialPendukung += $ppnAmount;
                            } else {
                                $totalDppSectionMaterialPendukung += $total;
                            }
                            $totalSectionMaterialPendukung += $total;
                        }
                    @endphp
                    <div class="p-4 bg-sky-50 dark:bg-sky-900/20 rounded-lg space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-medium text-sky-700 dark:text-sky-300">Total DPP:</span>
                            <span class="font-bold text-sky-600 dark:text-sky-400">
                                Rp {{ number_format($totalDppSectionMaterialPendukung, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($totalPpnSectionMaterialPendukung > 0)
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-medium text-sky-700 dark:text-sky-300">Total PPN:</span>
                            <span class="font-bold text-sky-600 dark:text-sky-400">
                                Rp {{ number_format($totalPpnSectionMaterialPendukung, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center border-t border-sky-200 dark:border-sky-800 pt-2">
                            <span class="text-sm font-bold text-sky-700 dark:text-sky-300">Total Section Material Pendukung:</span>
                            <span class="text-lg font-extrabold text-sky-600 dark:text-sky-400">
                                Rp {{ number_format($totalSectionMaterialPendukung, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data section material pendukung</p>
                </div>
            @endif
        </div>

        <!-- Pengeluaran Pemasangan -->
        <div class="w-full mb-6 border border-amber-200 dark:border-amber-700 dark:bg-zinc-900/30">
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-lg font-semibold w-full text-center bg-amber-600 dark:bg-amber-600/30 py-2 uppercase text-white">
                    Pengeluaran Pemasangan
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-pemasangan', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-amber-600 text-white text-sm rounded-md hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_pengeluaran_pemasangan)
                <div class="w-full">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-amber-50 dark:bg-amber-900/20">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-amber-700 dark:text-amber-300 uppercase">
                                        Item</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-amber-700 dark:text-amber-300 uppercase">
                                        Satuan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-amber-700 dark:text-amber-300 uppercase">
                                        Qty</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-amber-700 dark:text-amber-300 uppercase">
                                        Harga Satuan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-amber-700 dark:text-amber-300 uppercase">
                                        Total Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_pemasangan as $item)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                            {{ $item['item'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['satuan'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['qty'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            Rp {{ number_format((float) preg_replace('/[^\d.]/', '', $item['harga_satuan'] ?? 0), 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            Rp {{ number_format((float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0), 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Total Pemasangan -->
                    @php
                        $totalPemasangan = 0;
                        foreach ($rancanganAnggaranBiaya->json_pengeluaran_pemasangan as $item) {
                            $totalPemasangan += (float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0);
                        }
                    @endphp
                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                        <div class="text-right">
                            <span class="text-sm font-medium text-amber-700 dark:text-amber-300">Total Pemasangan:</span>
                            <span class="ml-2 text-lg font-bold text-amber-600 dark:text-amber-400">
                                Rp {{ number_format($totalPemasangan, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data pengeluaran pemasangan</p>
                </div>
            @endif
        </div>

        <!-- Harga Tukang -->
        <div class="w-full mb-6 border border-purple-200 dark:border-purple-700 dark:bg-zinc-900/30">
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600/30 py-2 uppercase text-white">
                    Harga Tukang
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-harga-tukang', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang)
                <div class="w-full">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-purple-50 dark:bg-purple-900/20">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                        Item</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                        Satuan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                        Qty</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                        Harga Satuan</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                        Total Harga</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang as $item)
                                    @php
                                        $status = $item['status'] ?? 'Pengajuan';
                                        $statusColor = match($status) {
                                            'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                            default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                            {{ $item['item'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['satuan'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            {{ $item['qty'] ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            Rp {{ number_format((float) preg_replace('/[^\d.]/', '', $item['harga_satuan'] ?? 0), 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                            Rp {{ number_format((float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0), 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Total Harga Tukang -->
                    @php
                        $totalHargaTukang = 0;
                        foreach ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang as $item) {
                            $totalHargaTukang += (float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0);
                        }
                    @endphp
                    <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-right">
                            <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Total Harga Tukang:</span>
                            <span class="ml-2 text-lg font-bold text-purple-600 dark:text-purple-400">
                                Rp {{ number_format($totalHargaTukang, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data harga tukang</p>
                </div>
            @endif
        </div>

        <!-- Material Pendukung -->
        <div class="w-full mb-6 border border-sky-200 dark:border-sky-700 dark:bg-zinc-900/30">
            <div class="flex items-center justify-between gap-4 mb-6">
                <h2
                    class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600/30 py-2 uppercase text-white">
                    Pengeluaran Material Pendukung
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-material-pendukung', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-sky-600 text-white text-sm rounded-md hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung)
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung as $mrIndex => $mrGroup)
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-sky-700 dark:text-sky-300">MR</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $mrGroup['mr'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-sky-700 dark:text-sky-300">Tanggal</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">@formatTanggalIndonesia($mrGroup['tanggal'] ?? null)</p>
                            </div>
                        </div>
                        @if (isset($mrGroup['materials']) && is_array($mrGroup['materials']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                    <thead class="bg-sky-50 dark:bg-sky-900/20">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                Supplier</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                Item</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                Qty</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                Satuan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                Harga Satuan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                PPN (%)</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                Sub Total</th>
                                            <th
                                                class="px-4 py-3 text-center text-xs font-medium text-sky-700 dark:text-sky-300 uppercase">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-zinc-900/30 divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach ($mrGroup['materials'] as $material)
                                            @php
                                                $status = $material['status'] ?? 'Pengajuan';
                                                $statusColor = match($status) {
                                                    'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                    'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                    default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                };
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                    {{ $material['supplier'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                    {{ $material['item'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ $material['qty'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ $material['satuan'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d.]/', '', $material['harga_satuan'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ $material['ppn'] ?? '0' }}%
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d.]/', '', $material['sub_total'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
                
                <!-- Total Pengeluaran Material Pendukung (Hanya Status Disetujui) -->
                @php
                    $totalPengeluaranMaterialPendukung = 0;
                    $totalSubTotalTanpaPpn = 0;
                    $totalPpnAmount = 0;

                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                // Hanya hitung yang status "Disetujui"
                                $status = $material['status'] ?? 'Pengajuan';
                                if ($status !== 'Disetujui') {
                                    continue;
                                }
                                
                                $itemValue = $material['item'] ?? '';
                                $subTotal = (float) preg_replace('/[^\d.]/', '', $material['sub_total'] ?? 0);
                                $ppnPersen = (float) ($material['ppn'] ?? 0);
                                
                                // Jika item adalah Diskon, kurangkan dari total
                                if (trim($itemValue) === 'Diskon') {
                                    $totalPengeluaranMaterialPendukung -= $subTotal;
                                    $totalSubTotalTanpaPpn -= $subTotal;
                                } else {
                                    // Hitung porsi PPN jika bukan Ongkir (Ongkir biasanya tidak ber-PPN di sini, atau PPN-nya 0)
                                    if (trim($itemValue) !== 'Ongkir' && $ppnPersen > 0) {
                                        $subTotalTanpaPpn = $subTotal / (1 + ($ppnPersen / 100));
                                        $ppnAmount = $subTotal - $subTotalTanpaPpn;
                                        
                                        $totalSubTotalTanpaPpn += $subTotalTanpaPpn;
                                        $totalPpnAmount += $ppnAmount;
                                    } else {
                                        $totalSubTotalTanpaPpn += $subTotal;
                                    }
                                    
                                    $totalPengeluaranMaterialPendukung += $subTotal;
                                }
                            }
                        }
                    }
                @endphp
                <div class="p-4 bg-sky-50 dark:bg-sky-900/20 rounded-lg space-y-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium text-sky-700 dark:text-sky-300">Total DPP:</span>
                        <span class="font-bold text-sky-600 dark:text-sky-400">
                            Rp {{ number_format($totalSubTotalTanpaPpn, 0, ',', '.') }}
                        </span>
                    </div>
                    @if($totalPpnAmount > 0)
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium text-sky-700 dark:text-sky-300">Total PPN:</span>
                        <span class="font-bold text-sky-600 dark:text-sky-400">
                            Rp {{ number_format($totalPpnAmount, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center border-t border-sky-200 dark:border-sky-800 pt-2">
                        <span class="text-sm font-bold text-sky-700 dark:text-sky-300">Grand Total (Disetujui):</span>
                        <span class="text-lg font-extrabold text-sky-600 dark:text-sky-400">
                            Rp {{ number_format($totalPengeluaranMaterialPendukung, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data pengeluaran material pendukung</p>
                </div>
            @endif
        </div>

        <!-- Material Tambahan -->
        <div class="w-full mb-6 border border-indigo-200 dark:border-indigo-700 dark:bg-zinc-900/30">
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-lg font-semibold w-full text-center bg-indigo-600 dark:bg-indigo-600/30 py-2 uppercase text-white">
                    Pengeluaran Material Tambahan
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-material-tambahan', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_pengeluaran_material_tambahan)
                @php
                    // Filter hanya material yang statusnya "Disetujui"
                    $filteredMaterialTambahan = [];
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_tambahan as $mrIndex => $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            $approvedMaterials = array_filter($mrGroup['materials'], function ($material) {
                                return ($material['status'] ?? '') === 'Disetujui';
                            });

                            if (!empty($approvedMaterials)) {
                                $filteredMR = $mrGroup;
                                $filteredMR['materials'] = array_values($approvedMaterials);
                                $filteredMaterialTambahan[] = $filteredMR;
                            }
                        }
                    }
                @endphp

                @if (count($filteredMaterialTambahan) > 0)
                    @foreach ($filteredMaterialTambahan as $mrIndex => $mrGroup)
                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-indigo-700 dark:text-indigo-300">MR</label>
                                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $mrGroup['mr'] ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-indigo-700 dark:text-indigo-300">Tanggal</label>
                                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">@formatTanggalIndonesia($mrGroup['tanggal'] ?? null)</p>
                                </div>
                            </div>
                            @if (isset($mrGroup['materials']) && is_array($mrGroup['materials']))
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                        <thead class="bg-indigo-50 dark:bg-indigo-900/20">
                                            <tr>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-indigo-700 dark:text-indigo-300 uppercase">
                                                    Supplier</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-indigo-700 dark:text-indigo-300 uppercase">
                                                    Item</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-indigo-700 dark:text-indigo-300 uppercase">
                                                    Qty</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-indigo-700 dark:text-indigo-300 uppercase">
                                                    Satuan</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-indigo-700 dark:text-indigo-300 uppercase">
                                                    Harga Satuan</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-indigo-700 dark:text-indigo-300 uppercase">
                                                    PPN (%)</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-indigo-700 dark:text-indigo-300 uppercase">
                                                    Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach ($mrGroup['materials'] as $material)
                                                <tr>
                                                    <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                        {{ $material['supplier'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                        {{ $material['item'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ $material['qty'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ $material['satuan'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ number_format((float) preg_replace('/[^\d.]/', '', $material['harga_satuan'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ $material['ppn'] ?? '0' }}%
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ number_format((float) preg_replace('/[^\d.]/', '', $material['sub_total'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    
                    <!-- Total Pengeluaran Material Tambahan -->
                    @php
                        $totalPengeluaranMaterialTambahan = 0;
                        $totalSubTotalTanpaPpnTambahan = 0;
                        $totalPpnAmountTambahan = 0;

                        foreach ($filteredMaterialTambahan as $mrGroup) {
                            if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                                foreach ($mrGroup['materials'] as $material) {
                                    // Hanya hitung yang statusnya Disetujui
                                    if (($material['status'] ?? '') === 'Disetujui') {
                                        $itemValue = $material['item'] ?? '';
                                        $subTotal = (float) preg_replace('/[^\d.]/', '', $material['sub_total'] ?? 0);
                                        $ppnPersen = (float) ($material['ppn'] ?? 0);

                                        // Jika item adalah Diskon, kurangkan dari total
                                        if (trim($itemValue) === 'Diskon') {
                                            $totalPengeluaranMaterialTambahan -= $subTotal;
                                            $totalSubTotalTanpaPpnTambahan -= $subTotal;
                                        } else {
                                            // Hitung porsi PPN jika bukan Ongkir
                                            if (trim($itemValue) !== 'Ongkir' && $ppnPersen > 0) {
                                                $subTotalTanpaPpn = $subTotal / (1 + ($ppnPersen / 100));
                                                $ppnAmount = $subTotal - $subTotalTanpaPpn;
                                                
                                                $totalSubTotalTanpaPpnTambahan += $subTotalTanpaPpn;
                                                $totalPpnAmountTambahan += $ppnAmount;
                                            } else {
                                                $totalSubTotalTanpaPpnTambahan += $subTotal;
                                            }
                                            
                                            $totalPengeluaranMaterialTambahan += $subTotal;
                                        }
                                    }
                                }
                            }
                        }
                    @endphp
                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-medium text-indigo-700 dark:text-indigo-300">Total DPP:</span>
                            <span class="font-bold text-indigo-600 dark:text-indigo-400">
                                Rp {{ number_format($totalSubTotalTanpaPpnTambahan, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($totalPpnAmountTambahan > 0)
                        <div class="flex justify-between items-center text-sm">
                            <span class="font-medium text-indigo-700 dark:text-indigo-300">Total PPN:</span>
                            <span class="font-bold text-indigo-600 dark:text-indigo-400">
                                Rp {{ number_format($totalPpnAmountTambahan, 0, ',', '.') }}
                            </span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center border-t border-indigo-200 dark:border-indigo-800 pt-2">
                            <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">Total Pengeluaran Material Tambahan:</span>
                            <span class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400">
                                Rp {{ number_format($totalPengeluaranMaterialTambahan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>Tidak ada material tambahan yang disetujui</p>
                    </div>
                @endif
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data pengeluaran material tambahan</p>
                </div>
            @endif
        </div>

        <!-- Entertaiment -->
        <div class="w-full mb-6 border border-teal-200 dark:border-teal-700 dark:bg-zinc-900/30">
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-lg font-semibold w-full text-center bg-teal-600 dark:bg-teal-600/30 py-2 uppercase text-white">
                    Pengeluaran Non Material
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-entertainment', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-teal-600 text-white text-sm rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment)
                @php
                    // Filter hanya material yang statusnya "Disetujui"
                    $filteredEntertainment = [];
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment as $mrIndex => $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            $approvedMaterials = array_filter($mrGroup['materials'], function ($material) {
                                return ($material['status'] ?? '') === 'Disetujui';
                            });

                            if (!empty($approvedMaterials)) {
                                $filteredMR = $mrGroup;
                                $filteredMR['materials'] = array_values($approvedMaterials);
                                $filteredEntertainment[] = $filteredMR;
                            }
                        }
                    }
                @endphp

                @if (count($filteredEntertainment) > 0)
                    @foreach ($filteredEntertainment as $mrIndex => $mrGroup)
                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-teal-700 dark:text-teal-300">MR</label>
                                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $mrGroup['mr'] ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-teal-700 dark:text-teal-300">Tanggal</label>
                                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">@formatTanggalIndonesia($mrGroup['tanggal'] ?? null)</p>
                                </div>
                            </div>
                            @if (isset($mrGroup['materials']) && is_array($mrGroup['materials']))
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                        <thead class="bg-teal-50 dark:bg-teal-900/20">
                                            <tr>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-teal-700 dark:text-teal-300 uppercase">
                                                    Supplier</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-teal-700 dark:text-teal-300 uppercase">
                                                    Item</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-teal-700 dark:text-teal-300 uppercase">
                                                    Qty</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-teal-700 dark:text-teal-300 uppercase">
                                                    Satuan</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-teal-700 dark:text-teal-300 uppercase">
                                                    Harga Satuan</th>
                                                <th
                                                    class="px-4 py-3 text-left text-xs font-medium text-teal-700 dark:text-teal-300 uppercase">
                                                    Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                            @foreach ($mrGroup['materials'] as $material)
                                                <tr>
                                                    <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                        {{ $material['supplier'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                        {{ $material['item'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ $material['qty'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ $material['satuan'] ?? '-' }}</td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ number_format((float) preg_replace('/[^\d.]/', '', $material['harga_satuan'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ number_format((float) preg_replace('/[^\d.]/', '', $material['sub_total'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>Tidak ada material non material yang disetujui</p>
                    </div>
                @endif
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data pengeluaran non material</p>
                </div>
            @endif
        </div>





        <!-- Tukang -->
        <div class="w-full mb-6 border border-purple-200 dark:border-purple-700">
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600/30 py-2 uppercase text-white">
                    Pengeluaran Tukang
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-tukang', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_pengeluaran_tukang)
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang as $sectionIndex => $section)
                    <div class="p-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-purple-700 dark:text-purple-300">Debet (Biaya
                                Tukang)</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                                {{ number_format((float) preg_replace('/[^\d.]/', '', $section['debet'] ?? 0), 0, ',', '.') }}
                            </p>
                        </div>
                        @if (isset($section['termin']) && is_array($section['termin']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                    <thead class="bg-purple-50 dark:bg-purple-900/20">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                                Termin</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                                Tanggal</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                                Kredit</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                                Sisa</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                                Persentase</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-purple-700 dark:text-purple-300 uppercase">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach ($section['termin'] as $terminIndex => $termin)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">Termin
                                                    {{ $terminIndex + 1 }}</td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    @formatTanggalIndonesia($termin['tanggal'] ?? null)</td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d.]/', '', $termin['kredit'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d.]/', '', $termin['sisa'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ $termin['persentase'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm">
                                                    @php
                                                        $status = $termin['status'] ?? 'Pengajuan';
                                                        $statusColors = [
                                                            'Pengajuan' =>
                                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                            'Disetujui' =>
                                                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                            'Ditolak' =>
                                                                'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                        ];
                                                        $color =
                                                            $statusColors[$status] ??
                                                            'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
                                                    @endphp
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-full {{ $color }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data pengeluaran tukang</p>
                </div>
            @endif
        </div>

        <!-- Kerja Tambah -->
        <div class="w-full mb-6 border border-orange-200 dark:border-orange-700">
            <div class="flex items-center justify-between gap-4">
                <h2
                    class="text-lg font-semibold w-full text-center bg-orange-600 dark:bg-orange-600/30 py-2 uppercase text-white">
                    Kerja Tambah
                </h2>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit-kerja-tambah', $rancanganAnggaranBiaya) }}" target="_blank"
                    class="px-3 py-1.5 bg-orange-600 text-white text-sm rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 flex items-center gap-2 mr-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
            @if ($rancanganAnggaranBiaya->json_kerja_tambah)
                @foreach ($rancanganAnggaranBiaya->json_kerja_tambah as $sectionIndex => $section)
                    <div class="p-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-orange-700 dark:text-orange-300">Debet (Biaya
                                Kerja Tambah)</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                                {{ number_format((float) preg_replace('/[^\d.]/', '', $section['debet'] ?? 0), 0, ',', '.') }}
                            </p>
                        </div>
                        @if (isset($section['termin']) && is_array($section['termin']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                    <thead class="bg-orange-50 dark:bg-orange-900/20">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-orange-700 dark:text-orange-300 uppercase">
                                                Termin</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-orange-700 dark:text-orange-300 uppercase">
                                                Tanggal</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-orange-700 dark:text-orange-300 uppercase">
                                                Kredit</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-orange-700 dark:text-orange-300 uppercase">
                                                Sisa</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-orange-700 dark:text-orange-300 uppercase">
                                                Persentase</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-orange-700 dark:text-orange-300 uppercase">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @foreach ($section['termin'] as $terminIndex => $termin)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">Termin
                                                    {{ $terminIndex + 1 }}</td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    @formatTanggalIndonesia($termin['tanggal'] ?? null)</td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d.]/', '', $termin['kredit'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d.]/', '', $termin['sisa'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ $termin['persentase'] ?? '-' }}</td>
                                                <td class="px-4 py-3 text-sm">
                                                    @php
                                                        $status = $termin['status'] ?? 'Pengajuan';
                                                        $statusColors = [
                                                            'Pengajuan' =>
                                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                            'Disetujui' =>
                                                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                            'Ditolak' =>
                                                                'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                        ];
                                                        $color =
                                                            $statusColors[$status] ??
                                                            'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400';
                                                    @endphp
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium rounded-full {{ $color }}">
                                                        {{ $status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>Tidak ada data kerja tambah</p>
                </div>
            @endif
        </div>

        <!-- Sisa Anggaran -->
        <div class="w-full mb-6">
            <div class="flex items-center justify-between gap-4 mb-6">
                <h2
                    class="text-lg font-semibold w-full text-center bg-red-600 dark:bg-red-600/30 py-2 uppercase text-white">
                    Sisa Anggaran</h2>
            </div>

            @php
                // SECTION 1: TOTAL MATERIAL PENDUKUNG - PENGELUARAN MATERIAL PENDUKUNG - PENGELUARAN MATERIAL TAMBAHAN
                
                // Total Material Pendukung (Section Material Pendukung) - hitung semua tanpa filter status
                $totalMaterialPendukung = 0;
                if ($rancanganAnggaranBiaya->json_section_material_pendukung) {
                    foreach ($rancanganAnggaranBiaya->json_section_material_pendukung as $item) {
                        // Hitung semua item tanpa filter status
                        $totalMaterialPendukung += (float) preg_replace('/[^\d.]/', '', $item['total'] ?? 0);
                    }
                }

                // Pengeluaran Material Pendukung - perhitungkan diskon yang ada di dalam material pendukung
                // Hanya yang status "Disetujui"
                $pengeluaranMaterialPendukung = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                // Hanya hitung yang status "Disetujui"
                                if (($material['status'] ?? 'Pengajuan') !== 'Disetujui') {
                                    continue;
                                }
                                
                                $itemValue = $material['item'] ?? '';
                                $subTotal = (float) preg_replace('/[^\d.]/', '', $material['sub_total'] ?? 0);

                                // Jika item adalah Diskon, kurangkan dari total
                                if (trim($itemValue) === 'Diskon') {
                                    $pengeluaranMaterialPendukung -= $subTotal;
                                } else {
                                    // Untuk item lain (termasuk PPN dan Ongkir), tambahkan ke total
                                    $pengeluaranMaterialPendukung += $subTotal;
                                }
                            }
                        }
                    }
                }

                // Pengeluaran Material Tambahan - hanya yang status Disetujui
                $pengeluaranMaterialTambahan = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_material_tambahan) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_tambahan as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                // Hanya hitung yang statusnya Disetujui
                                if (($material['status'] ?? '') === 'Disetujui') {
                                    $pengeluaranMaterialTambahan += (float) preg_replace(
                                        '/[^\d]/',
                                        '',
                                        $material['sub_total'] ?? 0,
                                    );
                                }
                            }
                        }
                    }
                }

                // Sisa Anggaran Section 1
                $sisaAnggaranSection1 = $totalMaterialPendukung - $pengeluaranMaterialPendukung - $pengeluaranMaterialTambahan;

                // SECTION 2: TOTAL PENGELUARAN PEMASANGAN - HARGA TUKANG - PENGELUARAN ENTERTAIMENT
                
                // Total Pengeluaran Pemasangan
                $totalPengeluaranPemasangan = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_pemasangan) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_pemasangan as $item) {
                        $totalPengeluaranPemasangan += (float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0);
                    }
                }

                // Harga Tukang - hanya yang status Disetujui
                $hargaTukang = 0;
                if ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang) {
                    foreach ($rancanganAnggaranBiaya->json_pengajuan_harga_tukang as $item) {
                        // Hanya hitung yang statusnya Disetujui
                        if (($item['status'] ?? '') === 'Disetujui') {
                            $hargaTukang += (float) preg_replace('/[^\d.]/', '', $item['total_harga'] ?? 0);
                        }
                    }
                }

                // Pengeluaran Entertainment - hanya yang status Disetujui
                $pengeluaranEntertainment = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                // Hanya hitung yang statusnya Disetujui
                                if (($material['status'] ?? '') === 'Disetujui') {
                                    $pengeluaranEntertainment += (float) preg_replace(
                                        '/[^\d]/',
                                        '',
                                        $material['sub_total'] ?? 0,
                                    );
                                }
                            }
                        }
                    }
                }

                // Pengeluaran Kerja Tambah - hanya termin yang status Disetujui
                $pengeluaranKerjaTambah = 0;
                if ($rancanganAnggaranBiaya->json_kerja_tambah) {
                    foreach ($rancanganAnggaranBiaya->json_kerja_tambah as $section) {
                        if (isset($section['termin']) && is_array($section['termin'])) {
                            foreach ($section['termin'] as $termin) {
                                // Hanya hitung kredit dari termin yang statusnya Disetujui
                                if (($termin['status'] ?? '') === 'Disetujui') {
                                    $pengeluaranKerjaTambah += (float) preg_replace('/[^\d.]/', '', $termin['kredit'] ?? 0);
                                }
                            }
                        }
                    }
                }

                // Sisa Anggaran Section 2
                $sisaAnggaranSection2 = $totalPengeluaranPemasangan - $hargaTukang - $pengeluaranEntertainment - $pengeluaranKerjaTambah;

                // Total Sisa Anggaran
                $totalSisaAnggaran = $sisaAnggaranSection1 + $sisaAnggaranSection2;
            @endphp

            <!-- Section 1 -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-4">
                <h3 class="text-md font-semibold text-blue-700 dark:text-blue-300 mb-4">Rincian Material</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-600 dark:text-zinc-400">Total Material Pendukung:</span>
                        <span class="font-medium text-zinc-900 dark:text-white">
                            Rp {{ number_format($totalMaterialPendukung, 2, ',', '.') }}
                        </span>
                </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-600 dark:text-zinc-400">Pengeluaran Material Pendukung:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">
                            - Rp {{ number_format($pengeluaranMaterialPendukung, 2, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-600 dark:text-zinc-400">Pengeluaran Material Tambahan:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">
                            - Rp {{ number_format($pengeluaranMaterialTambahan, 2, ',', '.') }}
                        </span>
                    </div>
                    <div class="border-t border-blue-200 dark:border-blue-700 pt-2 mt-2">
                        <div class="flex justify-between items-center font-semibold">
                            <span class="text-blue-700 dark:text-blue-300">Sisa Anggaran Material:</span>
                            <span class="text-blue-700 dark:text-blue-300 {{ $sisaAnggaranSection1 < 0 ? 'text-red-600 dark:text-red-400' : '' }}">
                                Rp {{ number_format($sisaAnggaranSection1, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2 -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 mb-4">
                <h3 class="text-md font-semibold text-green-700 dark:text-green-300 mb-4">Rincian Pemasangan</h3>
                <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                        <span class="text-zinc-600 dark:text-zinc-400">Total Pengeluaran Pemasangan:</span>
                        <span class="font-medium text-zinc-900 dark:text-white">
                            Rp {{ number_format($totalPengeluaranPemasangan, 2, ',', '.') }}
                            </span>
                        </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-600 dark:text-zinc-400">Harga Tukang:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">
                            - Rp {{ number_format($hargaTukang, 2, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-600 dark:text-zinc-400">Pengeluaran Kerja Tambah:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">
                            - Rp {{ number_format($pengeluaranKerjaTambah, 2, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-600 dark:text-zinc-400">Pengeluaran Non Material:</span>
                        <span class="font-medium text-red-600 dark:text-red-400">
                            - Rp {{ number_format($pengeluaranEntertainment, 2, ',', '.') }}
                        </span>
                    </div>
                    <div class="border-t border-green-200 dark:border-green-700 pt-2 mt-2">
                        <div class="flex justify-between items-center font-semibold">
                            <span class="text-green-700 dark:text-green-300">Sisa Anggaran Pemasangan:</span>
                            <span class="text-green-700 dark:text-green-300 {{ $sisaAnggaranSection2 < 0 ? 'text-red-600 dark:text-red-400' : '' }}">
                                Rp {{ number_format($sisaAnggaranSection2, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sisa Anggaran -->
            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-red-600 dark:text-red-400">
                        Rp {{ number_format($totalSisaAnggaran, 2, ',', '.') }}
                    </div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                        Total Sisa Anggaran
                    </p>
                </div>
            </div>
        </div>
        <!-- Status Update Form -->
        <div
            class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm lg:border border-zinc-200 dark:border-zinc-700 p-0 lg:p-6">
            <h2 class="text-lg font-semibold mb-4">Update Status</h2>
            <form action="{{ route('admin.rancangan-anggaran-biaya.update-status', $rancanganAnggaranBiaya) }}"
                method="POST" class="flex items-center justify-between space-x-4">
                @csrf
                @method('PATCH')
                <select name="status"
                    class="px-3 py-2 w-full border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white">
                    <option value="draft" {{ $rancanganAnggaranBiaya->status == 'draft' ? 'selected' : '' }}>Draft
                    </option>
                    <option value="on_progress"
                        {{ $rancanganAnggaranBiaya->status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                    <option value="selesai" {{ $rancanganAnggaranBiaya->status == 'selesai' ? 'selected' : '' }}>
                        Selesai</option>
                </select>
                <button type="submit"
                    class="px-4 w-full py-2 bg-blue-50 border border-blue-200 dark:border-blue-700 dark:bg-blue-900 text-blue-600 dark:text-blue-50 rounded-md hover:bg-blue-100 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>

