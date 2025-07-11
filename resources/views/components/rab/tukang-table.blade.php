<div>
    <div id="tukang-section-list" class="space-y-8"></div>
    <button type="button" class="mt-6 bg-purple-600 dark:bg-purple-900/30 border-b border-t border-purple-600 dark:border-purple-400 text-white px-4 py-2 w-full" id="add-tukang-section">Tambah Section Pengeluaran Tukang</button>
    <template id="tukang-section-template">
        <div class="tukang-section rounded-xl bg-white dark:bg-zinc-800/40 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nilai Kontrak</label>
                    <input type="number" name="json_pengeluaran_tukang[__SECIDX__][nilai_kontrak]" class="border rounded-lg px-4 py-2.5 w-full dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Debet (Biaya Tukang)</label>
                    <input type="number" name="json_pengeluaran_tukang[__SECIDX__][debet]" class="border rounded-lg px-4 py-2.5 w-full dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                </div>
            </div>
            <div class="space-y-4 termin-list"></div>
            <button type="button" class="mt-4 bg-blue-500 text-white rounded-xl px-4 py-2 add-termin">Tambah Termin</button>
            <button type="button" class="absolute top-2 right-2 text-red-500 font-bold remove-section" style="z-index:10;">Hapus Section</button>
            <template class="termin-row-template">
                <div class="grid grid-cols-5 gap-2 items-end tukang-termin-row bg-gray-50 dark:bg-zinc-700/30 p-6 rounded-xl relative">
                    <input type="date" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][tanggal]" class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                    <input type="text" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][item]" placeholder="Termin" class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                    <input type="number" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][progress]" placeholder="%" class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" min="0" max="100" required>
                    <input type="number" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][kredit]" placeholder="Kredit" class="border rounded-lg px-4 py-2.5 kredit-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" min="0">
                    <input type="number" name="json_pengeluaran_tukang[__SECIDX__][termin][__TERIDX__][sisa]" placeholder="Sisa" class="border rounded-lg px-4 py-2.5 sisa-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly>
                    <div class="flex justify-end col-span-5">
                        <button type="button" class="text-red-400 bg-red-600 dark:bg-red-900/30 border border-red-600 dark:border-red-400 font-bold remove-termin mt-4 px-4 py-2 rounded-lg">Hapus</button>
                    </div>
                </div>
            </template>
        </div>
    </template>
    <script>
        (function () {
            const sectionList = document.getElementById('tukang-section-list');
            const addSectionBtn = document.getElementById('add-tukang-section');
            const sectionTemplate = document.getElementById('tukang-section-template');

            function renderSectionNames() {
                sectionList.querySelectorAll('.tukang-section').forEach((section, secIdx) => {
                    // Nilai kontrak & debet
                    section.querySelectorAll('input[name^="json_pengeluaran_tukang["]').forEach(input => {
                        let name = input.getAttribute('name');
                        name = name.replace(/json_pengeluaran_tukang\[\d+\]/, `json_pengeluaran_tukang[${secIdx}]`);
                        input.setAttribute('name', name);
                    });
                    // Termin
                    section.querySelectorAll('.tukang-termin-row').forEach((row, terIdx) => {
                        row.querySelectorAll('input').forEach(input => {
                            let name = input.getAttribute('name');
                            name = name.replace(/json_pengeluaran_tukang\[\d+\]\[termin\]\[\d+\]/, `json_pengeluaran_tukang[${secIdx}][termin][${terIdx}]`);
                            input.setAttribute('name', name);
                        });
                    });
                });
            }

            function fillTerminRow(row, data) {
                if (!data) return;
                for (const key in data) {
                    const input = row.querySelector(`[name^='json_pengeluaran_tukang'][name$='[${key}]']`);
                    if (input) input.value = data[key];
                }
            }
            function fillSection(section, data) {
                if (!data) return;
                for (const key in data) {
                    if (key === 'termin') continue;
                    const input = section.querySelector(`[name^='json_pengeluaran_tukang'][name$='[${key}]']`);
                    if (input) input.value = data[key];
                }
            }

            function addSection(data) {
                const secIdx = sectionList.querySelectorAll('.tukang-section').length;
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
            }

            function addTermin(section, data) {
                const terminList = section.querySelector('.termin-list');
                const rowTemplate = section.querySelector('.termin-row-template');
                const terIdx = terminList.querySelectorAll('.tukang-termin-row').length;
                const html = rowTemplate.innerHTML.replace(/__TERIDX__/g, terIdx);
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const row = temp.firstElementChild;
                terminList.appendChild(row);
                fillTerminRow(row, data);
                renderSectionNames();
                toggleRemoveTerminButtons(section);
            }

            function toggleRemoveSectionButtons() {
                const sections = sectionList.querySelectorAll('.tukang-section');
                sections.forEach(section => {
                    const removeBtn = section.querySelector('.remove-section');
                    if (sections.length === 1) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = '';
                    }
                });
            }

            function toggleRemoveTerminButtons(section) {
                const rows = section.querySelectorAll('.tukang-termin-row');
                rows.forEach(row => {
                    const removeBtn = row.querySelector('.remove-termin');
                    if (rows.length === 1) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = '';
                    }
                });
            }

            // Section events
            sectionList.addEventListener('click', function (e) {
                // Remove section
                if (e.target.classList.contains('remove-section')) {
                    if (sectionList.querySelectorAll('.tukang-section').length > 1) {
                        e.target.closest('.tukang-section').remove();
                        renderSectionNames();
                        toggleRemoveSectionButtons();
                    }
                }
                // Add termin
                if (e.target.classList.contains('add-termin')) {
                    const section = e.target.closest('.tukang-section');
                    addTermin(section);
                }
                // Remove termin
                if (e.target.classList.contains('remove-termin')) {
                    const section = e.target.closest('.tukang-section');
                    const terminList = section.querySelector('.termin-list');
                    if (terminList.querySelectorAll('.tukang-termin-row').length > 1) {
                        e.target.closest('.tukang-termin-row').remove();
                        renderSectionNames();
                        toggleRemoveTerminButtons(section);
                    }
                }
            });

            addSectionBtn.addEventListener('click', addSection);

            // Inisialisasi dari old input jika ada
            if (window.oldTukang && Array.isArray(window.oldTukang) && window.oldTukang.length) {
                window.oldTukang.forEach(section => addSection(section));
            } else if (sectionList.querySelectorAll('.tukang-section').length === 0) {
                addSection();
            } else toggleRemoveSectionButtons();
        })();
    </script>
</div> 