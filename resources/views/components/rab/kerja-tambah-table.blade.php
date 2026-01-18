    <div>
        <div id="kerja-tambah-section-list" class="space-y-8"></div>
        <button type="button"
            class="mt-6 bg-orange-600 dark:bg-orange-900/30 border-b border-t border-orange-600 dark:border-orange-400 text-white px-4 py-2 w-full"
            id="add-kerja-tambah-section">Tambah Section Kerja Tambah</button>
        <div class="p-4 bg-orange-50 dark:bg-orange-900 border border-orange-200 dark:border-orange-700">
            <div class="text-right">
                <span class="text-sm font-medium text-orange-700 dark:text-orange-300">Grand Total:</span>
                <span class="ml-2 text-lg font-bold text-orange-600/30 dark:text-orange-400 kerja-tambah-grand-total">Rp
                    0</span>
            </div>
        </div>
        <template id="kerja-tambah-section-template">
            <div class="kerja-tambah-section relative">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Debet (Biaya Kerja Tambah)</label>
                        <input type="text" placeholder="masukkan nilai debet"
                            name="json_kerja_tambah[__SECIDX__][debet]"
                            class="border rounded-lg px-4 py-2.5 w-full debet-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    </div>
                </div>
                <div class="space-y-4 kerja-tambah-termin-list"></div>
                <button type="button"
                    class="mt-4 text-orange-400 border border-orange-600 dark:border-orange-400 rounded-xl px-4 py-2 add-kerja-tambah-termin">Tambah
                    Termin</button>
                <button type="button" class="absolute top-0 right-0 text-red-500 font-bold remove-kerja-tambah-section"
                    style="z-index:10;">Hapus Section</button>
                <template class="kerja-tambah-termin-row-template">
                    <div class="grid grid-cols-1 gap-2 items-center kerja-tambah-termin-row relative">
                        <span class="termin-label font-semibold"></span>
                        <input type="date" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][tanggal]"
                            class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][kredit]"
                            placeholder="Kredit"
                            class="border rounded-lg px-4 py-2.5 kredit-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][sisa]"
                            placeholder="Sisa"
                            class="border rounded-lg px-4 py-2.5 sisa-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                            readonly>
                        <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][persentase]"
                            placeholder="%"
                            class="border rounded-lg px-4 py-2.5 persentase-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                            readonly>
                        <select name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][status]"
                            class="border rounded-lg px-4 py-2.5 status-select dark:bg-zinc-800 dark:border-zinc-700 dark:text-white font-medium">
                            <option value="Pengajuan">Pengajuan</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                        <div class="flex justify-end w-full">
                            <button type="button"
                                class="text-red-400 bg-red-600 dark:bg-red-900/30 border border-red-600 dark:border-red-400 font-bold remove-kerja-tambah-termin px-4 py-2.5 w-full rounded-lg">Hapus</button>
                        </div>
                    </div>
                </template>
            </div>
        </template>
        <script>
            (function() {
                const sectionList = document.getElementById('kerja-tambah-section-list');
                const addSectionBtn = document.getElementById('add-kerja-tambah-section');
                const sectionTemplate = document.getElementById('kerja-tambah-section-template');

                // Fungsi format Rupiah
                function formatRupiah(angka) {
                    if (angka === 0) return '0';
                    if (!angka || angka === '') return '';
                    const number = parseInt(angka.toString().replace(/\D/g, ''));
                    if (isNaN(number)) return '';
                    return number.toLocaleString('id-ID');
                }

                // Fungsi untuk mendapatkan nilai numerik dari input yang diformat
                function getNumericValue(input) {
                    const value = input.value.replace(/\D/g, '');
                    return value ? parseInt(value) : 0;
                }

                // Fungsi untuk setup format Rupiah pada input
                function setupRupiahFormat(input) {
                    input.addEventListener('input', function(e) {
                        const cursorPosition = e.target.selectionStart;
                        const oldValue = e.target.value;
                        const numericValue = oldValue.replace(/\D/g, '');
                        const formattedValue = formatRupiah(numericValue);

                        e.target.value = formattedValue;

                        // Menyesuaikan posisi cursor
                        const newCursorPosition = cursorPosition + (formattedValue.length - oldValue.length);
                        e.target.setSelectionRange(newCursorPosition, newCursorPosition);
                    });

                    input.addEventListener('blur', function(e) {
                        const numericValue = getNumericValue(e.target);
                        if (numericValue >= 0) {
                            e.target.value = formatRupiah(numericValue);
                        } else {
                            e.target.value = '';
                        }
                    });
                }

                function renderSectionNames() {
                    sectionList.querySelectorAll('.kerja-tambah-section').forEach((section, secIdx) => {
                        // Debet
                        section.querySelectorAll('input[name^="json_kerja_tambah["]').forEach(input => {
                            let name = input.getAttribute('name');
                            name = name.replace(/json_kerja_tambah\[\d+\]/, `json_kerja_tambah[${secIdx}]`);
                            input.setAttribute('name', name);
                        });
                        // Termin
                        section.querySelectorAll('.kerja-tambah-termin-row').forEach((row, terIdx) => {
                            row.querySelectorAll('input').forEach(input => {
                                let name = input.getAttribute('name');
                                name = name.replace(/json_kerja_tambah\[\d+\]\[termin\]\[\d+\]/,
                                    `json_kerja_tambah[${secIdx}][termin][${terIdx}]`);
                                input.setAttribute('name', name);
                            });
                            // Label Termin
                            const label = row.querySelector('.termin-label');
                            if (label) label.textContent = `Termin ${terIdx + 1}`;
                        });
                    });
                }

                function fillTerminRow(row, data) {
                    if (data && typeof data === 'object') {
                        for (const key in data) {
                            const input = row.querySelector(`[name^='json_kerja_tambah'][name$='[${key}]']`);
                            if (input) {
                                if (key === 'kredit' || key === 'sisa') {
                                    // Format Rupiah untuk field kredit dan sisa
                                    let value = data[key];
                                    if (value !== null && value !== undefined) {
                                        const numericValue = parseInt(value.toString().replace(/\D/g, '')) || 0;
                                        input.value = formatRupiah(numericValue);
                                    } else {
                                        input.value = '';
                                    }
                                } else if (key === 'status') {
                                    // Gunakan status dari data jika ada, default ke Pengajuan
                                    const statusValue = data[key] || 'Pengajuan';
                                    if (input.tagName === 'SELECT') {
                                        input.value = statusValue;
                                        updateStatusStyling(input);
                                    } else {
                                        input.value = statusValue;
                                    }
                                } else {
                                    input.value = data[key] || '';
                                }
                            }
                        }
                    }

                    // Pastikan status ada untuk termin baru
                    const statusInput = row.querySelector('[name*="[status]"]');
                    if (statusInput) {
                        if (statusInput.tagName === 'SELECT') {
                            if (!statusInput.value) {
                                statusInput.value = 'Pengajuan';
                            }
                            updateStatusStyling(statusInput);
                        } else if (statusInput.tagName !== 'SELECT' && !statusInput.value) {
                            statusInput.value = 'Pengajuan';
                        }
                    }
                }

                function fillSection(section, data) {
                    if (!data) return;
                    console.log('Filling section with data:', data); // Debug
                    for (const key in data) {
                        if (key === 'termin') continue;
                        const input = section.querySelector(`[name^='json_kerja_tambah'][name$='[${key}]']`);
                        if (input) {
                            if (key === 'debet') {
                                // Format Rupiah untuk field debet
                                const numericValue = parseInt(data[key].toString().replace(/\D/g, '')) || 0;
                                input.value = formatRupiah(numericValue);
                                console.log('Set debet input value:', input.value); // Debug
                            } else {
                                input.value = data[key];
                            }
                        }
                    }
                }

                function addSection(data, isReadonly = false) {
                    const secIdx = sectionList.querySelectorAll('.kerja-tambah-section').length;
                    const html = sectionTemplate.innerHTML.replace(/__SECIDX__/g, secIdx);
                    const temp = document.createElement('div');
                    temp.innerHTML = html;
                    const section = temp.firstElementChild;
                    sectionList.appendChild(section);
                    fillSection(section, data);
                    if (data && data.termin && Array.isArray(data.termin) && data.termin.length > 0) {
                        data.termin.forEach((ter, i) => {
                            if (ter && typeof ter === 'object') {
                                addTermin(section, ter, isReadonly);
                            }
                        });
                    } else {
                        addTermin(section, null, isReadonly);
                    }
                    renderSectionNames();
                    toggleRemoveSectionButtons();
                    setupAutoCalc(section);
                    setTimeout(updateGrandTotal, 100); // Update grand total setelah setup selesai

                    // Set readonly untuk data existing hanya jika bukan halaman edit
                    // Di halaman edit, section bisa diedit (kecuali termin dengan status Disetujui)
                    if (isReadonly) {
                        setSectionReadonly(section);
                    }
                }

                function addTermin(section, data, isReadonly = false) {
                    const terminList = section.querySelector('.kerja-tambah-termin-list');
                    const rowTemplate = section.querySelector('.kerja-tambah-termin-row-template');
                    const terIdx = terminList.querySelectorAll('.kerja-tambah-termin-row').length;
                    const html = rowTemplate.innerHTML.replace(/__TERIDX__/g, terIdx);
                    const temp = document.createElement('div');
                    temp.innerHTML = html;
                    const row = temp.firstElementChild;
                    terminList.appendChild(row);
                    fillTerminRow(row, data);

                    // Setup format Rupiah untuk input baru
                    const kreditInput = row.querySelector('.kredit-input');
                    if (kreditInput) {
                        setupRupiahFormat(kreditInput);
                    }

                    // Set readonly untuk data existing hanya jika isReadonly = true
                    // Status sekarang bisa diubah, jadi tidak perlu readonly hanya karena status "Disetujui"
                    if (isReadonly) {
                        setTerminRowReadonly(row);
                    }

                    // Setup event listener untuk status select
                    const statusSelect = row.querySelector('select[name*="[status]"]');
                    if (statusSelect) {
                        updateStatusStyling(statusSelect);
                        statusSelect.addEventListener('change', function() {
                            updateStatusStyling(this);
                            toggleRemoveButtonByStatus(row);
                            toggleRemoveSectionButtons();
                            updateGrandTotal();
                        });
                    }

                    renderSectionNames();
                    toggleRemoveTerminButtons(section);
                    setupAutoCalc(section);

                    // Pastikan button hapus sesuai dengan status
                    toggleRemoveButtonByStatus(row);
                }

                function toggleRemoveSectionButtons() {
                    const sections = sectionList.querySelectorAll('.kerja-tambah-section');
                    sections.forEach(section => {
                        const removeBtn = section.querySelector('.remove-kerja-tambah-section');

                        // Cek apakah ada termin dengan status Disetujui di section ini
                        const statusInputs = section.querySelectorAll('.kerja-tambah-termin-row [name*="[status]"]');
                        let hasApprovedTermins = false;

                        statusInputs.forEach(input => {
                            const statusValue = input.value || input.textContent;
                            if (statusValue === 'Disetujui') {
                                hasApprovedTermins = true;
                            }
                        });

                        // Hanya sembunyikan jika ada termin yang disetujui, tetap bisa hapus walaupun hanya 1 section
                        if (hasApprovedTermins) {
                            removeBtn.style.display = 'none';
                        } else {
                            removeBtn.style.display = '';
                        }
                    });
                }

                function toggleRemoveTerminButtons(section) {
                    const rows = section.querySelectorAll('.kerja-tambah-termin-row');
                    rows.forEach(row => {
                        toggleRemoveButtonByStatus(row);
                    });
                }

                function toggleRemoveButtonByStatus(row) {
                    const removeBtn = row.querySelector('.remove-kerja-tambah-termin');
                    const statusInput = row.querySelector('[name*="[status]"]');

                    if (statusInput) {
                        const statusValue = statusInput.value || statusInput.textContent;
                        if (statusValue === 'Disetujui') {
                            removeBtn.style.display = 'none';
                        } else {
                            const rows = row.closest('.kerja-tambah-termin-list').querySelectorAll('.kerja-tambah-termin-row');
                            if (rows.length === 1) {
                                removeBtn.style.display = 'none';
                            } else {
                                removeBtn.style.display = '';
                            }
                        }
                    }
                }

                // Set readonly untuk section (data existing)
                function setSectionReadonly(section) {
                    // Set readonly untuk input debet
                    section.querySelectorAll('.debet-input').forEach(input => {
                        input.readOnly = true;
                        input.classList.add('bg-gray-100', 'dark:bg-zinc-700', 'cursor-not-allowed');
                    });

                    // Sembunyikan tombol hapus section
                    const removeSectionBtn = section.querySelector('.remove-kerja-tambah-section');
                    if (removeSectionBtn) {
                        removeSectionBtn.style.display = 'none';
                    }

                    // Tampilkan tombol tambah termin untuk data existing
                    // (tidak disembunyikan agar bisa tambah termin baru)
                    const addTerminBtn = section.querySelector('.add-kerja-tambah-termin');
                    if (addTerminBtn) {
                        addTerminBtn.style.display = '';
                    }
                }

                // Set readonly untuk termin row (data existing)
                function setTerminRowReadonly(row) {
                    // Set readonly untuk semua input termin
                    row.querySelectorAll('input').forEach(input => {
                        input.readOnly = true;
                        input.classList.add('bg-gray-100', 'dark:bg-zinc-700', 'cursor-not-allowed');
                    });

                    // Set disabled untuk select status
                    const statusSelect = row.querySelector('select[name*="[status]"]');
                    if (statusSelect) {
                        statusSelect.disabled = true;
                        statusSelect.classList.add('bg-gray-100', 'dark:bg-zinc-700', 'cursor-not-allowed');
                    }

                    // Sembunyikan tombol hapus termin
                    const removeTerminBtn = row.querySelector('.remove-kerja-tambah-termin');
                    if (removeTerminBtn) {
                        removeTerminBtn.style.display = 'none';
                    }
                }

                // Fungsi untuk update styling berdasarkan status
                function updateStatusStyling(selectElement) {
                    if (!selectElement || selectElement.tagName !== 'SELECT') return;
                    
                    // Hapus semua class styling sebelumnya
                    selectElement.classList.remove(
                        'bg-yellow-100', 'dark:bg-yellow-900/30', 'text-yellow-700', 'dark:text-yellow-300',
                        'bg-green-100', 'dark:bg-green-900/30', 'text-green-700', 'dark:text-green-300',
                        'bg-red-100', 'dark:bg-red-900/30', 'text-red-700', 'dark:text-red-300'
                    );

                    // Tambahkan class styling berdasarkan status
                    const status = selectElement.value;
                    if (status === 'Pengajuan') {
                        selectElement.classList.add('bg-yellow-100', 'dark:bg-yellow-900/30', 'text-yellow-700', 'dark:text-yellow-300');
                    } else if (status === 'Disetujui') {
                        selectElement.classList.add('bg-green-100', 'dark:bg-green-900/30', 'text-green-700', 'dark:text-green-300');
                    } else if (status === 'Ditolak') {
                        selectElement.classList.add('bg-red-100', 'dark:bg-red-900/30', 'text-red-700', 'dark:text-red-300');
                    }
                }

                function setupAutoCalc(section) {
                    const debetInput = section.querySelector('.debet-input');
                    const terminRows = section.querySelectorAll('.kerja-tambah-termin-row');

                    function calcAllTermins() {
                        const totalDebet = getNumericValue(debetInput);
                        let remainingDebet = totalDebet;

                        terminRows.forEach((row, idx) => {
                            const kreditInput = row.querySelector('.kredit-input');
                            const sisaInput = row.querySelector('.sisa-input');
                            const persentaseInput = row.querySelector('.persentase-input');

                            const kredit = getNumericValue(kreditInput);
                            const sisa = remainingDebet - kredit;

                            sisaInput.value = formatRupiah(sisa);
                            persentaseInput.value = totalDebet ? ((kredit / totalDebet) * 100).toFixed(2) + '%' :
                                '0%';

                            // Update remaining debet for next termin
                            remainingDebet = sisa;
                        });
                    }

                    // Add event listeners
                    debetInput.addEventListener('input', function() {
                        setTimeout(() => calcAllTermins(), 100);
                    });
                    terminRows.forEach(row => {
                        const kreditInput = row.querySelector('.kredit-input');
                        kreditInput.addEventListener('input', function() {
                            setTimeout(() => calcAllTermins(), 100);
                        });
                    });

                    // Initial calculation
                    calcAllTermins();
                }

                // Section events
                sectionList.addEventListener('click', function(e) {
                    // Remove section
                    if (e.target.classList.contains('remove-kerja-tambah-section')) {
                            if (confirm('Yakin mau hapus section kerja tambah ini?')) {
                                e.target.closest('.kerja-tambah-section').remove();
                                renderSectionNames();
                                toggleRemoveSectionButtons();
                                updateGrandTotal();
                        }
                    }
                    // Add termin
                    if (e.target.classList.contains('add-kerja-tambah-termin')) {
                        const section = e.target.closest('.kerja-tambah-section');
                        addTermin(section);
                        toggleRemoveSectionButtons(); // Update section remove buttons
                    }
                    // Remove termin
                    if (e.target.classList.contains('remove-kerja-tambah-termin')) {
                        const section = e.target.closest('.kerja-tambah-section');
                        const terminList = section.querySelector('.kerja-tambah-termin-list');
                        if (terminList.querySelectorAll('.kerja-tambah-termin-row').length > 1) {
                            if (confirm('Yakin mau hapus termin ini?')) {
                                e.target.closest('.kerja-tambah-termin-row').remove();
                                renderSectionNames();
                                toggleRemoveTerminButtons(section);
                                toggleRemoveSectionButtons(); // Update section remove buttons
                            }
                        }
                    }
                });

                addSectionBtn.addEventListener('click', function() {
                    addSection();
                    toggleRemoveSectionButtons(); // Update section remove buttons
                });

                // Inisialisasi dari data existing RAB jika ada (prioritas tertinggi)
                if (window.existingKerjaTambah && Array.isArray(window.existingKerjaTambah) && window.existingKerjaTambah.length > 0) {
                    console.log('Loading existing kerja tambah data:', window.existingKerjaTambah); // Debug
                    // Jika ini halaman edit (isEditPage = true), maka data bisa diedit (isReadonly = false)
                    // Jika bukan halaman edit, data readonly (isReadonly = true)
                    const isReadonly = !window.isEditPage;
                    window.existingKerjaTambah.forEach(section => {
                        if (section && typeof section === 'object') {
                            addSection(section, isReadonly);
                        }
                    });
                    // Update grand total setelah semua section ditambahkan
                    setTimeout(updateGrandTotal, 1000);
                    setTimeout(toggleRemoveSectionButtons, 1000); // Update section remove buttons
                }
                // Inisialisasi dari old input jika ada (untuk validation error)
                else if (window.oldKerjaTambah && Array.isArray(window.oldKerjaTambah) && window.oldKerjaTambah.length > 0) {
                    console.log('Loading old kerja tambah data:', window.oldKerjaTambah); // Debug
                    window.oldKerjaTambah.forEach(section => {
                        if (section && typeof section === 'object') {
                            addSection(section, false);
                        }
                    });
                    // Update grand total setelah semua section ditambahkan
                    setTimeout(updateGrandTotal, 1000);
                    setTimeout(toggleRemoveSectionButtons, 1000); // Update section remove buttons
                }
                // Tidak menambahkan section secara otomatis jika tidak ada data
                // User harus klik tombol "Tambah Section Kerja Tambah" untuk menambahkan section
                toggleRemoveSectionButtons();

                // Setup format Rupiah untuk input yang sudah ada
                function setupExistingRupiahFormat() {
                    sectionList.querySelectorAll('.debet-input').forEach(input => {
                        setupRupiahFormat(input);
                    });
                    sectionList.querySelectorAll('.kredit-input').forEach(input => {
                        setupRupiahFormat(input);
                    });
                }

                // Setup format Rupiah setelah data dimuat
                setTimeout(() => {
                    setupExistingRupiahFormat();
                    updateGrandTotal(); // Update grand total setelah format Rupiah
                }, 100);

                document.addEventListener('DOMContentLoaded', function() {
                    setupExistingRupiahFormat();
                    updateGrandTotal(); // Update grand total setelah DOM loaded
                });

                // Function to update grand total
                function updateGrandTotal() {
                    let grandTotal = 0;
                    sectionList.querySelectorAll('.kerja-tambah-section').forEach(section => {
                        // Hitung hanya dari kredit termin yang status Disetujui
                        const terminRows = section.querySelectorAll('.kerja-tambah-termin-row');
                        terminRows.forEach(row => {
                            const kreditInput = row.querySelector('.kredit-input');
                            const statusInput = row.querySelector('[name*="[status]"]');

                            // Hanya hitung kredit dari termin yang statusnya Disetujui
                            const statusValue = statusInput ? (statusInput.value || statusInput.textContent) : '';
                            if (statusValue === 'Disetujui' && kreditInput) {
                                // Handle both formatted and raw values
                                let value = kreditInput.value || '0';
                                // Remove Rp, spaces, and convert to number
                                value = value.replace(/[^\d]/g, '');
                                const val = parseInt(value) || 0;
                                grandTotal += val;
                            }
                        });
                    });
                    const grandTotalEl = document.querySelector('.kerja-tambah-grand-total');
                    if (grandTotalEl) {
                        grandTotalEl.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
                    }
                    console.log('Kerja Tambah Grand Total:', grandTotal); // Debug
                }

                // Update grand total when inputs change
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('debet-input') ||
                        e.target.classList.contains('kredit-input') ||
                        (e.target.name && e.target.name.includes('[status]'))) {
                        setTimeout(updateGrandTotal, 100);

                        // Jika yang berubah adalah status input, update button hapus
                        if (e.target.name && e.target.name.includes('[status]')) {
                            const row = e.target.closest('.kerja-tambah-termin-row');
                            if (row) {
                                toggleRemoveButtonByStatus(row);
                                if (e.target.tagName === 'SELECT') {
                                    updateStatusStyling(e.target);
                                }
                            }
                            toggleRemoveSectionButtons(); // Update section remove buttons
                        }
                    }
                });

                // Update grand total when status select changes
                document.addEventListener('change', function(e) {
                    if (e.target.tagName === 'SELECT' && e.target.name && e.target.name.includes('[status]')) {
                        setTimeout(updateGrandTotal, 100);
                        const row = e.target.closest('.kerja-tambah-termin-row');
                        if (row) {
                            toggleRemoveButtonByStatus(row);
                            updateStatusStyling(e.target);
                        }
                        toggleRemoveSectionButtons();
                    }
                });

                // Update grand total when sections are added/removed
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'childList') {
                            setTimeout(updateGrandTotal, 100);
                        }
                    });
                });

                observer.observe(sectionList, {
                    childList: true
                });

                // Initial grand total calculation
                setTimeout(updateGrandTotal, 500);

                // Function to collect kerja tambah data and update hidden input
                window.updateKerjaTambahHiddenInput = function() {
                    const kerjaTambahData = [];
                    
                    sectionList.querySelectorAll('.kerja-tambah-section').forEach((section, secIdx) => {
                        const debetInput = section.querySelector('.debet-input');
                        const debetValue = debetInput ? getNumericValue(debetInput) : 0;
                        
                        if (debetValue > 0) {
                            const terminRows = section.querySelectorAll('.kerja-tambah-termin-row');
                            const terminData = [];
                            
                            terminRows.forEach((row, terIdx) => {
                                const tanggalInput = row.querySelector('input[name*="[tanggal]"]');
                                const kreditInput = row.querySelector('.kredit-input');
                                const sisaInput = row.querySelector('.sisa-input');
                                const persentaseInput = row.querySelector('.persentase-input');
                                const statusInput = row.querySelector('[name*="[status]"]');
                                
                                const tanggal = tanggalInput ? tanggalInput.value : '';
                                const kredit = kreditInput ? getNumericValue(kreditInput) : 0;
                                const sisa = sisaInput ? getNumericValue(sisaInput) : 0;
                                const persentase = persentaseInput ? persentaseInput.value : '0%';
                                const status = statusInput ? (statusInput.value || statusInput.textContent) : 'Pengajuan';
                                
                                // Only add termin if tanggal and kredit are filled
                                if (tanggal && kredit > 0) {
                                    terminData.push({
                                        tanggal: tanggal,
                                        kredit: kredit,
                                        sisa: sisa,
                                        persentase: persentase,
                                        status: status
                                    });
                                }
                            });
                            
                            // Only add section if it has at least one termin
                            if (terminData.length > 0) {
                                kerjaTambahData.push({
                                    debet: debetValue,
                                    termin: terminData
                                });
                            }
                        }
                    });
                    
                    // Update hidden input if exists
                    const hiddenInput = document.querySelector('input[name="json_kerja_tambah"]');
                    if (hiddenInput) {
                        hiddenInput.value = JSON.stringify(kerjaTambahData);
                        console.log('Updated json_kerja_tambah:', kerjaTambahData);
                    } else {
                        console.warn('Hidden input json_kerja_tambah not found');
                    }
                };

                // Convert format Rupiah ke angka sebelum form submit
                document.addEventListener('submit', function(e) {
                    if (e.target.closest('form')) {
                        // Convert debet input
                        sectionList.querySelectorAll('.debet-input').forEach(input => {
                            const numericValue = getNumericValue(input);
                            input.value = numericValue;
                        });

                        // Convert kredit input
                        sectionList.querySelectorAll('.kredit-input').forEach(input => {
                            const numericValue = getNumericValue(input);
                            input.value = numericValue;
                        });

                        // Convert sisa input
                        sectionList.querySelectorAll('.sisa-input').forEach(input => {
                            const numericValue = getNumericValue(input);
                            input.value = numericValue;
                        });
                        
                        // Update hidden input before submit
                        if (typeof window.updateKerjaTambahHiddenInput === 'function') {
                            window.updateKerjaTambahHiddenInput();
                        }
                    }
                });
            })();
        </script>
    </div>
