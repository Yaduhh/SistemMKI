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
    <div class="py-4 max-w-7xl mx-auto">
        <form action="{{ route('admin.penawaran.store') }}" method="POST" class="space-y-8" x-data="penawaranForm()">
            @csrf
            <!-- Section Data Penawaran -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Penawaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:select name="id_client" label="Client" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <option value="">Pilih Client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nama }}</option>
                        @endforeach
                    </flux:select>
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    <flux:input name="judul_penawaran" label="Judul Penawaran" type="text" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
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
                        <button type="button" @click="removeSection(sIdx)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none" x-show="sections.length > 1">
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
                                    <th class="px-2 py-2 font-bold">Tebal/Panjang</th>
                                    <th class="px-2 py-2 font-bold">Warna</th>
                                    <th class="px-2 py-2 font-bold">Qty Area</th>
                                    <th class="px-2 py-2 font-bold">Satuan Area</th>
                                    <th class="px-2 py-2 font-bold">Qty</th>
                                    <th class="px-2 py-2 font-bold">Satuan</th>
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
                                            <select :name="'json_produk['+section.kategori+']['+i+'][item]'" x-model="row.item" class="w-44 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400" @change="autofillProduk(section, row)">
                                                <option value="">Pilih</option>
                                                <template x-for="p in section.master">
                                                    <option :value="p.code" x-text="p.code + (p.lebar ? ' - ' + p.lebar + 'x' + (p.tebal ?? '') + 'x' + (p.panjang ?? '') : '') + (p.warna ? ' - ' + p.warna : '')"></option>
                                                </template>
                                            </select>
                                        </td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][type]'" x-model="row.type" class="w-24 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" readonly /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][dimensi]'" x-model="row.dimensi" class="w-24 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][tebal_panjang]'" x-model="row.tebal_panjang" class="w-16 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][warna]'" x-model="row.warna" class="w-20 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][qty_area]'" x-model="row.qty_area" class="w-16 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2">
                                            <select :name="'json_produk['+section.kategori+']['+i+'][satuan_area]'" x-model="row.satuan_area" class="w-16 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                                <option value="m2">m2</option>
                                                <option value="m">m</option>
                                                <option value="kg">kg</option>
                                            </select>
                                        </td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][qty]'" x-model="row.qty" class="w-16 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][satuan]'" x-model="row.satuan" class="w-16 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][harga]'" x-model="row.harga" type="number" class="w-24 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
                                        <td class="px-2 py-2"><input :name="'json_produk['+section.kategori+']['+i+'][total_harga]'" x-model="row.total_harga" type="number" class="w-28 rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" /></td>
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
                    <div class="mt-2 flex gap-2">
                        <button type="button" @click="addProduk(sIdx)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                            + Tambah Baris Produk
                        </button>
                    </div>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold mb-1">Subtotal</label>
                            <input type="number" :value="sectionSubtotal(section)" class="w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Diskon (%)</label>
                            <input type="number" min="0" max="100" x-model="section.diskon" :name="'json_produk['+section.kategori+'][diskon]'" class="w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">PPN (%)</label>
                            <input type="number" min="0" max="100" x-model="section.ppn" :name="'json_produk['+section.kategori+'][ppn]'" class="w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Grand Total</label>
                            <input type="number" :value="sectionGrandTotal(section)" class="w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-bold" readonly>
                        </div>
                    </div>
                </div>
            </template>
            <div class="mt-4">
                <template x-if="sectionOptions.filter(opt => !sections.map(s => s.kategori).includes(opt.kategori)).length > 0">
                    <div class="flex flex-col md:flex-row gap-2 items-start md:items-center">
                        <label class="font-semibold text-sm">Tambah Section Produk:</label>
                        <template x-for="opt in sectionOptions.filter(opt => !sections.map(s => s.kategori).includes(opt.kategori))" :key="opt.kategori">
                            <button type="button" @click="addSection(opt.kategori)" class="px-4 py-2 rounded border font-semibold transition bg-white dark:bg-zinc-900 border-gray-300 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-zinc-800 text-xs md:text-sm" :class="{
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
            <!-- Section Syarat & Catatan -->
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tambahan</h2>
                <div class="space-y-6">
                    <flux:input name="syarat_kondisi" label="Syarat & Kondisi" type="textarea" rows="3" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
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
                produk: [{item: '', type: '', dimensi: '', tebal_panjang: '', warna: '', qty_area: '', satuan_area: 'm2', qty: '', satuan: '', harga: '', total_harga: ''}],
                diskon: 0,
                ppn: 11
            });
        },
        removeSection(idx) {
            this.sections.splice(idx, 1);
        },
        addProduk(sIdx) {
            this.sections[sIdx].produk.push({item: '', type: '', dimensi: '', tebal_panjang: '', warna: '', qty_area: '', satuan_area: 'm2', qty: '', satuan: '', harga: '', total_harga: ''});
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
        autofillProduk(section, row) {
            if (!row.item) return;
            const produk = section.master.find(p => p.code === row.item);
            if (produk) {
                row.type = produk.code ?? '';
                row.dimensi = (produk.lebar && produk.tebal && produk.panjang) ? produk.lebar + 'x' + produk.tebal + 'x' + produk.panjang : '';
                row.tebal_panjang = produk.tebal ?? produk.panjang ?? '';
                row.warna = produk.warna ?? '';
                row.satuan = produk.satuan ?? '';
                row.harga = produk.harga ?? '';
            }
        }
    }
}
</script> 