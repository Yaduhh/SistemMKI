<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Buat Penawaran Pintu</h1>
            <x-button as="a" href="{{ route('admin.penawaran-pintu.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Kembali ke Daftar
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-4 mx-auto w-full">
        <form action="{{ route('admin.penawaran-pintu.store') }}" method="POST" class="space-y-8" x-data="penawaranForm()">
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
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Penawaran Pintu</h2>
                <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                        <x-icon name="info" class="w-4 h-4 inline mr-1" />
                        Nomor penawaran pintu akan dibuat otomatis dengan format: <strong>A/MKI/MM/YY</strong>
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Client -->
                    <flux:select name="id_client" :label="__('Client')" required>
                        <option value="" disabled selected>{{ __('Pilih Client') }}</option>
                    </flux:select>
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" x-data="{ today: new Date().toISOString().split('T')[0] }" x-bind:min="today" />
                    <flux:input name="judul_penawaran" label="Judul Penawaran" placeholder="masukkan judul penawaran pintu" type="text" required class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                    <flux:input name="project" label="Project" placeholder="Nama Project (opsional)" type="text" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
                </div>
            </div>

            <!-- Section Produk Pintu -->
            <div class="w-full border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-white dark:bg-zinc-900">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Produk Pintu</h2>
                    <button type="button" @click="addPintuProduk()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <x-icon name="plus" class="w-4 h-4" /> Tambah Produk Pintu
                    </button>
                </div>
                
                <template x-if="pintuData.length > 0">
                    <template x-for="(pintu, index) in pintuData" :key="index">
                        <div class="border-2 border-gray-200 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800 mb-4">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-semibold text-gray-900 dark:text-white">Produk Pintu #<span x-text="index + 1"></span></h4>
                                <button type="button" @click="removePintuProduk(index)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                    <x-icon name="trash" class="w-5 h-5" />
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Produk Pintu -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Produk Pintu</label>
                                    <select :name="'json_penawaran_pintu[' + index + '][item]'" x-model="pintu.slug" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" @change="autofillPintu(pintu)">
                                        <option value="">Pilih Produk Pintu</option>
                                        <template x-for="p in products.pintu" :key="p.slug">
                                            <option :value="p.slug" x-text="p.code + ' - ' + p.nama_produk + ' (' + p.lebar + 'x' + p.tebal + 'x' + p.tinggi + ' cm) - Rp ' + (p.harga_satuan ? p.harga_satuan.toLocaleString('id-ID') : '0')"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <!-- Dimensi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dimensi</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <input type="text" :name="'json_penawaran_pintu[' + index + '][lebar]'" x-model="pintu.lebar" placeholder="L" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                        <input type="text" :name="'json_penawaran_pintu[' + index + '][tebal]'" x-model="pintu.tebal" placeholder="T" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                        <input type="text" :name="'json_penawaran_pintu[' + index + '][tinggi]'" x-model="pintu.tinggi" placeholder="H" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                    </div>
                                </div>
                                
                                <!-- Warna -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna</label>
                                    <input type="text" :name="'json_penawaran_pintu[' + index + '][warna]'" x-model="pintu.warna" placeholder="Warna" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                </div>
                                
                                <!-- Harga -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga</label>
                                    <input type="text" :name="'json_penawaran_pintu[' + index + '][harga]'" x-model="pintu.harga_display" placeholder="Harga" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <!-- Jumlah -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah</label>
                                    <input type="number" :name="'json_penawaran_pintu[' + index + '][jumlah]'" x-model="pintu.jumlah" placeholder="Jumlah" min="1" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" @input="calculatePintuTotal(pintu)" />
                                </div>
                                
                                <!-- Total Harga -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Harga</label>
                                    <input type="text" :name="'json_penawaran_pintu[' + index + '][total_harga]'" x-model="pintu.total_harga_display" placeholder="Total Harga" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
            </div>

            <!-- Section Produk Lainnya -->
            <div class="w-full border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-white dark:bg-zinc-900">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Produk Lainnya</h2>
                    <button type="button" @click="addMainSection()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <x-icon name="plus" class="w-4 h-4" /> Tambah Section
                    </button>
                </div>
                
                <div id="main-sections-container" class="space-y-6">
                    <!-- Main sections will be added here dynamically -->
                </div>
            </div>

            <!-- Section Syarat & Ketentuan -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Syarat & Ketentuan</h2>
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($syaratKetentuan as $syarat)
                        <div class="flex items-center">
                            <input type="checkbox" name="syarat_kondisi[]" value="{{ $syarat->id }}" 
                                id="syarat_{{ $syarat->id }}" 
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="syarat_{{ $syarat->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ $syarat->syarat }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section Catatan -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catatan</h2>
                <flux:textarea name="catatan" label="Catatan" placeholder="Masukkan catatan tambahan (opsional)" rows="4" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3">
                    <x-icon name="save" class="w-4 h-4 mr-2" />
                    Simpan Penawaran Pintu
                </x-button>
            </div>
        </form>
    </div>

    <script>
        function penawaranForm() {
            return {
                mainSections: [],
                pintuProduk: [],
                products: {
                    pintu: @json($pintus)
                },

                init() {
                    this.addMainSection();
                    this.addPintuProduk();
                },

                loadClients(salesId) {
                    if (!salesId) return;
                    
                    fetch(`/admin/penawaran-pintu/clients/${salesId}`)
                        .then(response => response.json())
                        .then(clients => {
                            const clientSelect = document.querySelector('select[name="id_client"]');
                            clientSelect.innerHTML = '<option value="" disabled selected>Pilih Client</option>';
                            
                            clients.forEach(client => {
                                const option = document.createElement('option');
                                option.value = client.id;
                                option.textContent = client.nama_perusahaan || client.nama;
                                clientSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading clients:', error);
                        });
                },

                pintuProduk: [],
                pintuData: [],

                addPintuProduk() {
                    const newPintu = {
                        item: '',
                        code: '',
                        slug: '',
                        nama_produk: '',
                        lebar: '',
                        tebal: '',
                        tinggi: '',
                        warna: '',
                        harga: 0,
                        harga_display: 'Rp 0',
                        jumlah: 1,
                        total_harga: 0,
                        total_harga_display: 'Rp 0'
                    };
                    this.pintuData.push(newPintu);
                },

                removePintuProduk(index) {
                    this.pintuData.splice(index, 1);
                },

                autofillPintu(pintu) {
                    if (!pintu.slug) return;
                    
                    const produk = this.products.pintu.find(p => p.slug === pintu.slug);
                    if (produk) {
                        console.log('=== DEBUG AUTOFILL PINTU ===');
                        console.log('Produk dipilih:', produk.code);
                        
                        pintu.item = produk.nama_produk || '';
                        pintu.code = produk.code || '';
                        pintu.slug = produk.slug || '';
                        pintu.nama_produk = produk.nama_produk || '';
                        pintu.lebar = produk.lebar ? produk.lebar + ' cm' : '';
                        pintu.tebal = produk.tebal ? produk.tebal + ' cm' : '';
                        pintu.tinggi = produk.tinggi ? produk.tinggi + ' cm' : '';
                        pintu.warna = produk.warna || '';
                        pintu.harga = produk.harga_satuan || 0;
                        pintu.harga_display = this.formatCurrency(produk.harga_satuan || 0);
                        
                        // Hitung total harga otomatis
                        this.calculatePintuTotal(pintu);
                        console.log('================================');
                    }
                },

                calculatePintuTotal(pintu) {
                    if (pintu.harga && pintu.jumlah) {
                        pintu.total_harga = (parseFloat(pintu.harga) * parseFloat(pintu.jumlah)).toFixed(2);
                        pintu.total_harga_display = this.formatCurrency(pintu.total_harga);
                    }
                },

                formatCurrency(amount) {
                    return 'Rp ' + parseFloat(amount || 0).toLocaleString('id-ID');
                },

                addMainSection() {
                    const container = document.getElementById('main-sections-container');
                    const mainIndex = this.mainSections.length;
                    
                    const sectionDiv = document.createElement('div');
                    sectionDiv.className = 'border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-white dark:bg-zinc-900';
                    sectionDiv.innerHTML = `
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Section ${mainIndex + 1}</h3>
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Section
                            </button>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Section</label>
                            <input name="json_produk[${mainIndex}][judul]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Masukkan judul section" />
                        </div>
                        <div class="space-y-4">
                            <button type="button" onclick="addProductSection(${mainIndex})" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                                <x-icon name="plus" class="w-4 h-4" /> Tambah Sub Section
                            </button>
                            <div id="product-sections-${mainIndex}" class="space-y-4">
                                <!-- Product sections will be added here -->
                            </div>
                        </div>
                    `;
                    
                    container.appendChild(sectionDiv);
                    this.mainSections.push({ element: sectionDiv, productSections: [] });
                }
            }
        }


    </script>
</x-layouts.app>
