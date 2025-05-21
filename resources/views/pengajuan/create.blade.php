<x-layouts.app :title="__('Tambah Pengajuan')">

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

      <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Tambah Pengajuan')" :description="__('Masukkan detail pengajuan di bawah ini')" />

        <form id="pengajuanForm" method="POST" action="{{ route('admin.pengajuan.store') }}" class="flex flex-col gap-6">
            @csrf

            <input type="hidden" name="json_produk" id="json_produk">
            <input type="hidden" name="json_aksesoris" id="json_aksesoris">
            <input type="hidden" name="syarat_kondisi" id="syarat_kondisi">

            <!-- Sales -->
            <flux:select name="id_user" :label="__('Sales')" required>
                <option value="" disabled>{{ __('Pilih Pengguna') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </flux:select>

            <!-- Judul Pengajuan -->
            <flux:input name="judul_pengajuan" :label="__('Judul Pengajuan')" type="text" required autocomplete="off"
                :placeholder="__('Masukkan judul pengajuan')" value="{{ old('judul_pengajuan') }}" />

            <div class="grid grid-cols-2 gap-6">
                <flux:input name="title_produk" :label="__('Title Produk')" type="text" required autocomplete="off"
                    :placeholder="__('Masukkan Title Pengajuan Produk')" value="{{ old('title_produk') }}" />
                <flux:input name="title_aksesoris" :label="__('Title Aksesoris')" type="text" required
                    autocomplete="off" :placeholder="__('Masukkan Title Pengajuan Aksesoris')" value="{{ old('title_aksesoris') }}" />
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Client -->
                <flux:input name="client" :label="__('Client')" type="text" required autocomplete="off"
                    :placeholder="__('Masukkan nama client')" value="{{ old('client') }}" />

                <!-- Nama Client -->
                <flux:input name="nama_client" :label="__('Nama Client')" type="text" required autocomplete="off"
                    :placeholder="__('Masukkan nama lengkap client')" value="{{ old('nama_client') }}" />
            </div>

            <div class="grid grid-cols-2 gap-6">
                <flux:select name="json_produk" id="produkSelect">
                    <option value="" disabled selected>{{ __('Pilih Produk') }}</option>
                    @foreach ($produk as $prod)
                        <option value="{{ $prod->id }}" data-harga="{{ $prod->harga }}" data-type="{{ $prod->type }}"
                            data-dimensi-lebar="{{ $prod->dimensi_lebar }}" data-dimensi-tinggi="{{ $prod->dimensi_tinggi }}"
                            data-panjang="{{ $prod->panjang }}" data-warna="{{ $prod->warna }}"
                            {{ in_array($prod->id, old('json_produk', [])) ? 'selected' : '' }}>
                            {{ $prod->type }}
                        </option>
                    @endforeach
                </flux:select>

                <flux:select name="json_aksesoris" id="aksesorisSelect">
                    <option value="" disabled selected>{{ __('Pilih Aksesoris') }}</option>
                    @foreach ($aksesoris as $aks)
                        <option value="{{ $aks->id }}" data-harga="{{ $aks->harga }}" data-type="{{ $aks->type }}"
                            data-satuan="{{ $aks->satuan }}"
                            {{ in_array($aks->id, old('json_aksesoris', [])) ? 'selected' : '' }}>
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
            <div class="grid grid-cols-4 gap-6">
                <flux:input name="diskon_satu" :label="__('Diskon 1')" :placeholder="__('... %')" type="number"
                    value="{{ old('diskon_satu') }}" />
                <flux:input name="diskon_dua" :label="__('Diskon 2')" :placeholder="__('... %')" type="number"
                    value="{{ old('diskon_dua') }}" />
                <flux:input name="diskon_tiga" :label="__('Diskon 3')" :placeholder="__('... %')" type="number"
                    value="{{ old('diskon_tiga') }}" />
                <flux:input name="ppn" :label="__('PPn %')" :placeholder="__('... %')" type="number"
                    value="{{ old('ppn') }}" />
            </div>

            <!-- Note -->
            <flux:textarea name="note" :label="__('Catatan')" required rows="4"
                placeholder="Masukkan catatan tambahan...">{{ old('note') }}</flux:textarea>

            <div class="space-y-4">
                @foreach ($syarats as $syarat)
                    <div class="flex items-center">
                        <input type="checkbox" id="syarat_{{ $syarat->id }}" name="syarat_kondisi[]"
                            value="{{ $syarat->syarat }}" class="mr-2"
                            {{ in_array($syarat->syarat, old('syarat_kondisi', [])) ? 'checked' : '' }}>
                        <label for="syarat_{{ $syarat->id }}" class="text-sm">{{ $syarat->syarat }}</label>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Simpan') }}
                </flux:button>
            </div>
        </form>
    </div>

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

        // Fungsi untuk mengupdate data JSON produk
        function updateProdukJSON() {
            const produkData = [];
            produkTableBody.querySelectorAll('tr').forEach(row => {
                const id = row.id.split('_')[1];
                const quantityInput = row.querySelector('input[type="number"]');
                const quantity = quantityInput ? parseInt(quantityInput.value, 10) : 1;
                const hargaText = row.querySelector('td:nth-child(4)').textContent;
                const harga = parseFloat(hargaText.replace(/[^0-9]/g, ''));
                const type = row.querySelector('td:nth-child(1)').textContent;
                const dimensiText = row.querySelector('td:nth-child(2)').textContent;
                const warnaText = row.querySelector('td:nth-child(3)').textContent;

                produkData.push({
                    id: id,
                    type: type,
                    quantity: quantity,
                    harga: harga,
                    dimensi: dimensiText,
                    warna: warnaText
                });
            });

            document.getElementById('json_produk').value = JSON.stringify(produkData);
            console.log('Produk Data JSON:', document.getElementById('json_produk').value);
        }

        // Fungsi untuk mengupdate data JSON aksesoris
        function updateAksesorisJSON() {
            const aksesorisData = [];
            aksesorisTableBody.querySelectorAll('tr').forEach(row => {
                const id = row.id.split('_')[1];
                const quantityInput = row.querySelector('input[type="number"]');
                const quantity = quantityInput ? parseInt(quantityInput.value, 10) : 1;
                const hargaText = row.querySelector('td:nth-child(3)').textContent;
                const harga = parseFloat(hargaText.replace(/[^0-9]/g, ''));
                const satuanText = row.querySelector('td:nth-child(2)').textContent;

                aksesorisData.push({
                    id: id,
                    quantity: quantity,
                    harga: harga,
                    satuan: satuanText
                });
            });

            document.getElementById('json_aksesoris').value = JSON.stringify(aksesorisData);
            console.log('Aksesoris Data JSON:', document.getElementById('json_aksesoris').value);
        }

        // Event listener untuk select produk
        selectProduk.addEventListener('change', function() {
            const selectedProduk = this.options[this.selectedIndex];

            // Jika ada produk yang dipilih
            if (selectedProduk && selectedProduk.value) {
                produkSelected.style.display = "block";

                // Jika produk belum ada di tabel, tambahkan
                if (!document.getElementById('produk_' + selectedProduk.value)) {
                    const produkRow = document.createElement('tr');
                    produkRow.id = 'produk_' + selectedProduk.value;

                    const produkCell = document.createElement('td');
                    produkCell.classList.add('border', 'p-2');
                    produkCell.textContent = selectedProduk.textContent;

                    const dimensiLebar = selectedProduk.getAttribute('data-dimensi-lebar');
                    const dimensiTinggi = selectedProduk.getAttribute('data-dimensi-tinggi');
                    const panjang = selectedProduk.getAttribute('data-panjang');
                    const dimensiCell = document.createElement('td');
                    dimensiCell.classList.add('border', 'p-2');
                    dimensiCell.textContent = `${dimensiLebar} x ${dimensiTinggi} x ${panjang}`;

                    // Warna produk
                    const warna = selectedProduk.getAttribute('data-warna');
                    const warnaCell = document.createElement('td');
                    warnaCell.classList.add('border', 'p-2');
                    warnaCell.textContent = warna;

                    // Harga produk
                    const harga = parseFloat(selectedProduk.getAttribute('data-harga'));
                    const hargaCell = document.createElement('td');
                    hargaCell.classList.add('border', 'p-2');
                    hargaCell.textContent = `Rp. ${formatRupiah(harga)}`;

                    // Form input quantity untuk produk yang dipilih
                    const quantityCell = document.createElement('td');
                    quantityCell.classList.add('border', 'p-2');
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.name = `quantity_${selectedProduk.value}`;
                    quantityInput.min = 1;
                    quantityInput.value = 1;
                    quantityCell.appendChild(quantityInput);

                    // Total harga per produk (Harga x Quantity)
                    const totalCell = document.createElement('td');
                    totalCell.classList.add('border', 'p-2');
                    const totalSpan = document.createElement('span');
                    totalSpan.textContent = `Rp. ${formatRupiah(harga * parseInt(quantityInput.value, 10))}`;
                    totalCell.appendChild(totalSpan);

                    // Update total dan JSON saat quantity berubah
                    quantityInput.addEventListener('input', function() {
                        const quantity = parseInt(this.value, 10);
                        const total = (quantity > 0) ? harga * quantity : 0;
                        totalSpan.textContent = `Rp. ${formatRupiah(total)}`;
                        updateProdukJSON();
                    });

                    // Tombol hapus
                    const deleteCell = document.createElement('td');
                    deleteCell.classList.add('border', 'p-2', 'text-center');
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Remove';
                    deleteButton.classList.add('text-red-500');
                    deleteButton.type = 'button'; // Penting untuk mencegah form submit
                    deleteButton.onclick = function() {
                        produkRow.remove(); // Menghapus produk dari tabel
                        updateProdukJSON();
                        if (produkTableBody.children.length === 0) {
                            produkSelected.style.display = "none";
                        }
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
                    updateProdukJSON();
                }
            }

            // Reset pilihan dropdown setelah ditambahkan ke tabel
            this.selectedIndex = 0;
        });

        // Event listener untuk select aksesoris
        selectAksesoris.addEventListener('change', function() {
            const selectedAksesoris = this.options[this.selectedIndex];

            // Jika ada aksesoris yang dipilih
            if (selectedAksesoris && selectedAksesoris.value) {
                aksesorisSelected.style.display = "block";

                // Jika aksesoris belum ada di tabel, tambahkan
                if (!document.getElementById('aksesoris_' + selectedAksesoris.value)) {
                    const aksesorisRow = document.createElement('tr');
                    aksesorisRow.id = 'aksesoris_' + selectedAksesoris.value;

                    const aksesorisCell = document.createElement('td');
                    aksesorisCell.classList.add('border', 'p-2');
                    aksesorisCell.textContent = selectedAksesoris.textContent;

                    // Satuan aksesoris
                    const satuan = selectedAksesoris.getAttribute('data-satuan');
                    const satuanCell = document.createElement('td');
                    satuanCell.classList.add('border', 'p-2');
                    satuanCell.textContent = satuan;

                    const harga = parseFloat(selectedAksesoris.getAttribute('data-harga'));
                    const hargaCell = document.createElement('td');
                    hargaCell.classList.add('border', 'p-2');
                    hargaCell.textContent = `Rp. ${formatRupiah(harga)}`;

                    const quantityCell = document.createElement('td');
                    quantityCell.classList.add('border', 'p-2');
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.name = `quantity_${selectedAksesoris.value}`;
                    quantityInput.min = 1;
                    quantityInput.value = 1;
                    quantityCell.appendChild(quantityInput);

                    const totalCell = document.createElement('td');
                    totalCell.classList.add('border', 'p-2');
                    const totalSpan = document.createElement('span');
                    totalSpan.textContent = `Rp. ${formatRupiah(harga * parseInt(quantityInput.value, 10))}`;
                    totalCell.appendChild(totalSpan);

                    quantityInput.addEventListener('input', function() {
                        const quantity = parseInt(this.value, 10);
                        const total = (quantity > 0) ? harga * quantity : 0;
                        totalSpan.textContent = `Rp. ${formatRupiah(total)}`;
                        updateAksesorisJSON();
                    });

                    const deleteCell = document.createElement('td');
                    deleteCell.classList.add('border', 'p-2', 'text-center');
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Remove';
                    deleteButton.classList.add('text-red-500');
                    deleteButton.type = 'button'; // Penting untuk mencegah form submit
                    deleteButton.onclick = function() {
                        aksesorisRow.remove();
                        updateAksesorisJSON();
                        if (aksesorisTableBody.children.length === 0) {
                            aksesorisSelected.style.display = "none";
                        }
                    };

                    deleteCell.appendChild(deleteButton);

                    aksesorisRow.appendChild(aksesorisCell);
                    aksesorisRow.appendChild(satuanCell);
                    aksesorisRow.appendChild(hargaCell);
                    aksesorisRow.appendChild(quantityCell);
                    aksesorisRow.appendChild(totalCell);
                    aksesorisRow.appendChild(deleteCell);

                    aksesorisTableBody.appendChild(aksesorisRow);
                    updateAksesorisJSON();
                }
            }

            this.selectedIndex = 0;
        });

        // Form submission handler
        document.getElementById("pengajuanForm").addEventListener("submit", function(event) {
            updateProdukJSON();
            updateAksesorisJSON();
            const syaratKondisiCheckboxes = document.querySelectorAll('input[name="syarat_kondisi[]"]:checked');

            // Buat array untuk menyimpan syarat yang dicentang
            const syaratKondisi = Array.from(syaratKondisiCheckboxes).map(function(checkbox) {
                return {
                    id: checkbox.value,
                    kondisi: checkbox.nextElementSibling.textContent.trim() // Menyimpan teks syarat
                };
            });

            // Masukkan array ke dalam input hidden json_syarat_kondisi
            document.getElementById('syarat_kondisi').value = JSON.stringify(syaratKondisi);

            // Validasi form lainnya
            if (produkTableBody.children.length === 0) {
                alert('Pilih minimal satu produk!');
                return false;
            }

            if (aksesorisTableBody.children.length === 0) {
                alert('Pilih minimal satu aksesoris!');
                return false;
            }
        });
    </script>
</x-layouts.app>
