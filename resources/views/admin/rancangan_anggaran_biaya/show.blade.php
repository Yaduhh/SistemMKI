<x-layouts.app :title="__('Detail Rancangan Anggaran Biaya')">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Detail Rancangan Anggaran Biaya (RAB)</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.rancangan-anggaran-biaya.export-pdf', $rancanganAnggaranBiaya) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Cetak PDF
                </a>
                <a href="{{ route('admin.rancangan-anggaran-biaya.edit', $rancanganAnggaranBiaya) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit
                </a>
                <a href="{{ route('admin.rancangan-anggaran-biaya.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Project Information -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
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
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                            $statusText = [
                                'draft' => 'Draft',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
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
                        @if($rancanganAnggaranBiaya->supervisi)
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $rancanganAnggaranBiaya->supervisi->name }}
                            </p>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Belum ditugaskan</p>
                        @endif
                        
                        <!-- Form untuk mengubah supervisi -->
                        <form action="{{ route('admin.rancangan-anggaran-biaya.update-supervisi', $rancanganAnggaranBiaya) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center space-x-2">
                                <select name="supervisi_id" class="text-sm border border-zinc-300 dark:border-zinc-600 rounded-md px-3 py-1 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Supervisi</option>
                                    @foreach(\App\Models\User::where('role', 4)->get() as $supervisi)
                                        <option value="{{ $supervisi->id }}" {{ $rancanganAnggaranBiaya->supervisi_id == $supervisi->id ? 'selected' : '' }}>
                                            {{ $supervisi->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
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
        @if ($rancanganAnggaranBiaya->json_pengeluaran_material_utama)
            <div
                class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Pengeluaran Material Utama</h2>

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
                                    {{ number_format($rancanganAnggaranBiaya->penawaran->total - (($rancanganAnggaranBiaya->penawaran->total_diskon ?? 0) + ($rancanganAnggaranBiaya->penawaran->total_diskon_1 ?? 0) + ($rancanganAnggaranBiaya->penawaran->total_diskon_2 ?? 0)) ?? 0, 0, ',', '.') }}
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
                                        {{ number_format((float) preg_replace('/[^\d]/', '', $item['harga_satuan'] ?? 0), 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                        {{ number_format((float) preg_replace('/[^\d]/', '', $item['total'] ?? 0), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Material Pendukung -->
        @if ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung)
            <div class="w-full mb-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30"></div>
                        <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30 mt-2"></div>
                    </div>
                    <h2
                        class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600/30 py-2 uppercase text-white">
                        Pengeluaran Material Pendukung</h2>
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30"></div>
                        <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30 mt-2"></div>
                    </div>
                </div>
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung as $mrIndex => $mrGroup)
                    <div class="mb-8 p-4 border border-sky-200 dark:border-sky-700 rounded-lg">
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
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $material['harga_satuan'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Entertaiment -->
        @if ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment)
            <div class="w-full mb-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30"></div>
                        <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30 mt-2"></div>
                    </div>
                    <h2
                        class="text-lg font-semibold w-full text-center bg-teal-600 dark:bg-teal-600/30 py-2 uppercase text-white">
                        Pengeluaran Entertaiment</h2>
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30"></div>
                        <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30 mt-2"></div>
                    </div>
                </div>
                @php
                    // Filter hanya material yang statusnya "Disetujui"
                    $filteredEntertainment = [];
                    foreach($rancanganAnggaranBiaya->json_pengeluaran_entertaiment as $mrIndex => $mrGroup) {
                        if(isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            $approvedMaterials = array_filter($mrGroup['materials'], function($material) {
                                return ($material['status'] ?? '') === 'Disetujui';
                            });
                            
                            if(!empty($approvedMaterials)) {
                                $filteredMR = $mrGroup;
                                $filteredMR['materials'] = array_values($approvedMaterials);
                                $filteredEntertainment[] = $filteredMR;
                            }
                        }
                    }
                @endphp
                
                @if(count($filteredEntertainment) > 0)
                    @foreach ($filteredEntertainment as $mrIndex => $mrGroup)
                        <div class="mb-8 p-4 border border-teal-200 dark:border-teal-700 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-teal-700 dark:text-teal-300">MR</label>
                                    <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $mrGroup['mr'] ?? '-' }}</p>
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
                                                        {{ number_format((float) preg_replace('/[^\d]/', '', $material['harga_satuan'] ?? 0), 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                        {{ number_format((float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0), 0, ',', '.') }}
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
                        <p>Tidak ada material entertainment yang disetujui</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Akomodasi -->
        @if ($rancanganAnggaranBiaya->json_pengeluaran_akomodasi)
            <div class="w-full mb-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                        <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                    </div>
                    <h2
                        class="text-lg font-semibold w-full text-center bg-yellow-600 dark:bg-yellow-600/30 py-2 uppercase text-white">
                        Pengeluaran Akomodasi</h2>
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                        <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                    </div>
                </div>
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_akomodasi as $mrIndex => $mrGroup)
                    <div class="mb-8 p-4 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-yellow-700 dark:text-yellow-300">MR</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $mrGroup['mr'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-yellow-700 dark:text-yellow-300">Tanggal</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">@formatTanggalIndonesia($mrGroup['tanggal'] ?? null)</p>
                            </div>
                        </div>
                        @if (isset($mrGroup['materials']) && is_array($mrGroup['materials']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                    <thead class="bg-yellow-50 dark:bg-yellow-900/20">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-yellow-700 dark:text-yellow-300 uppercase">
                                                Supplier</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-yellow-700 dark:text-yellow-300 uppercase">
                                                Item</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-yellow-700 dark:text-yellow-300 uppercase">
                                                Qty</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-yellow-700 dark:text-yellow-300 uppercase">
                                                Satuan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-yellow-700 dark:text-yellow-300 uppercase">
                                                Harga Satuan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-yellow-700 dark:text-yellow-300 uppercase">
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
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $material['harga_satuan'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Lainnya -->
        @if ($rancanganAnggaranBiaya->json_pengeluaran_lainnya)
            <div class="w-full mb-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30"></div>
                        <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30 mt-2"></div>
                    </div>
                    <h2
                        class="text-lg font-semibold w-full text-center bg-pink-600 dark:bg-pink-600/30 py-2 uppercase text-white">
                        Pengeluaran Lainnya</h2>
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30"></div>
                        <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30 mt-2"></div>
                    </div>
                </div>
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_lainnya as $mrIndex => $mrGroup)
                    <div class="mb-8 p-4 border border-pink-200 dark:border-pink-700 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-pink-700 dark:text-pink-300">MR</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $mrGroup['mr'] ?? '-' }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-pink-700 dark:text-pink-300">Tanggal</label>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">@formatTanggalIndonesia($mrGroup['tanggal'] ?? null)</p>
                            </div>
                        </div>
                        @if (isset($mrGroup['materials']) && is_array($mrGroup['materials']))
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                    <thead class="bg-pink-50 dark:bg-pink-900/20">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-pink-700 dark:text-pink-300 uppercase">
                                                Supplier</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-pink-700 dark:text-pink-300 uppercase">
                                                Item</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-pink-700 dark:text-pink-300 uppercase">
                                                Qty</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-pink-700 dark:text-pink-300 uppercase">
                                                Satuan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-pink-700 dark:text-pink-300 uppercase">
                                                Harga Satuan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-pink-700 dark:text-pink-300 uppercase">
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
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $material['harga_satuan'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0), 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Tukang -->
        @if ($rancanganAnggaranBiaya->json_pengeluaran_tukang)
            <div class="w-full mb-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                        <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                    </div>
                    <h2
                        class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600/30 py-2 uppercase text-white">
                        Pengeluaran Tukang</h2>
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                        <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                    </div>
                </div>
                @foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang as $sectionIndex => $section)
                    <div class="mb-8 p-4 border border-purple-200 dark:border-purple-700 rounded-lg">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-purple-700 dark:text-purple-300">Debet (Biaya
                                Tukang)</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                                {{ number_format((float) preg_replace('/[^\d]/', '', $section['debet'] ?? 0), 0, ',', '.') }}
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
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $termin['kredit'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $termin['sisa'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ $termin['persentase'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Kerja Tambah -->
        @if ($rancanganAnggaranBiaya->json_kerja_tambah)
            <div class="w-full mb-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30"></div>
                        <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30 mt-2"></div>
                    </div>
                    <h2
                        class="text-lg font-semibold w-full text-center bg-orange-600 dark:bg-orange-600/30 py-2 uppercase text-white">
                        Kerja Tambah</h2>
                    <div class="w-full">
                        <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30"></div>
                        <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30 mt-2"></div>
                    </div>
                </div>
                @foreach ($rancanganAnggaranBiaya->json_kerja_tambah as $sectionIndex => $section)
                    <div class="mb-8 p-4 border border-orange-200 dark:border-orange-700 rounded-lg">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-orange-700 dark:text-orange-300">Debet (Biaya
                                Kerja Tambah)</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">
                                {{ number_format((float) preg_replace('/[^\d]/', '', $section['debet'] ?? 0), 0, ',', '.') }}
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
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $termin['kredit'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ number_format((float) preg_replace('/[^\d]/', '', $termin['sisa'] ?? 0), 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-300">
                                                    {{ $termin['persentase'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Grand Total -->
        <div class="w-full mb-6">
            <div class="flex items-center justify-between gap-4 mb-6">
                <h2
                    class="text-lg font-semibold w-full text-center bg-red-600 dark:bg-red-600/30 py-2 uppercase text-white">
                    Grand Total</h2>
            </div>

            @php
                $grandTotal = 0;
                $breakdown = [];

                // Material Utama - ambil dari grand_total penawaran yang terhubung
                $materialUtamaTotal = 0;
                if ($rancanganAnggaranBiaya->penawaran) {
                    $materialUtamaTotal = (float) (($rancanganAnggaranBiaya->penawaran->total ?? 0) - (($rancanganAnggaranBiaya->penawaran->total_diskon ?? 0) + ($rancanganAnggaranBiaya->penawaran->total_diskon_1 ?? 0) + ($rancanganAnggaranBiaya->penawaran->total_diskon_2 ?? 0)) ?? 0);
                } else {
                    // Fallback ke perhitungan manual jika tidak ada penawaran terhubung
                    if ($rancanganAnggaranBiaya->json_pengeluaran_material_utama) {
                        foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_utama as $item) {
                            $materialUtamaTotal += (float) preg_replace('/[^\d]/', '', $item['total'] ?? 0);
                        }
                    }
                }
                $grandTotal += $materialUtamaTotal;
                $breakdown['Material Utama'] = $materialUtamaTotal;

                // Material Pendukung - perhitungkan diskon yang ada di dalam material pendukung
                $materialPendukungTotal = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_material_pendukung as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                $itemValue = $material['item'] ?? '';
                                $subTotal = (float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0);
                                
                                // Jika item adalah Diskon, kurangkan dari total
                                if (trim($itemValue) === 'Diskon') {
                                    $materialPendukungTotal -= $subTotal;
                                } else {
                                    // Untuk item lain (termasuk PPN dan Ongkir), tambahkan ke total
                                    $materialPendukungTotal += $subTotal;
                                }
                            }
                        }
                    }
                }
                $grandTotal += $materialPendukungTotal;
                $breakdown['Material Pendukung'] = $materialPendukungTotal;

                // Entertaiment
                $entertaimentTotal = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_entertaiment as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                $entertaimentTotal += (float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0);
                            }
                        }
                    }
                }
                $grandTotal += $entertaimentTotal;
                $breakdown['Entertaiment'] = $entertaimentTotal;

                // Akomodasi
                $akomodasiTotal = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_akomodasi) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_akomodasi as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                $akomodasiTotal += (float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0);
                            }
                        }
                    }
                }
                $grandTotal += $akomodasiTotal;
                $breakdown['Akomodasi'] = $akomodasiTotal;

                // Lainnya
                $lainnyaTotal = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_lainnya) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_lainnya as $mrGroup) {
                        if (isset($mrGroup['materials']) && is_array($mrGroup['materials'])) {
                            foreach ($mrGroup['materials'] as $material) {
                                $lainnyaTotal += (float) preg_replace('/[^\d]/', '', $material['sub_total'] ?? 0);
                            }
                        }
                    }
                }
                $grandTotal += $lainnyaTotal;
                $breakdown['Lainnya'] = $lainnyaTotal;

                // Tukang
                $tukangTotal = 0;
                if ($rancanganAnggaranBiaya->json_pengeluaran_tukang) {
                    foreach ($rancanganAnggaranBiaya->json_pengeluaran_tukang as $section) {
                        $tukangTotal += (float) preg_replace('/[^\d]/', '', $section['debet'] ?? 0);
                    }
                }
                $grandTotal += $tukangTotal;
                $breakdown['Tukang'] = $tukangTotal;

                // Kerja Tambah
                $kerjaTambahTotal = 0;
                if ($rancanganAnggaranBiaya->json_kerja_tambah) {
                    foreach ($rancanganAnggaranBiaya->json_kerja_tambah as $section) {
                        $kerjaTambahTotal += (float) preg_replace('/[^\d]/', '', $section['debet'] ?? 0);
                    }
                }
                $grandTotal += $kerjaTambahTotal;
                $breakdown['Kerja Tambah'] = $kerjaTambahTotal;
            @endphp

            <div class="text-center mb-6">
                <div class="text-3xl font-bold text-red-600 dark:text-red-400">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">
                    Total keseluruhan pengeluaran proyek
                </p>
            </div>

            <!-- Breakdown Detail -->
            <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">Rincian Perhitungan:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                    @foreach ($breakdown as $category => $amount)
                        <div class="flex justify-between items-center">
                            <span class="text-zinc-600 dark:text-zinc-400">{{ $category }}:</span>
                            <span class="font-medium {{ $amount < 0 ? 'text-red-600 dark:text-red-400' : 'text-zinc-900 dark:text-white' }}">
                                {{ $amount < 0 ? '-' : '' }}Rp {{ number_format(abs($amount), 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                    <div class="col-span-full border-t border-zinc-200 dark:border-zinc-600 pt-2 mt-2">
                        <div class="flex justify-between items-center font-semibold">
                            <span class="text-red-600 dark:text-red-400">GRAND TOTAL:</span>
                            <span class="text-red-600 dark:text-red-400">Rp
                                {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Update Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
            <h2 class="text-lg font-semibold mb-4">Update Status</h2>
            <form action="{{ route('admin.rancangan-anggaran-biaya.update-status', $rancanganAnggaranBiaya) }}"
                method="POST" class="flex items-center space-x-4">
                @csrf
                <select name="status"
                    class="px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white">
                    <option value="draft" {{ $rancanganAnggaranBiaya->status == 'draft' ? 'selected' : '' }}>Draft
                    </option>
                    <option value="approved" {{ $rancanganAnggaranBiaya->status == 'approved' ? 'selected' : '' }}>
                        Disetujui</option>
                    <option value="rejected" {{ $rancanganAnggaranBiaya->status == 'rejected' ? 'selected' : '' }}>
                        Ditolak</option>
                </select>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
