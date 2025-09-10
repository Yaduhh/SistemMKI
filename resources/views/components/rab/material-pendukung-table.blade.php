<div class="mt-4">
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
            <div class="flex gap-2 mt-4">
                <button type="button" class="dark:bg-sky-900 bg-sky-600 border border-sky-600 text-sky-100 hover:bg-sky-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-material-row">Tambah Material Pendukung</button>
                <button type="button" class="dark:bg-green-900 bg-green-600 border border-green-600 text-green-100 hover:bg-green-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-ppn-row">Tambah PPN</button>
                <button type="button" class="dark:bg-yellow-900 bg-yellow-600 border border-yellow-600 text-yellow-100 hover:bg-yellow-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-diskon-row">Tambah Diskon</button>
                <button type="button" class="dark:bg-purple-900 bg-purple-600 border border-purple-600 text-purple-100 hover:bg-purple-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-ongkir-row">Tambah Ongkir</button>
            </div>
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
                <input type="text" data-material-field="harga_satuan" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="Harga Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-satuan-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="text" data-material-field="sub_total" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input" readonly />
            </div>
            <button type="button" class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
        </div>
    </template>
    <template id="ppn-row-template">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end p-6 bg-green-50 dark:bg-green-900/20 relative material-row pt-12 border border-green-200 dark:border-green-800">
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="PPN" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Persentase (%)</label>
                <input type="text" data-material-field="harga_satuan" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="11.5" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white ppn-persen-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="text" data-material-field="sub_total" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input" readonly />
            </div>
            <button type="button" class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
        </div>
    </template>
    <template id="diskon-row-template">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end p-6 bg-yellow-50 dark:bg-yellow-900/20 relative material-row pt-12 border border-yellow-200 dark:border-yellow-800">
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="Diskon" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Persentase (%)</label>
                <input type="text" data-material-field="harga_satuan" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="5.5" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white diskon-persen-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="text" data-material-field="sub_total" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input" readonly />
            </div>
            <button type="button" class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
        </div>
    </template>
    <template id="ongkir-row-template">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end p-6 bg-purple-50 dark:bg-purple-900/20 relative material-row pt-12 border border-purple-200 dark:border-purple-800">
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="Ongkir" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="text" data-material-field="sub_total" name="json_pengeluaran_material_pendukung[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input ongkir-subtotal-input" />
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
            const ppnRowTemplate = document.getElementById('ppn-row-template');
            const diskonRowTemplate = document.getElementById('diskon-row-template');
            const ongkirRowTemplate = document.getElementById('ongkir-row-template');
            const grandTotalEl = document.getElementById('grand-total-pendukung');
            if (!mrList || !addMrBtn || !mrGroupTemplate || !materialRowTemplate || !ppnRowTemplate || !diskonRowTemplate || !ongkirRowTemplate || !grandTotalEl) return;

            // Fungsi format rupiah
            function formatRupiahInput(el) {
                let value = el.value.replace(/[^\d]/g, '');
                if (!value) {
                    el.value = '';
                    return;
                }
                let number = parseInt(value);
                if (isNaN(number)) {
                    el.value = '';
                    return;
                }
                el.value = 'Rp ' + number.toLocaleString('id-ID');
            }
            
            function getAngkaFromRupiah(str) {
                return str.replace(/[^\d]/g, '');
            }

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
                
                // Renumber MR secara otomatis
                renumberMR();
                updateGrandTotal();
            }
            
            function renumberMR() {
                mrList.querySelectorAll('.mr-group').forEach((mrGroup, mrIdx) => {
                    const mrInput = mrGroup.querySelector('[data-mr-field="mr"]');
                    if (mrInput) {
                        const mrNumber = mrIdx + 1;
                        const mrValue = 'MR ' + String(mrNumber).padStart(3, '0');
                        
                        // Selalu set ke format sederhana MR 001, MR 002, dst
                        mrInput.value = mrValue;
                    }
                });
            }

            function fillMaterialRow(row, data) {
                if (!data) return;
                
                // Check if this is a special row (PPN, Diskon, Ongkir)
                const item = data.item || '';
                let isSpecialRow = false;
                let specialType = '';
                
                if (item === 'PPN') {
                    isSpecialRow = true;
                    specialType = 'ppn';
                } else if (item === 'Diskon') {
                    isSpecialRow = true;
                    specialType = 'diskon';
                } else if (item === 'Ongkir') {
                    isSpecialRow = true;
                    specialType = 'ongkir';
                }
                
                // If it's a special row, we need to replace the row with the correct template
                if (isSpecialRow) {
                    const mrGroup = row.closest('.mr-group');
                    const matList = mrGroup.querySelector('.material-list');
                    const matIdx = Array.from(matList.children).indexOf(row);
                    const mrIdx = Array.from(mrList.children).indexOf(mrGroup);
                    
                    // Remove the current row
                    row.remove();
                    
                    // Add the correct special row
                    if (specialType === 'ppn') {
                        addPpnRow(mrGroup, data);
                    } else if (specialType === 'diskon') {
                        addDiskonRow(mrGroup, data);
                    } else if (specialType === 'ongkir') {
                        addOngkirRow(mrGroup, data);
                    }
                    
                    return;
                }
                
                // For regular material rows, fill normally
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
                
                // Fill data first if available
                fillMrGroup(mrGroup, data);
                
                // Auto-fill MR number jika tidak ada data atau data.mr kosong
                const mrInput = mrGroup.querySelector('[data-mr-field="mr"]');
                if (mrInput && (!data || !data.mr || data.mr.trim() === '')) {
                    // Jangan set MR number di sini, biarkan renumberMR() yang handle
                    // Ini akan dipanggil di renderAllNames()
                }
                
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
                
                // Setup format rupiah untuk row baru
                setupRupiahFormatting();
            }

            function addPpnRow(mrGroup, data) {
                const mrIdx = Array.from(mrList.children).indexOf(mrGroup);
                const matList = mrGroup.querySelector('.material-list');
                const matIdx = matList.querySelectorAll('.material-row').length;
                const html = ppnRowTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx).replace(/__MATIDX__/g, matIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const row = temp.firstElementChild;
                matList.appendChild(row);
                
                // Set default values untuk field yang tidak ditampilkan
                setHiddenFieldValues(row, 'ppn');
                
                // Fill data if provided
                if (data) {
                    for (const key in data) {
                        const input = row.querySelector(`[data-material-field="${key}"]`);
                        if (input) input.value = data[key];
                    }
                }
                
                renderAllNames();
                
                // Setup event listener untuk persentase PPN
                setupPpnCalculation(mrGroup);
            }

            function addDiskonRow(mrGroup, data) {
                const mrIdx = Array.from(mrList.children).indexOf(mrGroup);
                const matList = mrGroup.querySelector('.material-list');
                const matIdx = matList.querySelectorAll('.material-row').length;
                const html = diskonRowTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx).replace(/__MATIDX__/g, matIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const row = temp.firstElementChild;
                matList.appendChild(row);
                
                // Set default values untuk field yang tidak ditampilkan
                setHiddenFieldValues(row, 'diskon');
                
                // Fill data if provided
                if (data) {
                    for (const key in data) {
                        const input = row.querySelector(`[data-material-field="${key}"]`);
                        if (input) input.value = data[key];
                    }
                }
                
                renderAllNames();
                
                // Setup event listener untuk persentase Diskon
                setupDiskonCalculation(mrGroup);
            }

            function addOngkirRow(mrGroup, data) {
                const mrIdx = Array.from(mrList.children).indexOf(mrGroup);
                const matList = mrGroup.querySelector('.material-list');
                const matIdx = matList.querySelectorAll('.material-row').length;
                const html = ongkirRowTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx).replace(/__MATIDX__/g, matIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const row = temp.firstElementChild;
                matList.appendChild(row);
                
                // Set default values untuk field yang tidak ditampilkan
                setHiddenFieldValues(row, 'ongkir');
                
                // Fill data if provided
                if (data) {
                    for (const key in data) {
                        const input = row.querySelector(`[data-material-field="${key}"]`);
                        if (input) input.value = data[key];
                    }
                }
                
                renderAllNames();
                
                // Setup format rupiah untuk ongkir
                setupOngkirFormatting();
            }

            function setHiddenFieldValues(row, type) {
                // Tambahkan hidden inputs untuk field yang tidak ditampilkan
                const mrIdx = Array.from(mrList.children).indexOf(row.closest('.mr-group'));
                const matIdx = row.closest('.material-list').querySelectorAll('.material-row').length - 1;
                
                const hiddenFields = [
                    { name: 'supplier', value: '' },
                    { name: 'ukuran', value: '' },
                    { name: 'panjang', value: '' },
                    { name: 'qty', value: '' },
                    { name: 'satuan', value: '' }
                ];
                
                // Untuk ongkir, tambahkan hidden input harga_satuan
                if (type === 'ongkir') {
                    hiddenFields.push({ name: 'harga_satuan', value: '' });
                }
                
                hiddenFields.forEach(field => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `json_pengeluaran_material_pendukung[${mrIdx}][materials][${matIdx}][${field.name}]`;
                    hiddenInput.value = field.value;
                    row.appendChild(hiddenInput);
                });
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                mrList.querySelectorAll('.mr-group').forEach(mrGroup => {
                    let totalMr = 0;
                    mrGroup.querySelectorAll('.material-row').forEach(materialRow => {
                        const itemInput = materialRow.querySelector('[data-material-field="item"]');
                        const subTotalInput = materialRow.querySelector('.sub-total-input');
                        
                        if (itemInput && subTotalInput) {
                            const itemValue = itemInput.value.trim();
                            const val = parseFloat(getAngkaFromRupiah(subTotalInput.value || '0'));
                            
                            if (!isNaN(val)) {
                                // Jika item adalah Diskon, kurangkan dari total
                                if (itemValue === 'Diskon') {
                                    totalMr -= val;
                                } else {
                                    // Untuk item lain (termasuk PPN dan Ongkir), tambahkan ke total
                                    totalMr += val;
                                }
                            }
                        }
                    });
                    
                    const totalMrEl = mrGroup.querySelector('.total-mr');
                    if (totalMrEl) totalMrEl.textContent = totalMr.toLocaleString('id-ID');
                    grandTotal += totalMr;
                });
                grandTotalEl.textContent = grandTotal.toLocaleString('id-ID');
                grandTotalEl.className = 'material-pendukung-grand-total';
            }

            function updateRowTotal(row) {
                const qty = parseFloat(row.querySelector('.qty-input')?.value || '0');
                const hargaInput = row.querySelector('.harga-satuan-input');
                // Ambil angka murni dari input harga (hilangkan Rp dan titik)
                const harga = parseFloat(getAngkaFromRupiah(hargaInput?.value || '0'));
                const subTotal = qty * harga;
                const subTotalInput = row.querySelector('.sub-total-input');
                
                console.log('Qty:', qty, 'Harga:', harga, 'SubTotal:', subTotal); // Debug
                
                if (subTotalInput) {
                    if (subTotal > 0) {
                        subTotalInput.value = 'Rp ' + subTotal.toLocaleString('id-ID');
                    } else {
                        subTotalInput.value = '';
                    }
                }
                updateGrandTotal();
            }

            function setupPpnCalculation(mrGroup) {
                const ppnInputs = mrGroup.querySelectorAll('.ppn-persen-input');
                ppnInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        // Allow only numbers, comma, and dot
                        let value = this.value.replace(/[^\d,.]/g, '');
                        
                        // Ensure only one decimal separator
                        const commaCount = (value.match(/,/g) || []).length;
                        const dotCount = (value.match(/\./g) || []).length;
                        
                        if (commaCount > 1 || dotCount > 1) {
                            // Keep only the first decimal separator
                            const firstComma = value.indexOf(',');
                            const firstDot = value.indexOf('.');
                            
                            if (firstComma !== -1 && firstDot !== -1) {
                                // Both comma and dot exist, keep the first one
                                if (firstComma < firstDot) {
                                    value = value.replace(/\./g, '');
                                } else {
                                    value = value.replace(/,/g, '');
                                }
                            } else if (commaCount > 1) {
                                // Multiple commas, keep only first
                                const parts = value.split(',');
                                value = parts[0] + ',' + parts.slice(1).join('');
                            } else if (dotCount > 1) {
                                // Multiple dots, keep only first
                                const parts = value.split('.');
                                value = parts[0] + '.' + parts.slice(1).join('');
                            }
                        }
                        
                        this.value = value;
                        
                        // Convert to number for calculation
                        const numericValue = parseFloat(value.replace(',', '.')) || 0;
                        
                        // Validate range (0-100)
                        if (numericValue > 100) {
                            this.value = '100';
                        }
                        
                        const persen = parseFloat(this.value.replace(',', '.')) || 0;
                        const row = this.closest('.material-row');
                        const subTotalInput = row.querySelector('.sub-total-input');
                        
                        // Hitung total sub total dari item material pendukung yang ada di atas PPN
                        let totalSubTotal = 0;
                        const currentRow = this.closest('.material-row');
                        const allRows = Array.from(mrGroup.querySelectorAll('.material-row'));
                        const currentIndex = allRows.indexOf(currentRow);
                        
                        // Ambil semua row yang ada di atas row PPN saat ini
                        for (let i = 0; i < currentIndex; i++) {
                            const materialRow = allRows[i];
                            const itemInput = materialRow.querySelector('[data-material-field="item"]');
                            const subTotal = materialRow.querySelector('.sub-total-input');
                            
                            // Hanya hitung jika bukan PPN, Diskon, atau Ongkir
                            if (itemInput && subTotal) {
                                const itemValue = itemInput.value.trim();
                                if (itemValue !== 'PPN' && itemValue !== 'Diskon' && itemValue !== 'Ongkir') {
                                    const val = parseFloat(getAngkaFromRupiah(subTotal.value || '0'));
                                    if (!isNaN(val)) totalSubTotal += val;
                                }
                            }
                        }
                        
                        const ppnAmount = (totalSubTotal * persen) / 100;
                        
                        if (subTotalInput) {
                            if (ppnAmount > 0) {
                                subTotalInput.value = 'Rp ' + ppnAmount.toLocaleString('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            } else {
                                subTotalInput.value = '';
                            }
                        }
                        updateGrandTotal();
                    });
                });
            }

            function setupDiskonCalculation(mrGroup) {
                const diskonInputs = mrGroup.querySelectorAll('.diskon-persen-input');
                diskonInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        // Allow only numbers, comma, and dot
                        let value = this.value.replace(/[^\d,.]/g, '');
                        
                        // Ensure only one decimal separator
                        const commaCount = (value.match(/,/g) || []).length;
                        const dotCount = (value.match(/\./g) || []).length;
                        
                        if (commaCount > 1 || dotCount > 1) {
                            // Keep only the first decimal separator
                            const firstComma = value.indexOf(',');
                            const firstDot = value.indexOf('.');
                            
                            if (firstComma !== -1 && firstDot !== -1) {
                                // Both comma and dot exist, keep the first one
                                if (firstComma < firstDot) {
                                    value = value.replace(/\./g, '');
                                } else {
                                    value = value.replace(/,/g, '');
                                }
                            } else if (commaCount > 1) {
                                // Multiple commas, keep only first
                                const parts = value.split(',');
                                value = parts[0] + ',' + parts.slice(1).join('');
                            } else if (dotCount > 1) {
                                // Multiple dots, keep only first
                                const parts = value.split('.');
                                value = parts[0] + '.' + parts.slice(1).join('');
                            }
                        }
                        
                        this.value = value;
                        
                        // Convert to number for calculation
                        const numericValue = parseFloat(value.replace(',', '.')) || 0;
                        
                        // Validate range (0-100)
                        if (numericValue > 100) {
                            this.value = '100';
                        }
                        
                        const persen = parseFloat(this.value.replace(',', '.')) || 0;
                        const row = this.closest('.material-row');
                        const subTotalInput = row.querySelector('.sub-total-input');
                        
                        // Hitung total sub total dari item material pendukung yang ada di atas Diskon
                        let totalSubTotal = 0;
                        const currentRow = this.closest('.material-row');
                        const allRows = Array.from(mrGroup.querySelectorAll('.material-row'));
                        const currentIndex = allRows.indexOf(currentRow);
                        
                        // Ambil semua row yang ada di atas row Diskon saat ini
                        for (let i = 0; i < currentIndex; i++) {
                            const materialRow = allRows[i];
                            const itemInput = materialRow.querySelector('[data-material-field="item"]');
                            const subTotal = materialRow.querySelector('.sub-total-input');
                            
                            // Hanya hitung jika bukan PPN, Diskon, atau Ongkir
                            if (itemInput && subTotal) {
                                const itemValue = itemInput.value.trim();
                                if (itemValue !== 'PPN' && itemValue !== 'Diskon' && itemValue !== 'Ongkir') {
                                    const val = parseFloat(getAngkaFromRupiah(subTotal.value || '0'));
                                    if (!isNaN(val)) totalSubTotal += val;
                                }
                            }
                        }
                        
                        const diskonAmount = (totalSubTotal * persen) / 100;
                        
                        if (subTotalInput) {
                            if (diskonAmount > 0) {
                                subTotalInput.value = 'Rp ' + diskonAmount.toLocaleString('id-ID', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            } else {
                                subTotalInput.value = '';
                            }
                        }
                        updateGrandTotal();
                    });
                });
            }

            function setupOngkirFormatting() {
                document.querySelectorAll('.ongkir-subtotal-input').forEach(function(input) {
                    input.addEventListener('input', function(e) {
                        setTimeout(() => {
                            formatRupiahInput(input);
                            updateGrandTotal();
                        }, 100);
                    });
                    
                    // Jika sudah ada value, format saat load
                    if (input.value) {
                        formatRupiahInput(input);
                    }
                });
            }

            // Inisialisasi dari old input jika ada
            if (window.oldMaterialPendukung && Array.isArray(window.oldMaterialPendukung) && window.oldMaterialPendukung.length) {
                // Clear any existing MR groups first
                mrList.innerHTML = '';
                
                // Add each MR group from old data
                window.oldMaterialPendukung.forEach(mr => {
                    // Clear MR field dari data lama agar menggunakan penomoran baru
                    const mrData = { ...mr };
                    mrData.mr = ''; // Force renumbering
                    addMrGroup(mrData);
                });
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
                        renderAllNames(); // Ini akan memanggil renumberMR() otomatis
                    }
                }
                // Tambah baris material
                if (e.target.classList.contains('add-material-row')) {
                    const mrGroup = e.target.closest('.mr-group');
                    addMaterialRow(mrGroup);
                }
                // Tambah baris PPN
                if (e.target.classList.contains('add-ppn-row')) {
                    const mrGroup = e.target.closest('.mr-group');
                    addPpnRow(mrGroup);
                }
                // Tambah baris Diskon
                if (e.target.classList.contains('add-diskon-row')) {
                    const mrGroup = e.target.closest('.mr-group');
                    addDiskonRow(mrGroup);
                }
                // Tambah baris Ongkir
                if (e.target.classList.contains('add-ongkir-row')) {
                    const mrGroup = e.target.closest('.mr-group');
                    addOngkirRow(mrGroup);
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
                if (e.target.classList.contains('qty-input')) {
                    const row = e.target.closest('.material-row');
                    if (row) {
                        updateRowTotal(row);
                    }
                }
            });
            // Event listener untuk format rupiah dan hitung sub_total
            function setupRupiahFormatting() {
                document.querySelectorAll('.harga-satuan-input, .sub-total-input').forEach(function(input) {
                    input.addEventListener('input', function(e) {
                        if (input.classList.contains('harga-satuan-input')) {
                            // Format rupiah dulu
                            setTimeout(() => {
                                formatRupiahInput(input);
                                // Lalu hitung sub_total
                                const row = input.closest('.material-row');
                                if (row) {
                                    setTimeout(() => {
                                        updateRowTotal(row);
                                    }, 50);
                                }
                            }, 100);
                        }
                    });
                    
                    // Jika sudah ada value, format saat load
                    if (input.value) {
                        formatRupiahInput(input);
                    }
                });
            }
            
            // Function to load existing data for edit mode
            function loadExistingData(existingData) {
                if (!existingData || !Array.isArray(existingData) || existingData.length === 0) {
                    return;
                }
                
                // Clear any existing MR groups first
                mrList.innerHTML = '';
                
                // Add each MR group from existing data
                existingData.forEach(mr => {
                    addMrGroup(mr);
                });
            }

            // Expose functions globally for external access
            window.materialPendukungFunctions = {
                renderAllNames: renderAllNames,
                setupRupiahFormatting: setupRupiahFormatting,
                addMrGroup: addMrGroup,
                addMaterialRow: addMaterialRow,
                updateGrandTotal: updateGrandTotal,
                loadExistingData: loadExistingData
            };

            // Setup format rupiah saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                setupRupiahFormatting();
                setupOngkirFormatting();
                
                // Setup PPN dan Diskon calculation untuk MR yang sudah ada
                mrList.querySelectorAll('.mr-group').forEach(mrGroup => {
                    setupPpnCalculation(mrGroup);
                    setupDiskonCalculation(mrGroup);
                });
                
                // Format existing values
                setTimeout(() => {
                    document.querySelectorAll('.harga-satuan-input, .sub-total-input, .ongkir-subtotal-input').forEach(function(input) {
                        if (input.value && !input.value.includes('Rp ')) {
                            formatRupiahInput(input);
                        }
                    });
                }, 100);
                
                // Saat submit form, ubah ke angka murni
                let form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function() {
                        form.querySelectorAll('.harga-satuan-input, .sub-total-input, .ongkir-subtotal-input').forEach(function(input) {
                            input.value = getAngkaFromRupiah(input.value);
                        });
                        
                        // Handle persentase input (ensure decimal format)
                        form.querySelectorAll('.ppn-persen-input, .diskon-persen-input').forEach(function(input) {
                            if (input.value) {
                                // Replace comma with dot and ensure it's a valid number
                                let value = input.value.replace(',', '.');
                                let numValue = parseFloat(value);
                                if (!isNaN(numValue)) {
                                    // Ensure it's within valid range
                                    if (numValue > 100) numValue = 100;
                                    if (numValue < 0) numValue = 0;
                                    input.value = numValue.toString();
                                } else {
                                    input.value = '0';
                                }
                            }
                        });
                    });
                }
            });
        })();
    </script>
</div> 