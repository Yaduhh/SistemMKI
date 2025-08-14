<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Penawaran Pintu</h1>
            <x-button as="a" href="{{ route('admin.penawaran-pintu.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Kembali ke Daftar
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-4 mx-auto w-full">
        <form action="{{ route('admin.penawaran-pintu.update', $penawaran->id) }}" method="POST" class="space-y-8" x-data="penawaranForm()" x-init="init()">
            @csrf
            @method('PUT')
            <!-- Sales -->
            <flux:select name="id_user" :label="__('Sales')" required @change="loadClients($event.target.value)">
                <option value="" disabled>{{ __('Pilih Pengguna') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $penawaran->id_user == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </flux:select>
            
            <!-- Section Data Penawaran -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Penawaran Pintu</h2>
                <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                        <x-icon name="info" class="w-4 h-4 inline mr-1" />
                        Nomor penawaran akan dibuat otomatis dengan format: <strong>A/MKI/MM/YY</strong>
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Client -->
                    <flux:select name="id_client" :label="__('Client')" required>
                        <option value="" disabled selected>{{ __('Pilih Client') }}</option>
                    </flux:select>
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" value="{{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('Y-m-d') : '' }}" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    <flux:input name="judul_penawaran" label="Judul Penawaran" placeholder="masukkan judul penawaran pintu" type="text" value="{{ $penawaran->judul_penawaran }}" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    <flux:input name="project" label="Project" placeholder="Nama Project (opsional)" type="text" value="{{ $penawaran->project ?? '' }}" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
            </div>

            <!-- Section Main Sections -->
            <template x-if="mainSections.length > 0">
                <template x-for="(mainSection, mainIdx) in mainSections" :key="mainIdx">
                    <div class="w-full border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-white dark:bg-zinc-900">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Section <span x-text="mainIdx + 1"></span></h2>
                            <button type="button" @click="removeMainSection(mainIdx)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none flex items-center gap-2" x-show="mainSections.length > 1">
                                <x-icon name="trash" class="w-5 h-5" /> Hapus Section
                            </button>
                        </div>
                        
                        <!-- Sub Judul Main Section -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Section</label>
                            <input :name="'json_produk[' + mainIdx + '][judul]'" x-model="mainSection.judul" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Masukkan judul section" />
                        </div>

                        <!-- Product Sections within Main Section -->
                        <template x-if="mainSection.productSections.length > 0">
                            <template x-for="(section, sIdx) in mainSection.productSections" :key="section.kategori">
                                <div class="w-full mb-6" :class="{
                                    'border-blue-400': section.kategori === 'flooring',
                                    'border-green-400': section.kategori === 'facade',
                                    'border-yellow-400': section.kategori === 'wallpanel',
                                    'border-purple-400': section.kategori === 'ceiling',
                                    'border-pink-400': section.kategori === 'decking',
                                }">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="section.label"></h3>
                                        <button type="button" @click="removeProductSection(mainIdx, sIdx)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none flex items-center gap-2" x-show="mainSection.productSections.length > 1">
                                            <x-icon name="trash" class="w-5 h-5" /> Hapus Sub Section
                                        </button>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <template x-for="(row, i) in section.produk" :key="i">
                                            <div class="border-2 border-gray-200 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800">
                                                <div class="flex justify-between items-center mb-3">
                                                    <h4 class="font-semibold text-gray-900 dark:text-white">Produk #<span x-text="i+1"></span></h4>
                                                    <button type="button" @click="removeProduk(mainIdx, sIdx, i)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                                        <x-icon name="trash" class="w-5 h-5" />
                                                    </button>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    <!-- Product -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product</label>
                                                        <select :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][item]'" x-model="row.slug" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" @change="autofillProduk(section, row)">
                                                            <option value="">Pilih Produk</option>
                                                            <template x-for="p in section.master" :key="p.slug">
                                                                <option :value="p.slug" x-text="p.code + ' - ' + (p.lebar ? p.lebar + 'x' + (p.tebal ?? '') + 'x' + (p.panjang ?? '') : '') + (p.warna ? ' - ' + p.warna : '') + ' (Rp ' + (p.harga ? p.harga.toLocaleString('id-ID') : '0') + ')'" :selected="p.slug === row.slug"></option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <!-- Nama Produk -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Produk</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][nama_produk]'" x-model="row.nama_produk" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Nama Produk" />
                                                    </div>

                                                    <!-- Dimensi -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dimensi</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][dimensi]'" x-model="row.dimensi" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-700 text-gray-500 dark:text-zinc-400 cursor-not-allowed" placeholder="Dimensi" readonly />
                                                    </div>

                                                    <!-- Finishing -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Finishing</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][finishing]'" x-model="row.finishing" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Finishing" />
                                                    </div>

                                                    <!-- VOL(m²) -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">VOL(m²)</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][qty_area]'" x-model="row.qty_area" @input="calculateQty(section, row)" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Volume" />
                                                    </div>

                                                    <!-- Quantity -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][qty]'" x-model="row.qty" @input="calculateTotalHarga(row)" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Qty" />
                                                    </div>

                                                    <!-- Panjang -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Panjang</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][panjang]'" x-model="row.panjang" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-700 text-gray-500 dark:text-zinc-400 cursor-not-allowed" placeholder="Panjang" readonly />
                                                    </div>

                                                    <!-- Harga -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga</label>
                                                        <input x-model="row.harga_display" @input="formatHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-700 text-gray-500 dark:text-zinc-400 cursor-not-allowed" placeholder="Rp 0" readonly />
                                                    </div>

                                                    <!-- Total -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total</label>
                                                        <input x-model="row.total_harga_display" @input="formatTotalHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 bg-gray-100 dark:bg-zinc-700 text-gray-500 dark:text-zinc-400 cursor-not-allowed font-semibold" placeholder="Rp 0" readonly />
                                                    </div>
                                                </div>

                                                <!-- Hidden input untuk menyimpan data dalam format JSON -->
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][item]'" x-model="row.item" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][type]'" x-model="row.type" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][dimensi]'" x-model="row.dimensi" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][finishing]'" x-model="row.finishing" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][tebal_panjang]'" x-model="row.tebal_panjang" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][qty_area]'" x-model="row.qty_area" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][qty]'" x-model="row.qty" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][harga]'" x-model="row.harga" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][total_harga]'" x-model="row.total_harga" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][satuan]'" x-model="row.satuan" />
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="button" @click="addProduk(mainIdx, sIdx)" class="w-full hover:cursor-pointer py-2 px-4 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-950 text-blue-600 dark:text-blue-400 rounded-lg border-2 border-blue-600 hover:border-blue-700 transition-colors duration-200 flex items-center justify-center gap-2">
                                            <x-icon name="plus" class="w-5 h-5" />
                                            <span>Tambah Produk</span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </template>
                        
                        <!-- Add Product Section Button -->
                        <div class="mt-4">
                            <template x-if="mainSection.productSections.length === 0">
                                <div class="w-full">
                                    <div class="flex items-center gap-2 mb-4">
                                        <h3 class="text-md font-semibold text-gray-900 dark:text-white">Pilih Sub Section Produk</h3>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                                        <template x-for="option in sectionOptions" :key="option.kategori">
                                            <button type="button" @click="addProductSection(mainIdx, option)" class="p-4 border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 text-center" :class="{
                                                'border-blue-400 text-blue-700': option.kategori === 'pintu',
                                            }">
                                                <div class="flex items-center justify-center gap-2">
                                                    <x-icon name="plus" class="w-5 h-5" />
                                                    <span x-text="option.label" class="font-medium text-gray-700 dark:text-gray-300"></span>
                                                </div>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="mainSection.productSections.length > 0">
                                <template x-if="sectionOptions.filter(opt => !mainSection.productSections.map(s => s.kategori).includes(opt.kategori)).length > 0">
                                    <div class="w-full">
                                        <div class="flex items-center gap-2 mb-4">
                                            <h3 class="text-md font-semibold text-gray-900 dark:text-white">Tambah Sub Section Produk</h3>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                                            <template x-for="option in sectionOptions.filter(opt => !mainSection.productSections.map(s => s.kategori).includes(opt.kategori))" :key="option.kategori">
                                                <button type="button" @click="addProductSection(mainIdx, option)" class="p-4 border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 text-center" :class="{
                                                    'border-blue-400 text-blue-700': option.kategori === 'pintu',
                                                }">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <x-icon name="plus" class="w-5 h-5" />
                                                        <span x-text="option.label" class="font-medium text-gray-700 dark:text-gray-300"></span>
                                                    </div>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                </template>
            </template>
            
            <!-- Section untuk menambah main section jika belum ada -->
            <div class="mt-4">
                <template x-if="mainSections.length === 0">
                    <div class="w-full">
                        <div class="flex items-center gap-2 mb-4">
                            <h3 class="text-md font-semibold text-gray-900 dark:text-white">Buat Section Pertama</h3>
                        </div>
                        <button type="button" @click="addMainSection()" class="w-full p-6 border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <x-icon name="plus" class="w-6 h-6" />
                                <span class="font-medium text-gray-700 dark:text-gray-300">Tambah Section</span>
                            </div>
                        </button>
                    </div>
                </template>
                
                <template x-if="mainSections.length > 0">
                    <div class="w-full">
                        <button type="button" @click="addMainSection()" class="w-full p-4 border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <x-icon name="plus" class="w-5 h-5" />
                                <span class="font-medium text-gray-700 dark:text-gray-300">Tambah Section Baru</span>
                            </div>
                        </button>
                    </div>
                </template>
            </div>
            <!-- Section Syarat & Ketentuan -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Syarat & Ketentuan</h2>
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($syaratKetentuan as $syarat)
                        <div class="flex items-center">
                            <input type="checkbox" name="syarat_kondisi[]" value="{{ $syarat->syarat }}" id="syarat_{{ $loop->index }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ is_array($penawaran->syarat_kondisi) && in_array($syarat->syarat, $penawaran->syarat_kondisi) ? 'checked' : '' }}>
                            <label for="syarat_{{ $loop->index }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ $syarat->syarat }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section Perhitungan -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Perhitungan</h2>
                <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subtotal</label>
                            <input type="text" x-model="formatCurrency(subtotal)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" />
                            <input type="hidden" name="total" :value="subtotal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon (%)</label>
                            <input type="number" name="diskon" x-model="diskon" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 1 (%)</label>
                            <input type="number" name="diskon_satu" x-model="diskon_satu" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 2 (%)</label>
                            <input type="number" name="diskon_dua" x-model="diskon_dua" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Diskon</label>
                            <input type="text" x-model="formatCurrency(total_diskon)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Diskon 1</label>
                            <input type="text" x-model="formatCurrency(total_diskon_1)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Diskon 2</label>
                            <input type="text" x-model="formatCurrency(total_diskon_2)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Setelah Diskon</label>
                            <input type="text" x-model="formatCurrency(after_diskon)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PPN (%)</label>
                            <input type="number" name="ppn" x-model="ppn" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Grand Total</label>
                            <input type="text" x-model="formatCurrency(grand_total)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-blue-500 dark:border-blue-400 dark:bg-zinc-800 dark:text-white font-bold text-lg text-blue-600 dark:text-blue-400" />
                            <input type="hidden" name="grand_total" :value="grand_total">
                            <input type="hidden" name="total_diskon" :value="total_diskon">
                            <input type="hidden" name="total_diskon_1" :value="total_diskon_1">
                            <input type="hidden" name="total_diskon_2" :value="total_diskon_2">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Catatan -->
            <div class="w-full">
                <flux:input name="catatan" label="Catatan" placeholder="Tambahkan catatan jika diperlukan" type="textarea" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ $penawaran->catatan }}" />
            </div>
            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <x-button type="button" as="a" href="{{ route('admin.penawaran-pintu.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white">
                    Batal
                </x-button>
                <x-button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white">
                    <x-icon name="check" class="w-4 h-4 mr-2" />
                    Update Penawaran Pintu
                </x-button>
            </div>
        </form>
    </div>
</x-layouts.app>
<script>
function penawaranForm() {
    return {
        mainSections: [], // Array untuk main sections
        sectionOptions: [
            { kategori: 'pintu', label: 'PINTU', master: @json($pintus) },
        ],
        
        subtotal: 0,
        diskon: {{ $penawaran->diskon ?? 0 }},
        diskon_satu: {{ $penawaran->diskon_satu ?? 0 }},
        diskon_dua: {{ $penawaran->diskon_dua ?? 0 }},
        ppn: {{ $penawaran->ppn ?? 11 }},
        total_diskon: 0,
        total_diskon_1: 0,
        total_diskon_2: 0,
        total_diskon_all: 0,
        after_diskon: 0,
        grand_total: 0,

        init() {
            // Load clients saat halaman dimuat jika sudah ada sales yang dipilih
            const selectedUserId = document.querySelector('select[name="id_user"]').value;
            if (selectedUserId) {
                this.loadClients(selectedUserId);
            }
            
            // Load data produk yang sudah ada
            const existingProduk = @json($penawaran->json_produk ?? []);
            console.log('=== DEBUG LOADING EXISTING DATA ===');
            console.log('Existing produk:', existingProduk);
            
            if (existingProduk && existingProduk.length > 0) {
                // Konversi data lama ke format baru
                this.mainSections = existingProduk.map(section => ({
                    judul: section.judul || '',
                    productSections: section.product_sections ? Object.keys(section.product_sections).map(kategori => ({
                        kategori: kategori,
                        label: this.getSectionLabel(kategori),
                        master: this.getMasterData(kategori),
                        produk: section.product_sections[kategori].map(produk => {
                            console.log('Processing produk:', produk);
                            // Cari produk di master data berdasarkan type (code)
                            const masterProduk = this.getMasterData(kategori).find(p => p.code === produk.type);
                            const correctSlug = masterProduk ? masterProduk.slug : produk.type;
                            
                            console.log('Found master produk:', masterProduk);
                            console.log('Correct slug:', correctSlug);
                            console.log('Row slug after assignment:', correctSlug);
                            
                            return {
                                ...produk,
                                slug: correctSlug, // Gunakan slug yang benar dari master data
                                code: produk.type,
                                nama_produk: produk.item,
                                harga_display: this.formatCurrency(parseFloat(produk.harga) || 0),
                                total_harga_display: this.formatCurrency(parseFloat(produk.total_harga) || 0),
                                qty: produk.qty || '0',
                                qty_area: produk.qty_area || '',
                                finishing: produk.finishing || '',
                                panjang: produk.panjang || ''
                            };
                        })
                    })) : []
                }));
                
                console.log('Converted mainSections:', this.mainSections);
                // Debug: cek slug di setiap produk
                this.mainSections.forEach((mainSection, mainIdx) => {
                    mainSection.productSections.forEach((section, sIdx) => {
                        section.produk.forEach((row, pIdx) => {
                            console.log(`Main ${mainIdx}, Section ${sIdx}, Produk ${pIdx}: slug = ${row.slug}`);
                        });
                    });
                });
            }
            console.log('=== END DEBUG LOADING ===');
            
            // Hitung total awal
            this.calculateSubtotal();
        },

        getSectionLabel(kategori) {
            const option = this.sectionOptions.find(opt => opt.kategori === kategori);
            return option ? option.label : 'UNKNOWN';
        },

        getMasterData(kategori) {
            const option = this.sectionOptions.find(opt => opt.kategori === kategori);
            const master = option ? option.master : [];
            console.log(`Master data for ${kategori}:`, master);
            console.log(`Sample master item:`, master[0]);
            return master;
        },

        findProductInMaster(kategori, produk) {
            const master = this.getMasterData(kategori);
            
            // Coba berbagai kemungkinan matching
            let found = master.find(p => p.code === produk.type);
            if (found) {
                console.log(`Found by type (${produk.type}):`, found);
                return found;
            }
            
            found = master.find(p => p.nama_produk === produk.item);
            if (found) {
                console.log(`Found by item (${produk.item}):`, found);
                return found;
            }
            
            found = master.find(p => p.code === produk.item);
            if (found) {
                console.log(`Found by item as code (${produk.item}):`, found);
                return found;
            }
            
            // Coba partial matching
            found = master.find(p => p.nama_produk && p.nama_produk.toLowerCase().includes(produk.item.toLowerCase()));
            if (found) {
                console.log(`Found by partial match (${produk.item}):`, found);
                return found;
            }
            
            console.log(`No match found for produk:`, produk);
            return null;
        },

        addMainSection() {
            this.mainSections.push({
                judul: '',
                productSections: []
            });
        },

        removeMainSection(index) {
            this.mainSections.splice(index, 1);
            this.calculateSubtotal();
        },

        addProductSection(mainIndex, option) {
            this.mainSections[mainIndex].productSections.push({
                kategori: option.kategori,
                label: option.label,
                master: option.master,
                produk: [{
                    item: '',
                    code: '',
                    slug: '',
                    nama_produk: '',
                    type: '',
                    dimensi: '',
                    panjang: '',
                    finishing: '',
                    tebal_panjang: '',
                    qty_area: '',
                    qty: '0', // Default quantity 0
                    satuan: '',
                    harga: 0,
                    harga_display: 'Rp 0',
                    total_harga: 0,
                    total_harga_display: 'Rp 0'
                }]
            });
        },

        removeProductSection(mainIndex, sectionIndex) {
            this.mainSections[mainIndex].productSections.splice(sectionIndex, 1);
            this.calculateSubtotal();
        },

        addProduk(mainIndex, sectionIndex) {
            this.mainSections[mainIndex].productSections[sectionIndex].produk.push({
                item: '',
                code: '',
                slug: '',
                nama_produk: '',
                type: '',
                dimensi: '',
                panjang: '',
                finishing: '',
                tebal_panjang: '',
                qty_area: '',
                qty: '0', // Default quantity 0
                satuan: '',
                harga: 0,
                harga_display: 'Rp 0',
                total_harga: 0,
                total_harga_display: 'Rp 0'
            });
        },

        removeProduk(mainIndex, sectionIndex, productIndex) {
            this.mainSections[mainIndex].productSections[sectionIndex].produk.splice(productIndex, 1);
            this.calculateSubtotal();
        },

        getAvailableProducts(section, row) {
            const allProducts = (() => {
                switch (section.kategori) {
                    case 'pintu':
                        return this.sectionOptions.find(opt => opt.kategori === 'pintu')?.master || [];
                    default:
                        return [];
                }
            })();

            // Untuk edit, tampilkan semua produk agar produk yang sudah dipilih tetap muncul
            return allProducts;
        },

        autofillProduk(section, row) {
            if (!row.slug) return;
            const produk = section.master.find(p => p.slug === row.slug);
            if (produk) {
                console.log('=== DEBUG AUTOFILL PRODUK ===');
                console.log('Produk dipilih:', produk.code);
                console.log('luas_btg produk:', produk.luas_btg);
                console.log('luas_m2 produk:', produk.luas_m2);
                console.log('VOL(m²) saat ini:', row.qty_area);
                
                row.item = produk.nama_produk || section.label;
                row.code = produk.code ?? '';
                row.slug = produk.slug ?? '';
                row.nama_produk = produk.nama_produk || section.label;
                row.type = produk.code ?? '';
                row.dimensi = (produk.lebar && produk.tebal && produk.panjang) ? produk.lebar + 'x' + produk.tebal : '';
                row.panjang = produk.panjang ?? '';
                row.tebal_panjang = produk.tebal ?? produk.panjang ?? '';
                row.harga = produk.harga || 0;
                row.harga_display = this.formatCurrency(produk.harga || 0);
                
                // Jangan reset qty jika sudah ada nilai
                if (!row.qty || row.qty === '0') {
                    row.qty = '0';
                }
                
                // Jangan reset total_harga jika sudah ada nilai
                if (!row.total_harga || row.total_harga === '0') {
                    row.total_harga = 0;
                    row.total_harga_display = this.formatCurrency(0);
                }
                
                // Gunakan luas_m2 dari database produk
                let luas_m2 = produk.luas_m2 || 1;
                
                // Jika vol (qty_area) sudah diisi, hitung qty
                if (row.qty_area && luas_m2 > 0) {
                    const qty = Math.ceil(parseFloat(row.qty_area) / luas_m2);
                    row.qty = qty.toString();
                    console.log('Perhitungan qty di autofill:', parseFloat(row.qty_area), '/', luas_m2, '=', qty);
                } else {
                    console.log('qty_area kosong atau luas_m2 tidak valid');
                }
                
                // Hitung total harga otomatis jika belum ada
                if (row.harga && row.qty && (!row.total_harga || row.total_harga === '0')) {
                    row.total_harga = (parseFloat(row.harga) * parseFloat(row.qty)).toFixed(2);
                    row.total_harga_display = this.formatCurrency(row.total_harga);
                }
                this.updateCalculations();
                console.log('================================');
            }
        },

        loadClients(userId) {
            if (!userId) {
                const clientSelect = document.querySelector('select[name="id_client"]');
                clientSelect.innerHTML = '<option value="" disabled selected>{{ __("Pilih Client") }}</option>';
                return;
            }

            fetch(`/admin/penawaran-pintu/clients/${userId}`)
                .then(response => response.json())
                .then(clients => {
                    const clientSelect = document.querySelector('select[name="id_client"]');
                    const currentClientId = '{{ $penawaran->id_client }}';
                    
                    clientSelect.innerHTML = '<option value="" disabled selected>{{ __("Pilih Client") }}</option>';
                    
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
                    clientSelect.innerHTML = '<option value="" disabled selected>Error loading clients</option>';
                });
        },

        calculateTotalHarga(row) {
            if (!row.qty || !row.harga) return;
            row.total_harga = row.qty * row.harga;
            row.total_harga_display = this.formatCurrency(row.total_harga);
            this.calculateSubtotal();
            console.log('Calculate Total Harga:', {
                qty: row.qty,
                harga: row.harga,
                total_harga: row.total_harga,
                total_harga_display: row.total_harga_display
            });
        },

        calculateQty(section, row) {
            if (!row.slug || !row.qty_area) return;
            
            const produk = section.master.find(p => p.slug === row.slug);
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
                const qty = Math.ceil(vol / luas_m2);
                row.qty = qty.toString();
                
                // Debug: Log hasil perhitungan
                console.log('Perhitungan: qty =', vol, '÷', luas_m2, '=', qty);
                console.log('================================');
                
                // Hitung ulang total harga
                if (row.harga) {
                    row.total_harga = (parseFloat(row.harga) * parseFloat(row.qty)).toFixed(2);
                    row.total_harga_display = this.formatCurrency(row.total_harga);
                }
                this.calculateSubtotal();
            } else {
                console.log('Error: vol atau luas_m2 tidak valid');
                console.log('vol:', vol, 'luas_m2:', luas_m2);
                console.log('================================');
            }
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
                this.calculateSubtotal();
            }
        },

        calculateSubtotal() {
            this.subtotal = 0;
            this.mainSections.forEach(mainSection => {
                mainSection.productSections.forEach(section => {
                    section.produk.forEach(produk => {
                        this.subtotal += parseFloat(produk.total_harga) || 0;
                    });
                });
            });
            this.calculateTotal();
        },

        calculateTotal() {
            const subtotal = parseFloat(this.subtotal) || 0;
            const diskon = parseFloat(this.diskon) || 0;
            const diskon_satu = parseFloat(this.diskon_satu) || 0;
            const diskon_dua = parseFloat(this.diskon_dua) || 0;
            const ppn = parseFloat(this.ppn) || 0;

            const total_diskon = subtotal * (diskon / 100);
            const total_diskon_1 = (subtotal - total_diskon) * (diskon_satu / 100);
            const total_diskon_2 = (subtotal - total_diskon - total_diskon_1) * (diskon_dua / 100);
            
            // Simpan nilai diskon ke properti Alpine.js
            this.total_diskon = total_diskon;
            this.total_diskon_1 = total_diskon_1;
            this.total_diskon_2 = total_diskon_2;
            this.total_diskon_all = total_diskon + total_diskon_1 + total_diskon_2;
            this.after_diskon = subtotal - this.total_diskon_all;
            const ppn_nominal = this.after_diskon * (ppn / 100);
            this.grand_total = Math.round(this.after_diskon + ppn_nominal);
        },

        updateCalculations() {
            this.calculateSubtotal();
        }
    }
}
</script> 