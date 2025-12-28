<x-layouts.app :title="__('Buat Revisi Pemasangan')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
                    <div class="mb-4 lg:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Buat Revisi Pemasangan</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Revisi untuk pemasangan <span class="font-semibold">{{ $pemasangan->nomor_pemasangan }}</span></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sales: <span class="font-semibold">{{ $sales->name }}</span></p>
                    </div>
                    <a href="{{ route('admin.pemasangan.show', $pemasangan->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Pemasangan
                    </a>
                </div>
            </div>
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />
            @if ($errors->any())
                <div class="mb-4">
                    <div class="text-red-600 dark:text-red-400 font-semibold">Terjadi kesalahan:</div>
                    <ul class="mt-2 text-sm text-red-500 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.pemasangan.store-revisi', $pemasangan->id) }}" method="POST" class="space-y-8" enctype="multipart/form-data" x-data="pemasanganForm()">
                @csrf
                <input type="hidden" name="id_penawaran" value="{{ $penawaran->id }}">
                <input type="hidden" name="id_client" value="{{ $client->id }}">
                <input type="hidden" name="id_sales" value="{{ $sales->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Pemasangan</label>
                        <input name="tanggal_pemasangan" type="date" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" value="{{ $pemasangan->tanggal_pemasangan ? $pemasangan->tanggal_pemasangan->format('Y-m-d') : date('Y-m-d') }}" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Pemasangan</label>
                        <input name="judul_pemasangan" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Judul pemasangan" value="{{ $pemasangan->judul_pemasangan }}" required>
                    </div>
                </div>

                <!-- Catatan Revisi -->
                <div class="w-full">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Revisi</label>
                    <textarea name="catatan_revisi" rows="3" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Alasan revisi pemasangan ini..."></textarea>
                </div>
                <div class="w-full">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Detail Pemasangan
                    </h2>
                    <template x-for="(section, sIdx) in sections" :key="sIdx">
                        <div class="mb-8 w-full">
                            <div class="flex justify-between items-center mb-4">
                                <div class="w-full">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sub Judul Section</label>
                                    <input :name="'json_pemasangan[' + sIdx + '][sub_judul]'" x-model="section.sub_judul" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Sub Judul Section">
                                </div>
                                <button type="button" @click="removeSection(sIdx)" class="ml-4 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none flex items-center gap-2" x-show="sections.length > 1">
                                    <x-icon name="trash" class="w-5 h-5" /> Hapus Section
                                </button>
                            </div>
                            <template x-for="(row, i) in section.items" :key="i">
                                <div class="border-2 border-gray-200 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800 mb-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Item #<span x-text="i+1"></span></h4>
                                        <button type="button" @click="removeItem(sIdx, i)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                            <x-icon name="trash" class="w-5 h-5" />
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Item</label>
                                            <input :name="'json_pemasangan[' + sIdx + '][items][' + i + '][item]'" x-model="row.item" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Item" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan</label>
                                            <input :name="'json_pemasangan[' + sIdx + '][items][' + i + '][satuan]'" x-model="row.satuan" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Satuan" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Qty</label>
                                            <input :name="'json_pemasangan[' + sIdx + '][items][' + i + '][qty]'" x-model="row.qty" type="number" min="0" step="any" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" placeholder="Qty" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga/Satuan</label>
                                            <input type="text"
                                                :value="formatRupiah(row.harga_satuan)"
                                                @input="e => { row.harga_satuan = parseRupiah(e.target.value); e.target.value = formatRupiah(row.harga_satuan); }"
                                                class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold"
                                                placeholder="Rp 0">
                                            <input type="hidden" :name="'json_pemasangan[' + sIdx + '][items][' + i + '][harga_satuan]'" :value="row.harga_satuan">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Harga</label>
                                            <input :name="'json_pemasangan[' + sIdx + '][items][' + i + '][total_harga]'"
                                                :value="formatRupiah(row.qty && row.harga_satuan ? row.qty * row.harga_satuan : 0)"
                                                readonly
                                                class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold"
                                                placeholder="Rp 0">
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="addItem(sIdx)" class="w-full hover:cursor-pointer py-2 px-4 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-950 text-blue-600 dark:text-blue-400 rounded-lg border-2 border-blue-600 hover:border-blue-700 transition-colors duration-200 flex items-center justify-center gap-2">
                                <x-icon name="plus" class="w-5 h-5" />
                                <span>Tambah Item</span>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addSection()" class="w-full hover:cursor-pointer py-2 px-4 bg-green-50 dark:bg-green-900/30 hover:bg-green-950 text-green-600 dark:text-green-400 rounded-lg border-2 border-green-600 hover:border-green-700 transition-colors duration-200 flex items-center justify-center gap-2 mb-8">
                        <x-icon name="plus" class="w-5 h-5" />
                        <span>Tambah Section</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total</label>
                        <input type="text" :value="formatRupiah(totalHarga())" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold">
                        <input type="hidden" name="total" :value="totalHarga()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon (%)</label>
                        <input name="diskon" type="number" min="0" max="100" step="any" :value="hitungDiskon()" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Grand Total (Setelah Diskon)</label>
                        <input type="text"
                            :value="formatRupiah(grandTotalManual)"
                            @input="e => { grandTotalManual = parseRupiah(e.target.value); e.target.value = formatRupiah(grandTotalManual); }"
                            class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-bold"
                            placeholder="Rp 0">
                        <input type="hidden" name="grand_total" :value="grandTotalFinal">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PPN (%)</label>
                        <input name="ppn" type="number" min="0" max="100" step="0.01" x-model="ppn" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" value="{{ $pemasangan->ppn ?? 11 }}">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nominal PPN</label>
                        <input type="text" :value="formatRupiah(ppnNominal())" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Final (Grand Total + PPN)</label>
                        <input type="text" :value="formatRupiah(grandTotalFinal)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-bold">
                    </div>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo</label>
                    <select name="logo" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        <option value="MEGA KOMPOSIT INDONESIA" {{ $pemasangan->logo == 'MEGA KOMPOSIT INDONESIA' ? 'selected' : '' }}>MEGA KOMPOSIT INDONESIA</option>
                        <option value="WPC MAKMUR ABADI" {{ $pemasangan->logo == 'WPC MAKMUR ABADI' ? 'selected' : '' }}>WPC MAKMUR ABADI</option>
                    </select>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Syarat & Kondisi Pemasangan 
                        @if($penawaran->penawaran_pintu)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 ml-2">
                                Pintu
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ml-2">
                                Biasa
                            </span>
                        @endif
                    </label>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        @if($penawaran->penawaran_pintu)
                            Menampilkan syarat pemasangan khusus untuk produk pintu
                        @else
                            Menampilkan syarat pemasangan untuk produk WPC
                        @endif
                    </p>
                    <div class="space-y-2">
                        @if($syaratPemasangan->count() > 0)
                            @foreach($syaratPemasangan as $syarat)
                                <div class="flex items-center">
                                    <input type="checkbox" name="json_syarat_kondisi[]" value="{{ $syarat->syarat }}" class="mr-2" 
                                        {{ is_array($pemasangan->json_syarat_kondisi) && in_array($syarat->syarat, $pemasangan->json_syarat_kondisi) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $syarat->syarat }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                <p class="text-sm">
                                    @if($penawaran->penawaran_pintu)
                                        Belum ada syarat pemasangan pintu yang tersedia
                                    @else
                                        Belum ada syarat pemasangan biasa yang tersedia
                                    @endif
                                </p>
                                <p class="text-xs mt-1">Silakan tambahkan syarat pemasangan di menu Admin > Syarat Pemasangan</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-emerald-600 dark:bg-emerald-600 border border-transparent rounded-lg font-semibold text-base text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Simpan Revisi Pemasangan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function pemasanganForm() {
            return {
                sections: {!! json_encode($pemasangan->json_pemasangan ?? [['sub_judul' => '', 'items' => [['item' => '', 'satuan' => '', 'qty' => 0, 'harga_satuan' => 0, 'total_harga' => 0]]]]) !!},
                grandTotalManual: {{ $pemasangan->grand_total ?? 0 }},
                ppn: {{ $pemasangan->ppn ?? 11 }},
                addSection() {
                    this.sections.push({ sub_judul: '', items: [ { item: '', satuan: '', qty: 0, harga_satuan: 0, total_harga: 0 } ] });
                },
                addItem(sIdx) {
                    this.sections[sIdx].items.push({ item: '', satuan: '', qty: 0, harga_satuan: 0, total_harga: 0 });
                },
                removeItem(sIdx, i) {
                    this.sections[sIdx].items.splice(i, 1);
                },
                removeSection(sIdx) {
                    this.sections.splice(sIdx, 1);
                },
                formatRupiah(val) {
                    val = Number(val) || 0;
                    return 'Rp ' + val.toLocaleString('id-ID');
                },
                parseRupiah(str) {
                    if (!str) return 0;
                    return Number(String(str).replace(/[^\d]/g, '')) || 0;
                },
                totalHarga() {
                    let total = 0;
                    this.sections.forEach(section => {
                        section.items.forEach(item => {
                            let subtotal = (Number(item.qty) || 0) * (Number(item.harga_satuan) || 0);
                            total += subtotal;
                        });
                    });
                    return total;
                },
                hitungDiskon() {
                    let total = this.totalHarga();
                    if (total === 0) return 0;
                    let selisih = total - this.grandTotalManual;
                    let diskonPersen = (selisih / total) * 100;
                    return diskonPersen > 0 ? Math.round(diskonPersen * 100) / 100 : 0;
                },
                ppnNominal() {
                    // PPN dihitung dari Grand Total (setelah diskon)
                    let grandTotal = this.grandTotalManual || 0;
                    let ppnValue = Number(this.ppn) || 0;
                    return grandTotal * (ppnValue / 100);
                },
                get grandTotalFinal() {
                    // Total Final = Grand Total (setelah diskon) + PPN
                    return this.grandTotalManual + this.ppnNominal();
                }
            }
        }
    </script>
</x-layouts.app> 