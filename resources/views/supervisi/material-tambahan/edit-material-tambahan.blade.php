<x-layouts.supervisi title="Edit Material Tambahan - {{ $rab->proyek }}">
    <div class="w-full">
        <div class="max-w-7xl mx-auto">
            <!-- Pengeluaran Material Tambahan -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-2">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Material Tambahan') }}
                    </h2>
                    <p class=" text-gray-600 dark:text-gray-400 mt-1">
                        {{ $rab->proyek }} • {{ $rab->pekerjaan }}
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('supervisi.rab.show', $rab) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-zinc-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-zinc-600 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-900 disabled:opacity-25 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="w-full">
                <div class="py-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pengeluaran Material Tambahan</h3>
                    @php
                        // Check if any material has approved/rejected status
                        $hasApprovedMaterial = false;
                        $hasRejectedMaterial = false;
                        if (
                            isset($rab->json_pengeluaran_material_tambahan) &&
                            is_array($rab->json_pengeluaran_material_tambahan)
                        ) {
                            foreach ($rab->json_pengeluaran_material_tambahan as $mr) {
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
                        }
                    @endphp

                    @if ($hasApprovedMaterial)
                        <div
                            class="mt-2 p-3 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg">
                            <div class="flex lg:items-center">
                                <span class=" text-green-800 dark:text-green-200 font-medium">
                                    Ada material yang sudah disetujui. Material tersebut tidak dapat diubah atau
                                    dihapus.
                                </span>
                            </div>
                        </div>
                    @elseif($hasRejectedMaterial)
                        <div
                            class="mt-2 p-3 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                            <div class="flex lg:items-center">
                                <span class=" text-red-800 dark:text-red-200 font-medium">
                                    Ada material yang ditolak. Material tersebut tidak dapat diubah atau dihapus.
                                </span>
                            </div>
                        </div>
                    @else
                        <div
                            class="mt-2 p-3 bg-blue-100 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg">
                            <div class="flex items-center">
                                <span class=" text-blue-800 dark:text-blue-200 font-medium">
                                    Semua material dalam status pengajuan. Data dapat diubah dan dihapus.
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="w-full">
                    <form action="{{ route('supervisi.rab.update-material-tambahan', $rab) }}" method="POST"
                        class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4">
                                <strong class="font-bold">Berhasil!</strong>
                                <p class="mt-1">{{ session('success') }}</p>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4">
                                <strong class="font-bold">Error!</strong>
                                <p class="mt-1">{{ session('error') }}</p>
                            </div>
                        @endif
                        
                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4">
                                <strong class="font-bold">Terjadi kesalahan validasi:</strong>
                                <ul class="list-disc list-inside mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Material Tambahan Container -->
                        <div id="material-tambahan-container" class="space-y-6">
                            @if (isset($rab->json_pengeluaran_material_tambahan) &&
                                    is_array($rab->json_pengeluaran_material_tambahan) &&
                                    count($rab->json_pengeluaran_material_tambahan) > 0)
                                @foreach ($rab->json_pengeluaran_material_tambahan as $mrIndex => $mr)
                                    <div class="material-tambahan-mr w-full overflow-hidden"
                                        data-mr-index="{{ $mrIndex }}">
                                        <!-- Header MR -->
                                        <div class="w-full">
                                            <div
                                                class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1">
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-indigo-100 mb-1">MR</label>
                                                                <input type="text"
                                                                    name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][mr]"
                                                                    value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.mr', $mr['mr'] ?? '') }}"
                                                                    class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-md text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                                                                    placeholder="Masukkan MR">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-indigo-100 mb-1">Tanggal</label>
                                                                <input type="date"
                                                                    name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][tanggal]"
                                                                    value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.tanggal', $mr['tanggal'] ?? '') }}"
                                                                    class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-md text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                                    <button type="button"
                                                        class="add-material-btn bg-white/20 hover:bg-white/30 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center"
                                                        data-mr-index="{{ $mrIndex }}">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        <span class="hidden sm:inline">Tambah Material</span>
                                                        <span class="sm:hidden">Tambah</span>
                                                    </button>
                                                    @php
                                                        // Check if any material in this MR has status Disetujui or Ditolak
                                                        $hasApprovedOrRejected = false;
                                                        if (isset($mr['materials']) && is_array($mr['materials'])) {
                                                            foreach ($mr['materials'] as $material) {
                                                                $status = $material['status'] ?? 'Pengajuan';
                                                                if (in_array($status, ['Disetujui', 'Ditolak'])) {
                                                                    $hasApprovedOrRejected = true;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @if (!$hasApprovedOrRejected)
                                                        <button type="button"
                                                            class="remove-mr-btn bg-red-500/20 hover:bg-red-500/30 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            <span class="ml-1 hidden sm:inline">Hapus MR</span>
                                                        </button>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Materials Table - Desktop -->
                                        <div class="p-4 hidden md:block">
                                            <div class="overflow-x-auto">
                                                <table
                                                    class="min-w-full divide-y divide-gray-200 dark:divide-zinc-600">
                                                    <thead class="bg-gray-50 dark:bg-zinc-800">
                                                        <tr>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Supplier</th>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Item</th>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Qty</th>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Satuan</th>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Harga Satuan</th>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Sub Total</th>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Status</th>
                                                            <th
                                                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                                                                Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                        class="material-tambahan-tbody bg-white dark:bg-zinc-900/50 divide-y divide-gray-200 dark:divide-zinc-600">
                                                        @if (isset($mr['materials']) && is_array($mr['materials']))
                                                            @foreach ($mr['materials'] as $matIndex => $material)
                                                                @php
                                                                    $currentStatus = old(
                                                                        'json_pengeluaran_material_tambahan.' .
                                                                            $mrIndex .
                                                                            '.materials.' .
                                                                            $matIndex .
                                                                            '.status',
                                                                        $material['status'] ?? 'Pengajuan',
                                                                    );
                                                                    $isLocked = in_array($currentStatus, [
                                                                        'Disetujui',
                                                                        'Ditolak',
                                                                    ]);
                                                                @endphp
                                                                <tr
                                                                    class="material-tambahan-row hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors duration-200">
                                                                    <td class="px-3 py-2">
                                                                        <input type="text"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][supplier]"
                                                                            value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.supplier', $material['supplier'] ?? '') }}"
                                                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-700 cursor-not-allowed' : '' }}"
                                                                            placeholder="Supplier"
                                                                            {{ $isLocked ? 'readonly' : '' }}>
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        <input type="text"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][item]"
                                                                            value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.item', $material['item'] ?? '') }}"
                                                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-700 cursor-not-allowed' : '' }}"
                                                                            placeholder="Item"
                                                                            {{ $isLocked ? 'readonly' : '' }}>
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        <input type="number" step="0.01"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][qty]"
                                                                            value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.qty', $material['qty'] ?? '') }}"
                                                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white material-qty {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-700 cursor-not-allowed' : '' }}"
                                                                            placeholder="0"
                                                                            data-mr-index="{{ $mrIndex }}"
                                                                            data-mat-index="{{ $matIndex }}"
                                                                            {{ $isLocked ? 'readonly' : '' }}>
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        <input type="text"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][satuan]"
                                                                            value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.satuan', $material['satuan'] ?? '') }}"
                                                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-700 cursor-not-allowed' : '' }}"
                                                                            placeholder="Satuan"
                                                                            {{ $isLocked ? 'readonly' : '' }}>
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        @php
                                                                            $hargaSatuan = old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.harga_satuan', $material['harga_satuan'] ?? '');
                                                                            // Parse nilai jika berupa string dengan format currency Indonesia
                                                                            if (is_string($hargaSatuan) && $hargaSatuan !== '') {
                                                                                // Hapus "Rp" dan spasi
                                                                                $hargaSatuan = preg_replace('/Rp\s*/i', '', $hargaSatuan);
                                                                                // Hapus semua karakter non-digit kecuali titik
                                                                                $hargaSatuan = preg_replace('/[^\d.]/', '', $hargaSatuan);
                                                                                // Jika ada titik, cek apakah itu pemisah ribuan (format Indonesia)
                                                                                // Format Indonesia: semua bagian setelah titik adalah 3 digit (misal: 1.800, 270.000, 2.000.000)
                                                                                if (strpos($hargaSatuan, '.') !== false) {
                                                                                    $parts = explode('.', $hargaSatuan);
                                                                                    // Jika semua bagian setelah titik pertama adalah 3 digit, itu pemisah ribuan
                                                                                    $isIndonesianFormat = true;
                                                                                    for ($i = 1; $i < count($parts); $i++) {
                                                                                        if (strlen($parts[$i]) !== 3) {
                                                                                            $isIndonesianFormat = false;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                    if ($isIndonesianFormat && count($parts) > 1) {
                                                                                        // Hapus semua titik (pemisah ribuan)
                                                                                        $hargaSatuan = str_replace('.', '', $hargaSatuan);
                                                                                    }
                                                                                }
                                                                                $hargaSatuan = $hargaSatuan ? floatval($hargaSatuan) : '';
                                                                            } else {
                                                                                $hargaSatuan = $hargaSatuan ? floatval($hargaSatuan) : '';
                                                                            }
                                                                        @endphp
                                                                        <input type="number" step="0.01"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][harga_satuan]"
                                                                            value="{{ $hargaSatuan }}"
                                                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white material-harga-satuan {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-700 cursor-not-allowed' : '' }}"
                                                                            placeholder="0"
                                                                            data-mr-index="{{ $mrIndex }}"
                                                                            data-mat-index="{{ $matIndex }}"
                                                                            {{ $isLocked ? 'readonly' : '' }}>
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        @php
                                                                            $subTotal = old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.sub_total', $material['sub_total'] ?? '');
                                                                            // Parse nilai jika berupa string dengan format currency Indonesia
                                                                            if (is_string($subTotal) && $subTotal !== '') {
                                                                                // Hapus "Rp" dan spasi
                                                                                $subTotal = preg_replace('/Rp\s*/i', '', $subTotal);
                                                                                // Hapus semua karakter non-digit kecuali titik
                                                                                $subTotal = preg_replace('/[^\d.]/', '', $subTotal);
                                                                                // Jika ada titik, cek apakah itu pemisah ribuan (format Indonesia)
                                                                                // Format Indonesia: semua bagian setelah titik pertama adalah 3 digit
                                                                                if (strpos($subTotal, '.') !== false) {
                                                                                    $parts = explode('.', $subTotal);
                                                                                    // Jika semua bagian setelah titik pertama adalah 3 digit, itu pemisah ribuan
                                                                                    $isIndonesianFormat = true;
                                                                                    for ($i = 1; $i < count($parts); $i++) {
                                                                                        if (strlen($parts[$i]) !== 3) {
                                                                                            $isIndonesianFormat = false;
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                    if ($isIndonesianFormat && count($parts) > 1) {
                                                                                        // Hapus semua titik (pemisah ribuan)
                                                                                        $subTotal = str_replace('.', '', $subTotal);
                                                                                    }
                                                                                }
                                                                                $subTotalNum = $subTotal ? floatval($subTotal) : 0;
                                                                                // Format dengan rupiah Indonesia
                                                                                $subTotal = $subTotalNum > 0 ? 'Rp ' . number_format($subTotalNum, 0, ',', '.') : '';
                                                                            } else {
                                                                                $subTotalNum = $subTotal ? floatval($subTotal) : 0;
                                                                                $subTotal = $subTotalNum > 0 ? 'Rp ' . number_format($subTotalNum, 0, ',', '.') : '';
                                                                            }
                                                                        @endphp
                                                                        <input type="text"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][sub_total]"
                                                                            value="{{ $subTotal }}"
                                                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white material-sub-total"
                                                                            placeholder="Rp 0" readonly>
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        <select
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][status]"
                                                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-700 cursor-not-allowed' : '' }}"
                                                                            {{ $isLocked ? 'disabled' : '' }}>
                                                                            <option value="Pengajuan"
                                                                                {{ $currentStatus == 'Pengajuan' ? 'selected' : '' }}>
                                                                                Pengajuan</option>
                                                                            <option value="Disetujui"
                                                                                {{ $currentStatus == 'Disetujui' ? 'selected' : '' }}>
                                                                                Disetujui</option>
                                                                            <option value="Ditolak"
                                                                                {{ $currentStatus == 'Ditolak' ? 'selected' : '' }}>
                                                                                Ditolak</option>
                                                                        </select>
                                                                        @if ($isLocked)
                                                                            <input type="hidden"
                                                                                name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][status]"
                                                                                value="{{ $currentStatus }}">
                                                                        @endif
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        @php
                                                                            $currentStatus = old(
                                                                                'json_pengeluaran_material_tambahan.' .
                                                                                    $mrIndex .
                                                                                    '.materials.' .
                                                                                    $matIndex .
                                                                                    '.status',
                                                                                $material['status'] ?? 'Pengajuan',
                                                                            );
                                                                            $canDelete = !in_array($currentStatus, [
                                                                                'Disetujui',
                                                                                'Ditolak',
                                                                            ]);
                                                                        @endphp
                                                                        @if ($canDelete)
                                                                            <button type="button"
                                                                                class="remove-material-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                                                                <svg class="w-3 h-3" fill="none"
                                                                                    stroke="currentColor"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                                    </path>
                                                                                </svg>
                                                                            </button>
                                                                        @else
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Materials Cards - Mobile -->
                                        <div class="py-4 md:hidden">
                                            <div class="space-y-4 material-tambahan-mobile">
                                                @if (isset($mr['materials']) && is_array($mr['materials']))
                                                    @foreach ($mr['materials'] as $matIndex => $material)
                                                        @php
                                                            $currentStatus = old(
                                                                'json_pengeluaran_material_tambahan.' .
                                                                    $mrIndex .
                                                                    '.materials.' .
                                                                    $matIndex .
                                                                    '.status',
                                                                $material['status'] ?? 'Pengajuan',
                                                            );
                                                            $isLocked = in_array($currentStatus, [
                                                                'Disetujui',
                                                                'Ditolak',
                                                            ]);
                                                            $canDelete = !in_array($currentStatus, [
                                                                'Disetujui',
                                                                'Ditolak',
                                                            ]);
                                                        @endphp
                                                        <div
                                                            class="material-tambahan-mobile-card border border-gray-200 dark:border-zinc-600 rounded-xl p-2">
                                                            <div class="flex justify-between items-start mb-3">
                                                                <h4 class="font-medium text-gray-900 dark:text-white">
                                                                    Material {{ $matIndex + 1 }}</h4>
                                                                @if ($canDelete)
                                                                    <button type="button"
                                                                        class="remove-material-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                                                        <svg class="w-3 h-3" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                            </path>
                                                                        </svg>
                                                                    </button>
                                                                @else
                                                                @endif
                                                            </div>
                                                            <div class="grid grid-cols-1 gap-3">
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Supplier</label>
                                                                    <input type="text"
                                                                        name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][supplier]"
                                                                        value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.supplier', $material['supplier'] ?? '') }}"
                                                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                        placeholder="Supplier"
                                                                        {{ $isLocked ? 'readonly' : '' }}>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Item</label>
                                                                    <input type="text"
                                                                        name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][item]"
                                                                        value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.item', $material['item'] ?? '') }}"
                                                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                        placeholder="Item"
                                                                        {{ $isLocked ? 'readonly' : '' }}>
                                                                </div>
                                                                <div class="grid grid-cols-2 gap-3">
                                                                    <div>
                                                                        <label
                                                                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Qty</label>
                                                                        <input type="number" step="0.01"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][qty]"
                                                                            value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.qty', $material['qty'] ?? '') }}"
                                                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white material-qty {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                            placeholder="0"
                                                                            data-mr-index="{{ $mrIndex }}"
                                                                            data-mat-index="{{ $matIndex }}"
                                                                            {{ $isLocked ? 'readonly' : '' }}>
                                                                    </div>
                                                                    <div>
                                                                        <label
                                                                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan</label>
                                                                        <input type="text"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][satuan]"
                                                                            value="{{ old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.satuan', $material['satuan'] ?? '') }}"
                                                                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                            placeholder="Satuan"
                                                                            {{ $isLocked ? 'readonly' : '' }}>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Harga
                                                                        Satuan</label>
                                                                    @php
                                                                        $hargaSatuan = old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.harga_satuan', $material['harga_satuan'] ?? '');
                                                                        // Parse nilai jika berupa string dengan format currency Indonesia
                                                                        if (is_string($hargaSatuan) && $hargaSatuan !== '') {
                                                                            // Hapus "Rp" dan spasi
                                                                            $hargaSatuan = preg_replace('/Rp\s*/i', '', $hargaSatuan);
                                                                            // Hapus semua karakter non-digit kecuali titik
                                                                            $hargaSatuan = preg_replace('/[^\d.]/', '', $hargaSatuan);
                                                                            // Jika ada titik, cek apakah itu pemisah ribuan (format Indonesia)
                                                                            // Format Indonesia: semua bagian setelah titik pertama adalah 3 digit
                                                                            if (strpos($hargaSatuan, '.') !== false) {
                                                                                $parts = explode('.', $hargaSatuan);
                                                                                // Jika semua bagian setelah titik pertama adalah 3 digit, itu pemisah ribuan
                                                                                $isIndonesianFormat = true;
                                                                                for ($i = 1; $i < count($parts); $i++) {
                                                                                    if (strlen($parts[$i]) !== 3) {
                                                                                        $isIndonesianFormat = false;
                                                                                        break;
                                                                                    }
                                                                                }
                                                                                if ($isIndonesianFormat && count($parts) > 1) {
                                                                                    // Hapus semua titik (pemisah ribuan)
                                                                                    $hargaSatuan = str_replace('.', '', $hargaSatuan);
                                                                                }
                                                                            }
                                                                            $hargaSatuan = $hargaSatuan ? floatval($hargaSatuan) : '';
                                                                        } else {
                                                                            $hargaSatuan = $hargaSatuan ? floatval($hargaSatuan) : '';
                                                                        }
                                                                    @endphp
                                                                    <input type="number" step="0.01"
                                                                        name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][harga_satuan]"
                                                                        value="{{ $hargaSatuan }}"
                                                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white material-harga-satuan {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                        placeholder="0"
                                                                        data-mr-index="{{ $mrIndex }}"
                                                                        data-mat-index="{{ $matIndex }}"
                                                                        {{ $isLocked ? 'readonly' : '' }}>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Sub
                                                                        Total</label>
                                                                    @php
                                                                        $subTotal = old('json_pengeluaran_material_tambahan.' . $mrIndex . '.materials.' . $matIndex . '.sub_total', $material['sub_total'] ?? '');
                                                                        // Parse nilai jika berupa string dengan format currency Indonesia
                                                                        if (is_string($subTotal) && $subTotal !== '') {
                                                                            // Hapus "Rp" dan spasi
                                                                            $subTotal = preg_replace('/Rp\s*/i', '', $subTotal);
                                                                            // Hapus semua karakter non-digit kecuali titik
                                                                            $subTotal = preg_replace('/[^\d.]/', '', $subTotal);
                                                                            // Jika ada titik, cek apakah itu pemisah ribuan (format Indonesia)
                                                                            // Format Indonesia: semua bagian setelah titik pertama adalah 3 digit
                                                                            if (strpos($subTotal, '.') !== false) {
                                                                                $parts = explode('.', $subTotal);
                                                                                // Jika semua bagian setelah titik pertama adalah 3 digit, itu pemisah ribuan
                                                                                $isIndonesianFormat = true;
                                                                                for ($i = 1; $i < count($parts); $i++) {
                                                                                    if (strlen($parts[$i]) !== 3) {
                                                                                        $isIndonesianFormat = false;
                                                                                        break;
                                                                                    }
                                                                                }
                                                                                if ($isIndonesianFormat && count($parts) > 1) {
                                                                                    // Hapus semua titik (pemisah ribuan)
                                                                                    $subTotal = str_replace('.', '', $subTotal);
                                                                                }
                                                                            }
                                                                            $subTotalNum = $subTotal ? floatval($subTotal) : 0;
                                                                            // Format dengan rupiah Indonesia
                                                                            $subTotal = $subTotalNum > 0 ? 'Rp ' . number_format($subTotalNum, 0, ',', '.') : '';
                                                                        } else {
                                                                            $subTotalNum = $subTotal ? floatval($subTotal) : 0;
                                                                            $subTotal = $subTotalNum > 0 ? 'Rp ' . number_format($subTotalNum, 0, ',', '.') : '';
                                                                        }
                                                                    @endphp
                                                                    <input type="text"
                                                                        name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][sub_total]"
                                                                        value="{{ $subTotal }}"
                                                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white material-sub-total"
                                                                        placeholder="Rp 0" readonly>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                                                    @php
                                                                        $currentStatus = old(
                                                                            'json_pengeluaran_material_tambahan.' .
                                                                                $mrIndex .
                                                                                '.materials.' .
                                                                                $matIndex .
                                                                                '.status',
                                                                            $material['status'] ?? 'Pengajuan',
                                                                        );
                                                                        $isLocked = in_array($currentStatus, [
                                                                            'Disetujui',
                                                                            'Ditolak',
                                                                        ]);
                                                                    @endphp
                                                                    <select
                                                                        name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][status]"
                                                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white {{ $isLocked ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                        {{ $isLocked ? 'disabled' : '' }}>
                                                                        <option value="Pengajuan"
                                                                            {{ $currentStatus == 'Pengajuan' ? 'selected' : '' }}>
                                                                            Pengajuan</option>
                                                                        <option value="Disetujui"
                                                                            {{ $currentStatus == 'Disetujui' ? 'selected' : '' }}>
                                                                            Disetujui</option>
                                                                        <option value="Ditolak"
                                                                            {{ $currentStatus == 'Ditolak' ? 'selected' : '' }}>
                                                                            Ditolak</option>
                                                                    </select>
                                                                    @if ($isLocked)
                                                                        <input type="hidden"
                                                                            name="json_pengeluaran_material_tambahan[{{ $mrIndex }}][materials][{{ $matIndex }}][status]"
                                                                            value="{{ $currentStatus }}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Add MR Button -->
                        <div class="flex justify-center">
                            <button type="button" id="add-mr-btn"
                                class="w-full flex justify-center items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-900 disabled:opacity-25 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah MR
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="">
                            <button type="submit" id="submit-btn"
                                class="w-full items-center px-6 py-3 bg-emerald-600 dark:bg-emerald-500 border border-transparent rounded-md font-semibold text-sm text-white dark:text-white uppercase tracking-widest hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 active:bg-indigo-900 disabled:opacity-25 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let mrIndex =
                    {{ isset($rab->json_pengeluaran_material_tambahan) ? count($rab->json_pengeluaran_material_tambahan) : 0 }};
                let materialIndex = {};

                // Initialize material index for each MR
                @if (isset($rab->json_pengeluaran_material_tambahan))
                    @foreach ($rab->json_pengeluaran_material_tambahan as $mrIdx => $mr)
                        materialIndex[{{ $mrIdx }}] =
                            {{ isset($mr['materials']) ? count($mr['materials']) : 0 }};
                    @endforeach
                @endif

                // Helper function to parse Indonesian currency format
                function parseIndonesianCurrency(value) {
                    if (!value) return 0;
                    let str = value.toString();
                    // Hapus "Rp" dan spasi
                    str = str.replace(/Rp\s*/gi, '');
                    // Hapus semua karakter non-digit kecuali titik
                    str = str.replace(/[^\d.]/g, '');
                    // Jika ada titik, cek apakah itu pemisah ribuan (format Indonesia)
                    // Format Indonesia: semua bagian setelah titik pertama adalah 3 digit (misal: 1.800, 270.000, 2.000.000)
                    if (str.indexOf('.') !== -1) {
                        const parts = str.split('.');
                        // Jika semua bagian setelah titik pertama adalah 3 digit, itu pemisah ribuan
                        let isIndonesianFormat = true;
                        for (let i = 1; i < parts.length; i++) {
                            if (parts[i].length !== 3) {
                                isIndonesianFormat = false;
                                break;
                            }
                        }
                        if (isIndonesianFormat && parts.length > 1) {
                            // Hapus semua titik (pemisah ribuan)
                            str = str.replace(/\./g, '');
                        }
                    }
                    return parseFloat(str) || 0;
                }

                // Helper function to format rupiah Indonesia
                function formatRupiah(value) {
                    if (!value || value === 0) return 'Rp 0';
                    const num = typeof value === 'string' ? parseIndonesianCurrency(value) : value;
                    return 'Rp ' + num.toLocaleString('id-ID');
                }

                // Calculate initial sub totals for existing materials
                function calculateInitialSubTotals() {
                    // Desktop table rows
                    document.querySelectorAll('.material-tambahan-row').forEach(row => {
                        const qtyInput = row.querySelector('.material-qty');
                        const hargaSatuanInput = row.querySelector('.material-harga-satuan');
                        const subTotalInput = row.querySelector('.material-sub-total');
                        
                        if (qtyInput && hargaSatuanInput && subTotalInput) {
                            // Parse nilai dengan benar menggunakan helper function
                            const qty = parseIndonesianCurrency(qtyInput.value);
                            const hargaSatuan = parseIndonesianCurrency(hargaSatuanInput.value);
                            const existingSubTotal = parseIndonesianCurrency(subTotalInput.value);
                            
                            let subTotal = existingSubTotal;
                            
                            // Jika qty dan harga_satuan ada, hitung ulang sub_total
                            if (qty > 0 && hargaSatuan > 0) {
                                subTotal = qty * hargaSatuan;
                            } else if (existingSubTotal > 0) {
                                subTotal = existingSubTotal;
                            }
                            
                            // Update nilai di input dengan format rupiah
                            subTotalInput.value = formatRupiah(Math.round(subTotal));
                            
                            // Pastikan harga_satuan juga terisi jika ada nilai
                            if (hargaSatuanInput.value === '' && existingSubTotal > 0 && qty > 0) {
                                hargaSatuanInput.value = Math.round(existingSubTotal / qty);
                            } else if (hargaSatuanInput.value && hargaSatuan === 0) {
                                // Jika harga_satuan masih dalam format currency, parse dan update
                                const parsedHarga = parseIndonesianCurrency(hargaSatuanInput.value);
                                if (parsedHarga > 0) {
                                    hargaSatuanInput.value = parsedHarga;
                                }
                            }
                        }
                    });

                    // Mobile cards
                    document.querySelectorAll('.material-tambahan-mobile-card').forEach(card => {
                        const qtyInput = card.querySelector('.material-qty');
                        const hargaSatuanInput = card.querySelector('.material-harga-satuan');
                        const subTotalInput = card.querySelector('.material-sub-total');
                        
                        if (qtyInput && hargaSatuanInput && subTotalInput) {
                            // Parse nilai dengan benar menggunakan helper function
                            const qty = parseIndonesianCurrency(qtyInput.value);
                            const hargaSatuan = parseIndonesianCurrency(hargaSatuanInput.value);
                            const existingSubTotal = parseIndonesianCurrency(subTotalInput.value);
                            
                            let subTotal = existingSubTotal;
                            
                            // Jika qty dan harga_satuan ada, hitung ulang sub_total
                            if (qty > 0 && hargaSatuan > 0) {
                                subTotal = qty * hargaSatuan;
                            } else if (existingSubTotal > 0) {
                                subTotal = existingSubTotal;
                            }
                            
                            // Update nilai di input dengan format rupiah
                            subTotalInput.value = formatRupiah(Math.round(subTotal));
                            
                            // Pastikan harga_satuan juga terisi jika ada nilai
                            if (hargaSatuanInput.value === '' && existingSubTotal > 0 && qty > 0) {
                                hargaSatuanInput.value = Math.round(existingSubTotal / qty);
                            } else if (hargaSatuanInput.value && hargaSatuan === 0) {
                                // Jika harga_satuan masih dalam format currency, parse dan update
                                const parsedHarga = parseIndonesianCurrency(hargaSatuanInput.value);
                                if (parsedHarga > 0) {
                                    hargaSatuanInput.value = parsedHarga;
                                }
                            }
                        }
                    });
                }

                // Run initial calculation
                calculateInitialSubTotals();

                // Add MR
                document.getElementById('add-mr-btn').addEventListener('click', function() {
                    const container = document.getElementById('material-tambahan-container');
                    const mrHtml = createMRHtml(mrIndex);
                    container.insertAdjacentHTML('beforeend', mrHtml);
                    materialIndex[mrIndex] = 0;
                    mrIndex++;
                });

                // Add Material
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.add-material-btn')) {
                        const btn = e.target.closest('.add-material-btn');
                        const mrIdx = parseInt(btn.dataset.mrIndex);
                        const mrDiv = btn.closest('.material-tambahan-mr');

                        // Add to desktop table
                        const tbody = mrDiv.querySelector('.material-tambahan-tbody');
                        if (tbody) {
                            const materialHtml = createMaterialHtml(mrIdx, materialIndex[mrIdx]);
                            tbody.insertAdjacentHTML('beforeend', materialHtml);
                        }

                        // Add to mobile cards
                        const mobileContainer = mrDiv.querySelector('.material-tambahan-mobile');
                        if (mobileContainer) {
                            const mobileMaterialHtml = createMobileMaterialHtml(mrIdx, materialIndex[mrIdx]);
                            mobileContainer.insertAdjacentHTML('beforeend', mobileMaterialHtml);
                        }

                        materialIndex[mrIdx]++;
                    }
                });

                // Remove MR
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-mr-btn')) {
                        const mrDiv = e.target.closest('.material-tambahan-mr');
                        const mrInput = mrDiv.querySelector('input[name*="[mr]"]');
                        const mrValue = mrInput ? mrInput.value : 'MR ini';

                        if (confirm(
                                `Apakah Anda yakin ingin menghapus ${mrValue}? Tindakan ini tidak dapat dibatalkan.`
                                )) {
                            mrDiv.remove();
                        }
                    }
                });

                // Remove Material
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-material-btn')) {
                        const row = e.target.closest('.material-tambahan-row');
                        const card = e.target.closest('.material-tambahan-mobile-card');

                        // Check if it's desktop table row or mobile card
                        const targetElement = row || card;
                        if (targetElement) {
                            const itemInput = targetElement.querySelector('input[name*="[item]"]');
                            const itemValue = itemInput ? itemInput.value : 'material ini';

                            if (confirm(
                                    `Apakah Anda yakin ingin menghapus ${itemValue}? Tindakan ini tidak dapat dibatalkan.`
                                    )) {
                                targetElement.remove();
                            }
                        }
                    }
                });

                // Calculate Sub Total
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('material-qty') || e.target.classList.contains(
                            'material-harga-satuan')) {
                        // Skip jika input readonly (material yang sudah disetujui/ditolak)
                        if (e.target.hasAttribute('readonly') || e.target.disabled) {
                            return;
                        }
                        
                        // Handle desktop table row
                        const row = e.target.closest('.material-tambahan-row');
                        if (row) {
                            const qtyInput = row.querySelector('.material-qty');
                            const hargaSatuanInput = row.querySelector('.material-harga-satuan');
                            const subTotalInput = row.querySelector('.material-sub-total');
                            
                            if (qtyInput && hargaSatuanInput && subTotalInput) {
                                // Skip jika input readonly
                                if (qtyInput.hasAttribute('readonly') || hargaSatuanInput.hasAttribute('readonly')) {
                                    return;
                                }
                                
                                // Parse nilai dengan benar menggunakan helper function
                                const qty = parseIndonesianCurrency(qtyInput.value);
                                const hargaSatuan = parseIndonesianCurrency(hargaSatuanInput.value);
                                const subTotal = qty * hargaSatuan;
                                subTotalInput.value = formatRupiah(Math.round(subTotal));
                            }
                        }

                        // Handle mobile card
                        const card = e.target.closest('.material-tambahan-mobile-card');
                        if (card) {
                            const qtyInput = card.querySelector('.material-qty');
                            const hargaSatuanInput = card.querySelector('.material-harga-satuan');
                            const subTotalInput = card.querySelector('.material-sub-total');
                            
                            if (qtyInput && hargaSatuanInput && subTotalInput) {
                                // Skip jika input readonly
                                if (qtyInput.hasAttribute('readonly') || hargaSatuanInput.hasAttribute('readonly')) {
                                    return;
                                }
                                
                                // Parse nilai dengan benar menggunakan helper function
                                const qty = parseIndonesianCurrency(qtyInput.value);
                                const hargaSatuan = parseIndonesianCurrency(hargaSatuanInput.value);
                                const subTotal = qty * hargaSatuan;
                                subTotalInput.value = formatRupiah(Math.round(subTotal));
                            }
                        }
                    }
                });

                function createMRHtml(index) {
                    return `
                    <div class="material-tambahan-mr overflow-hidden" data-mr-index="${index}">
                        <div class="w-full">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium text-indigo-100 mb-1">MR</label>
                                                <input type="text" name="json_pengeluaran_material_tambahan[${index}][mr]" class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-md text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent" placeholder="Masukkan MR">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-indigo-100 mb-1">Tanggal</label>
                                                <input type="date" name="json_pengeluaran_material_tambahan[${index}][tanggal]" class="w-full px-3 py-2 bg-white/20 border border-white/30 rounded-md text-white placeholder-indigo-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-row items-stretch sm:items-center gap-2">
                                    <button type="button" class="add-material-btn bg-white/20 hover:bg-white/30 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center" data-mr-index="${index}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Tambah Material</span>
                                        <span class="sm:hidden">Tambah</span>
                                    </button>
                                    <button type="button" class="remove-mr-btn bg-red-500/20 hover:bg-red-500/30 text-white px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span class="ml-1">Hapus MR</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Materials Table - Desktop -->
                        <div class="p-4 hidden md:block">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-600">
                                    <thead class="bg-gray-50 dark:bg-zinc-800">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Supplier</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Item</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Qty</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Satuan</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Harga Satuan</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Sub Total</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="material-tambahan-tbody bg-white dark:bg-zinc-900/50 divide-y divide-gray-200 dark:divide-zinc-600">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Materials Cards - Mobile -->
                        <div class="py-4 md:hidden">
                            <div class="space-y-4 material-tambahan-mobile">
                            </div>
                        </div>
                    </div>
                `;
                }

                function createMaterialHtml(mrIdx, matIdx) {
                    return `
                    <tr class="material-tambahan-row hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors duration-200">
                        <td class="px-3 py-2">
                            <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][supplier]" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white" placeholder="Supplier">
                        </td>
                        <td class="px-3 py-2">
                            <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][item]" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white" placeholder="Item">
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" step="0.01" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][qty]" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white material-qty" placeholder="0" data-mr-index="${mrIdx}" data-mat-index="${matIdx}">
                        </td>
                        <td class="px-3 py-2">
                            <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][satuan]" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white" placeholder="Satuan">
                        </td>
                        <td class="px-3 py-2">
                            <input type="number" step="0.01" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][harga_satuan]" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white material-harga-satuan" placeholder="0" data-mr-index="${mrIdx}" data-mat-index="${matIdx}">
                        </td>
                        <td class="px-3 py-2">
                            <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][sub_total]" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white material-sub-total" placeholder="0" readonly>
                        </td>
                        <td class="px-3 py-2">
                            <select name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][status]" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-800 dark:text-white" disabled>
                                <option value="Pengajuan" selected>Pengajuan</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            <input type="hidden" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][status]" value="Pengajuan">
                        </td>
                        <td class="px-3 py-2">
                            <button type="button" class="remove-material-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                `;
                }

                function createMobileMaterialHtml(mrIdx, matIdx) {
                    return `
                    <div class="material-tambahan-mobile-card border border-gray-200 dark:border-zinc-600 rounded-xl p-2">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-medium text-gray-900 dark:text-white">Material ${matIdx + 1}</h4>
                            <button type="button" class="remove-material-btn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-xs font-medium transition-colors duration-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Supplier</label>
                                <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][supplier]" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white" placeholder="Supplier">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Item</label>
                                <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][item]" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white" placeholder="Item">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Qty</label>
                                    <input type="number" step="0.01" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][qty]" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white material-qty" placeholder="0" data-mr-index="${mrIdx}" data-mat-index="${matIdx}">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Satuan</label>
                                    <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][satuan]" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white" placeholder="Satuan">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Satuan</label>
                                <input type="number" step="0.01" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][harga_satuan]" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white material-harga-satuan" placeholder="0" data-mr-index="${mrIdx}" data-mat-index="${matIdx}">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Sub Total</label>
                                <input type="text" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][sub_total]" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white material-sub-total" placeholder="0" readonly>
                            </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                    <select name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][status]" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-zinc-700 dark:text-white" disabled>
                                        <option value="Pengajuan" selected>Pengajuan</option>
                                        <option value="Disetujui">Disetujui</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                    <input type="hidden" name="json_pengeluaran_material_tambahan[${mrIdx}][materials][${matIdx}][status]" value="Pengajuan">
                                </div>
                        </div>
                    </div>
                `;
                }

                // Saat submit form, ubah format rupiah kembali ke angka murni
                (function() {
                    const form = document.querySelector('form');
                    
                    if (!form) {
                        return;
                    }
                    
                    // Form submit handler - HAPUS PREVENTDEFAULT, LANGSUNG HAPUS CONTAINER HIDDEN
                    const submitHandler = function(e) {
                        // TIDAK PREVENT DEFAULT - biarkan form submit normal setelah cleaning
                        
                        try {
                            // LOGIKA YANG BENAR:
                            // Desktop: container dengan class "md:hidden" = HIDDEN, hapus ini
                            // Mobile: container dengan class "hidden md:block" = HIDDEN, hapus ini
                            
                            const isDesktop = window.innerWidth >= 768;
                            let removedCount = 0;
                            
                            if (isDesktop) {
                                // DESKTOP: Hapus container dengan class "md:hidden" (mobile view)
                                const mobileContainers = form.querySelectorAll('div.md\\:hidden, div[class*="md:hidden"]');
                                mobileContainers.forEach(function(container) {
                                    // Double check: pastikan benar-benar hidden
                                    const style = window.getComputedStyle(container);
                                    if (style.display === 'none' || container.offsetParent === null) {
                                        const inputCount = container.querySelectorAll('input[name*="json_pengeluaran_material_tambahan"], select[name*="json_pengeluaran_material_tambahan"]').length;
                                        if (inputCount > 0) {
                                            container.remove();
                                            removedCount++;
                                        }
                                    }
                                });
                            } else {
                                // MOBILE: Hapus container dengan class "hidden md:block" (desktop view)
                                // Cari semua div yang punya class "hidden" dan cek apakah punya "md:block"
                                const allHiddenDivs = form.querySelectorAll('div[class*="hidden"]');
                                allHiddenDivs.forEach(function(container) {
                                    // Cek apakah class-nya mengandung "md:block" (desktop view)
                                    if (container.className.includes('md:block')) {
                                        // Double check: pastikan benar-benar hidden
                                        const style = window.getComputedStyle(container);
                                        if (style.display === 'none' || container.offsetParent === null) {
                                            const inputCount = container.querySelectorAll('input[name*="json_pengeluaran_material_tambahan"], select[name*="json_pengeluaran_material_tambahan"]').length;
                                            if (inputCount > 0) {
                                                container.remove();
                                                removedCount++;
                                            }
                                        }
                                    }
                                });
                            }
                            
                            // Final check: hapus semua input yang tidak terlihat
                            const allInputs = form.querySelectorAll('input[name*="json_pengeluaran_material_tambahan"], select[name*="json_pengeluaran_material_tambahan"]');
                            allInputs.forEach(function(input) {
                                if (input.offsetParent === null) {
                                    input.removeAttribute('name');
                                }
                            });
                            
                            // Clean sub_total (format currency)
                            form.querySelectorAll('.material-sub-total').forEach(function(input) {
                                if (input.hasAttribute('name') && input.value) {
                                    const numValue = parseIndonesianCurrency(input.value);
                                    input.value = numValue.toString();
                                }
                            });
                            
                            // Clean harga_satuan (format currency)
                            form.querySelectorAll('.material-harga-satuan').forEach(function(input) {
                                if (input.hasAttribute('name') && input.value) {
                                    const valueStr = input.value.toString();
                                    if (valueStr.includes('Rp') || (valueStr.includes('.') && valueStr.split('.').length > 2)) {
                                        const numValue = parseIndonesianCurrency(input.value);
                                        input.value = numValue.toString();
                                    }
                                } else if (input.hasAttribute('name')) {
                                    input.value = '0';
                                }
                            });
                            
                            // Clean qty (set default 0 jika kosong)
                            form.querySelectorAll('.material-qty').forEach(function(input) {
                                if (input.hasAttribute('name') && (!input.value || input.value === '')) {
                                    input.value = '0';
                                }
                            });
                            
                            // Verifikasi data yang akan dikirim
                            const formData = new FormData(form);
                            const submittedData = {};
                            for (let [key, value] of formData.entries()) {
                                if (key.startsWith('json_pengeluaran_material_tambahan')) {
                                    submittedData[key] = value;
                                }
                            }
                            
                            const dataCount = Object.keys(submittedData).length;
                            if (dataCount === 0) {
                                alert('Tidak ada data yang akan dikirim. Silakan coba lagi.');
                                e.preventDefault();
                                return false;
                            }
                            
                            // Form siap submit, biarkan submit normal
                            return true;
                            
                        } catch (error) {
                            alert('ERROR: ' + error.message);
                            e.preventDefault();
                            return false;
                        }
                    };
                    
                    form.addEventListener('submit', submitHandler, true);
                })();
            });
        </script>
    @endpush
</x-layouts.supervisi>

