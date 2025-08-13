<x-layouts.supervisi title="Detail RAB - {{ $rab->proyek }}">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail RAB') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $rab->proyek }} • {{ $rab->pekerjaan }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('supervisi.rab.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-zinc-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-zinc-600 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-900 disabled:opacity-25 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Informasi Proyek -->
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700 mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informasi Proyek</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nama Proyek</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->proyek }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pekerjaan</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->pekerjaan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Lokasi</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->lokasi }}</p>
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
                                    $color = $statusColors[$rab->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                    $text = $statusText[$rab->status] ?? $rab->status;
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ $text }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Dibuat Oleh</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->user->name ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Tanggal Dibuat</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Entertainment -->
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pengeluaran Entertainment</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Kelola pengeluaran entertainment untuk proyek ini
                    </p>
                </div>
                <div class="px-6 py-4">
                    <form action="{{ route('supervisi.rab.update-entertainment', $rab) }}" method="POST" id="entertainmentForm">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <div id="entertaiment-mr-list" class="space-y-8">
                                @if(isset($rab->json_pengeluaran_entertaiment) && is_array($rab->json_pengeluaran_entertaiment) && count($rab->json_pengeluaran_entertaiment) > 0)
                                    @foreach($rab->json_pengeluaran_entertaiment as $mrIndex => $mr)
                                        <div class="w-full relative mr-group">
                                            <div class="flex flex-col md:flex-row md:items-end gap-4 mb-4">
                                                <div class="w-full">
                                                    <label class="block text-sm font-medium mb-1">MR</label>
                                                    <input type="text" data-mr-field="mr" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][mr]" value="{{ $mr['mr'] ?? '' }}" placeholder="MR 001" class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </div>
                                                <div class="w-full">
                                                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                                                    <input type="date" data-mr-field="tanggal" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][tanggal]" value="{{ $mr['tanggal'] ?? '' }}" class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                </div>
                                                <div class="flex items-end">
                                                    <button type="button" class="dark:bg-teal-600 bg-teal-600 text-white px-4 py-2 rounded-xl add-entertaiment-material truncate" data-mr-index="{{ $mrIndex }}">+ Material</button>
                                                </div>
                                                <div class="flex items-end">
                                                    <button type="button" class="dark:bg-red-600 bg-red-600 text-white px-4 py-2 rounded-xl remove-entertaiment-mr-group truncate">Hapus MR</button>
                                                </div>
                                            </div>
                                            
                                            @if(isset($mr['materials']) && is_array($mr['materials']))
                                                @foreach($mr['materials'] as $matIndex => $material)
                                                    <div class="grid grid-cols-1 md:grid-cols-7 gap-4 items-end p-6 rounded-xl mt-4 bg-gray-100 dark:bg-zinc-700/30 relative entertaiment-material-row pt-12">
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Supplier</label>
                                                            <input type="text" data-material-field="supplier" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][supplier]" value="{{ $material['supplier'] ?? '' }}" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Item</label>
                                                            <input type="text" data-material-field="item" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][item]" value="{{ $material['item'] ?? '' }}" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Qty</label>
                                                            <input type="number" min="0" data-material-field="qty" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][qty]" value="{{ $material['qty'] ?? '' }}" placeholder="Qty" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white qty-input" />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Satuan</label>
                                                            <input type="text" data-material-field="satuan" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][satuan]" value="{{ $material['satuan'] ?? '' }}" placeholder="Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                                                            <input type="text" data-material-field="harga_satuan" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][harga_satuan]" value="{{ $material['harga_satuan'] ?? '' }}" placeholder="Harga Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-input" />
                                                            <input type="hidden" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][harga_satuan_raw]" value="{{ $material['harga_satuan'] ?? '' }}" />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Status</label>
                                                            <input type="text" data-material-field="status" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][status]" value="{{ $material['status'] ?? 'Pengajuan' }}" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white bg-gray-100 dark:bg-zinc-600" readonly />
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium mb-1">Sub Total</label>
                                                            <input type="text" data-material-field="sub_total" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][sub_total]" value="{{ $material['sub_total'] ?? '' }}" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input" readonly />
                                                            <input type="hidden" name="json_pengeluaran_entertaiment[{{ $mrIndex }}][materials][{{ $matIndex }}][sub_total_raw]" value="{{ $material['sub_total'] ?? '' }}" />
                                                        </div>
                                                        <button type="button" class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="dark:bg-teal-900 bg-teal-600 text-white w-full py-2 uppercase mt-4" id="add-entertaiment-mr-group">Tambah MR</button>
                            <div class="flex justify-end bg-teal-600/10 py-2 px-4">
                                <div class="font-semibold mr-2">Grand Total:</div>
                                <div class="font-bold text-teal-700 dark:text-teal-400" id="grand-total-entertainment">0</div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-zinc-700">
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="resetForm()" class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:border-zinc-400 focus:ring focus:ring-zinc-200 active:bg-zinc-100 disabled:opacity-25 transition">
                                    Reset
                                </button>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-amber-600 dark:bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-amber-700 dark:hover:bg-amber-600 focus:outline-none focus:border-amber-700 focus:ring focus:ring-amber-200 active:bg-amber-900 disabled:opacity-25 transition">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pengeluaran Material Pendukung -->
            @if(isset($rab->json_pengeluaran_material_pendukung) && is_array($rab->json_pengeluaran_material_pendukung) && count($rab->json_pengeluaran_material_pendukung) > 0)
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700 mt-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pengeluaran Material Pendukung</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Data material pendukung untuk proyek ini
                    </p>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-6">
                        @foreach($rab->json_pengeluaran_material_pendukung as $mrIndex => $mr)
                            <div class="w-full">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-100 dark:bg-zinc-900/50 p-4">
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $mr['mr'] ?? '-' }}</label>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Tanggal : {{ $mr['tanggal'] ?? '-' }}</label>
                                    </div>
                                </div>
                                
                                @if(isset($mr['materials']) && is_array($mr['materials']))
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                                            <thead class="bg-gray-50 dark:bg-zinc-700">
                                                <tr>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Supplier</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Item</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Qty</th>
                                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">Satuan</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                                                @foreach($mr['materials'] as $material)
                                                    <tr>
                                                        <td class="px-3 py-2 text-sm text-zinc-900 dark:text-white">{{ $material['supplier'] ?? '-' }}</td>
                                                        <td class="px-3 py-2 text-sm text-zinc-900 dark:text-white">{{ $material['item'] ?? '-' }}</td>
                                                        <td class="px-3 py-2 text-sm text-zinc-900 dark:text-white">{{ $material['qty'] ?? '-' }}</td>
                                                        <td class="px-3 py-2 text-sm text-zinc-900 dark:text-white">{{ $material['satuan'] ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Templates -->
    <template id="entertaiment-mr-group-template">
        <div class="w-full relative mr-group">
            <div class="flex flex-col md:flex-row md:items-end gap-4 mb-4">
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">MR</label>
                    <input type="text" data-mr-field="mr" name="json_pengeluaran_entertaiment[__MRIDX__][mr]" placeholder="MR 001" class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" data-mr-field="tanggal" name="json_pengeluaran_entertaiment[__MRIDX__][tanggal]" class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
                <div class="flex items-end">
                    <button type="button" class="dark:bg-teal-600 bg-teal-600 text-white px-4 py-2 rounded-xl add-entertaiment-material truncate" data-mr-index="__MRIDX__">+ Material</button>
                </div>
                <div class="flex items-end">
                    <button type="button" class="dark:bg-red-600 bg-red-600 text-white px-4 py-2 rounded-xl remove-entertaiment-mr-group truncate">Hapus MR</button>
                </div>
            </div>
        </div>
    </template>

    <template id="entertaiment-material-row-template">
        <div class="grid grid-cols-1 md:grid-cols-7 gap-4 items-end p-6 rounded-xl mt-4 bg-gray-100 dark:bg-zinc-700/30 relative entertaiment-material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" min="0" data-material-field="qty" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][qty]" placeholder="Qty" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white qty-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="text" data-material-field="harga_satuan" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="Harga Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-input" />
                <input type="hidden" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][harga_satuan_raw]" value="" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Status</label>
                <input type="text" data-material-field="status" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][status]" value="Pengajuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white bg-gray-100 dark:bg-zinc-600" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="text" data-material-field="sub_total" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-700 dark:text-white sub-total-input" readonly />
                <input type="hidden" name="json_pengeluaran_entertaiment[__MRIDX__][materials][__MATIDX__][sub_total_raw]" value="" />
            </div>
            <button type="button" class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
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
                    const mrIndex = mrGroup.querySelector('.add-entertaiment-material').getAttribute('data-mr-index');
                    
                    // Update all input names with new index
                    material.querySelectorAll('input[name*="[materials]"]').forEach(input => {
                        const oldName = input.name;
                        const newName = oldName.replace(/\[materials\]\[\d+\]/, `[materials][${index}]`);
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
