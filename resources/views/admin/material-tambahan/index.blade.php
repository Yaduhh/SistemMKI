<x-layouts.app :title="__('Pengeluaran Material Tambahan')">
    <div class="container mx-auto">
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold">Material Tambahan</h1>
                    <p class="text-zinc-600 dark:text-zinc-400 text-sm lg:text-base">Kelola status pengeluaran
                        material tambahan
                    </p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div
            class="mb-6 bg-white dark:bg-zinc-800">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Filter Data</h3>
            </div>
            <form method="GET" class="flex justify-between gap-4 items-center">
                <div class="w-full">
                    <select name="status_filter"
                        class="border w-full border-zinc-300 dark:border-zinc-600 rounded-md px-3 py-2.5 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="Pengajuan" {{ request('status_filter') == 'Pengajuan' ? 'selected' : '' }}>
                            Pengajuan</option>
                        <option value="Disetujui" {{ request('status_filter') == 'Disetujui' ? 'selected' : '' }}>
                            Disetujui</option>
                        <option value="Ditolak" {{ request('status_filter') == 'Ditolak' ? 'selected' : '' }}>Ditolak
                        </option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.material-tambahan.index') }}"
                        class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Card Layout untuk Mobile -->
        <div class="space-y-4">
            @forelse($materialTambahans as $materialTambahan)
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-4">
                    <!-- Header Card -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div>
                                <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $materialTambahan['rab_proyek'] }}</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $materialTambahan['rab_pekerjaan'] }}</p>
                            </div>
                        </div>
                        @php
                            $statusColors = [
                                'Pengajuan' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                'Disetujui' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'Ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            ];
                            $color = $statusColors[$materialTambahan['status']] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                            {{ $materialTambahan['status'] }}
                        </span>
                    </div>

                    <!-- Supervisi Info -->
                    @if(!empty($materialTambahan['supervisi_nama']))
                        <div class="mb-4 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Supervisi:</span>
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $materialTambahan['supervisi_nama'] }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Detail Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Tanggal -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Tanggal:</span>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                @if (!empty($materialTambahan['tanggal']) && $materialTambahan['tanggal'] !== '-' && $materialTambahan['tanggal'] !== null)
                                    @formatTanggalIndonesia($materialTambahan['tanggal'])
                                @else
                                    -
                                @endif
                            </span>
                        </div>

                        <!-- Qty -->
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Qty:</span>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $materialTambahan['qty'] }} {{ $materialTambahan['satuan'] }}</span>
                        </div>
                    </div>

                    <!-- Supplier & Item -->
                    <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="mb-2">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Supplier</span>
                            </div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 ml-6">{{ $materialTambahan['supplier'] }}</p>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Item</span>
                            </div>
                            <p class="text-sm text-blue-600 dark:text-blue-400 ml-6">{{ $materialTambahan['item'] }}</p>
                        </div>
                    </div>

                    <!-- Harga Info -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-700 dark:text-green-300">Harga Satuan</span>
                            </div>
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">Rp {{ number_format((float) $materialTambahan['harga_satuan'], 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Sub Total</span>
                            </div>
                            <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">Rp {{ number_format((float) $materialTambahan['sub_total'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        @if ($materialTambahan['rab_status'] !== 'selesai')
                            <button
                                onclick="updateStatus({{ $materialTambahan['rab_id'] }}, {{ $materialTambahan['mr_index'] }}, {{ $materialTambahan['material_index'] }}, '{{ $materialTambahan['status'] }}')"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center gap-2 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Update Status
                            </button>
                        @endif
                        <a href="{{ route('admin.rancangan-anggaran-biaya.show', $materialTambahan['rab_id']) }}"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat RAB
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-8 text-center">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-2">Tidak ada data</h3>
                            <p class="text-zinc-500 dark:text-zinc-400">Belum ada pengeluaran material tambahan yang tercatat.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Update Status -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600/30 backdrop-blur-sm dark:bg-zinc-900/30 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 w-96 border border-zinc-200 dark:border-zinc-400">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Update Pengajuan Material Tambahan</h3>
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="material_tambahan_index" id="material_tambahan_index">
                    <input type="hidden" name="material_index" id="material_index">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Status</label>
                        <select name="status"
                            class="w-full border border-zinc-300 dark:border-zinc-600 rounded-md px-3 py-2 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white">
                            <option value="Pengajuan">Pengajuan</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeStatusModal()"
                            class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(rabId, materialTambahanIndex, materialIndex, currentStatus) {
            document.getElementById('material_tambahan_index').value = materialTambahanIndex;
            document.getElementById('material_index').value = materialIndex;
            document.getElementById('statusForm').action = `/admin/material-tambahan/${rabId}/update-status`;
            document.querySelector('select[name="status"]').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });
    </script>
</x-layouts.app>
