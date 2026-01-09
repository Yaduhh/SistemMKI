<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Buat Revisi Penawaran Pintu</h1>
            <x-button as="a" href="{{ route('admin.penawaran-pintu.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white">
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
                    Revisi dari Penawaran Pintu Revisi
                @else
                    Revisi dari Penawaran Pintu Asli
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
                <span class="text-blue-800 dark:text-blue-200">Ini adalah revisi dari penawaran pintu yang sudah direvisi sebelumnya. Revisi berikutnya akan menjadi R{{ preg_match('/R(\d+)$/', $penawaran->nomor_penawaran, $matches) ? $matches[1] + 1 : '?' }}.</span>
            </div>
        @endif
    </div>

    <div class="py-4 mx-auto w-full">
        <form action="{{ route('admin.penawaran-pintu.store-revisi', $penawaran) }}" method="POST" class="space-y-8"
            x-data="penawaranForm()" id="penawaran-form">
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
                        @php
                            $nomorAsli = preg_replace('/\s+R\d+$/', '', $penawaran->nomor_penawaran);
                            $currentRevision = preg_match('/R(\d+)$/', $penawaran->nomor_penawaran, $matches) ? (int)$matches[1] : 0;
                            $nextRevision = $currentRevision + 1;
                    $suggestedNomor = $nomorAsli . ' R' . $nextRevision;
                        @endphp
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Penawaran Pintu</h2>
                <div
                    class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                        <x-icon name="info" class="w-4 h-4 inline mr-1" />
                        Format nomor revisi yang disarankan: <strong>{{ $suggestedNomor }}</strong>
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
                    <!-- Nomor Penawaran -->
                    <div>
                        <flux:input name="nomor_penawaran" label="Nomor Penawaran"
                            placeholder="Masukkan nomor penawaran (contoh: A/MKI/01/25 R1)" type="text" required
                            class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                            value="{{ old('nomor_penawaran', $suggestedNomor) }}" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Format yang disarankan: <span class="font-medium">{{ $suggestedNomor }}</span>
                        </p>
                    </div>
                    <flux:input name="judul_penawaran" label="Judul Penawaran"
                        placeholder="masukkan judul penawaran pintu" type="text" required
                        class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ old('judul_penawaran', $penawaran->judul_penawaran) }}" />
                    <flux:input name="project" label="Project" placeholder="Nama Project (opsional)" type="text"
                        class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ old('project', $penawaran->project) }}" />
                    <flux:input name="tanggal_penawaran" label="Tanggal Penawaran" type="date" required
                        class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                        value="{{ old('tanggal_penawaran', date('Y-m-d')) }}" />
                 </div>


            </div>

            <!-- Section Produk Pintu -->
            <div class="w-full">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Produk Pintu</h2>
                    <button type="button" @click="addPintuSection()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <x-icon name="plus" class="w-4 h-4" /> Tambah Section Pintu
                    </button>
                </div>

                <!-- Container untuk sections -->
                <div id="pintu-sections-container" class="space-y-6">
                    <!-- Sections akan ditambahkan di sini -->
                </div>

                <!-- Template untuk sections akan dirender di sini oleh JavaScript -->
            </div>

            <!-- Section Syarat & Ketentuan -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Syarat & Ketentuan</h2>
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($syaratKetentuan as $syarat)
                        <div class="flex items-center">
                            <input type="checkbox" name="syarat_kondisi[]" value="{{ $syarat->syarat }}"
                                id="syarat_{{ $syarat->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ in_array($syarat->syarat, $penawaran->syarat_kondisi ?? []) ? 'checked' : '' }}>
                            <label for="syarat_{{ $syarat->id }}"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subtotal</label>
                            <input type="text" x-model="formatCurrency(subtotal)" readonly
                                class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white font-semibold" />
                            <input type="hidden" name="total" :value="subtotal" value="{{ old('total', $penawaran->total ?? 0) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">PPN
                                (%)</label>
                            <input type="number" name="ppn" x-model="ppn" @input="calculateTotal"
                                step="0.01"
                                class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ old('ppn', $penawaran->ppn ?? 11) }}" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Grand
                                Total</label>
                            <input type="text" x-model="formatCurrency(grand_total)" readonly
                                class="w-full py-2 px-3 rounded-lg border-2 border-blue-500 dark:border-blue-400 dark:bg-zinc-800 dark:text-white font-bold text-lg text-blue-600 dark:text-blue-400" />
                            <input type="hidden" name="grand_total" :value="grand_total" value="{{ old('grand_total', $penawaran->grand_total ?? 0) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Catatan -->
            <div class="w-full">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catatan</h2>
                <flux:textarea name="catatan" label="Catatan" placeholder="Masukkan catatan tambahan (opsional)"
                    rows="4" class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" value="{{ old('catatan', $penawaran->catatan) }}" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <x-button type="button" as="a" href="{{ route('admin.penawaran-pintu.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white">
                    Batal
                </x-button>
                <x-button type="submit" @click="submitForm($event)" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-3">
                    <x-icon name="save" class="w-4 h-4 mr-2" />
                    Simpan Revisi Penawaran Pintu
                </x-button>
            </div>
        </form>
    </div>

    <script>
        function penawaranForm() {
            return {
                mainSections: [],
                pintuSections: [],
                pintuProduk: [],
                isLoadingData: false,
                products: {
                    pintu: @json($pintus)
                },

                // Properti untuk perhitungan
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

                init() {
                    console.log('=== ALPINE.JS INIT ===');
                    console.log('Products pintu:', this.products.pintu);
                    console.log('Initializing penawaran form...');
                    
                    try {
                        // Load data produk pintu dari penawaran asli
                        this.loadDataFromOriginal();
                        
                        // Tambah section pertama jika tidak ada data
                        if (this.pintuSections.length === 0) {
                            this.addPintuSection();
                            console.log('✅ Section pertama berhasil ditambahkan');
                        } else {
                            console.log(`✅ Loaded ${this.pintuSections.length} sections from original data`);
                        }
                    } catch (error) {
                        console.error('❌ Error saat inisialisasi:', error);
                        alert('Error saat inisialisasi: ' + error.message);
                    }
                    
                    console.log('=== INIT COMPLETE ===');
                },

                // Load data dari penawaran asli
                loadDataFromOriginal() {
                    console.log('=== LOAD DATA FROM ORIGINAL ===');
                    this.isLoadingData = true;
                    const originalData = @json($penawaran->json_penawaran_pintu ?? '{}');
                    console.log('Data asli:', originalData);
                    
                    if (originalData && Object.keys(originalData).length > 0) {
                        // Convert object keys to array and sort by section number
                        const sections = Object.keys(originalData)
                            .filter(key => key.startsWith('section_'))
                            .sort((a, b) => {
                                const numA = parseInt(a.replace('section_', ''));
                                const numB = parseInt(b.replace('section_', ''));
                                return numA - numB;
                            });
                        
                        sections.forEach((sectionKey, sectionIndex) => {
                            const section = originalData[sectionKey];
                            console.log(`Loading section ${sectionIndex}:`, section);
                            
                            // Tambah section
                            this.addPintuSection();
                            
                            // Set nilai section (judul_1, judul_2, jumlah)
                            this.setSectionValue(sectionIndex, section);
                            
                            // Load data produk
                            if (section.products && section.products.length > 0) {
                                section.products.forEach((produk, produkIndex) => {
                                    console.log(`Loading produk ${produkIndex}:`, produk);
                                    
                                    // Tambah produk
                                    this.addPintuProduk(sectionIndex);
                                    
                                    // Set nilai produk
                                    this.setProductValue(sectionIndex, produkIndex, produk);
                                });
                            }
                        });
                        
                        // Hitung ulang total
                        this.calculateSubtotal();
                        this.calculateTotal();
                    }
                    
                    this.isLoadingData = false;
                    console.log('=== LOAD DATA COMPLETE ===');
                },

                // Set nilai section
                setSectionValue(sectionIndex, section) {
                    const container = document.getElementById('pintu-sections-container');
                    if (container) {
                        const sectionDiv = container.children[sectionIndex];
                        if (sectionDiv) {
                            // Set judul_1
                            const judul1Input = sectionDiv.querySelector('input[name*="[judul_1]"]');
                            if (judul1Input) judul1Input.value = section.judul_1 || '';
                            
                            // Set judul_2
                            const judul2Input = sectionDiv.querySelector('input[name*="[judul_2]"]');
                            if (judul2Input) judul2Input.value = section.judul_2 || '';
                            
                            // Set jumlah
                            const jumlahInput = sectionDiv.querySelector('input[name*="[jumlah]"]');
                            if (jumlahInput) jumlahInput.value = section.jumlah || 1;
                        }
                    }
                },

                // Set nilai produk
                setProductValue(sectionIndex, productIndex, produk) {
                    const container = document.getElementById(`pintu-products-${sectionIndex}`);
                    if (container) {
                        const productDiv = container.children[productIndex];
                        if (productDiv) {
                            console.log(`Setting product values for section ${sectionIndex}, product ${productIndex}:`, produk);
                            
                            // Set select produk pintu
                            const selectProduct = productDiv.querySelector('select[name*="[item]"]');
                            if (selectProduct) {
                                selectProduct.value = produk.item || '';
                                console.log(`Set select product to: ${produk.item}`);
                                
                                // Cek status aksesoris dari produk yang dipilih
                                if (produk.item) {
                                    const selectedProduct = this.products.pintu.find(p => p.code === produk.item);
                                    if (selectedProduct) {
                                        console.log(`Found product:`, selectedProduct);
                                        console.log(`Status aksesoris:`, selectedProduct.status_aksesoris);
                                    }
                                }
                            }
                            
                            // Set jumlah individual - SELALU SET dan TAMPILKAN
                            const jumlahIndividualInput = productDiv.querySelector('input[name*="[jumlah_individual]"]');
                            if (jumlahIndividualInput) {
                                jumlahIndividualInput.value = produk.jumlah_individual || 1;
                                jumlahIndividualInput.closest('div').style.display = 'block';
                                console.log(`Set jumlah_individual to: ${produk.jumlah_individual || 1}`);
                            }
                            
                            // Set nama produk
                            const namaProdukInput = productDiv.querySelector('input[name*="[nama_produk]"]');
                            if (namaProdukInput) namaProdukInput.value = produk.nama_produk || '';
                            
                            // Set dimensi
                            const lebarInput = productDiv.querySelector('input[name*="[lebar]"]');
                            const tebalInput = productDiv.querySelector('input[name*="[tebal]"]');
                            const tinggiInput = productDiv.querySelector('input[name*="[tinggi]"]');
                            
                            if (lebarInput) lebarInput.value = produk.lebar || '';
                            if (tebalInput) tebalInput.value = produk.tebal || '';
                            if (tinggiInput) tinggiInput.value = produk.tinggi || '';
                            
                            // Set warna
                            const warnaInput = productDiv.querySelector('input[name*="[warna]"]');
                            if (warnaInput) warnaInput.value = produk.warna || '';
                            
                            // Set harga
                            const hargaInput = productDiv.querySelector('input[name*="[harga]"]');
                            if (hargaInput) hargaInput.value = produk.harga || '';
                            
                            // Set diskon
                            const diskonInput = productDiv.querySelector('input[name*="[diskon]"]');
                            const diskonSatuInput = productDiv.querySelector('input[name*="[diskon_satu]"]');
                            const diskonDuaInput = productDiv.querySelector('input[name*="[diskon_dua]"]');
                            
                            if (diskonInput) diskonInput.value = produk.diskon || 0;
                            if (diskonSatuInput) diskonSatuInput.value = produk.diskon_satu || 0;
                            if (diskonDuaInput) diskonDuaInput.value = produk.diskon_dua || 0;
                            
                            // Set total harga
                            const totalInput = productDiv.querySelector('input[name*="[total_harga]"]');
                            if (totalInput) totalInput.value = produk.total_harga || '';
                            
                            console.log(`Product values set successfully for section ${sectionIndex}, product ${productIndex}`);
                        }
                    }
                },

                loadClients(salesId) {
                    if (!salesId) return;

                    fetch(`/admin/penawaran-pintu/clients/${salesId}`)
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                const clientSelect = document.querySelector('select[name="id_client"]');
                                clientSelect.innerHTML = '<option value="" disabled>Pilih Client</option>';

                                result.data.forEach(client => {
                                    const option = document.createElement('option');
                                    option.value = client.id;
                                    option.textContent = client.nama_perusahaan || client.nama;
                                    // Set selected jika ini adalah client yang sudah dipilih sebelumnya
                                    if (client.id == {{ $penawaran->id_client ?? 0 }}) {
                                        option.selected = true;
                                    }
                                    clientSelect.appendChild(option);
                                });
                            } else {
                                console.error('Error loading clients:', result.message);
                                alert('Error: ' + result.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading clients:', error);
                            alert('Error saat memuat data client: ' + error.message);
                        });
                },

                pintuProduk: [],
                pintuData: [],

                addPintuSection() {
                    console.log('=== ADD PINTU SECTION ===');
                    console.log('Section index:', this.pintuSections.length);
                    
                    const container = document.getElementById('pintu-sections-container');
                    if (!container) {
                        console.error('❌ Container pintu-sections-container tidak ditemukan!');
                        alert('Error: Container sections tidak ditemukan!');
                        return;
                    }
                    
                    console.log('✅ Container ditemukan:', container);
                    const sectionIndex = this.pintuSections.length;

                    const sectionDiv = document.createElement('div');
                    sectionDiv.className = 'border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-white dark:bg-zinc-900';
                    sectionDiv.innerHTML = `
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Section ${sectionIndex + 1}</h3>
                            <button type="button" data-action="remove-section" data-section="${sectionIndex}" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Section
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul 1</label>
                                <input name="json_penawaran_pintu[section_${sectionIndex}][judul_1]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Masukkan judul 1 (opsional)" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul 2</label>
                                <input name="json_penawaran_pintu[section_${sectionIndex}][judul_2]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Masukkan judul 2 (opsional)" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah</label>
                                <input type="number" name="json_penawaran_pintu[section_${sectionIndex}][jumlah]" placeholder="Jumlah" min="1" value="1" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" data-section="${sectionIndex}" />
                            </div>
                        </div>
                        <div class="space-y-4">
                            <button type="button" data-action="add-product" data-section="${sectionIndex}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Produk Pintu
                            </button>
                            <div id="pintu-products-${sectionIndex}" class="space-y-4">
                                <!-- Produk pintu akan ditambahkan di sini -->
                            </div>
                        </div>
                    `;

                    // Add event listeners
                    const removeBtn = sectionDiv.querySelector('[data-action="remove-section"]');
                    const addProductBtn = sectionDiv.querySelector('[data-action="add-product"]');
                    const jumlahSectionInput = sectionDiv.querySelector('input[name*="[jumlah]"]');
                    const self = this;
                    
                    removeBtn.addEventListener('click', function() {
                        self.removePintuSection(sectionIndex);
                    });
                    addProductBtn.addEventListener('click', function() {
                        self.addPintuProduk(sectionIndex);
                    });
                    
                    // Event listener untuk jumlah section
                    if (jumlahSectionInput) {
                        jumlahSectionInput.addEventListener('input', function() {
                            self.calculateSubtotal();
                        });
                    }

                    container.appendChild(sectionDiv);
                    this.pintuSections.push({
                        element: sectionDiv,
                        products: []
                    });
                    
                    // Tambahkan produk pintu pertama secara otomatis (hanya jika bukan loading data)
                    if (!this.isLoadingData) {
                        try {
                            this.addPintuProduk(sectionIndex);
                            console.log(`✅ Produk pertama berhasil ditambahkan ke section ${sectionIndex}`);
                        } catch (error) {
                            console.error(`❌ Error saat menambahkan produk pertama ke section ${sectionIndex}:`, error);
                        }
                    }
                    
                    console.log(`=== SECTION ${sectionIndex} COMPLETE ===`);
                },

                removePintuSection(sectionIndex) {
                    const container = document.getElementById('pintu-sections-container');
                    const sectionDiv = container.children[sectionIndex];
                    if (sectionDiv) {
                        sectionDiv.remove();
                        this.pintuSections.splice(sectionIndex, 1);
                        
                        // Update section numbers and indices
                        this.updateSectionIndices();
                        this.calculateSubtotal();
                    }
                },

                addPintuProduk(sectionIndex) {
                    const container = document.getElementById(`pintu-products-${sectionIndex}`);
                    if (!container) {
                        return;
                    }
                    const productIndex = this.pintuSections[sectionIndex].products.length;

                    const productDiv = document.createElement('div');
                    productDiv.className = 'border-2 border-gray-200 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800';
                    productDiv.innerHTML = `
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Produk Pintu #${productIndex + 1}</h4>
                            <button type="button" data-action="remove-product" data-section="${sectionIndex}" data-product="${productIndex}" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Produk Pintu</label>
                                <select name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][item]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" data-section="${sectionIndex}" data-product="${productIndex}">
                                    <option value="">Pilih Produk Pintu</option>
                                    ${this.products.pintu.map(p => `<option value="${p.id}">${p.code} - ${p.nama_produk} (${this.formatNumber(p.lebar)}x${this.formatNumber(p.tebal)}x${this.formatNumber(p.tinggi)} cm) - Rp ${p.harga_satuan ? p.harga_satuan.toLocaleString('id-ID') : '0'}</option>`).join('')}
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Produk</label>
                                <input type="text" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][nama_produk]" placeholder="Nama Produk" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dimensi</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <input type="text" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][lebar]" placeholder="L" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                    <input type="text" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][tebal]" placeholder="T" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                    <input type="text" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][tinggi]" placeholder="H" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Warna</label>
                                <input type="text" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][warna]" placeholder="Warna" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga</label>
                                <input type="text" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][harga]" placeholder="Harga" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                            </div>
                        </div>
                                                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mt-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Individual</label>
                                 <input type="number" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][jumlah_individual]" placeholder="1" min="1" value="1" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" data-section="${sectionIndex}" data-product="${productIndex}" />
                             </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon (%)</label>
                                <input type="number" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][diskon]" placeholder="0" min="0" step="0.01" value="0" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" data-section="${sectionIndex}" data-product="${productIndex}" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 1 (%)</label>
                                <input type="number" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][diskon_satu]" placeholder="0" min="0" step="0.01" value="0" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" data-section="${sectionIndex}" data-product="${productIndex}" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Diskon 2 (%)</label>
                                <input type="number" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][diskon_dua]" placeholder="0" min="0" step="0.01" value="0" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" data-section="${sectionIndex}" data-product="${productIndex}" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Harga</label>
                                <input type="text" name="json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][total_harga]" placeholder="Total Harga" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" readonly />
                            </div>
                        </div>
                    `;

                    // Add event listeners
                    const removeBtn = productDiv.querySelector('[data-action="remove-product"]');
                    const selectProduct = productDiv.querySelector('select');
                    const jumlahIndividualInput = productDiv.querySelector('input[name*="[jumlah_individual]"]');
                    const diskonInput = productDiv.querySelector('input[name*="[diskon]"]');
                    const diskonSatuInput = productDiv.querySelector('input[name*="[diskon_satu]"]');
                    const diskonDuaInput = productDiv.querySelector('input[name*="[diskon_dua]"]');
                    const self = this;
                    
                    // Event listener untuk tombol hapus dengan arrow function untuk binding yang lebih baik
                    removeBtn.addEventListener('click', () => {
                        this.removePintuProduk(sectionIndex, productIndex);
                    });
                    
                    selectProduct.addEventListener('change', function(e) {
                        self.autofillPintuProduct(sectionIndex, productIndex, e.target.value);
                    });
                    
                    if (jumlahIndividualInput) {
                        jumlahIndividualInput.addEventListener('input', function() {
                            self.calculatePintuProductTotal(sectionIndex, productIndex);
                        });
                    }
                    
                    diskonInput.addEventListener('input', function() {
                        self.calculatePintuProductTotal(sectionIndex, productIndex);
                    });
                    diskonSatuInput.addEventListener('input', function() {
                        self.calculatePintuProductTotal(sectionIndex, productIndex);
                    });
                    diskonDuaInput.addEventListener('input', function() {
                        self.calculatePintuProductTotal(sectionIndex, productIndex);
                    });

                    container.appendChild(productDiv);
                    this.pintuSections[sectionIndex].products.push({
                        element: productDiv
                    });
                                },

                recalculateSectionProducts(sectionIndex) {
                    const container = document.getElementById(`pintu-products-${sectionIndex}`);
                    if (container) {
                        const productDivs = container.querySelectorAll('div[class*="border-2"]');
                        productDivs.forEach((productDiv, productIndex) => {
                            this.calculatePintuProductTotal(sectionIndex, productIndex);
                        });
                    }
                },

                removePintuProduk(sectionIndex, productIndex) {
                     const container = document.getElementById(`pintu-products-${sectionIndex}`);
                     if (!container) return;
                     
                     // Hapus dari array terlebih dahulu
                     this.pintuSections[sectionIndex].products.splice(productIndex, 1);
                     
                     // Hapus dari DOM
                     const productDiv = container.children[productIndex];
                     if (productDiv) {
                         productDiv.remove();
                     }
                     
                     // Update product numbers and indices
                     this.updateProductIndices(sectionIndex);
                     this.calculateSubtotal();
                 },

                                   updateProductIndices(sectionIndex) {
                      const container = document.getElementById(`pintu-products-${sectionIndex}`);
                      if (!container) return;
                      
                      // Ambil semua produk div yang tersisa
                      const productDivs = container.querySelectorAll('div[class*="border-2"]');
                      
                      productDivs.forEach((productDiv, newIndex) => {
                          // Update product title
                          const title = productDiv.querySelector('h4');
                          if (title) {
                              title.textContent = `Produk Pintu #${newIndex + 1}`;
                          }
                          
                          // Update all input names and data attributes
                          const inputs = productDiv.querySelectorAll('input, select');
                          inputs.forEach(input => {
                              if (input.name) {
                                  // Gunakan regex yang lebih spesifik untuk mengganti index
                                  input.name = input.name.replace(/products\]\[\d+\]/, `products][${newIndex}]`);
                              }
                              if (input.dataset.product !== undefined) {
                                  input.dataset.product = newIndex;
                              }
                          });
                          
                          // Update button data attributes
                          const buttons = productDiv.querySelectorAll('button[data-product]');
                          buttons.forEach(button => {
                              button.dataset.product = newIndex;
                          });
                          
                          // Update event listener untuk tombol hapus
                          const removeBtn = productDiv.querySelector('[data-action="remove-product"]');
                          if (removeBtn) {
                              // Hapus event listener lama
                              removeBtn.replaceWith(removeBtn.cloneNode(true));
                              const newRemoveBtn = productDiv.querySelector('[data-action="remove-product"]');
                              
                              // Pasang event listener baru
                              newRemoveBtn.addEventListener('click', () => {
                                  this.removePintuProduk(sectionIndex, newIndex);
                              });
                          }
                      });
                  },

                 autofillPintu(pintu) {
                    if (!pintu.code) return;

                    const produk = this.products.pintu.find(p => p.code === pintu.code);
                    if (produk) {
                        console.log('=== DEBUG AUTOFILL PINTU ===');
                        console.log('Produk dipilih:', produk.code);

                        pintu.item = produk.nama_produk || '';
                        pintu.code = produk.code || '';
                        pintu.slug = produk.slug || '';
                        pintu.nama_produk = produk.nama_produk || '';
                                                 pintu.lebar = produk.lebar || 0;
                        pintu.tebal = produk.tebal || 0;
                        pintu.tinggi = produk.tinggi || 0;
                        pintu.warna = produk.warna || '';
                        pintu.harga = produk.harga_satuan || 0;
                        pintu.harga_display = this.formatCurrency(produk.harga_satuan || 0);

                        // Hitung total harga otomatis
                        this.calculatePintuTotal(pintu);
                        console.log('================================');
                    }
                },

                 removePintuSection(sectionIndex) {
                     const container = document.getElementById('pintu-sections-container');
                     const sectionDiv = container.children[sectionIndex];
                     if (sectionDiv) {
                         sectionDiv.remove();
                         this.pintuSections.splice(sectionIndex, 1);
                         
                         // Update section numbers and indices
                         this.updateSectionIndices();
                         this.calculateSubtotal();
                     }
                 },

                 updateSectionIndices() {
                     const container = document.getElementById('pintu-sections-container');
                     Array.from(container.children).forEach((sectionDiv, newIndex) => {
                         // Update section title
                         const title = sectionDiv.querySelector('h3');
                         if (title) {
                             title.textContent = `Section ${newIndex + 1}`;
                         }
                         
                         // Update all input names and data attributes
                         const inputs = sectionDiv.querySelectorAll('input, select');
                         inputs.forEach(input => {
                             if (input.name) {
                                 input.name = input.name.replace(/section_\d+/, `section_${newIndex}`);
                             }
                             if (input.dataset.section !== undefined) {
                                 input.dataset.section = newIndex;
                             }
                         });
                         
                         // Update button data attributes
                         const buttons = sectionDiv.querySelectorAll('button[data-section]');
                         buttons.forEach(button => {
                             button.dataset.section = newIndex;
                         });
                         
                         // Update product container id
                         const productContainer = sectionDiv.querySelector('[id^="pintu-products-"]');
                         if (productContainer) {
                             productContainer.id = `pintu-products-${newIndex}`;
                         }
                     });
                 },

                 autofillPintuProduct(sectionIndex, productIndex, id) {
                    if (!id) return;

                    const produk = this.products.pintu.find(p => p.id == id);
                    if (produk) {
                        const container = document.getElementById(`pintu-products-${sectionIndex}`);
                        const productDiv = container.children[productIndex];

                        if (productDiv) {
                            const namaProdukInput = productDiv.querySelector('input[name*="[nama_produk]"]');
                            const lebarInput = productDiv.querySelector('input[name*="[lebar]"]');
                            const tebalInput = productDiv.querySelector('input[name*="[tebal]"]');
                            const tinggiInput = productDiv.querySelector('input[name*="[tinggi]"]');
                            const warnaInput = productDiv.querySelector('input[name*="[warna]"]');
                            const hargaInput = productDiv.querySelector('input[name*="[harga]"]');

                            if (namaProdukInput) namaProdukInput.value = produk.nama_produk || '';
                            if (lebarInput) lebarInput.value = this.formatNumber(produk.lebar);
                            if (tebalInput) tebalInput.value = this.formatNumber(produk.tebal);
                            if (tinggiInput) tinggiInput.value = this.formatNumber(produk.tinggi);
                            if (warnaInput) warnaInput.value = produk.warna || '';
                            if (hargaInput) {
                                // Simpan harga sebagai angka biasa, bukan format currency
                                hargaInput.value = produk.harga_satuan || 0;
                                hargaInput.dataset.rawValue = produk.harga_satuan || 0;
                            }

                            // Simpan code produk ke hidden input
                            const codeInput = productDiv.querySelector('input[name*="[code]"]');
                            if (!codeInput) {
                                // Buat hidden input untuk code jika belum ada
                                const hiddenCodeInput = document.createElement('input');
                                hiddenCodeInput.type = 'hidden';
                                hiddenCodeInput.name = `json_penawaran_pintu[section_${sectionIndex}][products][${productIndex}][code]`;
                                productDiv.appendChild(hiddenCodeInput);
                                hiddenCodeInput.value = produk.code || '';
                            } else {
                                codeInput.value = produk.code || '';
                            }

                                                         // Selalu tampilkan field jumlah individual
                             const jumlahIndividualInput = productDiv.querySelector('input[name*="[jumlah_individual]"]');
                             if (jumlahIndividualInput) {
                                 jumlahIndividualInput.style.display = 'block';
                                 jumlahIndividualInput.closest('div').style.display = 'block';
                             }

                            // Hitung total harga otomatis
                            this.calculatePintuProductTotal(sectionIndex, productIndex);
                        }
                    }
                },

                calculatePintuTotal(pintu) {
                    if (pintu.harga && pintu.jumlah) {
                        pintu.total_harga = (parseFloat(pintu.harga) * parseFloat(pintu.jumlah)).toFixed(2);
                        pintu.total_harga_display = this.formatCurrency(pintu.total_harga);
                    }
                    this.calculateSubtotal();
                },

                calculatePintuProductTotal(sectionIndex, productIndex) {
                    const container = document.getElementById(`pintu-products-${sectionIndex}`);
                    const productDiv = container.children[productIndex];

                    if (productDiv) {
                        const hargaInput = productDiv.querySelector('input[name*="[harga]"]');
                        const diskonInput = productDiv.querySelector('input[name*="[diskon]"]');
                        const diskonSatuInput = productDiv.querySelector('input[name*="[diskon_satu]"]');
                        const diskonDuaInput = productDiv.querySelector('input[name*="[diskon_dua]"]');
                        const totalInput = productDiv.querySelector('input[name*="[total_harga]"]');
                        const jumlahIndividualInput = productDiv.querySelector('input[name*="[jumlah_individual]"]');

                        if (hargaInput && totalInput) {
                            // Ambil nilai dari input
                            const harga = parseFloat(hargaInput.value) || 0;
                            const diskon = parseFloat(diskonInput.value) || 0;
                            const diskonSatu = parseFloat(diskonSatuInput.value) || 0;
                            const diskonDua = parseFloat(diskonDuaInput.value) || 0;

                            // Hitung diskon bertahap langsung dari harga satuan
                            const totalDiskon = harga * (diskon / 100);
                            const totalDiskonSatu = (harga - totalDiskon) * (diskonSatu / 100);
                            const totalDiskonDua = (harga - totalDiskon - totalDiskonSatu) * (diskonDua / 100);

                            // Total akhir setelah semua diskon
                            let total = harga - totalDiskon - totalDiskonSatu - totalDiskonDua;

                            // Jika ada jumlah individual (produk aksesoris), kalikan dengan jumlah individual
                            if (jumlahIndividualInput && jumlahIndividualInput.style.display !== 'none') {
                                const jumlahIndividual = parseFloat(jumlahIndividualInput.value) || 1;
                                total = total * jumlahIndividual;
                            }

                            // Simpan total sebagai angka biasa
                            totalInput.value = total;
                            totalInput.dataset.rawValue = total;

                            // Update subtotal
                            this.calculateSubtotal();
                        }
                    }
                },

                calculateSubtotal() {
                    this.subtotal = 0;
                    
                    // Hitung total dari section pintu baru
                    this.pintuSections.forEach((section, sectionIndex) => {
                        const container = document.getElementById(`pintu-products-${sectionIndex}`);
                        if (container) {
                            // Ambil jumlah section
                            const jumlahSectionInput = container.closest('.border-2').querySelector('input[name*="[jumlah]"]');
                            const jumlahSection = parseFloat(jumlahSectionInput?.value) || 1;
                            
                            // Hitung total harga semua produk dalam section ini
                            let totalHargaSection = 0;
                            const productDivs = container.querySelectorAll('div[class*="border-2"]');
                            productDivs.forEach(productDiv => {
                                const totalInput = productDiv.querySelector('input[name*="[total_harga]"]');
                                if (totalInput && totalInput.value) {
                                    // Ambil nilai langsung dari value (sudah dalam format angka)
                                    totalHargaSection += parseFloat(totalInput.value) || 0;
                                }
                            });
                            
                            // Total section = total harga produk × jumlah section
                            this.subtotal += totalHargaSection * jumlahSection;
                        }
                    });

                    // Hitung total dari produk lainnya yang dibuat secara dinamis
                    this.mainSections.forEach((mainSection, mainIndex) => {
                        const container = document.getElementById(`product-sections-${mainIndex}`);
                        if (container) {
                            const productDivs = container.querySelectorAll('div[class*="border-2"]');
                            productDivs.forEach(productDiv => {
                                const totalInput = productDiv.querySelector('input[name*="[total_harga]"]');
                                if (totalInput && totalInput.value) {
                                    // Hapus format currency dan konversi ke angka
                                    const totalValue = totalInput.value.replace(/[^\d]/g, '');
                                    this.subtotal += parseFloat(totalValue) || 0;
                                }
                            });
                        }
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

                // Fungsi untuk format angka yang menghilangkan desimal yang tidak perlu
                formatNumber(number) {
                    if (number === null || number === undefined || number === '') return '0';
                    
                    // Konversi ke string dan hapus trailing zeros
                    const numStr = parseFloat(number).toString();
                    
                    // Jika ada desimal dan berakhir dengan .0 atau .00, hapus
                    if (numStr.includes('.')) {
                        return parseFloat(numStr).toString();
                    }
                    
                    return numStr;
                },

                addMainSection(defaultJudul = null) {
                    const container = document.getElementById('main-sections-container');
                    const mainIndex = this.mainSections.length;

                    const sectionDiv = document.createElement('div');
                    sectionDiv.className =
                        'border-2 border-gray-300 dark:border-zinc-600 rounded-lg p-6 bg-white dark:bg-zinc-900';
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
                             <input name="json_penawaran_pintu[section_${mainIndex}][judul]" value="${defaultJudul || ''}" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Masukkan judul section" />
                         </div>
                         <div class="space-y-4">
                             <button type="button" @click="addProductSection(${mainIndex})" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                                 <x-icon name="plus" class="w-4 h-4" /> Tambah Sub Section
                             </button>
                             <div id="product-sections-${mainIndex}" class="space-y-4">
                                 <!-- Product sections will be added here -->
                             </div>
                         </div>
                     `;

                    container.appendChild(sectionDiv);
                    this.mainSections.push({
                        element: sectionDiv,
                        productSections: []
                    });
                },

                addProductSection(mainIndex) {
                    const container = document.getElementById(`product-sections-${mainIndex}`);
                    const productIndex = this.mainSections[mainIndex].productSections.length;

                    const productDiv = document.createElement('div');
                    productDiv.className =
                        'border-2 border-gray-200 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800';
                    productDiv.innerHTML = `
                         <div class="flex justify-between items-center mb-3">
                             <h4 class="font-semibold text-gray-900 dark:text-white">Produk #${productIndex + 1}</h4>
                             <button type="button" @click="removeProductSection(${mainIndex}, ${productIndex})" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                 </svg>
                             </button>
                         </div>
                         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Produk</label>
                                 <input type="text" name="json_penawaran_pintu[section_${mainIndex}][produk][${productIndex}][nama]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Nama produk" />
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Spesifikasi</label>
                                 <input type="text" name="json_penawaran_pintu[section_${mainIndex}][produk][${productIndex}][spesifikasi]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Spesifikasi" />
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan</label>
                                 <input type="text" name="json_penawaran_pintu[section_${mainIndex}][produk][${productIndex}][satuan]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Satuan" />
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga Satuan</label>
                                 <input type="number" name="json_penawaran_pintu[section_${mainIndex}][produk][${productIndex}][harga_satuan]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Harga satuan" step="0.01" @input="calculateProductTotal(${mainIndex}, ${productIndex})" />
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah</label>
                                 <input type="number" name="json_penawaran_pintu[section_${mainIndex}][produk][${productIndex}][jumlah]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Jumlah" min="1" @input="calculateProductTotal(${mainIndex}, ${productIndex})" />
                             </div>
                             <div>
                                 <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Total Harga</label>
                                 <input type="text" name="json_penawaran_pintu[section_${mainIndex}][produk][${productIndex}][total_harga]" class="w-full py-2 px-3 rounded-lg border-2 border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400" placeholder="Total harga" readonly />
                             </div>
                         </div>
                     `;

                    container.appendChild(productDiv);
                    this.mainSections[mainIndex].productSections.push({
                        element: productDiv
                    });
                },

                removeProductSection(mainIndex, productIndex) {
                    // Hapus element dari DOM
                    const container = document.getElementById(`product-sections-${mainIndex}`);
                    const productDiv = container.children[productIndex];
                    if (productDiv) {
                        productDiv.remove();
                    }

                    // Hapus dari array
                    this.mainSections[mainIndex].productSections.splice(productIndex, 1);

                    // Update subtotal
                    this.calculateSubtotal();
                },

                calculateProductTotal(mainIndex, productIndex) {
                    const container = document.getElementById(`product-sections-${mainIndex}`);
                    const productDiv = container.children[productIndex];

                    if (productDiv) {
                        const hargaInput = productDiv.querySelector('input[name*="[harga_satuan]"]');
                        const jumlahInput = productDiv.querySelector('input[name*="[jumlah]"]');
                        const totalInput = productDiv.querySelector('input[name*="[total_harga]"]');

                        if (hargaInput && jumlahInput && totalInput) {
                            const harga = parseFloat(hargaInput.value) || 0;
                            const jumlah = parseFloat(jumlahInput.value) || 0;
                            const total = harga * jumlah;

                            totalInput.value = this.formatCurrency(total);

                            // Update subtotal
                            this.calculateSubtotal();
                        }
                    }
                },

                // Fungsi untuk submit form dengan validasi dan debugging lengkap
                submitForm(event) {
                    event.preventDefault();
                    
                    console.log('=== DEBUG SUBMIT FORM ===');
                    console.log('Event:', event);
                    console.log('Target:', event.target);
                    
                    // Validasi form dasar
                    const form = event.target.closest('form');
                    if (!form) {
                        console.error('❌ Form tidak ditemukan!');
                        alert('Error: Form tidak ditemukan!');
                        return;
                    }
                    
                    console.log('✅ Form ditemukan:', form);
                    console.log('Form action:', form.action);
                    console.log('Form method:', form.method);
                    console.log('Form ID:', form.id);
                    
                    // Debug route
                    console.log('Expected route:', '{{ route("admin.penawaran-pintu.store-revisi", $penawaran) }}');
                    console.log('Current form action:', form.action);
                    
                    // Validasi sales
                    const salesSelect = form.querySelector('select[name="id_user"]');
                    if (!salesSelect) {
                        console.error('❌ Select sales tidak ditemukan!');
                        alert('Error: Select sales tidak ditemukan!');
                        return;
                    }
                    
                    if (!salesSelect.value) {
                        console.error('❌ Sales belum dipilih!');
                        alert('Pilih Sales terlebih dahulu!');
                        salesSelect.focus();
                        return;
                    }
                    
                    console.log('✅ Sales ID:', salesSelect.value);
                    
                    // Validasi client
                    const clientSelect = form.querySelector('select[name="id_client"]');
                    if (!clientSelect) {
                        console.error('❌ Select client tidak ditemukan!');
                        alert('Error: Select client tidak ditemukan!');
                        return;
                    }
                    
                    if (!clientSelect.value) {
                        console.error('❌ Client belum dipilih!');
                        alert('Pilih Client terlebih dahulu!');
                        clientSelect.focus();
                        return;
                    }
                    
                    console.log('✅ Client ID:', clientSelect.value);
                    
                    // Validasi nomor penawaran
                    const nomorInput = form.querySelector('input[name="nomor_penawaran"]');
                    if (!nomorInput) {
                        console.error('❌ Input nomor penawaran tidak ditemukan!');
                        alert('Error: Input nomor penawaran tidak ditemukan!');
                        return;
                    }
                    
                    if (!nomorInput.value.trim()) {
                        console.error('❌ Nomor penawaran kosong!');
                        alert('Nomor penawaran harus diisi!');
                        nomorInput.focus();
                        return;
                    }
                    
                    console.log('✅ Nomor Penawaran:', nomorInput.value);
                    
                    // Validasi judul penawaran
                    const judulInput = form.querySelector('input[name="judul_penawaran"]');
                    if (!judulInput) {
                        console.error('❌ Input judul tidak ditemukan!');
                        alert('Error: Input judul tidak ditemukan!');
                        return;
                    }
                    
                    if (!judulInput.value.trim()) {
                        console.error('❌ Judul penawaran kosong!');
                        alert('Judul penawaran harus diisi!');
                        judulInput.focus();
                        return;
                    }
                    
                    console.log('✅ Judul:', judulInput.value);
                     
                     // Validasi tanggal penawaran
                     const tanggalInput = form.querySelector('input[name="tanggal_penawaran"]');
                     if (!tanggalInput) {
                         console.error('❌ Input tanggal tidak ditemukan!');
                         alert('Error: Input tanggal tidak ditemukan!');
                         return;
                     }
                     
                     if (!tanggalInput.value) {
                         console.error('❌ Tanggal penawaran kosong!');
                         alert('Tanggal penawaran harus diisi!');
                         tanggalInput.focus();
                         return;
                     }
                     
                     console.log('✅ Tanggal:', tanggalInput.value);
                     
                     // Validasi produk pintu
                    console.log('=== VALIDASI PRODUK PINTU ===');
                    console.log('Pintu sections:', this.pintuSections);
                    
                    let hasProducts = false;
                    let productCount = 0;
                    
                    this.pintuSections.forEach((section, sectionIndex) => {
                        console.log(`Section ${sectionIndex}:`, section);
                        
                        const container = document.getElementById(`pintu-products-${sectionIndex}`);
                        if (container) {
                            console.log(`Container section ${sectionIndex}:`, container);
                            
                            const productDivs = container.querySelectorAll('div[class*="border-2"]');
                            console.log(`Product divs di section ${sectionIndex}:`, productDivs.length);
                            
                            productDivs.forEach((productDiv, productIndex) => {
                                const selectProduct = productDiv.querySelector('select');
                                if (selectProduct) {
                                    console.log(`Product ${productIndex} select:`, selectProduct.value);
                                    if (selectProduct.value) {
                                        hasProducts = true;
                                        productCount++;
                                    }
                                }
                            });
                        } else {
                            console.error(`❌ Container section ${sectionIndex} tidak ditemukan!`);
                        }
                    });
                    
                    console.log('Total produk yang dipilih:', productCount);
                    
                    if (!hasProducts) {
                        console.error('❌ Tidak ada produk pintu yang dipilih!');
                        alert('Minimal harus ada 1 produk pintu yang dipilih!');
                        return;
                    }
                    
                    console.log('✅ Produk pintu valid');
                     
                     // Debug data yang akan dikirim
                     console.log('=== DATA YANG AKAN DIKIRIM ===');
                     console.log('Sales ID:', salesSelect.value);
                     console.log('Client ID:', clientSelect.value);
                     console.log('Judul:', judulInput.value);
                     console.log('Tanggal:', tanggalInput.value);
                    console.log('Subtotal:', this.subtotal);
                    console.log('Grand Total:', this.grand_total);
                    console.log('Pintu Sections:', this.pintuSections);
                    
                    // Debug form data
                    const formData = new FormData(form);
                    console.log('=== FORM DATA ===');
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}:`, value);
                    }
                    
                    // Jika semua validasi berhasil, submit form dengan AJAX
                    console.log('✅ Semua validasi berhasil!');
                    console.log('🚀 Submitting form dengan AJAX...');
                    
                    // Tampilkan loading state
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
                    submitBtn.disabled = true;
                    
                    try {
                        // Submit dengan AJAX
                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('✅ Response dari server:', data);
                            
                            if (data.success) {
                                // Redirect ke halaman index dengan flash message
                                window.location.href = '{{ route("admin.penawaran-pintu.index") }}';
                            } else {
                                // Tampilkan error
                                alert('Error: ' + (data.message || 'Terjadi kesalahan saat menyimpan'));
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('❌ Error AJAX:', error);
                            alert('Error: ' + error.message);
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });
                        
                    } catch (error) {
                        console.error('❌ Error saat submit form:', error);
                        alert('Error saat submit form: ' + error.message);
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }
            }
        }
    </script>
</x-layouts.app>
