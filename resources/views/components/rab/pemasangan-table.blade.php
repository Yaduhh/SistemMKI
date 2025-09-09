<div>
    <div id="mr-list-pemasangan" class="space-y-8">
        <!-- MR group akan di-generate oleh JS -->
    </div>
    <button type="button" class="dark:bg-amber-900 bg-amber-600 text-white py-2 uppercase w-full" id="add-mr-group-pemasangan">Tambah MR</button>
    <div class="flex justify-end bg-amber-600/10 py-2 px-4">
        <div class="font-semibold mr-2">Grand Total:</div>
        <div class="font-bold text-amber-700 dark:text-amber-400" id="grand-total-pemasangan">0</div>
    </div>
    <template id="mr-group-template-pemasangan">
        <div class="w-full relative mr-group">
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">MR</label>
                    <input type="text" data-mr-field="mr" name="json_pengeluaran_pemasangan[__MRIDX__][mr]" placeholder="MR 001" class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                </div>
                <div class="w-full">
                    <label class="block text-sm font-medium mb-1">Tanggal</label> 
                    <input type="date" data-mr-field="tanggal" name="json_pengeluaran_pemasangan[__MRIDX__][tanggal]" class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
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
                <button type="button" class="dark:bg-amber-900 bg-amber-600 border border-amber-600 text-amber-100 hover:bg-amber-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-material-row">Tambah Material Pemasangan</button>
                <button type="button" class="dark:bg-green-900 bg-green-600 border border-green-600 text-green-100 hover:bg-green-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-ppn-row">Tambah PPN</button>
                <button type="button" class="dark:bg-yellow-900 bg-yellow-600 border border-yellow-600 text-yellow-100 hover:bg-yellow-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-diskon-row">Tambah Diskon</button>
                <button type="button" class="dark:bg-purple-900 bg-purple-600 border border-purple-600 text-purple-100 hover:bg-purple-600 hover:text-white transition-all duration-300 rounded-xl px-4 py-2 add-ongkir-row">Tambah Ongkir</button>
            </div>
            <div class="mt-4 flex justify-end border-t border-b border-amber-600/30 bg-amber-600/10 px-4 py-2">
                <div class="font-semibold mr-2">Total MR :</div>
                <div class="font-bold text-amber-600 dark:text-amber-400 total-mr">0</div>
            </div>
        </div>
    </template>
    <template id="material-row-template-pemasangan">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end p-6  bg-white dark:bg-zinc-700/30 relative material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" data-material-field="qty" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][qty]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="number" data-material-field="harga_satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Total Harga</label>
                <input type="text" data-material-field="total_harga" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][total_harga]" placeholder="Rp 0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Action</label>
                <button type="button" class="text-red-600 font-bold remove-material flex items-center gap-2 bg-red-500/10 px-4 py-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    <p class="text-red-600 font-bold">Hapus</p>
                </button>
            </div>
        </div>
    </template>
    <template id="ppn-row-template-pemasangan">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end p-6 bg-white dark:bg-zinc-700/30 relative material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][item]" placeholder="PPN" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="%" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" data-material-field="qty" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][qty]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="number" data-material-field="harga_satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Total Harga</label>
                <input type="text" data-material-field="total_harga" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][total_harga]" placeholder="Rp 0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Action</label>
                <button type="button" class="text-red-600 font-bold remove-material flex items-center gap-2 bg-red-500/10 px-4 py-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    <p class="text-red-600 font-bold">Hapus</p>
                </button>
            </div>
        </div>
    </template>
    <template id="diskon-row-template-pemasangan">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end p-6 bg-white dark:bg-zinc-700/30 relative material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][item]" placeholder="Diskon" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="%" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" data-material-field="qty" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][qty]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="number" data-material-field="harga_satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Total Harga</label>
                <input type="text" data-material-field="total_harga" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][total_harga]" placeholder="Rp 0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Action</label>
                <button type="button" class="text-red-600 font-bold remove-material flex items-center gap-2 bg-red-500/10 px-4 py-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    <p class="text-red-600 font-bold">Hapus</p>
                </button>
            </div>
        </div>
    </template>
    <template id="ongkir-row-template-pemasangan">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end p-6 bg-white dark:bg-zinc-700/30 relative material-row pt-12">
            <div>
                <label class="block text-xs font-medium mb-1">Supplier</label>
                <input type="text" data-material-field="supplier" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Item</label>
                <input type="text" data-material-field="item" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][item]" placeholder="Ongkir" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Satuan</label>
                <input type="text" data-material-field="satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="kg" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Qty</label>
                <input type="number" data-material-field="qty" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][qty]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                <input type="number" data-material-field="harga_satuan" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" step="0.01" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Total Harga</label>
                <input type="text" data-material-field="total_harga" name="json_pengeluaran_pemasangan[__MRIDX__][materials][__MATIDX__][total_harga]" placeholder="Rp 0" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Action</label>
                <button type="button" class="text-red-600 font-bold remove-material flex items-center gap-2 bg-red-500/10 px-4 py-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    <p class="text-red-600 font-bold">Hapus</p>
                </button>
            </div>
        </div>
    </template>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let mrIndexPemasangan = 0;
    let materialIndexPemasangan = 0;
    const mrListPemasangan = document.getElementById('mr-list-pemasangan');
    const addMrGroupBtnPemasangan = document.getElementById('add-mr-group-pemasangan');
    const mrGroupTemplatePemasangan = document.getElementById('mr-group-template-pemasangan');
    const materialRowTemplatePemasangan = document.getElementById('material-row-template-pemasangan');
    const ppnRowTemplatePemasangan = document.getElementById('ppn-row-template-pemasangan');
    const diskonRowTemplatePemasangan = document.getElementById('diskon-row-template-pemasangan');
    const ongkirRowTemplatePemasangan = document.getElementById('ongkir-row-template-pemasangan');

    // Load existing data if available
    if (window.oldPemasangan && Array.isArray(window.oldPemasangan)) {
        window.oldPemasangan.forEach(mrGroup => {
            addMrGroupPemasangan(mrGroup);
        });
    }

    addMrGroupBtnPemasangan.addEventListener('click', function() {
        addMrGroupPemasangan();
    });

    function addMrGroupPemasangan(existingData = null) {
        const mrGroupElement = mrGroupTemplatePemasangan.content.cloneNode(true);
        const mrGroup = mrGroupElement.querySelector('.mr-group');
        
        // Update MR index
        mrGroup.innerHTML = mrGroup.innerHTML.replace(/__MRIDX__/g, mrIndexPemasangan);
        
        // Set existing data if provided
        if (existingData) {
            const mrInput = mrGroup.querySelector('input[data-mr-field="mr"]');
            const tanggalInput = mrGroup.querySelector('input[data-mr-field="tanggal"]');
            
            if (mrInput) mrInput.value = existingData.mr || '';
            if (tanggalInput) tanggalInput.value = existingData.tanggal || '';
            
            // Add existing materials
            if (existingData.materials && Array.isArray(existingData.materials)) {
                existingData.materials.forEach(material => {
                    addMaterialRowPemasangan(mrGroup, material);
                });
            }
        }
        
        mrListPemasangan.appendChild(mrGroupElement);
        
        // Add event listeners for this MR group
        setupMrGroupEventListenersPemasangan(mrGroup);
        
        mrIndexPemasangan++;
        updateGrandTotalPemasangan();
    }

    function setupMrGroupEventListenersPemasangan(mrGroup) {
        // Remove MR group
        const removeMrBtn = mrGroup.querySelector('.remove-mr');
        removeMrBtn.addEventListener('click', function() {
            mrGroup.remove();
            updateGrandTotalPemasangan();
        });

        // Add material row buttons
        const addMaterialBtn = mrGroup.querySelector('.add-material-row');
        const addPpnBtn = mrGroup.querySelector('.add-ppn-row');
        const addDiskonBtn = mrGroup.querySelector('.add-diskon-row');
        const addOngkirBtn = mrGroup.querySelector('.add-ongkir-row');

        addMaterialBtn.addEventListener('click', function() {
            addMaterialRowPemasangan(mrGroup);
        });

        addPpnBtn.addEventListener('click', function() {
            addPpnRowPemasangan(mrGroup);
        });

        addDiskonBtn.addEventListener('click', function() {
            addDiskonRowPemasangan(mrGroup);
        });

        addOngkirBtn.addEventListener('click', function() {
            addOngkirRowPemasangan(mrGroup);
        });
    }

    function addMaterialRowPemasangan(mrGroup, existingData = null) {
        const materialRowElement = materialRowTemplatePemasangan.content.cloneNode(true);
        const materialRow = materialRowElement.querySelector('.material-row');
        const materialList = mrGroup.querySelector('.material-list');
        
        // Update material index
        materialRow.innerHTML = materialRow.innerHTML.replace(/__MRIDX__/g, mrGroup.querySelector('input[data-mr-field="mr"]').name.match(/\[(\d+)\]/)[1]);
        materialRow.innerHTML = materialRow.innerHTML.replace(/__MATIDX__/g, materialIndexPemasangan);
        
        // Set existing data if provided
        if (existingData) {
            const supplierInput = materialRow.querySelector('input[data-material-field="supplier"]');
            const itemInput = materialRow.querySelector('input[data-material-field="item"]');
            const satuanInput = materialRow.querySelector('input[data-material-field="satuan"]');
            const qtyInput = materialRow.querySelector('input[data-material-field="qty"]');
            const hargaInput = materialRow.querySelector('input[data-material-field="harga_satuan"]');
            const totalInput = materialRow.querySelector('input[data-material-field="total_harga"]');
            
            if (supplierInput) supplierInput.value = existingData.supplier || '';
            if (itemInput) itemInput.value = existingData.item || '';
            if (satuanInput) satuanInput.value = existingData.satuan || '';
            if (qtyInput) qtyInput.value = existingData.qty || '';
            if (hargaInput) hargaInput.value = existingData.harga_satuan || '';
            if (totalInput) totalInput.value = existingData.total_harga || '';
        }
        
        materialList.appendChild(materialRowElement);
        
        // Add event listeners for this material row
        setupMaterialRowEventListenersPemasangan(materialRow);
        
        materialIndexPemasangan++;
        updateMrTotalPemasangan(mrGroup);
    }

    function addPpnRowPemasangan(mrGroup, existingData = null) {
        const ppnRowElement = ppnRowTemplatePemasangan.content.cloneNode(true);
        const ppnRow = ppnRowElement.querySelector('.material-row');
        const materialList = mrGroup.querySelector('.material-list');
        
        // Update material index
        ppnRow.innerHTML = ppnRow.innerHTML.replace(/__MRIDX__/g, mrGroup.querySelector('input[data-mr-field="mr"]').name.match(/\[(\d+)\]/)[1]);
        ppnRow.innerHTML = ppnRow.innerHTML.replace(/__MATIDX__/g, materialIndexPemasangan);
        
        // Set existing data if provided
        if (existingData) {
            const supplierInput = ppnRow.querySelector('input[data-material-field="supplier"]');
            const itemInput = ppnRow.querySelector('input[data-material-field="item"]');
            const satuanInput = ppnRow.querySelector('input[data-material-field="satuan"]');
            const qtyInput = ppnRow.querySelector('input[data-material-field="qty"]');
            const hargaInput = ppnRow.querySelector('input[data-material-field="harga_satuan"]');
            const totalInput = ppnRow.querySelector('input[data-material-field="total_harga"]');
            
            if (supplierInput) supplierInput.value = existingData.supplier || '';
            if (itemInput) itemInput.value = existingData.item || '';
            if (satuanInput) satuanInput.value = existingData.satuan || '';
            if (qtyInput) qtyInput.value = existingData.qty || '';
            if (hargaInput) hargaInput.value = existingData.harga_satuan || '';
            if (totalInput) totalInput.value = existingData.total_harga || '';
        }
        
        materialList.appendChild(ppnRowElement);
        
        // Add event listeners for this material row
        setupMaterialRowEventListenersPemasangan(ppnRow);
        
        materialIndexPemasangan++;
        updateMrTotalPemasangan(mrGroup);
    }

    function addDiskonRowPemasangan(mrGroup, existingData = null) {
        const diskonRowElement = diskonRowTemplatePemasangan.content.cloneNode(true);
        const diskonRow = diskonRowElement.querySelector('.material-row');
        const materialList = mrGroup.querySelector('.material-list');
        
        // Update material index
        diskonRow.innerHTML = diskonRow.innerHTML.replace(/__MRIDX__/g, mrGroup.querySelector('input[data-mr-field="mr"]').name.match(/\[(\d+)\]/)[1]);
        diskonRow.innerHTML = diskonRow.innerHTML.replace(/__MATIDX__/g, materialIndexPemasangan);
        
        // Set existing data if provided
        if (existingData) {
            const supplierInput = diskonRow.querySelector('input[data-material-field="supplier"]');
            const itemInput = diskonRow.querySelector('input[data-material-field="item"]');
            const satuanInput = diskonRow.querySelector('input[data-material-field="satuan"]');
            const qtyInput = diskonRow.querySelector('input[data-material-field="qty"]');
            const hargaInput = diskonRow.querySelector('input[data-material-field="harga_satuan"]');
            const totalInput = diskonRow.querySelector('input[data-material-field="total_harga"]');
            
            if (supplierInput) supplierInput.value = existingData.supplier || '';
            if (itemInput) itemInput.value = existingData.item || '';
            if (satuanInput) satuanInput.value = existingData.satuan || '';
            if (qtyInput) qtyInput.value = existingData.qty || '';
            if (hargaInput) hargaInput.value = existingData.harga_satuan || '';
            if (totalInput) totalInput.value = existingData.total_harga || '';
        }
        
        materialList.appendChild(diskonRowElement);
        
        // Add event listeners for this material row
        setupMaterialRowEventListenersPemasangan(diskonRow);
        
        materialIndexPemasangan++;
        updateMrTotalPemasangan(mrGroup);
    }

    function addOngkirRowPemasangan(mrGroup, existingData = null) {
        const ongkirRowElement = ongkirRowTemplatePemasangan.content.cloneNode(true);
        const ongkirRow = ongkirRowElement.querySelector('.material-row');
        const materialList = mrGroup.querySelector('.material-list');
        
        // Update material index
        ongkirRow.innerHTML = ongkirRow.innerHTML.replace(/__MRIDX__/g, mrGroup.querySelector('input[data-mr-field="mr"]').name.match(/\[(\d+)\]/)[1]);
        ongkirRow.innerHTML = ongkirRow.innerHTML.replace(/__MATIDX__/g, materialIndexPemasangan);
        
        // Set existing data if provided
        if (existingData) {
            const supplierInput = ongkirRow.querySelector('input[data-material-field="supplier"]');
            const itemInput = ongkirRow.querySelector('input[data-material-field="item"]');
            const satuanInput = ongkirRow.querySelector('input[data-material-field="satuan"]');
            const qtyInput = ongkirRow.querySelector('input[data-material-field="qty"]');
            const hargaInput = ongkirRow.querySelector('input[data-material-field="harga_satuan"]');
            const totalInput = ongkirRow.querySelector('input[data-material-field="total_harga"]');
            
            if (supplierInput) supplierInput.value = existingData.supplier || '';
            if (itemInput) itemInput.value = existingData.item || '';
            if (satuanInput) satuanInput.value = existingData.satuan || '';
            if (qtyInput) qtyInput.value = existingData.qty || '';
            if (hargaInput) hargaInput.value = existingData.harga_satuan || '';
            if (totalInput) totalInput.value = existingData.total_harga || '';
        }
        
        materialList.appendChild(ongkirRowElement);
        
        // Add event listeners for this material row
        setupMaterialRowEventListenersPemasangan(ongkirRow);
        
        materialIndexPemasangan++;
        updateMrTotalPemasangan(mrGroup);
    }

    function setupMaterialRowEventListenersPemasangan(materialRow) {
        // Remove material row
        const removeMaterialBtn = materialRow.querySelector('.remove-material');
        removeMaterialBtn.addEventListener('click', function() {
            materialRow.remove();
            const mrGroup = materialRow.closest('.mr-group');
            updateMrTotalPemasangan(mrGroup);
        });

        // Calculate total on input change
        const qtyInput = materialRow.querySelector('input[data-material-field="qty"]');
        const hargaInput = materialRow.querySelector('input[data-material-field="harga_satuan"]');
        const totalInput = materialRow.querySelector('input[data-material-field="total_harga"]');

        function calculateTotal() {
            const qty = parseFloat(qtyInput.value) || 0;
            const harga = parseFloat(hargaInput.value) || 0;
            const total = qty * harga;
            totalInput.value = formatRupiah(total);
            
            const mrGroup = materialRow.closest('.mr-group');
            updateMrTotalPemasangan(mrGroup);
        }

        qtyInput.addEventListener('input', calculateTotal);
        hargaInput.addEventListener('input', calculateTotal);
    }

    function updateMrTotalPemasangan(mrGroup) {
        const materialRows = mrGroup.querySelectorAll('.material-row');
        let total = 0;

        materialRows.forEach(row => {
            const totalInput = row.querySelector('input[data-material-field="total_harga"]');
            if (totalInput && totalInput.value) {
                const value = parseFloat(totalInput.value.replace(/[^\d]/g, '')) || 0;
                total += value;
            }
        });

        const totalMrElement = mrGroup.querySelector('.total-mr');
        if (totalMrElement) {
            totalMrElement.textContent = formatRupiah(total);
        }

        updateGrandTotalPemasangan();
    }

    function updateGrandTotalPemasangan() {
        const mrGroups = document.querySelectorAll('#mr-list-pemasangan .mr-group');
        let grandTotal = 0;

        mrGroups.forEach(mrGroup => {
            const totalMrElement = mrGroup.querySelector('.total-mr');
            if (totalMrElement && totalMrElement.textContent) {
                const value = parseFloat(totalMrElement.textContent.replace(/[^\d]/g, '')) || 0;
                grandTotal += value;
            }
        });

        const grandTotalElement = document.getElementById('grand-total-pemasangan');
        if (grandTotalElement) {
            grandTotalElement.textContent = formatRupiah(grandTotal);
        }
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }
});

</script>
