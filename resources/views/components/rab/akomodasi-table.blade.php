<div>
    <div id="akomodasi-mr-list" class="space-y-8">
        <!-- MR group akan di-generate oleh JS -->
    </div>
    <button type="button" class="dark:bg-yellow-900 bg-yellow-600 text-white w-full py-2 uppercase" id="add-akomodasi-mr-group">Tambah MR</button>
    <div class="flex justify-end bg-yellow-600/10 py-2 px-4">
        <div class="font-semibold mr-2">Grand Total:</div>
        <div class="font-bold text-yellow-700 dark:text-yellow-400" id="grand-total-akomodasi">0</div>
    </div>
    <template id="akomodasi-mr-group-template">
        <div class="w-full relative mr-group">
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">MR</label>
                    <input type="text" name="json_pengeluaran_akomodasi[__MRIDX__][mr]" placeholder="MR 001" class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="json_pengeluaran_akomodasi[__MRIDX__][tanggal]" class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
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
            <div class="space-y-0 akomodasi-material-list">
                <!-- Baris akomodasi akan di-generate oleh JS -->
            </div>
            <button type="button" class="dark:bg-yellow-900 bg-yellow-600 border border-yellow-600 text-yellow-100 hover:bg-yellow-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-akomodasi-material-row mt-6">Tambah Akomodasi</button>
            <div class="mt-4 flex justify-end border-t border-b border-yellow-600/30 bg-yellow-600/10 px-4 py-2">
                <div class="font-semibold mr-2">Total MR :</div>
                <div class="font-bold text-yellow-600 dark:text-yellow-400 total-mr">0</div>
            </div>
        </div>
    </template>
    <template id="akomodasi-material-row-template">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end p-6 rounded-xl bg-white dark:bg-zinc-700/30 relative akomodasi-material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" min="0" data-material-field="qty" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][qty]" placeholder="Qty" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white qty-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="text" data-material-field="harga_satuan" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="Harga Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-input" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Sub Total</label>
                <input type="text" data-material-field="sub_total" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input" readonly />
            </div>
            <button type="button" class="absolute top-6 right-6 text-red-600 font-bold remove-material">Hapus</button>
        </div>
    </template>
    <script>
        (function () {
            const mrList = document.getElementById('akomodasi-mr-list');
            const addMrBtn = document.getElementById('add-akomodasi-mr-group');
            const mrGroupTemplate = document.getElementById('akomodasi-mr-group-template');
            const materialRowTemplate = document.getElementById('akomodasi-material-row-template');
            const grandTotalEl = document.getElementById('grand-total-akomodasi');
            if (!mrList || !addMrBtn || !mrGroupTemplate || !materialRowTemplate || !grandTotalEl) return;

            // Fungsi format Rupiah
            function formatRupiah(angka) {
                if (!angka || angka === '') return '';
                const number = parseInt(angka.toString().replace(/\D/g, ''));
                if (isNaN(number)) return '';
                return number.toLocaleString('id-ID');
            }

            // Fungsi untuk mendapatkan nilai numerik dari input yang diformat
            function getNumericValue(input) {
                const value = input.value.replace(/\D/g, '');
                return value ? parseInt(value) : 0;
            }

            // Fungsi untuk setup format Rupiah pada input
            function setupRupiahFormat(input) {
                input.addEventListener('input', function(e) {
                    const cursorPosition = e.target.selectionStart;
                    const oldValue = e.target.value;
                    const numericValue = oldValue.replace(/\D/g, '');
                    const formattedValue = formatRupiah(numericValue);
                    
                    e.target.value = formattedValue;
                    
                    // Menyesuaikan posisi cursor
                    const newCursorPosition = cursorPosition + (formattedValue.length - oldValue.length);
                    e.target.setSelectionRange(newCursorPosition, newCursorPosition);
                });

                input.addEventListener('blur', function(e) {
                    const numericValue = getNumericValue(e.target);
                    if (numericValue > 0) {
                        e.target.value = formatRupiah(numericValue);
                    } else {
                        e.target.value = '';
                    }
                });
            }

            function renderAllNames() {
                mrList.querySelectorAll('.mr-group').forEach((mrGroup, mrIdx) => {
                    // Update MR & tanggal name
                    mrGroup.querySelectorAll('input[name^="json_pengeluaran_akomodasi["]').forEach(input => {
                        let name = input.getAttribute('name');
                        name = name.replace(/json_pengeluaran_akomodasi\[\d+\]/, `json_pengeluaran_akomodasi[${mrIdx}]`);
                        name = name.replace(/materials\]\[\d+\]/g, match => match.replace(/\d+/, '0'));
                        input.setAttribute('name', name);
                    });
                    // Update material row names
                    mrGroup.querySelectorAll('.akomodasi-material-row').forEach((row, matIdx, arr) => {
                        row.querySelectorAll('input').forEach(input => {
                            let name = input.getAttribute('name');
                            name = name.replace(/json_pengeluaran_akomodasi\[\d+\]/, `json_pengeluaran_akomodasi[${mrIdx}]`);
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
                    if (input) {
                        if (key === 'harga_satuan' || key === 'sub_total') {
                            // Format Rupiah untuk field harga
                            const numericValue = parseInt(data[key]) || 0;
                            input.value = numericValue > 0 ? formatRupiah(numericValue) : '';
                        } else {
                            input.value = data[key];
                        }
                    }
                }
            }
            
            function fillMrGroup(mrGroup, data) {
                if (!data) return;
                for (const key in data) {
                    if (key === 'materials') continue;
                    const input = mrGroup.querySelector(`[name^='json_pengeluaran_akomodasi'][data-mr-field='${key}']`);
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
                const matList = mrGroup.querySelector('.akomodasi-material-list');
                const matIdx = matList.querySelectorAll('.akomodasi-material-row').length;
                const html = materialRowTemplate.innerHTML.replace(/__MRIDX__/g, mrIdx).replace(/__MATIDX__/g, matIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const row = temp.firstElementChild;
                matList.appendChild(row);
                fillMaterialRow(row, data);
                
                // Setup format Rupiah untuk input baru
                const hargaInput = row.querySelector('.harga-input');
                if (hargaInput) {
                    setupRupiahFormat(hargaInput);
                }
                
                renderAllNames();
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                mrList.querySelectorAll('.mr-group').forEach(mrGroup => {
                    let totalMr = 0;
                    mrGroup.querySelectorAll('.sub-total-input').forEach(input => {
                        const val = getNumericValue(input);
                        if (!isNaN(val)) totalMr += val;
                    });
                    const totalMrEl = mrGroup.querySelector('.total-mr');
                    if (totalMrEl) totalMrEl.textContent = formatRupiah(totalMr);
                    grandTotal += totalMr;
                });
                grandTotalEl.textContent = formatRupiah(grandTotal);
                grandTotalEl.className = 'akomodasi-grand-total';
            }

            function updateRowTotal(row) {
                const qty = parseFloat(row.querySelector('.qty-input')?.value || '0');
                const harga = getNumericValue(row.querySelector('.harga-input'));
                const subTotal = qty * harga;
                const subTotalInput = row.querySelector('.sub-total-input');
                if (subTotalInput) {
                    subTotalInput.value = subTotal > 0 ? formatRupiah(subTotal) : '';
                }
                updateGrandTotal();
            }

            // Inisialisasi dari old input jika ada
            if (window.oldAkomodasi && Array.isArray(window.oldAkomodasi) && window.oldAkomodasi.length) {
                window.oldAkomodasi.forEach(mr => addMrGroup(mr));
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
                if (e.target.classList.contains('add-akomodasi-material-row')) {
                    const mrGroup = e.target.closest('.mr-group');
                    addMaterialRow(mrGroup);
                }
                // Hapus baris material
                if (e.target.classList.contains('remove-material')) {
                    const mrGroup = e.target.closest('.mr-group');
                    const matList = mrGroup.querySelector('.akomodasi-material-list');
                    const rows = matList.querySelectorAll('.akomodasi-material-row');
                    if (rows.length > 1) {
                        e.target.closest('.akomodasi-material-row').remove();
                        renderAllNames();
                    }
                }
            });

            mrList.addEventListener('input', function (e) {
                if (e.target.classList.contains('qty-input')) {
                    const row = e.target.closest('.akomodasi-material-row');
                    if (row) {
                        setTimeout(() => updateRowTotal(row), 100);
                    }
                }
                if (e.target.classList.contains('harga-input')) {
                    const row = e.target.closest('.akomodasi-material-row');
                    if (row) {
                        setTimeout(() => updateRowTotal(row), 100);
                    }
                }
            });

            // Setup format Rupiah untuk input yang sudah ada
            document.addEventListener('DOMContentLoaded', function() {
                mrList.querySelectorAll('.harga-input').forEach(input => {
                    setupRupiahFormat(input);
                });
            });
        })();
    </script>
</div> 