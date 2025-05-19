<x-layouts.app :title="__('Tambah Pengajuan')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Tambah Pengajuan')" :description="__('Masukkan detail pengajuan di bawah ini')" />

        <form action="{{ route('admin.pengajuan.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <!-- Judul Pengajuan -->
            <flux:input name="judul_pengajuan" :label="__('Judul Pengajuan')" type="text" required autocomplete="off"
                :placeholder="__('Masukkan judul pengajuan')" />
                
            <div class="grid grid-cols-2 gap-6">
                <!-- Client -->
                <flux:input name="client" :label="__('Client')" type="text" required autocomplete="off"
                    :placeholder="__('Masukkan nama client')" />

                <!-- Nama Client -->
                <flux:input name="nama_client" :label="__('Nama Client')" type="text" required autocomplete="off"
                    :placeholder="__('Masukkan nama lengkap client')" />
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Memilih Produk -->
                <flux:select name="json_produk[]" :label="__('Pilih Produk')" id="produkSelect" required>
                    <option value="" disabled selected>{{ __('Pilih Produk') }}</option>
                    @foreach ($produk as $prod)
                        <option value="{{ $prod->id }}" data-harga="{{ $prod->harga }}"
                            data-dimensi-lebar="{{ $prod->dimensi_lebar }}"
                            data-dimensi-tinggi="{{ $prod->dimensi_tinggi }}" data-panjang="{{ $prod->panjang }}"
                            data-warna="{{ $prod->warna }}">
                            {{ $prod->type }}
                        </option>
                    @endforeach
                </flux:select>
    
                    <!-- Memilih Aksesoris -->
                <flux:select name="json_aksesoris[]" :label="__('Pilih Aksesoris')" id="aksesorisSelect" required>
                    <option value="" disabled selected>{{ __('Pilih Aksesoris') }}</option>
                    @foreach ($aksesoris as $aks)
                        <option value="{{ $aks->id }}" data-harga="{{ $aks->harga }}"
                            data-type="{{ $aks->type }}" data-satuan="{{ $aks->satuan }}">
                            {{ $aks->type }}
                        </option>
                    @endforeach
                </flux:select>
            </div>    

            <!-- Daftar Produk yang Dipilih -->
            <div id="produkSelected" class="mt-4" style="display: none;">
                <!-- Tabel Produk yang Dipilih -->
                <table id="produkTable" class="min-w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="border p-2">Type</th>
                            <th class="border p-2">Dimensi</th>
                            <th class="border p-2">Warna</th>
                            <th class="border p-2">Harga</th>
                            <th class="border p-2">Quantity</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="produkTableBody"></tbody>
                </table>
            </div>

            <!-- Daftar Aksesoris yang Dipilih -->
            <div id="aksesorisSelected" class="mt-4" style="display: none;">
                <!-- Tabel Aksesoris yang Dipilih -->
                <table id="aksesorisTable" class="min-w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="border p-2">Type</th>
                            <th class="border p-2">Satuan</th>
                            <th class="border p-2">Harga</th>
                            <th class="border p-2">Quantity</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="aksesorisTableBody"></tbody>
                </table>
            </div>

            <!-- Diskon -->
            <div class="grid grid-cols-3 gap-6">
                <flux:input name="diskon_satu" :label="__('Diskon 1')" :placeholder="__('... %')" type="number"
                    required />
                <flux:input name="diskon_dua" :label="__('Diskon 2')" :placeholder="__('... %')" type="number"
                    required />
                <flux:input name="diskon_tiga" :label="__('Diskon 3')" :placeholder="__('... %')" type="number"
                    required />
            </div>

            <!-- Note -->
            <flux:textarea name="note" :label="__('Catatan')" required rows="4"
                placeholder="Masukkan catatan tambahan..."></flux:textarea>

            <!-- Status -->
            <flux:select name="status" :label="__('Status')" required>
                <option value="0">{{ __('Aktif') }}</option>
                <option value="1">{{ __('Non-Aktif') }}</option>
            </flux:select>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Simpan') }}
                </flux:button>
            </div>
        </form>
    </div>

    <!-- Memisahkan script dari kode HTML -->
    <script>
        // Mendapatkan elemen select dan div tempat produk dipilih akan ditampilkan
        const selectProduk = document.getElementById('produkSelect');
        const produkTableBody = document.getElementById('produkTableBody');
        const produkSelected = document.getElementById('produkSelected');

        const selectAksesoris = document.getElementById('aksesorisSelect');
        const aksesorisTableBody = document.getElementById('aksesorisTableBody');
        const aksesorisSelected = document.getElementById('aksesorisSelected');

        // Fungsi untuk memformat angka menjadi format Rupiah tanpa koma di desimal
        function formatRupiah(number) {
            return number.toLocaleString('id-ID');
        }

        selectProduk.addEventListener('change', function() {
            const selectedProduk = Array.from(selectProduk.selectedOptions);

            // Menampilkan tabel jika ada produk yang dipilih
            if (selectedProduk.length > 0) {
                produkSelected.style.display = "block";
            } else {
                produkSelected.style.display = "none";
            }

            // Membuat array dari produk yang dipilih
            const selectedIds = selectedProduk.map(option => option.value);

            // Loop melalui produk yang dipilih dan tambahkan atau hapus sesuai perubahan
            selectedProduk.forEach(function(option) {
                if (!document.getElementById('produk_' + option.value)) {
                    const produkRow = document.createElement('tr');
                    produkRow.id = 'produk_' + option.value;

                    const produkCell = document.createElement('td');
                    produkCell.classList.add('border', 'p-2');
                    produkCell.textContent = option.textContent;

                    const dimensiLebar = option.getAttribute('data-dimensi-lebar');
                    const dimensiTinggi = option.getAttribute('data-dimensi-tinggi');
                    const panjang = option.getAttribute('data-panjang');
                    const dimensiCell = document.createElement('td');
                    dimensiCell.classList.add('border', 'p-2');
                    dimensiCell.textContent = `${dimensiLebar} x ${dimensiTinggi} x ${panjang}`;

                    // Warna produk
                    const warna = option.getAttribute('data-warna');
                    const warnaCell = document.createElement('td');
                    warnaCell.classList.add('border', 'p-2');
                    warnaCell.textContent = warna;

                    // Harga produk
                    const harga = parseFloat(option.getAttribute('data-harga'));
                    const hargaCell = document.createElement('td');
                    hargaCell.classList.add('border', 'p-2');
                    hargaCell.textContent = `Rp. ${formatRupiah(harga)}`;

                    // Form input quantity untuk produk yang dipilih
                    const quantityCell = document.createElement('td');
                    quantityCell.classList.add('border', 'p-2');
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.name = `quantity_${option.value}`;
                    quantityInput.min = 1;
                    quantityInput.value = 1;
                    quantityCell.appendChild(quantityInput);

                    // Total harga per produk (Harga x Quantity)
                    const totalCell = document.createElement('td');
                    totalCell.classList.add('border', 'p-2');
                    const totalSpan = document.createElement('span');
                    totalSpan.textContent = `Rp. ${formatRupiah(harga * quantityInput.value)}`;
                    totalCell.appendChild(totalSpan);

                    // Update total saat quantity berubah
                    quantityInput.addEventListener('input', function() {
                        const quantity = parseFloat(quantityInput.value);
                        const total = (quantity > 0) ? harga * quantity : 0;
                        totalSpan.textContent = `Rp. ${formatRupiah(total)}`;
                    });

                    // Tombol hapus
                    const deleteCell = document.createElement('td');
                    deleteCell.classList.add('border', 'p-2', 'text-center');
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Remove';
                    deleteButton.classList.add('text-red-500');
                    deleteButton.onclick = function() {
                        produkRow.remove(); // Menghapus produk dari tabel
                        selectProduk.querySelector(`option[value="${option.value}"]`).selected = false;
                    };

                    deleteCell.appendChild(deleteButton);

                    // Menambahkan sel ke dalam baris
                    produkRow.appendChild(produkCell);
                    produkRow.appendChild(dimensiCell);
                    produkRow.appendChild(warnaCell);
                    produkRow.appendChild(hargaCell);
                    produkRow.appendChild(quantityCell);
                    produkRow.appendChild(totalCell);
                    produkRow.appendChild(deleteCell);

                    // Menambahkan baris ke dalam tabel
                    produkTableBody.appendChild(produkRow);
                }
            });
        });

        selectAksesoris.addEventListener('change', function() {
            const selectedAksesoris = Array.from(selectAksesoris.selectedOptions);

            if (selectedAksesoris.length > 0) {
                aksesorisSelected.style.display = "block";
            } else {
                aksesorisSelected.style.display = "none";
            }

            selectedAksesoris.forEach(function(option) {
                if (!document.getElementById('aksesoris_' + option.value)) {
                    const aksesorisRow = document.createElement('tr');
                    aksesorisRow.id = 'aksesoris_' + option.value;

                    const aksesorisCell = document.createElement('td');
                    aksesorisCell.classList.add('border', 'p-2');
                    aksesorisCell.textContent = option.textContent;

                    // Satuan aksesoris
                    const satuan = option.getAttribute('data-satuan');
                    const satuanCell = document.createElement('td');
                    satuanCell.classList.add('border', 'p-2');
                    satuanCell.textContent = satuan; // Menampilkan satuan aksesoris

                    const harga = parseFloat(option.getAttribute('data-harga'));
                    const hargaCell = document.createElement('td');
                    hargaCell.classList.add('border', 'p-2');
                    hargaCell.textContent = `Rp. ${formatRupiah(harga)}`;

                    const quantityCell = document.createElement('td');
                    quantityCell.classList.add('border', 'p-2');
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.name = `quantity_${option.value}`;
                    quantityInput.min = 1;
                    quantityInput.value = 1;
                    quantityCell.appendChild(quantityInput);

                    const totalCell = document.createElement('td');
                    totalCell.classList.add('border', 'p-2');
                    const totalSpan = document.createElement('span');
                    totalSpan.textContent = `Rp. ${formatRupiah(harga * quantityInput.value)}`;
                    totalCell.appendChild(totalSpan);

                    quantityInput.addEventListener('input', function() {
                        const quantity = parseFloat(quantityInput.value);
                        const total = (quantity > 0) ? harga * quantity : 0;
                        totalSpan.textContent = `Rp. ${formatRupiah(total)}`;
                    });

                    const deleteCell = document.createElement('td');
                    deleteCell.classList.add('border', 'p-2', 'text-center');
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Remove';
                    deleteButton.classList.add('text-red-500');
                    deleteButton.onclick = function() {
                        aksesorisRow.remove();
                        selectAksesoris.querySelector(`option[value="${option.value}"]`).selected =
                            false;
                    };

                    deleteCell.appendChild(deleteButton);

                    aksesorisRow.appendChild(aksesorisCell);
                    aksesorisRow.appendChild(satuanCell); // Menambahkan kolom satuan
                    aksesorisRow.appendChild(hargaCell);
                    aksesorisRow.appendChild(quantityCell);
                    aksesorisRow.appendChild(totalCell);
                    aksesorisRow.appendChild(deleteCell);

                    aksesorisTableBody.appendChild(aksesorisRow);
                }
            });
        });
    </script>
</x-layouts.app>
