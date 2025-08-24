    <div>
        <div id="kerja-tambah-section-list" class="space-y-8"></div>
        <button type="button" class="mt-6 bg-orange-600 dark:bg-orange-900/30 border-b border-t border-orange-600 dark:border-orange-400 text-white px-4 py-2 w-full" id="add-kerja-tambah-section">Tambah Section Kerja Tambah</button>
        <div class="mt-4 p-4 bg-orange-50 dark:bg-orange-900 rounded-lg border border-orange-200 dark:border-orange-700">
            <div class="text-right">
                <span class="text-sm font-medium text-orange-700 dark:text-orange-300">Grand Total:</span>
                <span class="ml-2 text-lg font-bold text-orange-600/30 dark:text-orange-400 kerja-tambah-grand-total">Rp 0</span>
            </div>
        </div>
    <template id="kerja-tambah-section-template">
        <div class="kerja-tambah-section rounded-xl bg-gray-100 dark:bg-zinc-700 p-4 relative">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Debet (Biaya Kerja Tambah)</label>
                    <input type="text" placeholder="masukkan nilai debet" name="json_kerja_tambah[__SECIDX__][debet]" class="border rounded-lg px-4 py-2.5 w-full debet-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                </div>
            </div>
            <div class="space-y-4 kerja-tambah-termin-list"></div>
            <button type="button" class="mt-4 text-orange-400 border border-orange-600 dark:border-orange-400 rounded-xl px-4 py-2 add-kerja-tambah-termin">Tambah Termin</button>
            <button type="button" class="absolute top-4 right-4 text-red-500 font-bold remove-kerja-tambah-section" style="z-index:10;">Hapus Section</button>
            <template class="kerja-tambah-termin-row-template">
                <div class="grid grid-cols-7 gap-2 items-center kerja-tambah-termin-row bg-gray-50 dark:bg-zinc-700/30 p-6 rounded-xl relative">
                    <span class="termin-label font-semibold"></span>
                    <input type="date" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][tanggal]" class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][kredit]" placeholder="Kredit" class="border rounded-lg px-4 py-2.5 kredit-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][sisa]" placeholder="Sisa" class="border rounded-lg px-4 py-2.5 sisa-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly>
                    <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][persentase]" placeholder="%" class="border rounded-lg px-4 py-2.5 persentase-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly>
                    <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][status]" value="Pengajuan" class="border rounded-lg px-4 py-2.5 status-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200" readonly>
                    <div class="flex justify-end w-full">
                        <button type="button" class="text-red-400 bg-red-600 dark:bg-red-900/30 border border-red-600 dark:border-red-400 font-bold remove-kerja-tambah-termin px-4 py-2.5 w-full rounded-lg">Hapus</button>
                    </div>
                </div>
            </template>
        </div>
    </template>
    <script>
        (function () {
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
                            name = name.replace(/json_kerja_tambah\[\d+\]\[termin\]\[\d+\]/, `json_kerja_tambah[${secIdx}][termin][${terIdx}]`);
                            input.setAttribute('name', name);
                        });
                        // Label Termin
                        const label = row.querySelector('.termin-label');
                        if (label) label.textContent = `Termin ${terIdx + 1}`;
                    });
                });
            }

            function fillTerminRow(row, data) {
                if (!data) return;
                for (const key in data) {
                    const input = row.querySelector(`[name^='json_kerja_tambah'][name$='[${key}]']`);
                    if (input) {
                        if (key === 'kredit' || key === 'sisa') {
                            // Format Rupiah untuk field kredit dan sisa
                            const numericValue = parseInt(data[key].toString().replace(/\D/g, '')) || 0;
                            input.value = formatRupiah(numericValue);
                        } else if (key === 'status') {
                            // Gunakan status dari data jika ada, default ke Pengajuan
                            input.value = data[key] || 'Pengajuan';
                        } else {
                            input.value = data[key];
                        }
                    }
                }
                
                // Pastikan status ada untuk termin baru
                const statusInput = row.querySelector('[name*="[status]"]');
                if (statusInput && !statusInput.value) {
                    statusInput.value = 'Pengajuan';
                }
                
                // Update status color setelah fill data
                const statusInputForColor = row.querySelector('.status-input');
                if (statusInputForColor) {
                    updateStatusColor(statusInputForColor);
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

            function addSection(data) {
                const secIdx = sectionList.querySelectorAll('.kerja-tambah-section').length;
                const html = sectionTemplate.innerHTML.replace(/__SECIDX__/g, secIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const section = temp.firstElementChild;
                sectionList.appendChild(section);
                fillSection(section, data);
                if (data && Array.isArray(data.termin) && data.termin.length) {
                    data.termin.forEach((ter, i) => addTermin(section, ter));
                } else {
                    addTermin(section);
                }
                renderSectionNames();
                toggleRemoveSectionButtons();
                setupAutoCalc(section);
                setTimeout(updateGrandTotal, 100); // Update grand total setelah setup selesai
            }

            function addTermin(section, data) {
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
                
                // Pastikan status input di-set dengan benar
                const statusInput = row.querySelector('.status-input');
                if (statusInput && !statusInput.value) {
                    statusInput.value = 'Pengajuan';
                    updateStatusColor(statusInput);
                }
                
                renderSectionNames();
                toggleRemoveTerminButtons(section);
                setupAutoCalc(section);
            }

            function toggleRemoveSectionButtons() {
                const sections = sectionList.querySelectorAll('.kerja-tambah-section');
                sections.forEach(section => {
                    const removeBtn = section.querySelector('.remove-kerja-tambah-section');
                    
                    // Cek apakah ada termin dengan status Disetujui di section ini
                    const statusInputs = section.querySelectorAll('.kerja-tambah-termin-row .status-input');
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
                const rows = section.querySelectorAll('.kerja-tambah-termin-row');
                rows.forEach(row => {
                    toggleRemoveButtonByStatus(row);
                });
            }

            function toggleRemoveButtonByStatus(row) {
                const removeBtn = row.querySelector('.remove-kerja-tambah-termin');
                const statusInput = row.querySelector('.status-input');
                
                if (statusInput && statusInput.value === 'Disetujui') {
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

            function updateStatusColor(statusInput) {
                const status = statusInput.value;
                statusInput.className = 'border rounded-lg px-4 py-2.5 status-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white';
                
                if (status === 'Pengajuan') {
                    statusInput.classList.add('bg-yellow-100', 'dark:bg-yellow-900/30', 'text-yellow-800', 'dark:text-yellow-200');
                } else if (status === 'Disetujui') {
                    statusInput.classList.add('bg-green-100', 'dark:bg-green-900/30', 'text-green-800', 'dark:text-green-200');
                } else if (status === 'Ditolak') {
                    statusInput.classList.add('bg-red-100', 'dark:bg-red-900/30', 'text-red-800', 'dark:text-red-200');
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
                        persentaseInput.value = totalDebet ? ((kredit / totalDebet) * 100).toFixed(2) + '%' : '0%';
                        
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
            sectionList.addEventListener('click', function (e) {
                // Remove section
                if (e.target.classList.contains('remove-kerja-tambah-section')) {
                    if (sectionList.querySelectorAll('.kerja-tambah-section').length > 1) {
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
                        e.target.closest('.kerja-tambah-termin-row').remove();
                        renderSectionNames();
                        toggleRemoveTerminButtons(section);
                        toggleRemoveSectionButtons(); // Update section remove buttons
                    }
                }
            });

            addSectionBtn.addEventListener('click', function() {
                addSection();
                toggleRemoveSectionButtons(); // Update section remove buttons
            });

            // Inisialisasi dari old input atau existing data
            if (window.oldKerjaTambah && Array.isArray(window.oldKerjaTambah) && window.oldKerjaTambah.length > 0) {
                console.log('Loading old kerja tambah data:', window.oldKerjaTambah); // Debug
                window.oldKerjaTambah.forEach(section => addSection(section));
                // Update grand total setelah semua section ditambahkan
                setTimeout(updateGrandTotal, 1000);
            } else if (window.existingKerjaTambah && Array.isArray(window.existingKerjaTambah) && window.existingKerjaTambah.length > 0) {
                console.log('Loading existing kerja tambah data:', window.existingKerjaTambah); // Debug
                window.existingKerjaTambah.forEach(section => addSection(section));
                // Update grand total setelah semua section ditambahkan
                setTimeout(updateGrandTotal, 1000);
                setTimeout(toggleRemoveSectionButtons, 1000); // Update section remove buttons
            } else if (sectionList.querySelectorAll('.kerja-tambah-section').length === 0) {
                addSection();
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
                        const statusInput = row.querySelector('.status-input');
                        
                        if (kreditInput && statusInput && statusInput.value === 'Disetujui') {
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
                    e.target.classList.contains('status-input')) {
                    setTimeout(updateGrandTotal, 100);
                }
                
                // Update status color when status input changes
                if (e.target.classList.contains('status-input')) {
                    updateStatusColor(e.target);
                    toggleRemoveButtonByStatus(e.target.closest('.kerja-tambah-termin-row'));
                    toggleRemoveSectionButtons(); // Update section remove buttons
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

            observer.observe(sectionList, { childList: true });

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