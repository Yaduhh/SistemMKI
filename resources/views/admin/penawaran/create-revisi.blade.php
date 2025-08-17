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
                <option value="" disabled>{{ __('Pilih Pengguna') }}</option>
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
                        <option value="" disabled>{{ __('Pilih Client') }}</option>
                        @if($penawaran->client)
                            <option value="{{ $penawaran->client->id }}" selected>{{ $penawaran->client->nama ?? $penawaran->client->nama_perusahaan }}</option>
                        @endif
                    </flux:select>
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" x-data="{ today: new Date().toISOString().split('T')[0] }" x-bind:min="today" value="{{ old('tanggal_penawaran', date('Y-m-d')) }}" />
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
                                                                <option :value="p.slug" :selected="p.slug === row.slug" x-text="p.code + ' - ' + (p.lebar ? p.lebar + 'x' + (p.tebal ?? '') + 'x' + (p.panjang ?? '') : '') + (p.warna ? ' - ' + p.warna : '') + ' (Rp ' + (p.harga ? p.harga.toLocaleString('id-ID') : '0') + ')'"></option>
                                                            </template>
                                                        </select>
                                                    </div>

                                                    <!-- Type/Code -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type/Code</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][type]'" x-model="row.type" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Type/Code" readonly />
                                                    </div>

                                                    <!-- Nama Produk -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Produk</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][nama_produk]'" x-model="row.nama_produk" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Nama Produk" />
                                                    </div>

                                                    <!-- Dimensi -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dimensi</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][dimensi]'" x-model="row.dimensi" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Dimensi" readonly />
                                                    </div>



                                                    <!-- Finishing -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Finishing</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][finishing]'" x-model="row.finishing" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Finishing" />
                                                    </div>

                                                    <!-- Tebal/Panjang -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tebal/Panjang</label>
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][tebal_panjang]'" x-model="row.tebal_panjang" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Tebal/Panjang" readonly />
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
                                                        <input :name="'json_produk[' + mainIdx + '][product_sections][' + section.kategori + '][' + i + '][panjang]'" x-model="row.panjang" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Panjang" />
                                                    </div>

                                                    <!-- Harga -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga</label>
                                                        <input x-model="row.harga_display" @input="formatHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Rp 0" readonly />
                                                    </div>

                                                    <!-- Total -->
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total</label>
                                                        <input x-model="row.total_harga_display" @input="formatTotalHargaInput(row)" type="text" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" placeholder="Rp 0" readonly />
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
                <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subtotal</label>
                            <input type="text" x-model="formatCurrency(subtotal)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" />
                            <input type="hidden" name="total" :value="subtotal" value="{{ old('total', $penawaran->total ?? 0) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon (%)</label>
                            <input type="number" name="diskon" x-model="diskon" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('diskon', $penawaran->diskon ?? 0) }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 1 (%)</label>
                            <input type="number" name="diskon_satu" x-model="diskon_satu" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('diskon_satu', $penawaran->diskon_satu ?? 0) }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 2 (%)</label>
                            <input type="number" name="diskon_dua" x-model="diskon_dua" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('diskon_dua', $penawaran->diskon_dua ?? 0) }}" />
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
                            <input type="number" name="ppn" x-model="ppn" @input="calculateTotal" step="0.01" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('ppn', $penawaran->ppn ?? 11) }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Grand Total</label>
                            <input type="text" x-model="formatCurrency(grand_total)" readonly class="w-full py-2 px-3 rounded-lg border-2 border-blue-500 dark:border-blue-400 dark:bg-zinc-800 dark:text-white font-bold text-lg text-blue-600 dark:text-blue-400" />
                            <input type="hidden" name="grand_total" :value="grand_total" value="{{ old('grand_total', $penawaran->grand_total ?? 0) }}">
                            <input type="hidden" name="total_diskon" :value="total_diskon" value="{{ old('total_diskon', $penawaran->total_diskon ?? 0) }}">
                            <input type="hidden" name="total_diskon_1" :value="total_diskon_1" value="{{ old('total_diskon_1', $penawaran->total_diskon_1 ?? 0) }}">
                            <input type="hidden" name="total_diskon_2" :value="total_diskon_2" value="{{ old('total_diskon_2', $penawaran->total_diskon_2 ?? 0) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Catatan -->
            <div class="w-full">
                <flux:input name="catatan" label="Catatan" placeholder="Tambahkan catatan jika diperlukan" type="textarea" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ old('catatan', $penawaran->catatan) }}" />
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
        sectionOptions: [
            { kategori: 'flooring', label: 'FLOORING', master: @json($floorings) },
            { kategori: 'facade', label: 'FACADE', master: @json($facades) },
            { kategori: 'wallpanel', label: 'WALLPANEL', master: @json($wallpanels) },
            { kategori: 'ceiling', label: 'CEILING', master: @json($ceilings) },
            { kategori: 'decking', label: 'DECKING', master: @json($deckings) },
        ],
        

        subtotal: {{ $penawaran->total ?? 0 }},
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

        // Inisialisasi data saat halaman dimuat
        init() {
            console.log('=== INIT METHOD DIPANGGIL ===');
            
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
            
            // Tunggu sampai DOM selesai di-render
            this.$nextTick(() => {
                console.log('=== SETELAH $NEXTTICK ===');
                console.log('Data setelah konversi:', this.mainSections);
                
                this.calculateSubtotal();
                this.calculateTotal();
                
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
                row.qty = '0'; // Default quantity 0
                row.total_harga = 0;
                row.total_harga_display = this.formatCurrency(0);
                
                // Gunakan luas_m2 dari database produk
                let luas_m2 = produk.luas_m2 || 1;
                
                // Jika vol (qty_area) sudah diisi, hitung qty
                if (row.qty_area && luas_m2 > 0) {
                    const qty = Math.ceil(parseFloat(row.qty_area) / luas_m2);
                    row.qty = qty.toString();
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
                    clientSelect.innerHTML = '<option value="" disabled selected>{{ __("Error loading clients") }}</option>';
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
        }
    }
}
</script> 