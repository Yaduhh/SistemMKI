    <div>
        <div id="tukang-section-list" class="space-y-8"></div>
        <button type="button"
            class="bg-purple-600 dark:bg-purple-900/30 border-b border-t border-purple-600 dark:border-purple-400 text-white px-4 py-3 w-full"
            id="add-tukang-section">TAMBAH SECTION</button>
        <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
            <div class="text-right">
                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Grand Total:</span>
                <span class="ml-2 text-lg font-bold text-purple-600 dark:text-purple-400 tukang-grand-total">Rp 0</span>
            </div>
        </div>
        <template id="tukang-section-template">
            <div class="tukang-section relative">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Debet (Biaya Tukang)</label>
                        <input type="text" placeholder="masukkan nilai debet"
                            name="json_pengeluaran_tukang[__SECIDX__][debet]"
                            class="border rounded-lg px-4 py-2.5 w-full debet-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    </div>
                </div>
                <div class="space-y-4 termin-list"></div>
                <button type="button"
                    class="my-4 bg-purple-600 dark:bg-purple-900/30 rounded-lg border border-purple-600 dark:border-purple-400 text-white px-4 py-2 add-termin">
                    Tambah Termin
                </button>
                <button type="button" class="absolute top-0 right-0 text-red-500 font-bold remove-section"
                    style="z-index:10;">Hapus Section</button>
                <template class="termin-row-template">
                    <div
                        class="grid grid-cols-1 lg:grid-cols-7 gap-2 items-center tukang-termin-row relative">
                        <span class="termin-label font-semibold"></span>
                        <input type="date" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][tanggal]"
                            class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <input type="text" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][kredit]"
                            placeholder="Kredit"
                            class="border rounded-lg px-4 py-2.5 kredit-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                        <input type="text" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][sisa]"
                            placeholder="Sisa"
                            class="border rounded-lg px-4 py-2.5 sisa-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                            readonly>
                        <input type="text" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][persentase]"
                            placeholder="%"
                            class="border rounded-lg px-4 py-2.5 persentase-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                            readonly>
                        <input type="text" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][status]"
                            value="Pengajuan" placeholder="Status"
                            class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 font-medium"
                            readonly>
                        <div class="flex justify-end w-full">
                            <button type="button"
                                class="text-red-400 w-full bg-red-600 dark:bg-red-900/30 border border-red-600 dark:border-red-400 font-bold remove-termin px-4 py-2.5 rounded-lg">Hapus</button>
                        </div>
                    </div>
                </template>
            </div>
        </template>
        <script>
            (function() {
                const sectionList = document.getElementById('tukang-section-list');
                const addSectionBtn = document.getElementById('add-tukang-section');
                const sectionTemplate = document.getElementById('tukang-section-template');

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
                    sectionList.querySelectorAll('.tukang-section').forEach((section, secIdx) => {
                        // Debet
                        section.querySelectorAll('input[name^="json_pengeluaran_tukang["]').forEach(input => {
                            let name = input.getAttribute('name');
                            name = name.replace(/json_pengeluaran_tukang\[\d+\]/,
                                `json_pengeluaran_tukang[${secIdx}]`);
                            input.setAttribute('name', name);
                        });
                        // Termin
                        section.querySelectorAll('.tukang-termin-row').forEach((row, terIdx) => {
                            row.querySelectorAll('input').forEach(input => {
                                let name = input.getAttribute('name');
                                name = name.replace(
                                    /json_pengeluaran_tukang\[\d+\]\[termin\]\[\d+\]/,
                                    `json_pengeluaran_tukang[${secIdx}][termin][${terIdx}]`);
                                input.setAttribute('name', name);
                            });
                            // Label Termin
                            const label = row.querySelector('.termin-label');
                            if (label) label.textContent = `Termin ${terIdx + 1}`;
                        });
                    });
                }

                function fillTerminRow(row, data) {
                    if (!data || typeof data !== 'object') return;
                    for (const key in data) {
                        const input = row.querySelector(`[name^='json_pengeluaran_tukang'][name$='[${key}]']`);
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
                                input.value = data[key] || 'Pengajuan';
                            } else {
                                input.value = data[key] || '';
                            }
                        }
                    }

                    // Pastikan status ada untuk termin baru
                    const statusInput = row.querySelector('[name*="[status]"]');
                    if (statusInput && !statusInput.value) {
                        statusInput.value = 'Pengajuan';
                    }
                }

                function fillSection(section, data) {
                    if (!data || typeof data !== 'object') return;
                    console.log('Filling section with data:', data); // Debug
                    for (const key in data) {
                        if (key === 'termin') continue;
                        const input = section.querySelector(`[name^='json_pengeluaran_tukang'][name$='[${key}]']`);
                        if (input) {
                            if (key === 'debet') {
                                // Format Rupiah untuk field debet
                                let value = data[key];
                                if (value !== null && value !== undefined) {
                                    const numericValue = parseInt(value.toString().replace(/\D/g, '')) || 0;
                                    input.value = formatRupiah(numericValue);
                                    console.log('Set debet input value:', input.value); // Debug
                                } else {
                                    input.value = '';
                                }
                            } else {
                                input.value = data[key] || '';
                            }
                        }
                    }
                }

                function addSection(data, isReadonly = false) {
                    const secIdx = sectionList.querySelectorAll('.tukang-section').length;
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

                    // Set readonly untuk data existing
                    if (isReadonly) {
                        setSectionReadonly(section);
                    }
                }

                function addTermin(section, data, isReadonly = false) {
                    const terminList = section.querySelector('.termin-list');
                    const rowTemplate = section.querySelector('.termin-row-template');
                    const terIdx = terminList.querySelectorAll('.tukang-termin-row').length;
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

                    // Set readonly untuk data existing
                    if (isReadonly) {
                        setTerminRowReadonly(row);
                    }

                    renderSectionNames();
                    toggleRemoveTerminButtons(section);
                    setupAutoCalc(section);

                    // Pastikan button hapus sesuai dengan status
                    toggleRemoveButtonByStatus(row);

                    // Setup format Rupiah untuk input yang sudah ada
                    const sisaInput = row.querySelector('.sisa-input');
                    if (sisaInput) {
                        setupRupiahFormat(sisaInput);
                    }
                }

                function toggleRemoveSectionButtons() {
                    const sections = sectionList.querySelectorAll('.tukang-section');
                    sections.forEach(section => {
                        const removeBtn = section.querySelector('.remove-section');

                        // Cek apakah ada termin dengan status Disetujui di section ini
                        const statusInputs = section.querySelectorAll('.tukang-termin-row input[name*="[status]"]');
                        let hasApprovedTermins = false;

                        statusInputs.forEach(input => {
                            if (input.value === 'Disetujui') {
                                hasApprovedTermins = true;
                            }
                        });

                        if (sections.length === 1 || hasApprovedTermins) {
                            removeBtn.style.display = 'none';
                        } else {
                            removeBtn.style.display = '';
                        }
                    });
                }

                function toggleRemoveTerminButtons(section) {
                    const rows = section.querySelectorAll('.tukang-termin-row');
                    rows.forEach(row => {
                        toggleRemoveButtonByStatus(row);
                    });
                }

                // Set readonly untuk section (data existing)
                function setSectionReadonly(section) {
                    // Set readonly untuk input debet
                    section.querySelectorAll('.debet-input').forEach(input => {
                        input.readOnly = true;
                        input.classList.add('bg-gray-100', 'dark:bg-zinc-700', 'cursor-not-allowed');
                    });

                    // Sembunyikan tombol hapus section
                    const removeSectionBtn = section.querySelector('.remove-section');
                    if (removeSectionBtn) {
                        removeSectionBtn.style.display = 'none';
                    }

                    // Tampilkan tombol tambah termin untuk data existing
                    // (tidak disembunyikan agar bisa tambah termin baru)
                    const addTerminBtn = section.querySelector('.add-termin');
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

                    // Sembunyikan tombol hapus termin
                    const removeTerminBtn = row.querySelector('.remove-termin');
                    if (removeTerminBtn) {
                        removeTerminBtn.style.display = 'none';
                    }
                }

                // Fungsi untuk menyembunyikan button hapus berdasarkan status
                function toggleRemoveButtonByStatus(row) {
                    const statusInput = row.querySelector('input[name*="[status]"]');
                    const removeTerminBtn = row.querySelector('.remove-termin');

                    if (statusInput && removeTerminBtn) {
                        if (statusInput.value === 'Disetujui') {
                            removeTerminBtn.style.display = 'none';
                        } else {
                            // Tampilkan button hapus jika bukan status Disetujui
                            // Tapi tetap cek apakah ini termin terakhir
                            const section = row.closest('.tukang-section');
                            const terminRows = section.querySelectorAll('.tukang-termin-row');
                            if (terminRows.length > 1) {
                                removeTerminBtn.style.display = '';
                            } else {
                                removeTerminBtn.style.display = 'none';
                            }
                        }
                    }
                }

                function setupAutoCalc(section) {
                    const debetInput = section.querySelector('.debet-input');
                    const terminRows = section.querySelectorAll('.tukang-termin-row');

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
                    if (e.target.classList.contains('remove-section')) {
                        if (sectionList.querySelectorAll('.tukang-section').length > 1) {
                            if (confirm('Yakin mau hapus section tukang ini?')) {
                                e.target.closest('.tukang-section').remove();
                                renderSectionNames();
                                toggleRemoveSectionButtons();
                                updateGrandTotal();
                            }
                        }
                    }
                    // Add termin
                    if (e.target.classList.contains('add-termin')) {
                        const section = e.target.closest('.tukang-section');
                        addTermin(section);
                        toggleRemoveSectionButtons(); // Update section remove buttons
                    }
                    // Remove termin
                    if (e.target.classList.contains('remove-termin')) {
                        const section = e.target.closest('.tukang-section');
                        const terminList = section.querySelector('.termin-list');
                        if (terminList.querySelectorAll('.tukang-termin-row').length > 1) {
                            if (confirm('Yakin mau hapus termin ini?')) {
                                e.target.closest('.tukang-termin-row').remove();
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
                if (window.existingTukang && Array.isArray(window.existingTukang) && window.existingTukang.length > 0) {
                    console.log('Loading existing tukang data:', window.existingTukang); // Debug
                    window.existingTukang.forEach(section => {
                        if (section && typeof section === 'object') {
                            addSection(section, true);
                        }
                    });
                    // Update grand total setelah semua section ditambahkan
                    setTimeout(updateGrandTotal, 1000);
                    setTimeout(toggleRemoveSectionButtons, 1000); // Update section remove buttons
                }
                // Inisialisasi dari old input jika ada (untuk validation error)
                else if (window.oldTukang && Array.isArray(window.oldTukang) && window.oldTukang.length > 0) {
                    console.log('Loading old tukang data:', window.oldTukang); // Debug
                    window.oldTukang.forEach(section => {
                        if (section && typeof section === 'object') {
                            addSection(section, false);
                        }
                    });
                    // Update grand total setelah semua section ditambahkan
                    setTimeout(updateGrandTotal, 1000);
                    setTimeout(toggleRemoveSectionButtons, 1000); // Update section remove buttons
                }
                toggleRemoveSectionButtons();

                // Setup format Rupiah untuk input yang sudah ada
                function setupExistingRupiahFormat() {
                    sectionList.querySelectorAll('.debet-input').forEach(input => {
                        setupRupiahFormat(input);
                    });
                    sectionList.querySelectorAll('.kredit-input').forEach(input => {
                        setupRupiahFormat(input);
                    });
                    sectionList.querySelectorAll('.sisa-input').forEach(input => {
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
                    sectionList.querySelectorAll('.tukang-section').forEach(section => {
                        // Cek setiap termin dalam section
                        const terminRows = section.querySelectorAll('.tukang-termin-row');
                        terminRows.forEach(row => {
                            const statusInput = row.querySelector('input[name*="[status]"]');
                            const kreditInput = row.querySelector('.kredit-input');

                            // Hanya hitung kredit dari termin yang statusnya Disetujui
                            if (statusInput && statusInput.value === 'Disetujui' && kreditInput) {
                                let kreditValue = kreditInput.value || '0';
                                // Remove Rp, spaces, and convert to number
                                kreditValue = kreditValue.replace(/[^\d]/g, '');
                                const kreditVal = parseInt(kreditValue) || 0;
                                grandTotal += kreditVal;
                            }
                        });
                    });
                    const grandTotalEl = document.querySelector('.tukang-grand-total');
                    if (grandTotalEl) {
                        grandTotalEl.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
                    }
                    console.log('Tukang Grand Total (Approved Kredit Only):', grandTotal); // Debug
                }

                // Update grand total when inputs change
                document.addEventListener('input', function(e) {
                    if (e.target.classList.contains('debet-input') || e.target.classList.contains('kredit-input') ||
                        e.target.name && e.target.name.includes('[status]')) {
                        setTimeout(updateGrandTotal, 100);

                        // Jika yang berubah adalah status input, update button hapus
                        if (e.target.name && e.target.name.includes('[status]')) {
                            const row = e.target.closest('.tukang-termin-row');
                            if (row) {
                                toggleRemoveButtonByStatus(row);
                            }
                            toggleRemoveSectionButtons(); // Update section remove buttons
                        }
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
                    }
                });
            })();
        </script>
    </div>
