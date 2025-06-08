<x-layouts.app>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Edit Penawaran</h1>
    </x-slot>
    <div class="py-4 max-w-5xl mx-auto">
        <form action="{{ route('admin.penawaran.update', $penawaran) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <!-- Section Data Penawaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:select name="id_client" label="Client" required>
                    <option value="">Pilih Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" @if($penawaran->id_client == $client->id) selected @endif>{{ $client->nama }}</option>
                    @endforeach
                </flux:select>
                <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" value="{{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('Y-m-d') : '' }}" required />
                <flux:input name="judul_penawaran" label="Judul Penawaran" type="text" value="{{ $penawaran->judul_penawaran }}" required />
                <flux:input name="diskon" label="Diskon (%)" type="number" min="0" max="100" value="{{ $penawaran->diskon }}" />
                <flux:input name="ppn" label="PPN (%)" type="number" min="0" max="100" value="{{ $penawaran->ppn }}" />
            </div>

            <!-- Section Produk Dinamis -->
            <div x-data='{
                produk: @json($penawaran->json_produk ?? [["item"=>"", "type"=>"", "dimensi"=>"", "tebal"=>"", "warna"=>"", "qty_area"=>"", "satuan_area"=>"m2", "qty"=>"", "satuan"=>"", "harga"=>"", "total_harga"=>""]]),
                addProduk() { this.produk.push({item: "", type: "", dimensi: "", tebal: "", warna: "", qty_area: "", satuan_area: "m2", qty: "", satuan: "", harga: "", total_harga: ""}) },
                removeProduk(i) { this.produk.splice(i, 1) }
            }'>
                <h2 class="font-semibold mb-2">Produk Penawaran</h2>
                <div class="overflow-x-auto rounded-lg border">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-2 text-xs font-bold">Item</th>
                                <th class="px-2 py-2 text-xs font-bold">Type</th>
                                <th class="px-2 py-2 text-xs font-bold">Dimensi</th>
                                <th class="px-2 py-2 text-xs font-bold">Tebal</th>
                                <th class="px-2 py-2 text-xs font-bold">Warna</th>
                                <th class="px-2 py-2 text-xs font-bold">Qty Area</th>
                                <th class="px-2 py-2 text-xs font-bold">Satuan Area</th>
                                <th class="px-2 py-2 text-xs font-bold">Qty</th>
                                <th class="px-2 py-2 text-xs font-bold">Satuan</th>
                                <th class="px-2 py-2 text-xs font-bold">Harga</th>
                                <th class="px-2 py-2 text-xs font-bold">Total Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, i) in produk" :key="i">
                                <tr>
                                    <td><input x-model="row.item" name="produk_data[][item]" class="form-input w-24" required></td>
                                    <td><input x-model="row.type" name="produk_data[][type]" class="form-input w-24"></td>
                                    <td><input x-model="row.dimensi" name="produk_data[][dimensi]" class="form-input w-24"></td>
                                    <td><input x-model="row.tebal" name="produk_data[][tebal]" class="form-input w-16"></td>
                                    <td><input x-model="row.warna" name="produk_data[][warna]" class="form-input w-20"></td>
                                    <td><input x-model="row.qty_area" name="produk_data[][qty_area]" class="form-input w-16"></td>
                                    <td>
                                        <select x-model="row.satuan_area" name="produk_data[][satuan_area]" class="form-select w-16">
                                            <option value="m2">m2</option>
                                            <option value="m">m</option>
                                            <option value="kg">kg</option>
                                        </select>
                                    </td>
                                    <td><input x-model="row.qty" name="produk_data[][qty]" class="form-input w-16"></td>
                                    <td><input x-model="row.satuan" name="produk_data[][satuan]" class="form-input w-16"></td>
                                    <td><input x-model="row.harga" name="produk_data[][harga]" class="form-input w-24" type="number"></td>
                                    <td><input x-model="row.total_harga" name="produk_data[][total_harga]" class="form-input w-28" type="number"></td>
                                    <td>
                                        <button type="button" @click="removeProduk(i)" class="text-red-600 hover:text-red-800 font-bold">&times;</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <button type="button" @click="addProduk" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Tambah Baris Produk
                    </button>
                </div>
            </div>

            <!-- Section Syarat & Catatan -->
            <flux:input name="syarat_kondisi" label="Syarat & Kondisi" type="textarea" rows="3">{{ is_array($penawaran->syarat_kondisi) ? implode("\n", $penawaran->syarat_kondisi) : $penawaran->syarat_kondisi }}</flux:input>
            <flux:input name="catatan" label="Catatan" type="textarea" rows="2">{{ $penawaran->catatan }}</flux:input>
            <div class="flex gap-2">
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white">
                    <x-icon name="check" class="w-4 h-4 mr-2" />
                    Update Penawaran
                </x-button>
                <x-button as="a" href="{{ route('admin.penawaran.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                    Batal
                </x-button>
            </div>
        </form>
    </div>
</x-layouts.app> 