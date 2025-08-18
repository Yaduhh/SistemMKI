<x-layouts.app :title="__('Tambah Pengeluaran Akomodasi')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Tambah Pengeluaran Akomodasi</h1>
                    <p class="text-zinc-600 dark:text-zinc-400">RAB: {{ $rancanganAnggaranBiaya->proyek }} - {{ $rancanganAnggaranBiaya->pekerjaan }}</p>
                </div>
                <a href="{{ route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya) }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Kembali ke Detail RAB
                </a>
            </div>

            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="font-medium">Nomor Penawaran:</div>
                    <div class="font-medium">Nomor Pemasangan:</div>
                    <div class="font-medium">{{ $rancanganAnggaranBiaya->penawaran->nomor_penawaran ?? '-' }}</div>
                    <div class="font-medium">{{ $rancanganAnggaranBiaya->pemasangan->nomor_pemasangan ?? '-' }}</div>
                </div>
            </div>



            @php
                $validAkomodasiData = collect($rancanganAnggaranBiaya->json_pengeluaran_akomodasi ?? [])
                    ->filter(function($mr) {
                        return $mr['mr'] && $mr['tanggal'] && 
                               collect($mr['materials'])->some(function($material) {
                                   return $material['supplier'] && $material['item'] && 
                                          $material['qty'] && $material['satuan'] && 
                                          $material['harga_satuan'] && $material['sub_total'] &&
                                          $material['status'] === 'Disetujui';
                               });
                    })
                    ->map(function($mr) {
                        // Filter materials hanya yang status Disetujui
                        $mr['materials'] = collect($mr['materials'])
                            ->filter(function($material) {
                                return $material['status'] === 'Disetujui';
                            })
                            ->values()
                            ->toArray();
                        return $mr;
                    })
                    ->filter(function($mr) {
                        // Hanya tampilkan MR yang masih punya materials setelah difilter
                        return count($mr['materials']) > 0;
                    });
            @endphp
            
            @if($validAkomodasiData->count() > 0)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Data Akomodasi yang Sudah Ada</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg">
                        <thead class="bg-gray-50 dark:bg-zinc-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">MR</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">Supplier</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">Item</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">Qty</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">Satuan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">Harga Satuan</th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-zinc-600">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-600">
                            @foreach($validAkomodasiData as $mrIndex => $mr)
                                @foreach($mr['materials'] as $materialIndex => $material)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700/50">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600">
                                            @if($materialIndex === 0)
                                                <span class="font-medium">{{ $mr['mr'] }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600">
                                            @if($materialIndex === 0)
                                                {{ \Carbon\Carbon::parse($mr['tanggal'])->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600">{{ $material['supplier'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600">{{ $material['item'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600">{{ $material['qty'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600">{{ $material['satuan'] }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600">Rp {{ number_format((float)($material['harga_satuan'] ?? 0), 0, ',', '.') }}</td>

                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-zinc-600 font-medium">Rp {{ number_format((float)($material['sub_total'] ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.rancangan-anggaran-biaya.store-akomodasi', $rancanganAnggaranBiaya) }}" method="POST">
                @csrf
                <input type="hidden" name="rancangan_anggaran_biaya_id" value="{{ $rancanganAnggaranBiaya->id }}">

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                        </div>
                        <h2 class="text-lg font-semibold w-full text-center bg-yellow-600 dark:bg-yellow-600/30 py-2 uppercase text-white">
                            Pengeluaran Akomodasi</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                        </div>
                    </div>
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
                             <div class="w-full relative mr-group" data-mr-id="">
                                 <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                                     <div class="w-full">
                                         <label class="block text-sm font-medium mb-1">MR</label>
                                         <input type="text" data-mr-field="mr" name="json_pengeluaran_akomodasi[__MRIDX__][mr]" placeholder="MR 002" class="border w-full rounded-xl px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                                     </div>
                                     <div class="w-full">
                                         <label class="block text-sm font-medium mb-1">Tanggal</label>
                                         <input type="date" data-mr-field="tanggal" name="json_pengeluaran_akomodasi[__MRIDX__][tanggal]" class="border rounded-xl w-full px-4 py-2 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
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
                             <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end p-6 rounded-xl mt-4 bg-gray-100 dark:bg-zinc-700/30 relative akomodasi-material-row pt-12">
                                 <div>
                                     <label class="block text-xs font-medium mb-1">Supplier</label>
                                     <input type="text" data-material-field="supplier" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][supplier]" placeholder="Supplier" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                                 </div>
                                 <div>
                                     <label class="block text-xs font-medium mb-1">Item</label>
                                     <input type="text" data-material-field="item" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][item]" placeholder="Item" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                                 </div>
                                 <div>
                                     <label class="block text-xs font-medium mb-1">Qty</label>
                                     <input type="number" min="0" data-material-field="qty" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][qty]" placeholder="Qty" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white qty-input" required />
                                 </div>
                                 <div>
                                     <label class="block text-xs font-medium mb-1">Satuan</label>
                                     <input type="text" data-material-field="satuan" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][satuan]" placeholder="Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                                 </div>
                                 <div>
                                     <label class="block text-xs font-medium mb-1">Harga Satuan</label>
                                     <input type="text" data-material-field="harga_satuan" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][harga_satuan]" placeholder="Harga Satuan" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white harga-input" required />
                                 </div>
                                 <div>
                                     <label class="block text-xs font-medium mb-1">Sub Total</label>
                                     <input type="text" data-material-field="sub_total" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][sub_total]" placeholder="Sub Total" class="w-full border rounded-lg px-2 py-1 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white sub-total-input" readonly />
                                 </div>
                                 <!-- Hidden input untuk status dengan nilai default Disetujui -->
                                 <input type="hidden" name="json_pengeluaran_akomodasi[__MRIDX__][materials][__MATIDX__][status]" value="Disetujui" />
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
                                         const value = e.target.value;
                                         const numericValue = value.replace(/\D/g, '');
                                         const formattedValue = formatRupiah(numericValue);
                                         e.target.value = formattedValue;
                                         
                                         // Restore cursor position
                                         const newCursorPosition = cursorPosition + (formattedValue.length - value.length);
                                         e.target.setSelectionRange(newCursorPosition, newCursorPosition);
                                         
                                         // Trigger calculation after formatting
                                         const materialRow = e.target.closest('.akomodasi-material-row');
                                         if (materialRow) {
                                             calculateSubTotal(materialRow);
                                         }
                                         
                                         // Pastikan nilai yang disimpan adalah angka murni
                                         e.target.setAttribute('data-numeric-value', numericValue);
                                     });
                                     

                                 }

                                 // Fungsi untuk menghitung sub total
                                 function calculateSubTotal(materialRow) {
                                     const qtyInput = materialRow.querySelector('.qty-input');
                                     const hargaInput = materialRow.querySelector('.harga-input');
                                     const subTotalInput = materialRow.querySelector('.sub-total-input');
                                     
                                     if (qtyInput && hargaInput && subTotalInput) {
                                         const qty = parseInt(qtyInput.value) || 0;
                                         // Gunakan nilai murni dari data attribute jika ada, fallback ke getNumericValue
                                         const harga = parseInt(hargaInput.getAttribute('data-numeric-value')) || getNumericValue(hargaInput);
                                         const subTotal = qty * harga;
                                         // Sub total disimpan sebagai angka murni, bukan format Rupiah
                                         subTotalInput.value = subTotal;
                                         // Update totals
                                         updateTotalMR(materialRow.closest('.mr-group'));
                                         updateGrandTotal();
                                     }
                                 }

                                 // Fungsi untuk update total MR
                                 function updateTotalMR(mrGroup) {
                                     const totalEl = mrGroup.querySelector('.total-mr');
                                     const materialRows = mrGroup.querySelectorAll('.akomodasi-material-row');
                                     let total = 0;
                                     
                                     materialRows.forEach(row => {
                                         const subTotalInput = row.querySelector('.sub-total-input');
                                         if (subTotalInput) {
                                             total += parseInt(subTotalInput.value) || 0;
                                         }
                                     });
                                     
                                     if (totalEl) {
                                         totalEl.textContent = formatRupiah(total);
                                     }
                                 }

                                 // Fungsi untuk update grand total
                                 function updateGrandTotal() {
                                     const totalEls = document.querySelectorAll('.total-mr');
                                     let grandTotal = 0;
                                     
                                     totalEls.forEach(el => {
                                         const value = el.textContent.replace(/\D/g, '');
                                         grandTotal += parseInt(value) || 0;
                                     });
                                     
                                     grandTotalEl.textContent = formatRupiah(grandTotal);
                                 }

                                 // Fungsi untuk mendapatkan nomor MR berikutnya berdasarkan data existing
                                 function getNextMrNumber() {
                                     const existingMrNumbers = [];
                                     
                                     // Ambil semua nomor MR yang sudah ada dari data existing (termasuk yang ditolak)
                                     const allAkomodasiData = @json($rancanganAnggaranBiaya->json_pengeluaran_akomodasi ?? []);
                                     if (allAkomodasiData && Array.isArray(allAkomodasiData)) {
                                         allAkomodasiData.forEach(mr => {
                                             if (mr.mr && mr.mr.match(/MR\s*(\d+)/i)) {
                                                 const match = mr.mr.match(/MR\s*(\d+)/i);
                                                 if (match) {
                                                     existingMrNumbers.push(parseInt(match[1]));
                                                 }
                                             }
                                         });
                                     }
                                     
                                     // Ambil semua nomor MR yang sudah ada di form
                                     const formMrGroups = mrList.querySelectorAll('.mr-group');
                                     formMrGroups.forEach(group => {
                                         const mrInput = group.querySelector('[data-mr-field="mr"]');
                                         if (mrInput && mrInput.value) {
                                             const match = mrInput.value.match(/MR\s*(\d+)/i);
                                             if (match) {
                                                 existingMrNumbers.push(parseInt(match[1]));
                                             }
                                         }
                                     });
                                     
                                     // Cari gap/nomor yang kosong terlebih dahulu
                                     if (existingMrNumbers.length > 0) {
                                         existingMrNumbers.sort((a, b) => a - b);
                                         
                                         // Cari gap pertama
                                         for (let i = 1; i <= Math.max(...existingMrNumbers); i++) {
                                             if (!existingMrNumbers.includes(i)) {
                                                 return i;
                                             }
                                         }
                                         
                                         // Jika tidak ada gap, return nomor berikutnya
                                         return Math.max(...existingMrNumbers) + 1;
                                     }
                                     
                                     // Jika tidak ada data existing, mulai dari 001
                                     return 1;
                                 }

                                 // Fungsi untuk menambah MR group
                                 function addMrGroup() {
                                     const mrCount = mrList.querySelectorAll('.mr-group').length;
                                     const newMrGroup = mrGroupTemplate.content.cloneNode(true);
                                     const mrInput = newMrGroup.querySelector('[data-mr-field="mr"]');
                                     
                                     // Set MR number otomatis
                                     const nextMrNumber = getNextMrNumber();
                                     mrInput.value = `MR ${String(nextMrNumber).padStart(3, '0')}`;
                                     
                                     // Replace template placeholders dengan index numerik
                                     const mrId = mrCount;
                                     newMrGroup.querySelectorAll('[name*="__MRIDX__"]').forEach(input => {
                                         input.name = input.name.replace('__MRIDX__', mrId);
                                     });
                                     
                                     // Set data-mr-id attribute
                                     const mrGroupDiv = newMrGroup.querySelector('.mr-group');
                                     if (mrGroupDiv) {
                                         mrGroupDiv.setAttribute('data-mr-id', mrId);
                                     }
                                     
                                     mrList.appendChild(newMrGroup);
                                     
                                     // Add initial material row
                                     addMaterialRow(newMrGroup.querySelector('.akomodasi-material-list'), mrId);
                                     
                                     // Setup event listeners for new MR group
                                     setupMrGroupEventListeners(newMrGroup, mrId);
                                 }

                                 // Fungsi untuk menambah material row
                                 function addMaterialRow(materialList, mrId) {
                                     const materialCount = materialList.querySelectorAll('.akomodasi-material-row').length;
                                     const newMaterialRow = materialRowTemplate.content.cloneNode(true);
                                     
                                     // Replace template placeholders dengan index numerik
                                     newMaterialRow.querySelectorAll('[name*="__MATIDX__"]').forEach(input => {
                                         input.name = input.name.replace('__MATIDX__', materialCount);
                                     });
                                     
                                     newMaterialRow.querySelectorAll('[name*="__MRIDX__"]').forEach(input => {
                                         input.name = input.name.replace('__MRIDX__', mrId);
                                     });
                                     
                                     materialList.appendChild(newMaterialRow);
                                     
                                     // Setup event listeners for new material row
                                     setupMaterialRowEventListeners(newMaterialRow);
                                     
                                     // Update totals after adding new row
                                     updateTotalMR(materialList.closest('.mr-group'));
                                     updateGrandTotal();
                                 }

                                 // Fungsi untuk setup event listeners MR group
                                 function setupMrGroupEventListeners(mrGroup, mrId) {
                                     // Event listeners sudah ditangani oleh event delegation
                                 }

                                 // Fungsi untuk setup event listeners material row
                                 function setupMaterialRowEventListeners(materialRow) {
                                     const hargaInput = materialRow.querySelector('.harga-input');
                                     const qtyInput = materialRow.querySelector('.qty-input');
                                     
                                     if (hargaInput) {
                                         setupRupiahFormat(hargaInput);
                                         
                                         // Pastikan nilai awal kosong
                                         hargaInput.value = '';
                                         

                                     }
                                     
                                     if (qtyInput) {
                                         // Pastikan qty selalu berupa angka
                                         qtyInput.addEventListener('input', function() {
                                             this.value = this.value.replace(/\D/g, '');
                                         });
                                         
                                         // Pastikan nilai awal kosong
                                         qtyInput.value = '';
                                     }
                                 }

                                 // Setup event listeners
                                 addMrBtn.addEventListener('click', addMrGroup);
                                 
                                 // Event delegation untuk button tambah material dan hapus material
                                 mrList.addEventListener('click', function(e) {
                                     // Hapus MR group
                                     if (e.target.classList.contains('remove-mr')) {
                                         const mrGroups = mrList.querySelectorAll('.mr-group');
                                         if (mrGroups.length > 1) {
                                             e.target.closest('.mr-group').remove();
                                             updateGrandTotal();
                                         }
                                     }
                                     
                                     // Tambah baris material
                                     if (e.target.classList.contains('add-akomodasi-material-row')) {
                                         const mrGroup = e.target.closest('.mr-group');
                                         const materialList = mrGroup.querySelector('.akomodasi-material-list');
                                         const mrId = mrGroup.getAttribute('data-mr-id');
                                         addMaterialRow(materialList, mrId);
                                     }
                                     
                                     // Hapus baris material
                                     if (e.target.classList.contains('remove-material')) {
                                         const materialRow = e.target.closest('.akomodasi-material-row');
                                         const mrGroup = materialRow.closest('.mr-group');
                                         materialRow.remove();
                                         updateTotalMR(mrGroup);
                                         updateGrandTotal();
                                     }
                                 });
                                 
                                                                   // Event delegation untuk input events
                                  mrList.addEventListener('input', function(e) {
                                      if (e.target.classList.contains('qty-input') || e.target.classList.contains('harga-input')) {
                                          const materialRow = e.target.closest('.akomodasi-material-row');
                                          if (materialRow) {
                                              calculateSubTotal(materialRow);
                                          }
                                      }
                                      
                                      // Pastikan format Rupiah konsisten untuk harga input
                                      if (e.target.classList.contains('harga-input')) {
                                          const value = e.target.value;
                                          if (value && !value.includes(',') && !isNaN(value)) {
                                              // Jika input angka murni, format ke Rupiah
                                              e.target.value = formatRupiah(value);
                                          }
                                      }
                                  });
                                  
                                  
                                 
                                 // Add initial MR group on page load
                                 addMrGroup();
                                 
                                 // Setup form submission to convert formatted values to numbers
                                 document.addEventListener('submit', function(e) {
                                     // Validasi semua field yang wajib diisi
                                     const requiredInputs = document.querySelectorAll('input[required]');
                                     let isValid = true;
                                     
                                     requiredInputs.forEach(input => {
                                         if (!input.value.trim()) {
                                             input.style.borderColor = 'red';
                                             isValid = false;
                                         } else {
                                             input.style.borderColor = '';
                                         }
                                     });
                                     
                                     if (!isValid) {
                                         e.preventDefault();
                                         alert('Mohon lengkapi semua field yang wajib diisi!');
                                         return;
                                     }
                                     
                                     // Convert semua input harga ke format angka murni
                                     const hargaInputs = document.querySelectorAll('.harga-input');
                                     
                                     hargaInputs.forEach(input => {
                                         // Gunakan nilai murni dari data attribute jika ada
                                         const numericValue = input.getAttribute('data-numeric-value');
                                         if (numericValue) {
                                             input.value = numericValue;
                                         } else {
                                             // Fallback ke getNumericValue
                                             input.value = getNumericValue(input);
                                         }
                                     });
                                     
                                     // Sub total sudah dalam format angka murni, tidak perlu dikonversi
                                 });
                             })();
                         </script>
                     </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Simpan Akomodasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
