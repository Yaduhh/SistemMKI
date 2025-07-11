<div>
    <div id="mr-list" class="space-y-8">
        <!-- MR group akan di-generate oleh JS -->
    </div>
    <button type="button" class="dark:bg-sky-900 bg-sky-600 text-white py-2 uppercase w-full" id="add-mr-group">Tambah MR</button>
    <div class="flex justify-end bg-sky-600/10 py-2 px-4">
        <div class="font-semibold mr-2">Grand Total:</div>
        <div class="font-bold text-sky-700 dark:text-sky-400" id="grand-total-pendukung">0</div>
    </div>
    <template id="mr-group-template">
        <div class="w-full relative mr-group">
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">MR</label>
                    <input type="text" data-mr-field="mr" name="json_pengeluaran_material_pendukung[__MRIDX__][mr]" placeholder="MR 001" class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                </div>
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">Tanggal</label> 
                    <input type="date" data-mr-field="tanggal" name="json_pengeluaran_material_pendukung[__MRIDX__][tanggal]" class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Action</label> 
                    <button type="button" class="text-red-600 font-bold ml-auto remove-mr flex items-center gap-2 bg-red-500/10 px-4 py-2 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        <p class="text-red-600 font-bold">Hapus</p>
                    </button>
                </div>
            </div>
            <div class="space-y-0 material-list">
                <!-- Baris material akan di-generate oleh JS -->
            </div>
            <button type="button" class="dark:bg-sky-900 bg-sky-600 border border-sky-600 text-sky-100 hover:bg-sky-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-material-row mt-6">Tambah Material Pendukung</button>
            <div class="mt-4 flex justify-end border-t border-b border-sky-600/30 bg-sky-600/10 px-4 py-2">
                <div class="font-semibold mr-2">Total MR :</div>
                <div class="font-bold text-sky-600 dark:text-sky-400 total-mr">0</div>
            </div>
        </div>
    </template>
    <template id="material-row-template">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end p-6  bg-white dark:bg-zinc-700/30 relative material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Ukuran</label>
                <input type="text" data-material-field="ukuran" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][ukuran]" placeholder="Ukuran" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Panjang</label>
                <input type="text" data-material-field="panjang" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][panjang]" placeholder="Panjang" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" min="0" data-material-field="qty" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][qty]" placeholder="Qty" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white qty-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="number" min="0" data-material-field="harga_satuan" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="Harga Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="number" data-material-field="sub_total" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input" readonly />
            </div>
            <button type="button" class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
        </div>
    </template>
    <script>
        (function () {
            const mrList = document.getElementById('mr-list');
            const addMrBtn = document.getElementById('add-mr-group');
            const mrGroupTemplate = document.getElementById('mr-group-template');
            const materialRowTemplate = document.getElementById('material-row-template');
            const grandTotalEl = document.getElementById('grand-total-pendukung');
            if (!mrList || !addMrBtn || !mrGroupTemplate || !materialRowTemplate || !grandTotalEl) return;

            function renderAllNames() {
                mrList.querySelectorAll('.mr-group').forEach((mrGroup, mrIdx) => {
                    // Update MR & tanggal name
                    mrGroup.querySelectorAll('input[name^="json_pengeluaran_material_pendukung["]').forEach(input => {
                        let name = input.getAttribute('name');
                        name = name.replace(/json_pengeluaran_material_pendukung\[\d+\]/, `json_pengeluaran_material_pendukung[${mrIdx}]`);
                        name = name.replace(/materials\]\[\d+\]/g, match => match.replace(/\d+/, '0'));
                        input.setAttribute('name', name);
                    });
                    // Update material row names
                    mrGroup.querySelectorAll('.material-row').forEach((row, matIdx, arr) => {
                        row.querySelectorAll('input').forEach(input => {
                            let name = input.getAttribute('name');
                            name = name.replace(/json_pengeluaran_material_pendukung\[\d+\]/, `json_pengeluaran_material_pendukung[${mrIdx}]`);
                            name = name.replace(/materials\]\[\d+\]/, `materials][${matIdx}]`);
                            input.setAttribute('name', name);
                        });
                        // Toggle remove-material button visibility
                        const removeBtn = row.querySelector('.remove-material');
                        if (arr.length === 1) {
                            removeBtn.style.display = 'none';
                        } else {
                            removeBtn.style.display = '';
                        }
                    });
                });
                updateGrandTotal();
            }

            function fillMaterialRow(row, data) {
                if (!data) return;
                for (const key in data) {
                    const input = row.querySelector(`[data-material-field="${key}"]`);
                    if (input) input.value = data[key];
                }
            }
            function fillMrGroup(mrGroup, data) {
                if (!data) return;
                for (const key in data) {
                    if (key === 'materials') continue;
                    const input = mrGroup.querySelector(`[data-mr-field="${key}"]`);
                    if (input) input.value = data[key];
                }
            }

            function addMrGroup(data) {
                const mrIdx = mrList.querySelectorAll('.mr-group').length;
                const html = mrGroupTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const mrGroup = temp.firstElementChild;
                mrList.appendChild(mrGroup);
                fillMrGroup(mrGroup, data);
                if (data && Array.isArray(data.materials) && data.materials.length) {
                    data.materials.forEach((mat, i) => addMaterialRow(mrGroup, mat));
                } else {
                    addMaterialRow(mrGroup);
                }
                renderAllNames();
            }

            function addMaterialRow(mrGroup, data) {
                const mrIdx = Array.from(mrList.children).indexOf(mrGroup);
                const matList = mrGroup.querySelector('.material-list');
                const matIdx = matList.querySelectorAll('.material-row').length;
                const html = materialRowTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx).replace(/__MATIDX__/g, matIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const row = temp.firstElementChild;
                matList.appendChild(row);
                fillMaterialRow(row, data);
                renderAllNames();
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                mrList.querySelectorAll('.mr-group').forEach(mrGroup => {
                    let totalMr = 0;
                    mrGroup.querySelectorAll('.sub-total-input').forEach(input => {
                        const val = parseFloat(input.value);
                        if (!isNaN(val)) totalMr += val;
                    });
                    const totalMrEl = mrGroup.querySelector('.total-mr');
                    if (totalMrEl) totalMrEl.textContent = totalMr.toLocaleString('id-ID');
                    grandTotal += totalMr;
                });
                grandTotalEl.textContent = grandTotal.toLocaleString('id-ID');
            }

            function updateRowTotal(row) {
                const qty = parseFloat(row.querySelector('.qty-input')?.value || '0');
                const harga = parseFloat(row.querySelector('.harga-input')?.value || '0');
                const subTotal = qty * harga;
                const subTotalInput = row.querySelector('.sub-total-input');
                if (subTotalInput) subTotalInput.value = subTotal ? subTotal : '';
                updateGrandTotal();
            }

            // Inisialisasi dari old input jika ada
            if (window.oldMaterialPendukung && Array.isArray(window.oldMaterialPendukung) && window.oldMaterialPendukung.length) {
                window.oldMaterialPendukung.forEach(mr => addMrGroup(mr));
            } else if (mrList.querySelectorAll('.mr-group').length === 0) {
                addMrGroup();
            }

            addMrBtn.addEventListener('click', function () {
                addMrGroup();
            });

            mrList.addEventListener('click', function (e) {
                // Hapus MR group
                if (e.target.classList.contains('remove-mr')) {
                    const mrGroups = mrList.querySelectorAll('.mr-group');
                    if (mrGroups.length > 1) {
                        e.target.closest('.mr-group').remove();
                        renderAllNames();
                    }
                }
                // Tambah baris material
                if (e.target.classList.contains('add-material-row')) {
                    const mrGroup = e.target.closest('.mr-group');
                    addMaterialRow(mrGroup);
                }
                // Hapus baris material
                if (e.target.classList.contains('remove-material')) {
                    const mrGroup = e.target.closest('.mr-group');
                    const matList = mrGroup.querySelector('.material-list');
                    const rows = matList.querySelectorAll('.material-row');
                    if (rows.length > 1) {
                        e.target.closest('.material-row').remove();
                        renderAllNames();
                    }
                }
            });

            mrList.addEventListener('input', function (e) {
                if (e.target.classList.contains('qty-input') || e.target.classList.contains('harga-input')) {
                    const row = e.target.closest('.material-row');
                    if (row) updateRowTotal(row);
                }
            });
        })();
    </script>
</div> 