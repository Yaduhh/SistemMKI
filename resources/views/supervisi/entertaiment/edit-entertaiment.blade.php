<x-layouts.supervisi title="Edit Entertainment - {{ $rab->proyek }}">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Data Entertainment') }}
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
                    Kembali ke Detail RAB
                </a>
            </div>
        </div>
    </x-slot>

    <div class="w-full">
        <div class="max-w-7xl mx-auto">
            <!-- Pengeluaran Entertainment -->
            <div class="w-full">
                <div class="py-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pengeluaran Entertainment</h3>
                    <p class=" text-gray-600 dark:text-gray-400 mt-1">
                        Kelola pengeluaran entertainment untuk proyek ini
                    </p>
                    @php
                        // Check if any material has approved/rejected status
                        $hasApprovedMaterial = false;
                        $hasRejectedMaterial = false;
                        if (
                            isset($rab->json_pengeluaran_entertaiment) &&
                            is_array($rab->json_pengeluaran_entertaiment)
                        ) {
                            foreach ($rab->json_pengeluaran_entertaiment as $mr) {
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
                    <form action="{{ route('supervisi.rab.update-entertainment', $rab) }}" method="POST"
                        id="entertainmentForm">
                        @csrf
                        @method('PATCH')

                        <div>
                            <div id="entertaiment-mr-list" class="space-y-8">
                                @if (isset($rab->json_pengeluaran_entertaiment) &&
                                        is_array($rab->json_pengeluaran_entertaiment) &&
                                        count($rab->json_pengeluaran_entertaiment) > 0)
                                    @foreach ($rab->json_pengeluaran_entertaiment as $mrIndex => $mr)
                                        <div class="w-full relative mr-group">
                                            <div class="flex flex-col md:flex-row md:items-end gap-4 mb-4">
                                                <div class="w-full">
                                                    <label class="block  font-medium mb-1">MR</label>
                                                    <input type="text" data-mr-field="mr"
                                                        name="json_pengeluaran_entertaiment[{{ $mrIndex }}][mr]"
                                                        value="{{ $mr['mr'] ?? '' }}" placeholder="MR 001"
                                                        class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </div>
                                                <div class="w-full">
                                                    <label class="block  font-medium mb-1">Tanggal <span class="text-red-500">*</span></label>
                                                    <input type="date" data-mr-field="tanggal"
                                                        name="json_pengeluaran_entertaiment[{{ $mrIndex }}][tanggal]"
                                                        value="{{ $mr['tanggal'] ?? '' }}"
                                                        required
                                                        class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </div>
                                                <div class="flex gap-2 items-end">
                                                    <button type="button"
                                                        class="dark:bg-teal-600 bg-teal-600 text-white px-4 py-2 rounded-xl add-entertaiment-material truncate"
                                                        data-mr-index="{{ $mrIndex }}">+ Material</button>
                                                    @php
                                                        // Check if any material in this MR has approved status
                                                        $hasApprovedMaterialInMR = false;
                                                        if (isset($mr['materials']) && is_array($mr['materials'])) {
                                                            foreach ($mr['materials'] as $material) {
                                                                if (($material['status'] ?? '') === 'Disetujui') {
                                                                    $hasApprovedMaterialInMR = true;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    @if (!$hasApprovedMaterialInMR)
                                                        <button type="button"
                                                            class="dark:bg-red-600 bg-red-600 text-white px-4 py-2 rounded-xl remove-entertaiment-mr-group truncate">Hapus
                                                            MR</button>
                                                    @endif
                                                </div>
                                            </div>

                                            @if (isset($mr['materials']) && is_array($mr['materials']))
                                                @foreach ($mr['materials'] as $matIndex => $material)
                                                    <div
                                                        class="grid grid-cols-1 md:grid-cols-7 gap-4 items-end p-6 rounded-xl mt-4 bg-gray-100 dark:bg-zinc-700/30 relative entertaiment-material-row pt-12">
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium mb-1">Supplier</label>
                                                            <input type="text" data-material-field="supplier"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][supplier]"
                                                                value="{{ $material['supplier'] ?? '' }}"
                                                                placeholder="Supplier"
                                                                class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'readonly' : '' }} />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Item</label>
                                                            <input type="text" data-material-field="item"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][item]"
                                                                value="{{ $material['item'] ?? '' }}"
                                                                placeholder="Item"
                                                                class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'readonly' : '' }} />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Qty</label>
                                                            <input type="number" min="0"
                                                                data-material-field="qty"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][qty]"
                                                                value="{{ $material['qty'] ?? '' }}"
                                                                placeholder="Qty"
                                                                class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white qty-input {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'readonly' : '' }} />
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium mb-1">Satuan</label>
                                                            <input type="text" data-material-field="satuan"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][satuan]"
                                                                value="{{ $material['satuan'] ?? '' }}"
                                                                placeholder="Satuan"
                                                                class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'readonly' : '' }} />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Harga
                                                                Satuan</label>
                                                            <input type="text" data-material-field="harga_satuan"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][harga_satuan]"
                                                                value="{{ $material['harga_satuan'] ?? '' }}"
                                                                placeholder="Harga Satuan"
                                                                class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-input {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'bg-gray-100 dark:bg-zinc-600 cursor-not-allowed' : '' }}"
                                                                {{ ($material['status'] ?? '') === 'Disetujui' || ($material['status'] ?? '') === 'Ditolak' ? 'readonly' : '' }} />
                                                            <input type="hidden"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][harga_satuan_raw]"
                                                                value="{{ $material['harga_satuan'] ?? '' }}" />
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium mb-1">Status</label>
                                                            <input type="text" data-material-field="status"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][status]"
                                                                value="{{ $material['status'] ?? 'Pengajuan' }}"
                                                                class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white bg-gray-100 dark:bg-zinc-600"
                                                                readonly />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Sub
                                                                Total</label>
                                                            <input type="text" data-material-field="sub_total"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][sub_total]"
                                                                value="{{ $material['sub_total'] ?? '' }}"
                                                                placeholder="Sub Total"
                                                                class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input"
                                                                readonly />
                                                            <input type="hidden"
                                                                name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][sub_total_raw]"
                                                                value="{{ $material['sub_total'] ?? '' }}" />
                                                        </div>
                                                        @if (($material['status'] ?? '') === 'Pengajuan')
                                                            <button type="button"
                                                                class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button"
                                class="dark:bg-teal-900 bg-teal-600 text-white w-full py-2 uppercase mt-4"
                                id="add-entertaiment-mr-group">Tambah MR</button>
                            <div class="flex justify-end bg-teal-600/10 py-2 px-4">
                                <div class="font-semibold mr-2">Grand Total:</div>
                                <div class="font-bold text-teal-700 dark:text-teal-400"
                                    id="grand-total-entertainment">0</div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-zinc-700">
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="resetForm()"
                                    class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:border-zinc-400 focus:ring focus:ring-zinc-200 active:bg-zinc-100 disabled:opacity-25 transition">
                                    Reset
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-amber-600 dark:bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-amber-700 dark:hover:bg-amber-600 focus:outline-none focus:border-amber-700 focus:ring focus:ring-amber-200 active:bg-amber-900 disabled:opacity-25 transition">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Templates -->
    <template id="entertaiment-mr-group-template">
        <div class="w-full relative mr-group">
            <div class="flex flex-col md:flex-row md:items-end gap-4 mb-4">
                <div class="w-full">
                    <label class="block  font-medium mb-1">MR</label>
                    <input type="text" data-mr-field="mr" name="json_pengeluaran_entertaiment[__MRIDX__][mr]"
                        placeholder="MR 001"
                        class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
                <div class="w-full">
                    <label class="block  font-medium mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" data-mr-field="tanggal"
                        name="json_pengeluaran_entertaiment[__MRIDX__][tanggal]"
                        required
                        class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-700 dark:text-white" />
                </div>
                <div class="flex items-end">
                    <button type="button"
                        class="dark:bg-teal-600 bg-teal-600 text-white px-4 py-2 rounded-xl add-entertaiment-material truncate"
                        data-mr-index="__MRIDX__">+ Material</button>
                </div>
                <div class="flex items-end">
                    <button type="button"
                        class="dark:bg-red-600 bg-red-600 text-white px-4 py-2 rounded-xl remove-entertaiment-mr-group truncate">Hapus
                        MR</button>
                </div>
            </div>
        </div>
    </template>

    <template id="entertaiment-material-row-template">
        <div
            class="grid grid-cols-1 md:grid-cols-7 gap-4 items-end p-6 rounded-xl mt-4 bg-gray-100 dark:bg-zinc-700/30 relative entertaiment-material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][supplier]"
                    placeholder="Supplier"
                    class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item"
                    class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" min="0" data-material-field="qty"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][qty]" placeholder="Qty"
                    class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white qty-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][satuan]"
                    placeholder="Satuan"
                    class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="text" data-material-field="harga_satuan"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][harga_satuan]"
                    placeholder="Harga Satuan"
                    class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-input" />
                <input type="hidden"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][harga_satuan_raw]"
                    value="" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Status</label>
                <input type="text" data-material-field="status"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][status]" value="Pengajuan"
                    class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white bg-gray-100 dark:bg-zinc-600"
                    readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="text" data-material-field="sub_total"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][sub_total]"
                    placeholder="Sub Total"
                    class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-700 dark:text-white sub-total-input"
                    readonly />
                <input type="hidden"
                    name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][sub_total_raw]"
                    value="" />
            </div>
            <button type="button"
                class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
        </div>
    </template>

    <script>
        let mrIndex = {{ isset($rab->json_pengeluaran_entertaiment) ? count($rab->json_pengeluaran_entertaiment) : 0 }};
        let materialIndex = 0;

        // Add MR Group
        document.getElementById('add-entertaiment-mr-group').addEventListener('click', function() {
            const template = document.getElementById('entertaiment-mr-group-template');
            const mrList = document.getElementById('entertaiment-mr-list');
            const newMrGroup = template.content.cloneNode(true);

            // Update all placeholders
            newMrGroup.querySelectorAll('[name*="__MRIDX__"]').forEach(input => {
                input.name = input.name.replace('__MRIDX__', mrIndex);
            });
            newMrGroup.querySelectorAll('.add-entertaiment-material').forEach(button => {
                button.setAttribute('data-mr-index', mrIndex);
            });

            mrList.appendChild(newMrGroup);
            mrIndex++;
        });

        // Add Material Row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-entertaiment-material')) {
                const mrIndex = e.target.getAttribute('data-mr-index');
                const template = document.getElementById('entertaiment-material-row-template');
                const mrGroup = e.target.closest('.mr-group');

                // Count existing materials in this MR group to get next index
                const existingMaterials = mrGroup.querySelectorAll('.entertaiment-material-row');
                const nextMaterialIndex = existingMaterials.length;

                const newMaterialRow = template.content.cloneNode(true);

                // Update all placeholders
                newMaterialRow.querySelectorAll('[name*="__MRIDX__"]').forEach(input => {
                    input.name = input.name.replace('__MRIDX__', mrIndex);
                });
                newMaterialRow.querySelectorAll('[name*="__MATIDX__"]').forEach(input => {
                    input.name = input.name.replace('__MATIDX__', nextMaterialIndex);
                });

                // Insert before the "Tambah Material" button
                const addButton = mrGroup.querySelector('.add-entertaiment-material').parentElement.parentElement;
                addButton.parentNode.insertBefore(newMaterialRow, addButton.nextSibling);
            }
        });

        // Remove MR Group
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-entertaiment-mr-group')) {
                if (confirm('Apakah Anda yakin ingin menghapus MR group ini?')) {
                    e.target.closest('.mr-group').remove();
                }
            }
        });

        // Remove Material Row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-material')) {
                const materialRow = e.target.closest('.entertaiment-material-row');
                const mrGroup = materialRow.closest('.mr-group');
                materialRow.remove();

                // Reindex remaining materials in this MR group
                const remainingMaterials = mrGroup.querySelectorAll('.entertaiment-material-row');
                remainingMaterials.forEach((material, index) => {
                    const mrIndex = mrGroup.querySelector('.add-entertaiment-material').getAttribute(
                        'data-mr-index');

                    // Update all input names with new index
                    material.querySelectorAll('input[name*="[materials]"]').forEach(input => {
                        const oldName = input.name;
                        const newName = oldName.replace(/\[materials\]\[\d+\]/,
                            `[materials][${index}]`);
                        input.name = newName;
                    });
                });

                // Update grand total after reindexing
                updateGrandTotal();
            }
        });

        // Format harga input to currency format
        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('harga-input')) {
                const value = e.target.value.replace(/[^\d]/g, '');
                if (value) {
                    e.target.value = parseInt(value).toLocaleString('id-ID');
                }
            }
        });

        // Remove formatting when focusing on harga input
        document.addEventListener('focus', function(e) {
            if (e.target.classList.contains('harga-input')) {
                const value = e.target.value.replace(/[^\d]/g, '');
                if (value) {
                    e.target.value = value;
                }
            }
        });

        // Calculate sub total on input change
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input') || e.target.classList.contains('harga-input')) {
                const row = e.target.closest('.entertaiment-material-row');
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const hargaInput = row.querySelector('.harga-input');

                // Parse harga satuan - handle both formatted and unformatted values
                let harga = 0;
                if (hargaInput.value.includes('.')) {
                    // If formatted (e.g., "9.000"), parse it correctly
                    harga = parseFloat(hargaInput.value.replace(/\./g, '')) || 0;
                } else {
                    // If unformatted (e.g., "9000"), parse normally
                    harga = parseFloat(hargaInput.value) || 0;
                }

                const subTotal = qty * harga;
                row.querySelector('.sub-total-input').value = subTotal.toLocaleString('id-ID');

                // Update hidden inputs with raw values
                const hiddenHargaInput = row.querySelector('input[name*="[harga_satuan_raw]"]');
                const hiddenSubTotalInput = row.querySelector('input[name*="[sub_total_raw]"]');
                if (hiddenHargaInput) {
                    hiddenHargaInput.value = harga;
                }
                if (hiddenSubTotalInput) {
                    hiddenSubTotalInput.value = subTotal;
                }

                updateGrandTotal();
            }
        });

        // Also calculate when harga input loses focus (after formatting)
        document.addEventListener('blur', function(e) {
            if (e.target.classList.contains('harga-input')) {
                const row = e.target.closest('.entertaiment-material-row');
                if (row) {
                    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;

                    // Parse harga satuan - handle both formatted and unformatted values
                    let harga = 0;
                    if (e.target.value.includes('.')) {
                        // If formatted (e.g., "9.000"), parse it correctly
                        harga = parseFloat(e.target.value.replace(/\./g, '')) || 0;
                    } else {
                        // If unformatted (e.g., "9000"), parse normally
                        harga = parseFloat(e.target.value) || 0;
                    }

                    const subTotal = qty * harga;
                    row.querySelector('.sub-total-input').value = subTotal.toLocaleString('id-ID');

                    // Update hidden inputs with raw values
                    const hiddenHargaInput = row.querySelector('input[name*="[harga_satuan_raw]"]');
                    const hiddenSubTotalInput = row.querySelector('input[name*="[sub_total_raw]"]');
                    if (hiddenHargaInput) {
                        hiddenHargaInput.value = harga;
                    }
                    if (hiddenSubTotalInput) {
                        hiddenSubTotalInput.value = subTotal;
                    }

                    updateGrandTotal();
                }
            }
        });

        // Update grand total
        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.sub-total-input').forEach(input => {
                // Parse sub total - handle both formatted and unformatted values
                let value = 0;
                if (input.value.includes('.')) {
                    // If formatted (e.g., "25.000"), parse it correctly
                    value = parseFloat(input.value.replace(/\./g, '')) || 0;
                } else {
                    // If unformatted (e.g., "25000"), parse normally
                    value = parseFloat(input.value) || 0;
                }
                total += value;
            });
            document.getElementById('grand-total-entertainment').textContent = total.toLocaleString('id-ID');
        }

        // Initialize grand total
        updateGrandTotal();

        // Handle form submission
        document.getElementById('entertainmentForm').addEventListener('submit', function(e) {
            // Update all inputs with raw values before submit
            document.querySelectorAll('.harga-input').forEach((input, index) => {
                const row = input.closest('.entertaiment-material-row');
                const hiddenHargaInput = row.querySelector('input[name*="[harga_satuan_raw]"]');
                const hiddenSubTotalInput = row.querySelector('input[name*="[sub_total_raw]"]');

                if (hiddenHargaInput && hiddenHargaInput.value) {
                    input.value = hiddenHargaInput.value;
                }

                // Also update sub total input with raw value
                const subTotalInput = row.querySelector('.sub-total-input');
                if (hiddenSubTotalInput && hiddenSubTotalInput.value && subTotalInput) {
                    subTotalInput.value = hiddenSubTotalInput.value;
                }
            });
        });

        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang belum disimpan akan hilang.')) {
                document.getElementById('entertainmentForm').reset();
                updateGrandTotal();
            }
        }
    </script>
</x-layouts.supervisi>