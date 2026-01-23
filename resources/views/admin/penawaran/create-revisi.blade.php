<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Buat Revisi Penawaran</h1>
            <x-button as="a" href="{{ route('admin.penawaran.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Kembali ke Daftar
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />
    
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <div class="flex items-start gap-2">
                <x-icon name="exclamation-triangle" class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" />
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-2">Terjadi kesalahan validasi:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Informasi Penawaran yang akan di-Revisi -->
    <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
        <div class="flex items-center gap-2 mb-2">
            <x-icon name="info" class="w-5 h-5 text-yellow-600 dark:text-yellow-400" />
            <h3 class="font-semibold text-yellow-800 dark:text-yellow-200">
                @if($penawaran->is_revisi)
                    Revisi dari Penawaran Revisi
                @else
                    Revisi dari Penawaran Asli
                @endif
            </h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="font-medium text-yellow-700 dark:text-yellow-300">Nomor:</span>
                <span class="text-yellow-800 dark:text-yellow-200">{{ $penawaran->nomor_penawaran }}</span>
            </div>
            <div>
                <span class="font-medium text-yellow-700 dark:text-yellow-300">Judul:</span>
                <span class="text-yellow-800 dark:text-yellow-200">{{ $penawaran->judul_penawaran }}</span>
            </div>
            <div>
                <span class="font-medium text-yellow-700 dark:text-yellow-300">Client:</span>
                <span class="text-yellow-800 dark:text-yellow-200">{{ $penawaran->client->nama ?? $penawaran->client->nama_perusahaan }}</span>
            </div>
        </div>
        @if($penawaran->is_revisi)
            <div class="mt-3 p-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded text-xs">
                <span class="font-medium text-blue-700 dark:text-blue-300">Info:</span>
                <span class="text-blue-800 dark:text-blue-200">Ini adalah revisi dari penawaran yang sudah direvisi sebelumnya. Revisi berikutnya akan menjadi R{{ preg_match('/R(\d+)$/', $penawaran->nomor_penawaran, $matches) ? $matches[1] + 1 : '?' }}.</span>
            </div>
        @endif
    </div>

    <div class="py-4 mx-auto w-full">
        <form action="{{ route('admin.penawaran.store-revisi', $penawaran) }}" method="POST" class="space-y-8" x-data="penawaranForm()">
            @csrf
            <!-- Sales -->
            <flux:select name="id_user" :label="__('Sales')" required @change="loadClients($event.target.value)">
                <option value="">{{ __('Pilih Pengguna') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('id_user', $penawaran->id_user) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </flux:select>
            
            <!-- Section Data Penawaran -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Penawaran</h2>
                <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                        <x-icon name="info" class="w-4 h-4 inline mr-1" />
                        @php
                            $nomorAsli = preg_replace('/\s+R\d+$/', '', $penawaran->nomor_penawaran);
                            $currentRevision = preg_match('/R(\d+)$/', $penawaran->nomor_penawaran, $matches) ? (int)$matches[1] : 0;
                            $nextRevision = $currentRevision + 1;
                        @endphp
                        Nomor revisi akan dibuat otomatis dengan format: <strong>{{ $nomorAsli }} R{{ $nextRevision }}</strong>
                        @if($penawaran->is_revisi)
                            <br><span class="text-xs">(Revisi ke-{{ $nextRevision }} dari penawaran {{ $nomorAsli }})</span>
                        @endif
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Client -->
                    <flux:select name="id_client" :label="__('Client')" required>
                        <option value="">{{ __('Pilih Client') }}</option>
                        @if($penawaran->client)
                            <option value="{{ $penawaran->client->id }}" selected>{{ $penawaran->client->nama ?? $penawaran->client->nama_perusahaan }}</option>
                        @endif
                    </flux:select>
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ old('tanggal_penawaran', date('Y-m-d')) }}" />
                    <flux:input name="judul_penawaran" label="Judul Penawaran" placeholder="masukkan judul penawaran" type="text" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ old('judul_penawaran', $penawaran->judul_penawaran) }}" />
                    <flux:input name="project" label="Project" placeholder="Nama Project (opsional)" type="text" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ old('project', $penawaran->project) }}" />
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
                                    'border-orange-400': section.kategori === 'hollow',
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
                                                            <template x-for="p in getAvailableProducts(section, row)" :key="p.slug">
                                                                <option :value="p.slug" :selected="p.slug === row.slug" x-text="p.code + ' - ' + (p.nama_produk || '') + (p.lebar ? ' (' + p.lebar + 'x' + (p.tebal ?? '') + 'x' + (p.panjang ?? '') + ')' : '') + (p.warna ? ' - ' + p.warna : '') + ' (Rp ' + (p.harga ? p.harga.toLocaleString('id-ID') : '0') + ')'"></option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <!-- Type/Code -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type/Code</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][type]'" x-model="row.type" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Type/Code" />
                                                    </div>

                                                    <!-- Nama Produk -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Produk</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][nama_produk]'" x-model="row.nama_produk" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Nama Produk" />
                                                    </div>

                                                    <!-- Dimensi -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dimensi</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][dimensi]'" x-model="row.dimensi" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Dimensi" />
                                                    </div>



                                                    <!-- Finishing -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Finishing</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][finishing]'" x-model="row.finishing" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Finishing" />
                                                    </div>

                                                    <!-- Tebal/Panjang -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tebal/Panjang</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][tebal_panjang]'" x-model="row.tebal_panjang" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Tebal/Panjang" />
                                                    </div>

                                                    <!-- VOL(m²) -->
                                                    <div x-show="section.kategori !== 'hollow'">
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">VOL(m²)</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][qty_area]'" x-model="row.qty_area" @input="calculateQty(section, row)" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Volume" />
                                                    </div>

                                                    <!-- Quantity -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][qty]'" x-model="row.qty" @input="calculateTotalHarga(row)" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Qty" />
                                                    </div>

                                                    <!-- Panjang -->
                                                    <div x-show="section.kategori !== 'hollow'">
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Panjang</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][panjang]'" x-model="row.panjang" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Panjang" />
                                                    </div>

                                                    <!-- Satuan -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][satuan]'" x-model="row.satuan" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Satuan" />
                                                    </div>

                                                    <!-- Warna -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][warna]'" x-model="row.warna" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Warna" />
                                                    </div>

                                                    <!-- Harga -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga</label>
                                                        <input x-model="row.harga_display" @input="formatHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Rp 0" />
                                                    </div>

                                                    <!-- Total -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total</label>
                                                        <input x-model="row.total_harga_display" @input="formatTotalHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 font-semibold" placeholder="Rp 0" />
                                                    </div>
                                                </div>

                                                <!-- Hidden input untuk menyimpan data dalam format JSON -->
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][slug]'" x-model="row.slug" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][nama_produk]'" x-model="row.nama_produk" />
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
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][warna]'" x-model="row.warna" />
                                                <input type="hidden" :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][panjang]'" x-model="row.panjang" />
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
                                                'border-blue-400 text-blue-700': option.kategori === 'flooring',
                                                'border-green-400 text-green-700': option.kategori === 'facade',
                                                'border-yellow-400 text-yellow-700': option.kategori === 'wallpanel',
                                                'border-purple-400 text-purple-700': option.kategori === 'ceiling',
                                                'border-pink-400 text-pink-700': option.kategori === 'decking',
                                                'border-orange-400 text-orange-700': option.kategori === 'hollow',
                                                'border-cyan-400 text-cyan-700': option.kategori === 'rotan_sintetis',
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
                                                    'border-blue-400 text-blue-700': option.kategori === 'flooring',
                                                    'border-green-400 text-green-700': option.kategori === 'facade',
                                                    'border-yellow-400 text-yellow-700': option.kategori === 'wallpanel',
                                                    'border-purple-400 text-purple-700': option.kategori === 'ceiling',
                                                    'border-pink-400 text-pink-700': option.kategori === 'decking',
                                                    'border-orange-400 text-orange-700': option.kategori === 'hollow',
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
                    <div class="w-full space-y-3">
                        <button type="button" @click="refreshAllProduk()" class="w-full p-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <x-icon name="arrow-path" class="w-5 h-5" />
                            <span class="font-medium">Refresh Semua Harga Produk</span>
                        </button>
                        <button type="button" @click="addMainSection()" class="w-full p-4 border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <x-icon name="plus" class="w-5 h-5" />
                                <span class="font-medium text-gray-700 dark:text-gray-300">Tambah Section Baru</span>
                            </div>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Section Additional Condition (Aksesoris/Hollow) -->
            <div class="w-full">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Additional Condition (Aksesoris)</h2>
                    <div class="flex items-center gap-2">
                        <template x-if="additionalConditions.length > 0">
                            <button type="button" @click="refreshAllAdditionalProduk()" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                                <x-icon name="arrow-path" class="w-5 h-5" />
                                <span>Refresh Harga Aksesoris</span>
                            </button>
                        </template>
                        <button type="button" @click="addAdditionalCondition()" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                            <x-icon name="plus" class="w-5 h-5" />
                            <span>Tambah Additional Condition</span>
                        </button>
                    </div>
                </div>

                <template x-if="additionalConditions.length > 0">
                    <template x-for="(condition, condIdx) in additionalConditions" :key="condIdx">
                        <div class="w-full rounded-lg mb-4">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex-1 mr-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Additional Condition</label>
                                    <input 
                                        type="text" 
                                        :name="'additional_condition[' + condIdx + '][label]'" 
                                        x-model="condition.label" 
                                        class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" 
                                        placeholder="Masukkan nama condition (contoh: Aksesoris Tambahan 1)"
                                    />
                                </div>
                                <button type="button" @click="removeAdditionalCondition(condIdx)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none flex items-center gap-2 ml-4" x-show="additionalConditions.length > 1">
                                    <x-icon name="trash" class="w-5 h-5" /> Hapus
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(row, i) in condition.produk" :key="i">
                                    <div class="border-2 border-gray-200 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800">
                                        <div class="flex justify-between items-center mb-3">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">Aksesoris #<span x-text="i+1"></span></h4>
                                            <button type="button" @click="removeAdditionalProduk(condIdx, i)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                                <x-icon name="trash" class="w-5 h-5" />
                                            </button>
                                        </div>

                                        <!-- Baris Pertama: 5 Inputan -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                                            <!-- Product (Hollow) -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Aksesoris</label>
                                                <select :name="'additional_condition[' + condIdx + '][produk][' + i + '][item]'" x-model="row.slug" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" @change="autofillAdditionalProduk(condition, row)">
                                                    <option value="">Pilih Aksesoris</option>
                                                    <template x-for="p in getAvailableHollows(condition, row)" :key="p.slug">
                                                        <option :value="p.slug" :selected="p.slug === row.slug" x-text="p.code + ' - ' + (p.nama_produk || '') + ' (Rp ' + (p.harga ? p.harga.toLocaleString('id-ID') : '0') + ')'"></option>
                                                    </template>
                                                </select>
                                            </div>

                                            <!-- Nama Produk -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Produk</label>
                                                <input :name="'additional_condition[' + condIdx + '][produk][' + i + '][nama_produk]'" x-model="row.nama_produk" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Nama Produk" />
                                            </div>

                                            <!-- Satuan -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan</label>
                                                <input :name="'additional_condition[' + condIdx + '][produk][' + i + '][satuan]'" x-model="row.satuan" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Satuan" />
                                            </div>

                                            <!-- VOL(m²) -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">VOL(m²)</label>
                                                <input :name="'additional_condition[' + condIdx + '][produk][' + i + '][qty_area]'" x-model="row.qty_area" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Volume" />
                                            </div>

                                            <!-- Satuan VOL -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan VOL</label>
                                                <input :name="'additional_condition[' + condIdx + '][produk][' + i + '][satuan_vol]'" x-model="row.satuan_vol" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Satuan VOL" />
                                            </div>
                                        </div>

                                        <!-- Baris Kedua: 3 Inputan -->
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <!-- Quantity -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                                                <input :name="'additional_condition[' + condIdx + '][produk][' + i + '][qty]'" x-model="row.qty" @input="calculateAdditionalTotalHarga(row)" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Qty" />
                                            </div>

                                            <!-- Harga -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga</label>
                                                <input x-model="row.harga_display" @input="formatAdditionalHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Rp 0" />
                                            </div>

                                            <!-- Total -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total</label>
                                                <input x-model="row.total_harga_display" @input="formatAdditionalTotalHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" placeholder="Rp 0" />
                                            </div>
                                        </div>

                                        <!-- Hidden inputs -->
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][label]'" x-model="condition.label" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][item]'" x-model="row.item" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][code]'" x-model="row.code" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][slug]'" x-model="row.slug" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][satuan]'" x-model="row.satuan" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][qty_area]'" x-model="row.qty_area" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][satuan_vol]'" x-model="row.satuan_vol" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][harga]'" x-model="row.harga" />
                                        <input type="hidden" :name="'additional_condition[' + condIdx + '][produk][' + i + '][total_harga]'" x-model="row.total_harga" />
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4">
                                <button type="button" @click="addAdditionalProduk(condIdx)" class="w-full hover:cursor-pointer py-2 px-4 bg-orange-50 dark:bg-orange-900/30 hover:bg-orange-100 dark:hover:bg-orange-900/50 text-orange-600 dark:text-orange-400 rounded-lg border-2 border-orange-600 hover:border-orange-700 transition-colors duration-200 flex items-center justify-center gap-2">
                                    <x-icon name="plus" class="w-5 h-5" />
                                    <span>Tambah Aksesoris</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </template>

                <template x-if="additionalConditions.length === 0">
                    <div class="w-full p-6 border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-lg text-center">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada Additional Condition. Klik tombol di atas untuk menambahkan.</p>
                    </div>
                </template>
            </div>

            <!-- Section Syarat & Ketentuan -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Syarat & Ketentuan</h2>
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($syaratKetentuan as $syarat)
                        <div class="flex items-center">
                            <input type="checkbox" name="syarat_kondisi[]" value="{{ $syarat->syarat }}" id="syarat_{{ $loop->index }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ in_array($syarat->syarat, $penawaran->syarat_kondisi ?? []) ? 'checked' : '' }}>
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
                <div class="bg-white dark:bg-zinc-900 rounded-lg border-2 border-gray-200 dark:border-zinc-700 shadow-sm">
                    <!-- Subtotal Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-zinc-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Subtotal Produk</h3>
                            <div class="text-right">
                                <input type="text" x-model="formatCurrency(subtotal)" @input="subtotal = parseCurrency($event.target.value) || 0; calculateTotal()" class="text-lg font-bold text-gray-900 dark:text-white bg-transparent border-none p-0 w-auto min-w-[150px] text-right" />
                                <input type="hidden" name="total" :value="subtotal">
                            </div>
                        </div>
                    </div>

                    <!-- Diskon Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800/50">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Diskon</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon (%)</label>
                                <input type="number" name="diskon" x-model="diskon" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('diskon', $penawaran->diskon ?? 0) }}" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 1 (%)</label>
                                <input type="number" name="diskon_satu" x-model="diskon_satu" @input="handleDiskon1Input($event)" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('diskon_satu', $penawaran->diskon_satu ?? 0) }}" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 2 (%)</label>
                                <input type="number" name="diskon_dua" x-model="diskon_dua" @input="handleDiskon2Input($event)" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('diskon_dua', $penawaran->diskon_dua ?? 0) }}" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Total Diskon</label>
                                <input type="text" x-model="formatCurrency(total_diskon)" @input="total_diskon = parseCurrency($event.target.value) || 0; calculateTotal()" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 font-semibold text-gray-900 dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Total Diskon 1</label>
                                <input type="text" x-model="formatCurrency(total_diskon_1)" @input="handleTotalDiskon1Input($event)" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 font-semibold text-gray-900 dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Total Diskon 2</label>
                                <input type="text" x-model="formatCurrency(total_diskon_2)" @input="handleTotalDiskon2Input($event)" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 font-semibold text-gray-900 dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Setelah Diskon</label>
                                <input type="text" x-model="formatCurrency(after_diskon)" @input="after_diskon = parseCurrency($event.target.value) || 0; calculateTotal()" class="w-full py-2 px-3 rounded-lg border-2 border-blue-300 dark:border-blue-600 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 font-semibold text-blue-700 dark:text-blue-400" />
                            </div>
                        </div>
                    </div>

                    <!-- Additional Condition Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-zinc-700 bg-orange-50 dark:bg-orange-900/10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Total Additional Condition</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Tidak kena diskon</p>
                            </div>
                            <div class="text-right">
                                <input type="text" x-model="formatCurrency(additional_condition_total)" @input="additional_condition_total = parseCurrency($event.target.value) || 0; calculateTotal()" class="text-lg font-bold text-orange-600 dark:text-orange-400 bg-transparent border-none p-0 w-auto min-w-[150px] text-right" />
                            </div>
                        </div>
                    </div>

                    <!-- PPN Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-zinc-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PPN (%)</label>
                                <input type="number" name="ppn" x-model="ppn" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('ppn', $penawaran->ppn ?? 11) }}" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nominal PPN</label>
                                <input type="text" x-model="formatCurrency((after_diskon + additional_condition_total) * (ppn / 100))" @input="ppn = (parseCurrency($event.target.value) || 0) / ((after_diskon + additional_condition_total) || 1) * 100; calculateTotal()" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 font-semibold text-gray-900 dark:text-white" />
                            </div>
                        </div>
                    </div>

                    <!-- Grand Total Section -->
                    <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border-t-4 border-blue-500 dark:border-blue-400">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Grand Total</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Total akhir setelah semua perhitungan</p>
                            </div>
                            <div class="text-right">
                                <input type="text" x-model="formatCurrency(grand_total)" @input="grand_total = parseCurrency($event.target.value) || 0" class="text-2xl font-bold text-blue-600 dark:text-blue-400 bg-transparent border-none p-0 w-auto min-w-[200px] text-right" />
                                <input type="hidden" name="grand_total" :value="grand_total">
                                <input type="hidden" name="total_diskon" :value="total_diskon">
                                <input type="hidden" name="total_diskon_1" :value="total_diskon_1">
                                <input type="hidden" name="total_diskon_2" :value="total_diskon_2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Catatan -->
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan</label>
                <textarea 
                    name="catatan" 
                    rows="4" 
                    placeholder="Tambahkan catatan jika diperlukan" 
                    class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 resize-y"
                >{{ old('catatan', $penawaran->catatan) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <x-button type="button" as="a" href="{{ route('admin.penawaran.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white">
                    Batal
                </x-button>
                <x-button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white">
                    <x-icon name="check" class="w-4 h-4 mr-2" />
                    Simpan Revisi Penawaran
                </x-button>
            </div>
        </form>
    </div>
</x-layouts.app>

<script>
function penawaranForm() {
    return {
        mainSections: [], // Akan diinisialisasi di init()
        additionalConditions: [], // Array untuk additional condition (aksesoris/hollow)
        sectionOptions: [
            { kategori: 'flooring', label: 'FLOORING', master: @json($floorings) },
            { kategori: 'facade', label: 'FACADE', master: @json($facades) },
            { kategori: 'wallpanel', label: 'WALLPANEL', master: @json($wallpanels) },
            { kategori: 'ceiling', label: 'CEILING', master: @json($ceilings) },
            { kategori: 'decking', label: 'DECKING', master: @json($deckings) },
            { kategori: 'hollow', label: 'HOLLOW', master: @json($hollows) },
            { kategori: 'rotan_sintetis', label: 'ROTAN SINTETIS', master: @json($rotanSintetis ?? []) },
        ],
        hollows: @json($hollows), // Data hollow untuk additional condition

        subtotal: {{ $penawaran->total ?? 0 }},
        additional_condition_total: 0, // Total dari additional condition (tidak kena diskon)
        diskon: {{ $penawaran->diskon ?? 0 }},
        diskon_satu: {{ $penawaran->diskon_satu ?? 0 }},
        diskon_dua: {{ $penawaran->diskon_dua ?? 0 }},
        ppn: {{ $penawaran->ppn ?? 11 }},
        total_diskon: 0,
        total_diskon_1: 0,
        total_diskon_2: 0,
        total_diskon_all: 0,
        after_diskon: 0,
        grand_total: {{ $penawaran->grand_total ?? 0 }},
        total_diskon_1_manual: null, // Flag untuk menandai jika total_diskon_1 diinput manual
        total_diskon_2_manual: null, // Flag untuk menandai jika total_diskon_2 diinput manual

        // Inisialisasi data saat halaman dimuat
        init() {
            console.log('=== INIT METHOD DIPANGGIL ===');
            
            // Load total_diskon_1 dan total_diskon_2 dari database TERLEBIH DAHULU jika ada
            // Ini untuk memastikan nilai yang sudah diinput manual tetap sama saat edit
            // HARUS dilakukan di awal sebelum perhitungan apapun
            const dbTotalDiskon1 = {{ $penawaran->total_diskon_1 ?? 'null' }};
            const dbTotalDiskon2 = {{ $penawaran->total_diskon_2 ?? 'null' }};
            
            if (dbTotalDiskon1 !== null && dbTotalDiskon1 !== undefined) {
                // Jika total_diskon_1 sudah ada di database, set sebagai manual
                // Ini akan memastikan nilai tetap sama dan tidak dihitung ulang dari persentase yang dibulatkan
                const value = parseFloat(dbTotalDiskon1) || 0;
                this.total_diskon_1_manual = value;
                this.total_diskon_1 = value; // Set langsung nilai total_diskon_1
                console.log('Loaded total_diskon_1 from DB (early):', this.total_diskon_1_manual);
            }
            
            if (dbTotalDiskon2 !== null && dbTotalDiskon2 !== undefined) {
                // Jika total_diskon_2 sudah ada di database, set sebagai manual
                const value = parseFloat(dbTotalDiskon2) || 0;
                this.total_diskon_2_manual = value;
                this.total_diskon_2 = value; // Set langsung nilai total_diskon_2
                console.log('Loaded total_diskon_2 from DB (early):', this.total_diskon_2_manual);
            }
            
            // Load data produk dari penawaran asli
            const rawData = @json($penawaran->json_produk ?? []);
            console.log('Data mentah dari database:', rawData);
            
            // Konversi data dari format database ke format template
            const convertedData = this.convertDatabaseDataSync(rawData);
            console.log('Data setelah konversi:', convertedData);
            
            // Set data yang sudah dikonversi ke mainSections
            this.mainSections = convertedData;
            console.log('Data final mainSections:', this.mainSections);
            
            // Debug: Log dropdown values untuk memastikan data ter-set
            console.log('=== DEBUG DROPDOWN VALUES ===');
            this.mainSections.forEach((mainSection, mainIdx) => {
                if (mainSection.productSections) {
                    mainSection.productSections.forEach((section, sIdx) => {
                        if (section.produk) {
                            section.produk.forEach((produk, pIdx) => {
                                console.log(`Dropdown ${mainIdx}-${sIdx}-${pIdx}:`, {
                                    slug: produk.slug,
                                    type: produk.type,
                                    item: produk.item
                                });
                            });
                        }
                    });
                }
            });
            console.log('================================');
            
            // Load additional condition data
            let existingAdditionalCondition = @json($penawaran->additional_condition ?? null);
            console.log('=== DEBUG LOADING ADDITIONAL CONDITION ===');
            console.log('Raw additional condition from DB:', existingAdditionalCondition);
            console.log('Type:', typeof existingAdditionalCondition);
            
            // Handle jika data masih berupa JSON string (belum di-decode)
            if (typeof existingAdditionalCondition === 'string' && existingAdditionalCondition.trim() !== '') {
                try {
                    existingAdditionalCondition = JSON.parse(existingAdditionalCondition);
                    console.log('Parsed from JSON string:', existingAdditionalCondition);
                } catch (e) {
                    console.error('Error parsing JSON string:', e);
                    existingAdditionalCondition = null;
                }
            }
            
            // Handle jika data null atau undefined
            if (!existingAdditionalCondition) {
                existingAdditionalCondition = [];
            }
            
            // Pastikan data berupa array
            if (!Array.isArray(existingAdditionalCondition)) {
                console.warn('Additional condition is not an array, converting...');
                existingAdditionalCondition = [];
            }
            
            console.log('Processed additional condition:', existingAdditionalCondition);
            
            if (existingAdditionalCondition && existingAdditionalCondition.length > 0) {
                this.additionalConditions = existingAdditionalCondition.map((condition, condIdx) => ({
                    label: condition.label || '',
                    produk: (condition.produk || []).map((produk, prodIdx) => {
                        // Cari hollow di master data berdasarkan berbagai kemungkinan
                        let hollow = null;
                        let correctSlug = '';
                        
                        // Coba cari berdasarkan slug dulu (paling akurat)
                        if (produk.slug) {
                            hollow = this.hollows.find(h => h.slug === produk.slug);
                            if (hollow) {
                                correctSlug = hollow.slug;
                            }
                        }
                        
                        // Jika tidak ketemu, coba cari berdasarkan code
                        if (!hollow && produk.code) {
                            hollow = this.hollows.find(h => h.code === produk.code);
                            if (hollow) {
                                correctSlug = hollow.slug;
                            }
                        }
                        
                        // Jika masih tidak ketemu, coba cari berdasarkan item
                        if (!hollow && produk.item) {
                            hollow = this.hollows.find(h => h.code === produk.item || h.nama_produk === produk.item);
                            if (hollow) {
                                correctSlug = hollow.slug;
                            }
                        }
                        
                        // Jika masih tidak ketemu, gunakan slug/code dari produk
                        if (!correctSlug) {
                            correctSlug = produk.slug || produk.code || '';
                        }
                        
                        console.log('Processing produk additional condition:', {
                            original: produk,
                            foundHollow: hollow,
                            correctSlug: correctSlug,
                            availableHollows: this.hollows.length
                        });
                        
                        const rowData = {
                            item: produk.item || hollow?.nama_produk || '',
                            code: produk.code || hollow?.code || '',
                            slug: correctSlug, // Pastikan slug ter-set dengan benar - ini yang penting untuk dropdown
                            nama_produk: produk.nama_produk || produk.item || hollow?.nama_produk || '',
                            satuan: produk.satuan || hollow?.satuan || '',
                            qty_area: produk.qty_area || '',
                            satuan_vol: produk.satuan_vol || '',
                            qty: produk.qty || '0',
                            harga: parseFloat(produk.harga) || parseFloat(hollow?.harga) || 0,
                            harga_display: this.formatCurrency(parseFloat(produk.harga) || parseFloat(hollow?.harga) || 0),
                            total_harga: parseFloat(produk.total_harga) || 0,
                            total_harga_display: this.formatCurrency(parseFloat(produk.total_harga) || 0)
                        };
                        
                        // Jika ada hollow yang cocok, pastikan semua data terisi dengan benar
                        if (hollow && correctSlug) {
                            // Update data dari hollow untuk memastikan konsistensi
                            rowData.item = hollow.nama_produk || rowData.item;
                            rowData.code = hollow.code || rowData.code;
                            rowData.nama_produk = hollow.nama_produk || rowData.nama_produk;
                            rowData.satuan = hollow.satuan || rowData.satuan;
                            if (!rowData.harga || rowData.harga === 0) {
                                rowData.harga = parseFloat(hollow.harga) || 0;
                                rowData.harga_display = this.formatCurrency(rowData.harga);
                            }
                            // Pastikan slug menggunakan slug dari hollow (bukan code)
                            rowData.slug = hollow.slug;
                        }
                        
                        console.log('Final rowData:', rowData);
                        
                        return rowData;
                    })
                }));
                console.log('Converted additionalConditions:', this.additionalConditions);
                
                // Tunggu sampai DOM selesai render, lalu pastikan dropdown ter-set
                this.$nextTick(() => {
                    // Pastikan semua data terisi dengan benar dan dropdown ter-set
                    this.additionalConditions.forEach((condition, condIdx) => {
                        condition.produk.forEach((row, prodIdx) => {
                            if (row.slug) {
                                // Pastikan data dari hollow ter-update
                                const hollow = this.hollows.find(h => h.slug === row.slug);
                                if (hollow) {
                                    // Update data jika belum lengkap
                                    if (!row.item) row.item = hollow.nama_produk || '';
                                    if (!row.code) row.code = hollow.code || '';
                                    if (!row.nama_produk) row.nama_produk = hollow.nama_produk || '';
                                    if (!row.satuan) row.satuan = hollow.satuan || '';
                                    if (!row.harga || row.harga === 0) {
                                        row.harga = parseFloat(hollow.harga) || 0;
                                        row.harga_display = this.formatCurrency(row.harga);
                                    }
                                    // Pastikan slug menggunakan slug dari hollow (bukan code)
                                    row.slug = hollow.slug;
                                    console.log(`Updated row ${condIdx}-${prodIdx} with slug:`, row.slug);
                                } else {
                                    console.warn(`Hollow not found for slug: ${row.slug}`);
                                }
                            } else {
                                console.warn(`Row ${condIdx}-${prodIdx} has no slug`);
                            }
                        });
                    });
                    // Recalculate total setelah update
                    this.calculateAdditionalConditionTotal();
                    console.log('Additional conditions after $nextTick:', this.additionalConditions);
                });
            } else {
                console.log('No additional condition data found or empty array');
                this.additionalConditions = [];
            }
            console.log('=== END DEBUG LOADING ADDITIONAL CONDITION ===');
            
            // Tunggu sampai DOM selesai di-render
            this.$nextTick(() => {
                console.log('=== SETELAH $NEXTTICK ===');
                console.log('Data setelah konversi:', this.mainSections);
                
                this.calculateSubtotal();
                this.calculateAdditionalConditionTotal();
                this.calculateTotal();
                
                // Debug: Log final state setelah semua data di-load
                console.log('=== FINAL STATE AFTER INIT ===');
                console.log('Additional Conditions:', this.additionalConditions);
                this.additionalConditions.forEach((condition, condIdx) => {
                    condition.produk.forEach((row, prodIdx) => {
                        console.log(`Condition ${condIdx}, Produk ${prodIdx}:`, {
                            slug: row.slug,
                            code: row.code,
                            item: row.item,
                            nama_produk: row.nama_produk,
                            availableInHollows: this.hollows.find(h => h.slug === row.slug) ? 'YES' : 'NO'
                        });
                    });
                });
                console.log('=== END FINAL STATE ===');
                
                // Load clients untuk sales yang sudah dipilih
                if ({{ $penawaran->id_user ?? 0 }}) {
                    this.loadClients({{ $penawaran->id_user ?? 0 }});
                }
            });
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
                    warna: '',
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
                warna: '',
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
                    case 'flooring':
                        return this.sectionOptions.find(opt => opt.kategori === 'flooring')?.master || [];
                    case 'facade':
                        return this.sectionOptions.find(opt => opt.kategori === 'facade')?.master || [];
                    case 'wallpanel':
                        return this.sectionOptions.find(opt => opt.kategori === 'wallpanel')?.master || [];
                    case 'ceiling':
                        return this.sectionOptions.find(opt => opt.kategori === 'ceiling')?.master || [];
                    case 'decking':
                        return this.sectionOptions.find(opt => opt.kategori === 'decking')?.master || [];
                    case 'hollow':
                        return this.sectionOptions.find(opt => opt.kategori === 'hollow')?.master || [];
                    case 'rotan_sintetis':
                        return this.sectionOptions.find(opt => opt.kategori === 'rotan_sintetis')?.master || [];
                    default:
                        return [];
                }
            })();

            // Filter produk yang sudah dipilih di section ini
            const selectedSlugs = section.produk
                .filter(p => p.slug && p.slug !== row.slug) // Exclude current row
                .map(p => p.slug);

            return allProducts.filter(product => !selectedSlugs.includes(product.slug));
        },

        autofillProduk(section, row) {
            if (!row.slug) return;
            const produk = section.master.find(p => p.slug === row.slug);
            if (produk) {
                console.log('=== DEBUG AUTOFILL PRODUK ===');
                console.log('Produk dipilih:', produk.code);
                
                row.item = produk.nama_produk || section.label;
                row.code = produk.code ?? '';
                row.slug = produk.slug ?? '';
                row.nama_produk = produk.nama_produk || section.label;
                row.type = produk.code ?? '';
                row.harga = produk.harga || 0;
                row.harga_display = this.formatCurrency(produk.harga || 0);
                row.qty = '0'; // Default quantity 0
                row.total_harga = 0;
                row.total_harga_display = this.formatCurrency(0);
                
                // Untuk produk dengan dimensi (bukan hollow)
                if (section.kategori !== 'hollow') {
                    console.log('luas_btg produk:', produk.luas_btg);
                    console.log('luas_m2 produk:', produk.luas_m2);
                    console.log('VOL(m²) saat ini:', row.qty_area);
                    
                    row.dimensi = (produk.lebar && produk.tebal && produk.panjang) ? produk.lebar + 'x' + produk.tebal : '';
                    row.panjang = produk.panjang ?? '';
                    row.tebal_panjang = produk.tebal ?? produk.panjang ?? '';
                    row.satuan = produk.satuan ?? '';
                    row.warna = produk.warna ?? '';
                    
                    // Gunakan luas_m2 dari database produk
                    let luas_m2 = produk.luas_m2 || 1;
                    
                    // Jika vol (qty_area) sudah diisi, hitung qty
                    if (row.qty_area && luas_m2 > 0) {
                        const qty = Math.ceil(parseFloat(row.qty_area) / luas_m2);
                        row.qty = qty.toString();
                    }
                } else {
                    // Untuk hollow, tidak ada dimensi dan perhitungan luas
                    row.dimensi = '';
                    row.panjang = '';
                    row.tebal_panjang = '';
                    row.qty_area = '';
                    row.satuan = produk.satuan ?? '';
                    row.warna = produk.warna ?? '';
                }
                
                // Hitung total harga otomatis
                if (row.harga && row.qty) {
                    row.total_harga = (parseFloat(row.harga) * parseFloat(row.qty)).toFixed(2);
                    row.total_harga_display = this.formatCurrency(row.total_harga);
                }
                this.updateCalculations();
                console.log('================================');
            }
        },

        loadClients(userId) {
            if (!userId) {
                // Reset client dropdown jika tidak ada user yang dipilih
                const clientSelect = document.querySelector('select[name="id_client"]');
                    clientSelect.innerHTML = '<option value="" selected>{{ __("Pilih Client") }}</option>';
                return;
            }

            // Fetch clients berdasarkan sales yang dipilih
            fetch(`/admin/penawaran/clients/${userId}`)
                .then(response => response.json())
                .then(clients => {
                    const clientSelect = document.querySelector('select[name="id_client"]');
                    clientSelect.innerHTML = '<option value="" selected>{{ __("Pilih Client") }}</option>';
                    
                    clients.forEach(client => {
                        const option = document.createElement('option');
                        option.value = client.id;
                        option.textContent = client.nama + (client.nama_perusahaan ? ` - ${client.nama_perusahaan}` : '');
                        // Set selected jika ini adalah client yang sudah dipilih sebelumnya
                        if (client.id == {{ $penawaran->id_client ?? 0 }}) {
                            option.selected = true;
                        }
                        clientSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading clients:', error);
                    const clientSelect = document.querySelector('select[name="id_client"]');
                    clientSelect.innerHTML = '<option value="" selected>{{ __("Error loading clients") }}</option>';
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
            // Hollow tidak perlu perhitungan qty dari qty_area
            if (section.kategori === 'hollow') return;
            
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

        calculateSubtotal() {
            // Hitung subtotal dari produk utama saja (tidak termasuk additional condition)
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

        calculateAdditionalConditionTotal() {
            // Hitung total dari additional condition (tidak kena diskon)
            this.additional_condition_total = 0;
            this.additionalConditions.forEach(condition => {
                condition.produk.forEach(produk => {
                    this.additional_condition_total += parseFloat(produk.total_harga) || 0;
                });
            });
            this.calculateTotal();
        },

        calculateTotal() {
            const subtotal = parseFloat(this.subtotal) || 0;
            const diskon = parseFloat(this.diskon) || 0;
            const ppn = parseFloat(this.ppn) || 0;
            const additionalTotal = parseFloat(this.additional_condition_total) || 0;

            // Hitung diskon hanya dari subtotal (produk utama), tidak termasuk additional condition
            const total_diskon = subtotal * (diskon / 100);
            
            // Jika total_diskon_1 sudah di-set manual, hitung diskon_satu dari total_diskon_1
            // Jika tidak, hitung total_diskon_1 dari diskon_satu
            let total_diskon_1, diskon_satu;
            const base_after_diskon_1 = subtotal - total_diskon;
            
            if (this.total_diskon_1_manual !== undefined && this.total_diskon_1_manual !== null) {
                // User sudah input total_diskon_1 manual, hitung diskon_satu
                total_diskon_1 = parseFloat(this.total_diskon_1_manual) || 0;
                if (base_after_diskon_1 > 0) {
                    diskon_satu = (total_diskon_1 / base_after_diskon_1) * 100;
                    // Bulatkan ke 2 desimal
                    diskon_satu = Math.round(diskon_satu * 100) / 100;
                } else {
                    diskon_satu = 0;
                }
                this.diskon_satu = diskon_satu;
            } else {
                // Hitung total_diskon_1 dari diskon_satu
                diskon_satu = parseFloat(this.diskon_satu) || 0;
                total_diskon_1 = base_after_diskon_1 * (diskon_satu / 100);
            }
            
            // Jika total_diskon_2 sudah di-set manual, hitung diskon_dua dari total_diskon_2
            // Jika tidak, hitung total_diskon_2 dari diskon_dua
            let total_diskon_2, diskon_dua;
            const base_after_diskon_2 = base_after_diskon_1 - total_diskon_1;
            
            if (this.total_diskon_2_manual !== undefined && this.total_diskon_2_manual !== null) {
                // User sudah input total_diskon_2 manual, hitung diskon_dua
                total_diskon_2 = parseFloat(this.total_diskon_2_manual) || 0;
                if (base_after_diskon_2 > 0) {
                    diskon_dua = (total_diskon_2 / base_after_diskon_2) * 100;
                    // Bulatkan ke 2 desimal
                    diskon_dua = Math.round(diskon_dua * 100) / 100;
                } else {
                    diskon_dua = 0;
                }
                this.diskon_dua = diskon_dua;
            } else {
                // Hitung total_diskon_2 dari diskon_dua
                diskon_dua = parseFloat(this.diskon_dua) || 0;
                total_diskon_2 = base_after_diskon_2 * (diskon_dua / 100);
            }
            
            // Simpan nilai diskon ke properti Alpine.js
            this.total_diskon = total_diskon;
            this.total_diskon_1 = total_diskon_1;
            this.total_diskon_2 = total_diskon_2;
            this.total_diskon_all = total_diskon + total_diskon_1 + total_diskon_2;
            this.after_diskon = subtotal - this.total_diskon_all;
            
            // Hitung PPN dari (after_diskon + additional condition total)
            // PPN dikenakan pada total setelah diskon + additional condition
            const total_sebelum_ppn = this.after_diskon + additionalTotal;
            const ppn_nominal = total_sebelum_ppn * (ppn / 100);
            
            // Grand total = (subtotal setelah diskon + additional condition) + PPN
            // Additional condition tidak kena diskon, tapi kena PPN
            this.grand_total = Math.round(total_sebelum_ppn + ppn_nominal);
        },

        handleTotalDiskon1Input(event) {
            const numericValue = this.parseCurrency(event.target.value);
            if (numericValue !== '') {
                this.total_diskon_1_manual = parseFloat(numericValue) || 0;
            } else {
                this.total_diskon_1_manual = null;
            }
            this.calculateTotal();
        },

        handleTotalDiskon2Input(event) {
            const numericValue = this.parseCurrency(event.target.value);
            if (numericValue !== '') {
                this.total_diskon_2_manual = parseFloat(numericValue) || 0;
            } else {
                this.total_diskon_2_manual = null;
            }
            this.calculateTotal();
        },

        handleDiskon1Input(event) {
            const value = parseFloat(event.target.value) || 0;
            // Bulatkan ke 2 desimal
            this.diskon_satu = Math.round(value * 100) / 100;
            this.total_diskon_1_manual = null;
            this.calculateTotal();
        },

        handleDiskon2Input(event) {
            const value = parseFloat(event.target.value) || 0;
            // Bulatkan ke 2 desimal
            this.diskon_dua = Math.round(value * 100) / 100;
            this.total_diskon_2_manual = null;
            this.calculateTotal();
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

        // Konversi data dari format database ke format template (synchronous)
        convertDatabaseDataSync(rawData) {
            console.log('=== DEBUG CONVERT DATABASE DATA SYNC ===');
            console.log('Raw Data:', rawData);
            console.log('Section Options:', this.sectionOptions);
            
            if (rawData && rawData.length > 0) {
                const convertedData = rawData.map(mainSection => {
                    // Konversi product_sections ke productSections
                    if (mainSection.product_sections) {
                        const productSections = [];
                        
                        Object.keys(mainSection.product_sections).forEach(kategori => {
                            const produkArray = mainSection.product_sections[kategori];
                            const sectionOption = this.sectionOptions.find(opt => opt.kategori === kategori);
                            
                            console.log('Kategori:', kategori);
                            console.log('Produk Array:', produkArray);
                            console.log('Section Option:', sectionOption);
                            console.log('Master produk tersedia:', sectionOption ? sectionOption.master.length : 'TIDAK ADA');
                            
                            if (sectionOption && produkArray) {
                                const convertedSection = {
                                    kategori: kategori,
                                    label: sectionOption.label,
                                    master: sectionOption.master,
                                    produk: produkArray.map(produk => {
                                        // Cari produk yang sesuai di master berdasarkan code/type
                                        const masterProduk = sectionOption.master.find(mp => 
                                            mp.code === produk.type || 
                                            mp.slug === produk.type ||
                                            mp.nama_produk === produk.item
                                        );
                                        
                                        // Debug: Log pencarian produk
                                        console.log('=== DEBUG PENCARIAN PRODUK SYNC ===');
                                        console.log('Produk dari DB:', produk.item, produk.type);
                                        console.log('Master produk yang tersedia:', sectionOption.master.map(mp => ({ code: mp.code, slug: mp.slug, nama: mp.nama_produk })));
                                        console.log('Master produk yang ditemukan:', masterProduk);
                                        console.log('Slug yang akan digunakan:', masterProduk ? masterProduk.slug : 'TIDAK DITEMUKAN');
                                        console.log('================================');
                                        
                                        // Jika tidak ditemukan di master, coba cari berdasarkan dimensi dan nama
                                        let finalSlug = masterProduk ? masterProduk.slug : null;
                                        if (!finalSlug) {
                                            const produkByDimensi = sectionOption.master.find(mp => {
                                                // Cari berdasarkan dimensi yang mirip
                                                const dbDimensi = produk.dimensi || '';
                                                const masterDimensi = mp.lebar && mp.tebal ? `${mp.lebar}x${mp.tebal}` : '';
                                                return masterDimensi === dbDimensi && mp.nama_produk.toLowerCase().includes('wallpanel');
                                            });
                                            if (produkByDimensi) {
                                                finalSlug = produkByDimensi.slug;
                                                console.log('Produk ditemukan berdasarkan dimensi:', produkByDimensi);
                                            }
                                        }
                                        
                                        return {
                                            item: produk.item || '',
                                            code: produk.type || '',
                                            slug: finalSlug || produk.type, // Gunakan slug yang ditemukan
                                            nama_produk: produk.item || '',
                                            type: produk.type || '',
                                            dimensi: produk.dimensi || '',
                                            panjang: produk.panjang || '',
                                            finishing: produk.finishing || '',
                                            tebal_panjang: produk.tebal_panjang || '',
                                            qty_area: produk.qty_area || '',
                                            qty: produk.qty || '0',
                                            satuan: produk.satuan || '',
                                            warna: produk.warna || '',
                                            harga: parseFloat(produk.harga) || 0,
                                            harga_display: this.formatCurrency(parseFloat(produk.harga) || 0),
                                            total_harga: parseFloat(produk.total_harga) || 0,
                                            total_harga_display: this.formatCurrency(parseFloat(produk.total_harga) || 0)
                                        };
                                    })
                                };
                                
                                productSections.push(convertedSection);
                            }
                        });
                        
                        return {
                            ...mainSection,
                            productSections: productSections
                        };
                    }
                    
                    return mainSection;
                });
                
                console.log('=== HASIL KONVERSI SYNC ===');
                console.log('Data yang dikonversi:', convertedData);
                console.log('================================');
                
                return convertedData;
            }
            
            return [];
        },

        // Konversi data dari format database ke format template (legacy method)
        convertDatabaseData() {
            console.log('=== DEBUG CONVERT DATABASE DATA ===');
            console.log('Main Sections:', this.mainSections);
            console.log('Section Options:', this.sectionOptions);
            
            if (this.mainSections && this.mainSections.length > 0) {
                this.mainSections.forEach(mainSection => {
                    // Konversi product_sections ke productSections
                    if (mainSection.product_sections) {
                        mainSection.productSections = [];
                        
                        Object.keys(mainSection.product_sections).forEach(kategori => {
                            const produkArray = mainSection.product_sections[kategori];
                            const sectionOption = this.sectionOptions.find(opt => opt.kategori === kategori);
                            
                            console.log('Kategori:', kategori);
                            console.log('Produk Array:', produkArray);
                            console.log('Section Option:', sectionOption);
                            console.log('Master produk tersedia:', sectionOption ? sectionOption.master.length : 'TIDAK ADA');
                            
                            if (sectionOption && produkArray) {
                                const convertedSection = {
                                    kategori: kategori,
                                    label: sectionOption.label,
                                    master: sectionOption.master,
                                    produk: produkArray.map(produk => {
                                        // Cari produk yang sesuai di master berdasarkan code/type
                                        const masterProduk = sectionOption.master.find(mp => 
                                            mp.code === produk.type || 
                                            mp.slug === produk.type ||
                                            mp.nama_produk === produk.item
                                        );
                                        
                                        // Debug: Log pencarian produk
                                        console.log('=== DEBUG PENCARIAN PRODUK ===');
                                        console.log('Produk dari DB:', produk.item, produk.type);
                                        console.log('Master produk yang tersedia:', sectionOption.master.map(mp => ({ code: mp.code, slug: mp.slug, nama: mp.nama_produk })));
                                        console.log('Master produk yang ditemukan:', masterProduk);
                                        console.log('Slug yang akan digunakan:', masterProduk ? masterProduk.slug : 'TIDAK DITEMUKAN');
                                        console.log('================================');
                                        
                                        // Jika tidak ditemukan di master, coba cari berdasarkan dimensi dan nama
                                        let finalSlug = masterProduk ? masterProduk.slug : null;
                                        if (!finalSlug) {
                                            const produkByDimensi = sectionOption.master.find(mp => {
                                                // Cari berdasarkan dimensi yang mirip
                                                const dbDimensi = produk.dimensi || '';
                                                const masterDimensi = mp.lebar && mp.tebal ? `${mp.lebar}x${mp.tebal}` : '';
                                                return masterDimensi === dbDimensi && mp.nama_produk.toLowerCase().includes('wallpanel');
                                            });
                                            if (produkByDimensi) {
                                                finalSlug = produkByDimensi.slug;
                                                console.log('Produk ditemukan berdasarkan dimensi:', produkByDimensi);
                                            }
                                        }
                                        
                                        return {
                                            item: produk.item || '',
                                            code: produk.type || '',
                                            slug: finalSlug || produk.type, // Gunakan slug yang ditemukan
                                            nama_produk: produk.item || '',
                                            type: produk.type || '',
                                            dimensi: produk.dimensi || '',
                                            panjang: produk.panjang || '',
                                            finishing: produk.finishing || '',
                                            tebal_panjang: produk.tebal_panjang || '',
                                            qty_area: produk.qty_area || '',
                                            qty: produk.qty || '0',
                                            satuan: produk.satuan || '',
                                            harga: parseFloat(produk.harga) || 0,
                                            harga_display: this.formatCurrency(parseFloat(produk.harga) || 0),
                                            total_harga: parseFloat(produk.total_harga) || 0,
                                            total_harga_display: this.formatCurrency(parseFloat(produk.total_harga) || 0)
                                        };
                                    })
                                };
                                
                                mainSection.productSections.push(convertedSection);
                            }
                        });
                        
                        // Hapus product_sections lama
                        delete mainSection.product_sections;
                    }
                });
            }
            
            console.log('=== HASIL KONVERSI ===');
            console.log('Main Sections setelah konversi:', this.mainSections);
            
            // Debug: Lihat field slug untuk setiap produk
            this.mainSections.forEach((mainSection, mainIdx) => {
                if (mainSection.productSections) {
                    mainSection.productSections.forEach((section, sIdx) => {
                        if (section.produk) {
                            section.produk.forEach((produk, pIdx) => {
                                console.log(`Produk ${mainIdx}-${sIdx}-${pIdx}:`, {
                                    item: produk.item,
                                    type: produk.type,
                                    slug: produk.slug,
                                    nama_produk: produk.nama_produk
                                });
                            });
                        }
                    });
                }
            });
            console.log('================================');
        },

        updateCalculations() {
            this.calculateSubtotal();
        },

        // Additional Condition Functions
        addAdditionalCondition() {
            const defaultLabel = `Additional Condition ${this.additionalConditions.length + 1}`;
            this.additionalConditions.push({
                label: defaultLabel,
                produk: [{
                    item: '',
                    code: '',
                    slug: '',
                    nama_produk: '',
                    satuan: '',
                    qty_area: '',
                    satuan_vol: '',
                    qty: '0',
                    harga: 0,
                    harga_display: 'Rp 0',
                    total_harga: 0,
                    total_harga_display: 'Rp 0'
                }]
            });
        },

        removeAdditionalCondition(index) {
            this.additionalConditions.splice(index, 1);
            // Update total setelah hapus condition
            this.calculateAdditionalConditionTotal();
        },

        addAdditionalProduk(condIdx) {
            this.additionalConditions[condIdx].produk.push({
                item: '',
                code: '',
                slug: '',
                nama_produk: '',
                satuan: '',
                qty_area: '',
                satuan_vol: '',
                qty: '0',
                harga: 0,
                harga_display: 'Rp 0',
                total_harga: 0,
                total_harga_display: 'Rp 0'
            });
        },

        removeAdditionalProduk(condIdx, productIdx) {
            this.additionalConditions[condIdx].produk.splice(productIdx, 1);
            // Update total setelah hapus
            this.calculateAdditionalConditionTotal();
        },

        getAvailableHollows(condition, row) {
            // Untuk revisi, tampilkan semua hollow termasuk yang sudah dipilih
            // Agar dropdown bisa menampilkan nilai yang sudah ter-set
            const selectedSlugs = condition.produk
                .filter(p => p.slug && p.slug !== row.slug) // Exclude current row
                .map(p => p.slug);
            
            // Filter hollow, tapi selalu include hollow yang sudah dipilih di row ini
            return this.hollows.filter(hollow => {
                // Jika hollow ini sudah dipilih di row ini, selalu tampilkan
                if (row.slug && hollow.slug === row.slug) {
                    return true;
                }
                // Jika hollow ini sudah dipilih di row lain, jangan tampilkan
                return !selectedSlugs.includes(hollow.slug);
            });
        },

        autofillAdditionalProduk(condition, row) {
            if (!row.slug) return;
            const hollow = this.hollows.find(h => h.slug === row.slug);
            if (hollow) {
                row.item = hollow.nama_produk || '';
                row.code = hollow.code ?? '';
                row.slug = hollow.slug ?? '';
                row.nama_produk = hollow.nama_produk || '';
                row.satuan = hollow.satuan || '';
                row.harga = hollow.harga || 0;
                row.harga_display = this.formatCurrency(hollow.harga || 0);
                row.qty = '0';
                row.total_harga = 0;
                row.total_harga_display = this.formatCurrency(0);
                // Update total setelah autofill
                this.calculateAdditionalConditionTotal();
            }
        },

        calculateAdditionalTotalHarga(row) {
            if (!row.qty || !row.harga) return;
            row.total_harga = row.qty * row.harga;
            row.total_harga_display = this.formatCurrency(row.total_harga);
            // Update total additional condition dan recalculate grand total
            this.calculateAdditionalConditionTotal();
        },

        formatAdditionalHargaInput(row) {
            const numericValue = this.parseCurrency(row.harga_display);
            if (numericValue) {
                row.harga = numericValue;
                row.harga_display = this.formatInputCurrency(numericValue);
                this.calculateAdditionalTotalHarga(row);
            }
        },

        formatAdditionalTotalHargaInput(row) {
            const numericValue = this.parseCurrency(row.total_harga_display);
            if (numericValue) {
                row.total_harga = numericValue;
                row.total_harga_display = this.formatInputCurrency(numericValue);
            }
        },

        refreshAllProduk() {
            let refreshedCount = 0;
            let notFoundCount = 0;

            this.mainSections.forEach(mainSection => {
                mainSection.productSections.forEach(section => {
                    section.produk.forEach(row => {
                        if (!row.slug) return;

                        // Cari produk terbaru dari master berdasarkan slug
                        const produk = section.master.find(p => p.slug === row.slug);
                        if (!produk) {
                            notFoundCount++;
                            return;
                        }

                        // Simpan data yang sudah diisi user (jangan diubah)
                        const savedQty = row.qty || '0';
                        const savedQtyArea = row.qty_area || '';
                        const savedFinishing = row.finishing || '';

                        // Update informasi produk dari database
                        row.item = produk.nama_produk || section.label;
                        row.code = produk.code ?? '';
                        row.nama_produk = produk.nama_produk || section.label;
                        row.type = produk.code ?? '';
                        row.harga = produk.harga || 0;
                        row.harga_display = this.formatCurrency(produk.harga || 0);
                        row.satuan = produk.satuan || '';
                        row.warna = produk.warna || '';

                        // Update dimensi jika bukan hollow
                        if (section.kategori !== 'hollow') {
                            row.dimensi = (produk.lebar && produk.tebal && produk.panjang) ? produk.lebar + 'x' + produk.tebal : '';
                            row.panjang = produk.panjang ?? '';
                            row.tebal_panjang = produk.tebal ?? produk.panjang ?? '';

                            // Jika qty_area sudah ada, hitung ulang qty berdasarkan luas_m2 baru
                            if (savedQtyArea) {
                                let luas_m2 = produk.luas_m2 || 1;
                                if (luas_m2 > 0) {
                                    const qty = Math.ceil(parseFloat(savedQtyArea) / luas_m2);
                                    row.qty = qty.toString();
                                } else {
                                    row.qty = savedQty;
                                }
                            } else {
                                row.qty = savedQty;
                            }
                        } else {
                            // Untuk hollow, tetap gunakan qty yang sudah diisi
                            row.qty = savedQty;
                            row.dimensi = '';
                            row.panjang = '';
                            row.tebal_panjang = '';
                            row.qty_area = '';
                        }

                        // Kembalikan finishing yang sudah diisi user
                        row.finishing = savedFinishing;

                        // Hitung ulang total harga dengan harga baru
                        if (row.harga && row.qty) {
                            row.total_harga = (parseFloat(row.harga) * parseFloat(row.qty)).toFixed(2);
                            row.total_harga_display = this.formatCurrency(row.total_harga);
                        }

                        refreshedCount++;
                    });
                });
            });

            // Update perhitungan setelah refresh
            this.updateCalculations();

            // Tampilkan notifikasi
            if (refreshedCount > 0) {
                alert(`Berhasil refresh ${refreshedCount} produk${notFoundCount > 0 ? `\n${notFoundCount} produk tidak ditemukan` : ''}`);
            } else {
                alert('Tidak ada produk yang bisa di-refresh. Pastikan produk sudah dipilih.');
            }
        },

        refreshAllAdditionalProduk() {
            // Fetch data hollow terbaru dari server
            const url = '/admin/penawaran/hollows';
            console.log('Fetching from:', url);
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);
                    
                    if (!response.ok) {
                        // Coba baca response sebagai text untuk melihat error
                        return response.text().then(text => {
                            console.error('Error response:', text);
                            throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}`);
                        });
                    }
                    
                    // Cek content type
                    const contentType = response.headers.get('content-type');
                    console.log('Content-Type:', contentType);
                    
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            console.error('Response is not JSON:', text);
                            throw new Error('Response is not JSON');
                        });
                    }
                    
                    return response.json();
                })
                .then(hollowsData => {
                    console.log('Hollows data received:', hollowsData);
                    console.log('Number of hollows:', hollowsData?.length || 0);
                    
                    if (!Array.isArray(hollowsData)) {
                        console.error('Invalid data format:', hollowsData);
                        throw new Error('Data format tidak valid');
                    }
                    
                    // Update this.hollows dengan data terbaru dari server
                    this.hollows = hollowsData;
                    
                    let refreshedCount = 0;
                    let notFoundCount = 0;

                    this.additionalConditions.forEach(condition => {
                        condition.produk.forEach(row => {
                            if (!row.slug) return;

                            // Cari hollow terbaru dari data yang baru di-fetch
                            const hollow = this.hollows.find(h => h.slug === row.slug);
                            if (!hollow) {
                                notFoundCount++;
                                return;
                            }

                            // Simpan data yang sudah diisi user (jangan diubah)
                            const savedQty = row.qty || '0';
                            const savedQtyArea = row.qty_area || '';
                            const savedSatuanVol = row.satuan_vol || '';

                            // Update informasi hollow dari data terbaru (dari server)
                            row.item = hollow.nama_produk || '';
                            row.code = hollow.code ?? '';
                            row.nama_produk = hollow.nama_produk || '';
                            row.satuan = hollow.satuan || '';
                            row.harga = parseFloat(hollow.harga) || 0;
                            row.harga_display = this.formatCurrency(row.harga);

                            // Tetap gunakan qty, qty_area, dan satuan_vol yang sudah diisi user
                            row.qty = savedQty;
                            row.qty_area = savedQtyArea;
                            row.satuan_vol = savedSatuanVol;

                            // Hitung ulang total harga dengan harga baru
                            if (row.harga && row.qty) {
                                row.total_harga = parseFloat(row.harga) * parseFloat(row.qty);
                                row.total_harga_display = this.formatCurrency(row.total_harga);
                            }

                            refreshedCount++;
                        });
                    });

                    // Update perhitungan setelah refresh
                    this.calculateAdditionalConditionTotal();

                    // Tampilkan notifikasi
                    if (refreshedCount > 0) {
                        alert(`Berhasil refresh ${refreshedCount} aksesoris${notFoundCount > 0 ? `\n${notFoundCount} aksesoris tidak ditemukan` : ''}`);
                    } else {
                        alert('Tidak ada aksesoris yang bisa di-refresh. Pastikan aksesoris sudah dipilih.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching hollows:', error);
                    console.error('Error message:', error.message);
                    console.error('Error stack:', error.stack);
                    alert('Gagal mengambil data terbaru dari server.\n\nError: ' + error.message + '\n\nCek console untuk detail lebih lanjut.');
                });
        }
    }
}
</script> 