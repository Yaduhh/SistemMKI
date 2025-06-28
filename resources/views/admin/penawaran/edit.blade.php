<x-layouts.app>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Edit Penawaran</h1>
    </x-slot>
    <div class="py-4 max-w-7xl mx-auto">
        <form action="{{ route('admin.penawaran.update', $penawaran->id) }}" method="POST" class="space-y-8" x-data="penawaranForm()" x-init="init()">
            @csrf
            @method('PUT')
            <!-- Section Data Penawaran -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Penawaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:select name="id_user" label="Sales" required @change="loadClients($event.target.value)">
                        <option value="">Pilih Sales</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($penawaran->id_user == $user->id) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:select name="id_client" label="Client" required>
                        <option value="">Pilih Client</option>
                    </flux:select>
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" value="{{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('Y-m-d') : '' }}" required />
                    <flux:input name="judul_penawaran" label="Judul Penawaran" type="text" value="{{ $penawaran->judul_penawaran }}" required />
                </div>
            </div>

            <!-- Section Produk Dinamis -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Produk Penawaran</h2>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Tambah Section Produk</label>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="option in sectionOptions" :key="option.kategori">
                            <button type="button" @click="addSection(option.kategori)" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                <span x-text="option.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
                <template x-for="(section, sIdx) in sections" :key="sIdx">
                    <div class="mb-6 p-4 border border-gray-200 dark:border-zinc-700 rounded-lg" :class="{
                        'border-blue-200 bg-blue-50 dark:bg-blue-900/20': section.kategori === 'flooring',
                        'border-green-200 bg-green-50 dark:bg-green-900/20': section.kategori === 'facade',
                        'border-yellow-200 bg-yellow-50 dark:bg-yellow-900/20': section.kategori === 'wallpanel',
                        'border-purple-200 bg-purple-50 dark:bg-purple-900/20': section.kategori === 'ceiling',
                        'border-pink-200 bg-pink-50 dark:bg-pink-900/20': section.kategori === 'decking',
                    }">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg" x-text="section.label"></h3>
                            <button type="button" @click="removeSection(sIdx)" class="text-red-600 hover:text-red-800">
                                <x-icon name="trash-2" class="w-5 h-5" />
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                                <thead class="bg-gray-50 dark:bg-zinc-800">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Item</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Type</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Dimensi</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Tebal/Panjang</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Warna</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">VOL(m²)</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Qty</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Harga</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Total Harga</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                                    <template x-for="(row, i) in section.produk" :key="i">
                                        <tr>
                                            <td class="px-3 py-2">
                                                <select x-model="row.item" @change="autofillProduk(section, row)" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                                                    <option value="">Pilih Produk</option>
                                                    <template x-for="prod in section.master" :key="prod.id">
                                                        <option :value="prod.code" x-text="prod.code"></option>
                                                    </template>
                                                </select>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="row.type" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" readonly>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="row.dimensi" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" readonly>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="row.tebal_panjang" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" readonly>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="text" x-model="row.warna" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" readonly>
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" x-model="row.qty_area" @input="calculateQty(section, row)" step="0.01" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="number" x-model="row.qty" @input="calculateTotalHarga(row)" step="0.01" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" :placeholder="formatCurrency(0)">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input x-model="row.harga_display" @input="formatHargaInput(row)" type="text" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" placeholder="Rp 0">
                                            </td>
                                            <td class="px-3 py-2">
                                                <input x-model="row.total_harga_display" @input="formatTotalHargaInput(row)" type="text" class="w-full px-2 py-1 border border-gray-300 dark:border-zinc-600 rounded text-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white" placeholder="Rp 0" readonly>
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
                                            <td class="px-3 py-2">
                                                <button type="button" @click="removeProduk(sIdx, i)" class="text-red-600 hover:text-red-800">
                                                    <x-icon name="trash-2" class="w-4 h-4" />
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <button type="button" @click="addProduk(sIdx)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                + Tambah Produk
                            </button>
                            <div class="text-right">
                                <p class="text-sm text-gray-600 dark:text-zinc-400">Subtotal: <span x-text="formatCurrency(sectionSubtotal(section))"></span></p>
                                <p class="text-sm text-gray-600 dark:text-zinc-400">Grand Total: <span x-text="formatCurrency(sectionGrandTotal(section))"></span></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Subtotal</label>
                        <input type="text" :value="globalSubtotal" x-text="formatCurrency(globalSubtotal)" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" readonly>
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
                        <input type="text" :value="totalDiskon" x-text="formatCurrency(totalDiskon)" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">PPN (%)</label>
                        <input x-model="globalPPN" type="number" min="0" max="100" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="11">
                    </div>
                    <div class="md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-medium mb-1">Grand Total</label>
                        <input type="text" :value="globalGrandTotal" x-text="formatCurrency(globalGrandTotal)" class="w-full rounded-xl px-4 py-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-bold text-lg" readonly>
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
                                               {{ is_array($penawaran->syarat_kondisi) && in_array($syarat->syarat, $penawaran->syarat_kondisi) ? 'checked' : '' }}>
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
                    <flux:input name="catatan" label="Catatan" type="textarea" rows="2" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ $penawaran->catatan }}" />
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
                    Update Penawaran
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
        globalDiskon: 0,
        globalPPN: 11,
        diskon_satu: 0,
        diskon_dua: 0,
        init() {
            // Load clients saat halaman dimuat jika sudah ada sales yang dipilih
            const selectedUserId = document.querySelector('select[name="id_user"]').value;
            if (selectedUserId) {
                this.loadClients(selectedUserId);
            }
            
            // Load data produk yang sudah ada
            const existingProduk = @json($penawaran->json_produk ?? []);
            if (existingProduk && existingProduk.length > 0) {
                // Konversi data lama ke format baru
                this.sections = existingProduk.map(section => ({
                    kategori: section.kategori || 'flooring',
                    label: this.getSectionLabel(section.kategori || 'flooring'),
                    master: this.getMasterData(section.kategori || 'flooring'),
                    produk: section.produk || [],
                    diskon: section.diskon || 0,
                    ppn: section.ppn || 11
                }));
            }
        },
        getSectionLabel(kategori) {
            const option = this.sectionOptions.find(opt => opt.kategori === kategori);
            return option ? option.label : 'UNKNOWN';
        },
        getMasterData(kategori) {
            const option = this.sectionOptions.find(opt => opt.kategori === kategori);
            return option ? option.master : [];
        },
        addSection(kategori) {
            let opt = this.sectionOptions.find(o => o.kategori === kategori);
            if (!opt) return;
            this.sections.push({
                kategori: opt.kategori,
                label: opt.label,
                master: opt.master,
                produk: [{item: '', type: '', dimensi: '', tebal_panjang: '', warna: '', qty_area: '', qty: '', satuan: '', harga: '', total_harga: ''}],
                diskon: 0,
                ppn: 11
            });
        },
        removeSection(idx) {
            this.sections.splice(idx, 1);
        },
        addProduk(sIdx) {
            this.sections[sIdx].produk.push({item: '', type: '', dimensi: '', tebal_panjang: '', warna: '', qty_area: '', qty: '', satuan: '', harga: '', total_harga: ''});
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
                row.harga = produk.harga ?? '';
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
                console.log('================================');
            }
        },
        loadClients(userId) {
            if (!userId) {
                const clientSelect = document.querySelector('select[name="id_client"]');
                clientSelect.innerHTML = '<option value="">Pilih Client</option>';
                return;
            }

            fetch(`/admin/penawaran/clients/${userId}`)
                .then(response => response.json())
                .then(clients => {
                    const clientSelect = document.querySelector('select[name="id_client"]');
                    const currentClientId = '{{ $penawaran->id_client }}';
                    
                    clientSelect.innerHTML = '<option value="">Pilih Client</option>';
                    
                    clients.forEach(client => {
                        const option = document.createElement('option');
                        option.value = client.id;
                        option.textContent = client.nama + (client.nama_perusahaan ? ` - ${client.nama_perusahaan}` : '');
                        if (client.id == currentClientId) {
                            option.selected = true;
                        }
                        clientSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading clients:', error);
                    const clientSelect = document.querySelector('select[name="id_client"]');
                    clientSelect.innerHTML = '<option value="">Error loading clients</option>';
                });
        },
        calculateTotalHarga(row) {
            if (!row.qty || !row.harga) return;
            row.total_harga = row.qty * row.harga;
            row.total_harga_display = this.formatCurrency(row.total_harga);
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
        computed: {
            globalSubtotal() {
                let subtotal = 0;
                console.log('=== DEBUG GLOBAL SUBTOTAL ===');
                console.log('Jumlah sections:', this.sections.length);
                
                this.sections.forEach((section, sIdx) => {
                    console.log(`Section ${sIdx} (${section.kategori}):`, section.label);
                    console.log('Jumlah produk di section ini:', section.produk.length);
                    
                    section.produk.forEach((row, pIdx) => {
                        const totalHarga = parseInt(row.total_harga) || 0;
                        console.log(`  Produk ${pIdx + 1}: total_harga = ${row.total_harga} (parsed: ${totalHarga})`);
                        subtotal += totalHarga;
                    });
                });
                
                console.log('Total subtotal:', subtotal);
                console.log('================================');
                return subtotal;
            },
            globalDiskonNominal() {
                return this.globalSubtotal * (this.globalDiskon/100);
            },
            globalPPNNominal() {
                return (this.globalSubtotal - this.totalDiskon) * (this.globalPPN/100);
            },
            globalGrandTotal() {
                return Math.round(this.globalSubtotal - this.totalDiskon + this.globalPPNNominal);
            },
            totalDiskon() {
                let subtotal = this.globalSubtotal;
                let diskon1 = subtotal * (this.globalDiskon / 100);
                let diskon2 = (subtotal - diskon1) * (this.diskon_satu / 100);
                let diskon3 = (subtotal - diskon1 - diskon2) * (this.diskon_dua / 100);
                return diskon1 + diskon2 + diskon3;
            }
        }
    }
}
</script> 