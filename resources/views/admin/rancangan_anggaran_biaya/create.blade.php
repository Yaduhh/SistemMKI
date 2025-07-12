<x-layouts.app :title="__('Buat Rancangan Anggaran Biaya (RAB)')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <h1 class="text-2xl font-bold mb-4">RAB {{ $penawaran->nomor_penawaran ?? '-' }}</h1>
            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                <div>
                    <span class="font-medium">Nomor Penawaran:</span> {{ $penawaran->nomor_penawaran ?? '-' }}<br>
                    <span class="font-medium">Nomor Pemasangan:</span> {{ $pemasangan->nomor_pemasangan ?? '-' }}
                </div>
            </div>
            <script>
                window.oldMaterialPendukung = @json(old('json_pengeluaran_material_pendukung'));
                window.oldEntertaiment = @json(old('json_pengeluaran_entertaiment'));
                window.oldAkomodasi = @json(old('json_pengeluaran_akomodasi'));
                window.oldLainnya = @json(old('json_pengeluaran_lainnya'));
                window.oldTukang = @json(old('json_pengeluaran_tukang'));
                window.oldKerjaTambah = @json(old('json_kerja_tambah'));
            </script>
            <form action="{{ route('admin.rancangan-anggaran-biaya.store') }}" method="POST">
                @csrf
                <!-- Hidden inputs untuk penawaran_id dan pemasangan_id -->
                <input type="hidden" name="penawaran_id" value="{{ $penawaran->id ?? '' }}">
                <input type="hidden" name="pemasangan_id" value="{{ $pemasangan->id ?? '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:input name="proyek" label="Proyek" placeholder="Nama Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                    <div>
                        <flux:input name="pekerjaan" label="Pekerjaan" placeholder="Nama Pekerjaan" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                    <div>
                        <flux:input name="kontraktor" label="Kontraktor" placeholder="Nama Kontraktor" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                    <div>
                        <flux:input name="lokasi" label="Lokasi" placeholder="Lokasi Proyek" type="text"
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required />
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-2">Pengeluaran Material Utama</h2>
                    <x-rab.material-utama-table :produk="$produkPenawaran" />
                    <!-- Hidden input untuk menyimpan data material utama -->
                    <input type="hidden" name="json_pengeluaran_material_utama" id="json_pengeluaran_material_utama" value="">
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30"></div>
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30 mt-2"></div>
                        </div>
                        <h2 class="text-lg font-semibold w-full text-center bg-sky-600 dark:bg-sky-600/30 py-2 uppercase">Pengeluaran Material Pendukung</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30"></div>
                            <div class="w-full h-[0.5px] bg-sky-600 dark:bg-sky-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.material-pendukung-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30"></div>
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30 mt-2"></div>
                        </div>
                        <h2 class="text-lg font-semibold w-full text-center bg-teal-600 dark:bg-teal-600/30 py-2 uppercase">Pengeluaran Entertaiment</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30"></div>
                            <div class="w-full h-[0.5px] bg-teal-600 dark:bg-teal-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.entertaiment-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-yellow-600 dark:bg-yellow-600/30 py-2 uppercase">
                            Pengeluaran Akomodasi</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30"></div>
                            <div class="w-full h-[0.5px] bg-yellow-600 dark:bg-yellow-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.akomodasi-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30"></div>
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-pink-600 dark:bg-pink-600/30 py-2 uppercase">
                            Pengeluaran Lainnya</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30"></div>
                            <div class="w-full h-[0.5px] bg-pink-600 dark:bg-pink-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.lainnya-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600/30 py-2 uppercase">
                            Pengeluaran Tukang</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.tukang-table />
                </div>
                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30"></div>
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30 mt-2"></div>
                        </div>
                        <h2
                            class="text-lg font-semibold w-full text-center bg-orange-600 dark:bg-orange-600/30 py-2 uppercase">
                            Kerja Tambah</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30"></div>
                            <div class="w-full h-[0.5px] bg-orange-600 dark:bg-orange-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.kerja-tambah-table />
                </div>
                <div class="mt-8 flex justify-end">
                    <button type="submit" onclick="prepareFormData()"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function prepareFormData() {
            // Collect material utama data from the form inputs
            const materialUtamaInputs = document.querySelectorAll('input[name^="material_utama"]');
            const materialUtamaData = [];
            const processedItems = new Set();
            
            materialUtamaInputs.forEach(input => {
                const name = input.name;
                const match = name.match(/material_utama\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const index = match[1];
                    const field = match[2];
                    
                    if (!processedItems.has(index)) {
                        const itemInput = document.querySelector(`input[name="material_utama[${index}][item]"]`);
                        const qtyInput = document.querySelector(`input[name="material_utama[${index}][qty]"]`);
                        const satuanInput = document.querySelector(`input[name="material_utama[${index}][satuan]"]`);
                        const hargaInput = document.querySelector(`input[name="material_utama[${index}][harga_satuan]"]`);
                        const totalInput = document.querySelector(`input[name="material_utama[${index}][total]"]`);
                        
                        if (itemInput && satuanInput) {
                            const typeInput = document.querySelector(`input[name="material_utama[${index}][type]"]`);
                            const dimensiInput = document.querySelector(`input[name="material_utama[${index}][dimensi]"]`);
                            const panjangInput = document.querySelector(`input[name="material_utama[${index}][panjang]"]`);
                            const warnaInput = document.querySelector(`input[name="material_utama[${index}][warna]"]`);
                            
                            materialUtamaData.push({
                                item: itemInput.value,
                                type: typeInput ? typeInput.value : '',
                                dimensi: dimensiInput ? dimensiInput.value : '',
                                panjang: panjangInput ? panjangInput.value : '',
                                qty: parseFloat(qtyInput.value) || 0,
                                satuan: satuanInput.value,
                                warna: warnaInput ? warnaInput.value : '',
                                harga_satuan: parseFloat(hargaInput.value) || 0,
                                total: parseFloat(totalInput.value) || 0
                            });
                            processedItems.add(index);
                        }
                    }
                }
            });
            
            // Set the hidden input value
            document.getElementById('json_pengeluaran_material_utama').value = JSON.stringify(materialUtamaData);
        }

        function updateTotal(index) {
            const qtyInput = document.querySelector(`input[name="material_utama[${index}][qty]"]`);
            const hargaInput = document.querySelector(`input[name="material_utama[${index}][harga_satuan]"]`);
            const totalInput = document.querySelector(`input[name="material_utama[${index}][total]"]`);
            
            if (qtyInput && hargaInput && totalInput) {
                const qty = parseFloat(qtyInput.value) || 0;
                const harga = parseFloat(hargaInput.value) || 0;
                const total = qty * harga;
                totalInput.value = total;
            }
        }
    </script>
</x-layouts.app>
