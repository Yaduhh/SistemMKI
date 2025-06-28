<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Buat Penawaran</h1>
            <x-button as="a" href="{{ route('admin.penawaran.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Kembali ke Daftar
            </x-button>
        </div>
    </x-slot>
    <div class="py-4 mx-auto w-full">
        <form action="{{ route('admin.penawaran.store') }}" method="POST" class="space-y-8" x-data="penawaranForm()">
            @csrf
            <!-- Sales -->
            <flux:select name="id_user" :label="__('Sales')" required @change="loadClients($event.target.value)">
                <option value="" disabled>{{ __('Pilih Pengguna') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </flux:select>
            
            <!-- Section Data Penawaran -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Penawaran</h2>
                <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        <x-icon name="info" class="w-4 h-4 inline mr-1" />
                        Nomor penawaran akan dibuat otomatis dengan format: <strong>A/MKI/MM/YY</strong>
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Client -->
                    <flux:select name="id_client" :label="__('Client')" required>
                        <option value="" disabled selected>{{ __('Pilih Client') }}</option>
                    </flux:select>
                        
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    <flux:input name="judul_penawaran" label="Judul Penawaran" placeholder="masukkan judul penawaran" type="text" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
            </div>

            <!-- Section Produk Multi-Section -->
            <template x-for="(section, sIdx) in sections" :key="section.kategori">
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6 mt-6" :class="{
                    'border-blue-400': section.kategori === 'flooring',
                    'border-green-400': section.kategori === 'facade',
                    'border-yellow-400': section.kategori === 'wallpanel',
                    'border-purple-400': section.kategori === 'ceiling',
                    'border-pink-400': section.kategori === 'decking',
                }">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="section.label"></h2>
                        <button type="button" @click="removeSection(sIdx)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none flex items-center gap-2" x-show="sections.length > 1">
                            <x-icon name="trash" class="w-5 h-5" /> Hapus Section
                        </button>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-zinc-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700 text-xs md:text-sm">
                            <thead class="bg-gray-50 dark:bg-zinc-800 sticky top-0 z-10">
                                <tr>
                                    <th class="px-2 py-2 font-bold">No</th>
                                    <th class="px-2 py-2 font-bold">Item</th>
                                    <th class="px-2 py-2 font-bold">Type</th>
                                    <th class="px-2 py-2 font-bold">Dimensi</th>
                                    <th class="px-2 py-2 font-bold">Panjang</th>
                                    <th class="px-2 py-2 font-bold">Warna</th>
                                    <th class="px-2 py-2 font-bold">VOL(m2)</th>
                                    <th class="px-2 py-2 font-bold">Qty</th>
                                    <th class="px-2 py-2 font-bold">Harga</th>
                                    <th class="px-2 py-2 font-bold">Total Harga</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(row, i) in section.produk" :key="i">
                                    <tr :class="i % 2 === 0 ? 'bg-gray-50 dark:bg-zinc-800' : 'bg-white dark:bg-zinc-900'" class="transition hover:bg-blue-50 dark:hover:bg-zinc-700">
                                        <td class="px-2 py-2 text-center" x-text="i+1"></td>
                                        <td class="px-2 py-2">
                                            <select :name="'json_produk['+section.kategori+']['+i+'][item]'" x-model="row.item" class="w-44 py-2 px-2 rounded-xl border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400" @change="autofillProduk(section, row)">
                                                <option value="">Pilih Produk</option>
                                                <template x-for="p in section.master">
                                                    <option :value="p.code" x-text="p.code + (p.lebar ? ' - ' + p.lebar + 'x' + (p.tebal ?? '') + 'x' + (p.panjang ?? '') : '') + (p.warna ? ' - ' + p.warna : '')"></option>
                                                </template>
                                            </select>
                                        </td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][type]'" x-model="row.type" class="w-24 rounded-xl py-2 px-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" readonly /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][dimensi]'" x-model="row.dimensi" class="w-24 rounded-xl py-2 px-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][tebal_panjang]'" x-model="row.tebal_panjang" class="w-16 px-2 py-2 rounded-xl border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][warna]'" x-model="row.warna" class="w-20 rounded-xl px-2 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][qty_area]'" x-model="row.qty_area" @input="calculateQty(section, row)" class="w-16 px-2 py-2 rounded-xl border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input x-model="row.qty" @input="calculateTotalHarga(row)" class="w-16 px-2 py-2 rounded-xl border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2">
                                            <input x-model="row.harga_display" @input="formatHargaInput(row)" type="text" class="w-24 rounded-xl py-2 px-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Rp 0" />
                                        </td>
                                        <td class="px-2 py-2">
                                            <input x-model="row.total_harga_display" @input="formatTotalHargaInput(row)" type="text" class="w-32 rounded-xl py-2 px-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Rp 0" readonly />
                                        </td>
                                        <!-- Hidden input untuk menyimpan data dalam format JSON -->
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][item]'" x-model="row.item" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][type]'" x-model="row.type" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][dimensi]'" x-model="row.dimensi" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][tebal_panjang]'" x-model="row.tebal_panjang" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][warna]'" x-model="row.warna" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][qty_area]'" x-model="row.qty_area" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][qty]'" x-model="row.qty" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][harga]'" x-model="row.harga" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][total_harga]'" x-model="row.total_harga" />
                                        <input type="hidden" :name="'json_produk['+section.kategori+']['+i+'][satuan]'" x-model="row.satuan" />
                                        <td class="px-2 py-2 text-center">
                                            <button type="button" @click="removeProduk(sIdx, i)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                                <x-icon name="trash" class="w-5 h-5" />
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button type="button" @click="addProduk(sIdx)" class="px-4 py-2 bg-blue-950 text-blue-400 rounded-2xl hover:bg-blue-950">
                            + Tambah Baris Produk
                        </button>
                    </div>
                </div>
            </template>
            <div class="mt-4">
                <template x-if="sectionOptions.filter(opt => !sections.map(s => s.kategori).includes(opt.kategori)).length > 0">
                    <div class="flex flex-col md:flex-row gap-2 items-start md:items-center">
                        <label class="font-semibold text-sm">Tambah Section Produk:</label>
                        <template x-for="opt in sectionOptions.filter(opt => !sections.map(s => s.kategori).includes(opt.kategori))" :key="opt.kategori">
                            <button type="button" @click="addSection(opt.kategori)" class="px-4 py-2 flex gap-4 items-center rounded-2xl border font-semibold transition bg-white dark:bg-zinc-900 border-gray-300 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-zinc-800 text-xs md:text-sm" :class="{
                                'border-blue-400 text-blue-700': opt.kategori === 'flooring',
                                'border-green-400 text-green-700': opt.kategori === 'facade',
                                'border-yellow-400 text-yellow-700': opt.kategori === 'wallpanel',
                                'border-purple-400 text-purple-700': opt.kategori === 'ceiling',
                                'border-pink-400 text-pink-700': opt.kategori === 'decking',
                            }">
                                <x-icon name="plus" class="w-4 h-4 mr-1" />
                                <span x-text="opt.label"></span>
                            </button>
                        </template>
                    </div>
                </template>
            </div>
            <!-- Input Total dan Diskon -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Total dan Diskon</h2>
                
                <!-- Hidden inputs untuk menyimpan nilai ke database -->
                <input type="hidden" name="total" x-model="subtotalValue">
                <input type="hidden" name="total_diskon" x-model="totalDiskonValue">
                <input type="hidden" name="total_diskon_1" x-model="totalDiskon1Value">
                <input type="hidden" name="total_diskon_2" x-model="totalDiskon2Value">
                <input type="hidden" name="grand_total" x-model="grandTotalValue">
                <input type="hidden" name="diskon" x-model="globalDiskon">
                <input type="hidden" name="diskon_satu" x-model="diskon_satu">
                <input type="hidden" name="diskon_dua" x-model="diskon_dua">
                <input type="hidden" name="ppn" x-model="globalPPN">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Subtotal</label>
                        <input type="text" x-model="subtotalDisplay" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Diskon (%)</label>
                        <input x-model="globalDiskon" type="number" min="0" max="100" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Diskon 1 (%)</label>
                        <input x-model="diskon_satu" type="number" min="0" max="100" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Diskon 2 (%)</label>
                        <input x-model="diskon_dua" type="number" min="0" max="100" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Total Diskon</label>
                        <input type="text" x-model="totalDiskonDisplay" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">PPN (%)</label>
                        <input x-model="globalPPN" type="number" min="0" max="100" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="11">
                    </div>
                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-medium mb-1">Grand Total</label>
                        <input type="text" x-model="grandTotalDisplay" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-bold text-lg" readonly>
                    </div>
                </div>
            </div>
            <!-- Section Syarat & Catatan -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tambahan</h2>
                <div class="space-y-6">
                    <!-- Syarat & Kondisi Checkbox -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Syarat & Kondisi</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 dark:border-zinc-700 rounded-lg p-4">
                            @if($syaratKetentuan->count() > 0)
                                @foreach($syaratKetentuan as $syarat)
                                    <div class="flex items-start">
                                        <input type="checkbox" 
                                               id="syarat_{{ $syarat->id }}" 
                                               name="syarat_kondisi[]" 
                                               value="{{ $syarat->syarat }}" 
                                               class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                               {{ in_array($syarat->syarat, old('syarat_kondisi', [])) ? 'checked' : '' }}>
                                        <label for="syarat_{{ $syarat->id }}" class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ $syarat->syarat }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada syarat & ketentuan yang tersedia</p>
                            @endif
                        </div>
                    </div>
                    <flux:input name="catatan" label="Catatan" type="textarea" rows="2" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <x-button as="a" href="{{ route('admin.penawaran.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                    <x-icon name="x" class="w-4 h-4 mr-2" />
                    Batal
                </x-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white">
                    <x-icon name="check" class="w-4 h-4 mr-2" />
                    Simpan Penawaran
                </x-button>
            </div>
        </form>
    </div>
</x-layouts.app>
<script>
function penawaranForm() {
    return {
        sections: [],
        sectionOptions: [
            { kategori: 'flooring', label: 'FLOORING', master: @json($floorings) },
            { kategori: 'facade', label: 'FACADE', master: @json($facades) },
            { kategori: 'wallpanel', label: 'WALLPANEL', master: @json($wallpanels) },
            { kategori: 'ceiling', label: 'CEILING', master: @json($ceilings) },
            { kategori: 'decking', label: 'DECKING', master: @json($deckings) },
        ],
        addSection(kategori) {
            let opt = this.sectionOptions.find(o => o.kategori === kategori);
            if (!opt) return;
            this.sections.push({
                kategori: opt.kategori,
                label: opt.label,
                master: opt.master,
                produk: [{item: '', type: '', dimensi: '', tebal_panjang: '', warna: '', qty_area: '', qty: '', satuan: '', harga: '', harga_display: '', total_harga: '', total_harga_display: ''}],
                diskon: 0,
                ppn: 11
            });
        },
        removeSection(idx) {
            this.sections.splice(idx, 1);
        },
        addProduk(sIdx) {
            this.sections[sIdx].produk.push({item: '', type: '', dimensi: '', tebal_panjang: '', warna: '', qty_area: '', qty: '', satuan: '', harga: '', harga_display: '', total_harga: '', total_harga_display: ''});
        },
        removeProduk(sIdx, i) {
            this.sections[sIdx].produk.splice(i, 1);
        },
        sectionSubtotal(section) {
            return section.produk.reduce((sum, p) => sum + (parseFloat(p.total_harga) || 0), 0);
        },
        sectionGrandTotal(section) {
            let subtotal = this.sectionSubtotal(section);
            let diskon = section.diskon ? subtotal * (section.diskon/100) : 0;
            let afterDiskon = subtotal - diskon;
            let ppn = section.ppn ? afterDiskon * (section.ppn/100) : 0;
            return Math.round(afterDiskon + ppn);
        },
        formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        },
        formatInputCurrency(value) {
            if (!value) return '';
            // Hapus semua karakter non-digit
            const numericValue = value.toString().replace(/[^\d]/g, '');
            if (!numericValue) return '';
            // Format sebagai rupiah
            return this.formatCurrency(parseInt(numericValue));
        },
        parseCurrency(value) {
            if (!value) return '';
            // Hapus semua karakter non-digit
            return value.toString().replace(/[^\d]/g, '');
        },
        autofillProduk(section, row) {
            if (!row.item) return;
            const produk = section.master.find(p => p.code === row.item);
            if (produk) {
                console.log('=== DEBUG AUTOFILL PRODUK ===');
                console.log('Produk dipilih:', produk.code);
                console.log('luas_btg produk:', produk.luas_btg);
                console.log('luas_m2 produk:', produk.luas_m2);
                console.log('VOL(m²) saat ini:', row.qty_area);
                
                row.type = produk.code ?? '';
                row.dimensi = (produk.lebar && produk.tebal && produk.panjang) ? produk.lebar + 'x' + produk.tebal : '';
                row.tebal_panjang = produk.tebal ?? produk.panjang ?? '';
                row.warna = produk.warna ?? '';
                row.harga = produk.harga;
                row.harga_display = this.formatCurrency(produk.harga);
                row.total_harga = produk.harga * row.qty;
                row.total_harga_display = this.formatCurrency(row.total_harga);
                // Gunakan luas_m2 dari database produk
                let luas_m2 = produk.luas_m2 || 1;
                // Jika vol (qty_area) sudah diisi, hitung qty
                if (row.qty_area && luas_m2 > 0) {
                    const qty = (parseFloat(row.qty_area) / luas_m2).toFixed(2);
                    row.qty = qty;
                    console.log('Perhitungan qty di autofill:', parseFloat(row.qty_area), '/', luas_m2, '=', qty);
                } else {
                    row.qty = '';
                    console.log('qty_area kosong atau luas_m2 tidak valid');
                }
                // Hitung total harga otomatis
                if (row.harga && row.qty) {
                    row.total_harga = (parseFloat(row.harga) * parseFloat(row.qty)).toFixed(2);
                }
                this.updateCalculations();
                console.log('================================');
            }
        },
        loadClients(userId) {
            if (!userId) {
                // Reset client dropdown jika tidak ada user yang dipilih
                const clientSelect = document.querySelector('select[name="id_client"]');
                clientSelect.innerHTML = '<option value="" disabled selected>{{ __("Pilih Client") }}</option>';
                return;
            }

            // Fetch clients berdasarkan sales yang dipilih
            fetch(`/admin/penawaran/clients/${userId}`)
                .then(response => response.json())
                .then(clients => {
                    const clientSelect = document.querySelector('select[name="id_client"]');
                    clientSelect.innerHTML = '<option value="" disabled selected>{{ __("Pilih Client") }}</option>';
                    
                    clients.forEach(client => {
                        const option = document.createElement('option');
                        option.value = client.id;
                        option.textContent = client.nama + (client.nama_perusahaan ? ` - ${client.nama_perusahaan}` : '');
                        clientSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading clients:', error);
                    const clientSelect = document.querySelector('select[name="id_client"]');
                    clientSelect.innerHTML = '<option value="" disabled selected>{{ __("Error loading clients") }}</option>';
                });
        },
        calculateTotalHarga(row) {
            if (!row.qty || !row.harga) return;
            row.total_harga = row.qty * row.harga;
            row.total_harga_display = this.formatCurrency(row.total_harga);
            this.updateCalculations();
            console.log('Calculate Total Harga:', {
                qty: row.qty,
                harga: row.harga,
                total_harga: row.total_harga,
                total_harga_display: row.total_harga_display
            });
        },
        calculateQty(section, row) {
            if (!row.item || !row.qty_area) return;
            
            const produk = section.master.find(p => p.code === row.item);
            if (!produk) return;
            
            // Debug: Log nilai-nilai yang digunakan
            console.log('=== DEBUG PERHITUNGAN QTY ===');
            console.log('Produk:', produk.code);
            console.log('VOL(m²) yang diinput:', row.qty_area);
            console.log('luas_btg produk:', produk.luas_btg);
            console.log('luas_m2 produk:', produk.luas_m2);
            console.log('lebar produk:', produk.lebar);
            console.log('panjang produk:', produk.panjang);
            
            // Gunakan luas_m2 dari database produk
            let luas_m2 = produk.luas_m2 || 1;
            
            // Hitung qty = vol ÷ luas_m2
            const vol = parseFloat(row.qty_area);
            if (!isNaN(vol) && luas_m2 > 0) {
                const qty = (vol / luas_m2).toFixed(2);
                row.qty = qty;
                
                // Debug: Log hasil perhitungan
                console.log('Perhitungan: qty =', vol, '÷', luas_m2, '=', qty);
                console.log('================================');
                
                // Hitung ulang total harga
                if (row.harga) {
                    row.total_harga = (parseFloat(row.harga) * parseFloat(row.qty)).toFixed(2);
                }
                this.updateCalculations();
            } else {
                console.log('Error: vol atau luas_m2 tidak valid');
                console.log('vol:', vol, 'luas_m2:', luas_m2);
                console.log('================================');
            }
        },
        formatHargaInput(row) {
            // Format input sebagai rupiah
            const numericValue = this.parseCurrency(row.harga_display);
            if (numericValue) {
                row.harga = numericValue;
                row.harga_display = this.formatInputCurrency(numericValue);
                this.calculateTotalHarga(row);
            }
        },
        formatTotalHargaInput(row) {
            // Format input total harga sebagai rupiah
            const numericValue = this.parseCurrency(row.total_harga_display);
            if (numericValue) {
                row.total_harga = numericValue;
                row.total_harga_display = this.formatInputCurrency(numericValue);
            }
        },
        globalDiskon: 0,
        globalPPN: 11,
        diskon_satu: 0,
        diskon_dua: 0,
        subtotalDisplay: 'Rp 0',
        totalDiskonDisplay: 'Rp 0',
        grandTotalDisplay: 'Rp 0',
        subtotalValue: 0,
        totalDiskonValue: 0,
        totalDiskon1Value: 0,
        totalDiskon2Value: 0,
        grandTotalValue: 0,
        init() {
            // Watch for changes in discount and PPN values
            this.$watch('globalDiskon', () => this.updateAllDisplays());
            this.$watch('diskon_satu', () => this.updateAllDisplays());
            this.$watch('diskon_dua', () => this.updateAllDisplays());
            this.$watch('globalPPN', () => this.updateAllDisplays());
            
            // Watch for changes in sections
            this.$watch('sections', () => {
                this.updateAllDisplays();
            }, { deep: true });
            
            // Initialize values
            this.$nextTick(() => {
                this.initializeValues();
            });
        },
        initializeValues() {
            // Force initial calculation
            this.updateAllDisplays();
        },
        updateCalculations() {
            // Update all displays
            this.updateAllDisplays();
        },
        updateAllDisplays() {
            // Calculate subtotal
            let subtotal = 0;
            this.sections.forEach((section) => {
                section.produk.forEach((row) => {
                    const totalHarga = parseFloat(row.total_harga) || 0;
                    subtotal += totalHarga;
                });
            });
            
            // Calculate total diskon
            let diskon1 = subtotal * (this.globalDiskon / 100);
            let diskon2 = (subtotal - diskon1) * (this.diskon_satu / 100);
            let diskon3 = (subtotal - diskon1 - diskon2) * (this.diskon_dua / 100);
            let totalDiskon = diskon1 + diskon2 + diskon3;
            
            // Calculate grand total
            let afterDiskon = subtotal - totalDiskon;
            let ppnNominal = afterDiskon * (this.globalPPN / 100);
            let grandTotal = Math.round(afterDiskon + ppnNominal);
            
            // Update displays
            this.subtotalDisplay = this.formatCurrency(subtotal);
            this.totalDiskonDisplay = this.formatCurrency(totalDiskon);
            this.grandTotalDisplay = this.formatCurrency(grandTotal);
            
            // Update hidden inputs untuk database
            this.subtotalValue = subtotal;
            this.totalDiskonValue = totalDiskon;
            this.totalDiskon1Value = diskon1;
            this.totalDiskon2Value = diskon2;
            this.grandTotalValue = grandTotal;
            
            console.log('updateAllDisplays called:', {
                subtotal: subtotal,
                subtotalDisplay: this.subtotalDisplay,
                totalDiskon: totalDiskon,
                totalDiskonDisplay: this.totalDiskonDisplay,
                grandTotal: grandTotal,
                grandTotalDisplay: this.grandTotalDisplay,
                // Nilai yang akan dikirim ke database
                subtotalValue: this.subtotalValue,
                totalDiskonValue: this.totalDiskonValue,
                totalDiskon1Value: this.totalDiskon1Value,
                totalDiskon2Value: this.totalDiskon2Value,
                grandTotalValue: this.grandTotalValue,
                globalDiskon: this.globalDiskon,
                diskon_satu: this.diskon_satu,
                diskon_dua: this.diskon_dua,
                globalPPN: this.globalPPN
            });
        }
    }
}
</script> 