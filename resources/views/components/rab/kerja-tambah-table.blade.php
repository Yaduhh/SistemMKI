<div>
    <div id="kerja-tambah-section-list" class="space-y-8"></div>
    <button type="button" class="mt-6 bg-orange-600 dark:bg-orange-900/30 border-b border-t border-orange-600 dark:border-orange-400 text-white px-4 py-2 w-full" id="add-kerja-tambah-section">Tambah Section Kerja Tambah</button>
    <template id="kerja-tambah-section-template">
        <div class="kerja-tambah-section rounded-xl bg-white dark:bg-zinc-800/40 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nilai Kontrak</label>
                    <input type="number" name="json_kerja_tambah[__SECIDX__][nilai_kontrak]" class="border rounded-lg px-4 py-2.5 w-full dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Debet (Biaya Kerja Tambah)</label>
                    <input type="number" name="json_kerja_tambah[__SECIDX__][debet]" class="border rounded-lg px-4 py-2.5 w-full dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                </div>
            </div>
            <div class="space-y-4 kerja-tambah-termin-list"></div>
            <button type="button" class="mt-4 text-orange-400 border border-orange-600 dark:border-orange-400 rounded-xl px-4 py-2 add-kerja-tambah-termin">Tambah Termin</button>
            <button type="button" class="absolute top-4 right-4 text-red-500 font-bold remove-kerja-tambah-section" style="z-index:10;">Hapus Section</button>
            <template class="kerja-tambah-termin-row-template">
                <div class="grid grid-cols-5 gap-2 items-end kerja-tambah-termin-row bg-gray-50 dark:bg-zinc-700/30 p-6 rounded-xl relative">
                    <input type="date" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][tanggal]" class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                    <input type="text" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][item]" placeholder="Termin" class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" required>
                    <input type="number" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][progress]" placeholder="%" class="border rounded-lg px-4 py-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" min="0" max="100" required>
                    <input type="number" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][kredit]" placeholder="Kredit" class="border rounded-lg px-4 py-2.5 kredit-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" min="0">
                    <input type="number" name="json_kerja_tambah[__SECIDX__][termin][__TERIDX__][sisa]" placeholder="Sisa" class="border rounded-lg px-4 py-2.5 sisa-input dark:bg-zinc-800 dark:border-zinc-700 dark:text-white" readonly>
                    <div class="flex justify-end col-span-5">
                        <button type="button" class="text-red-400 bg-red-600 dark:bg-red-900/30 border border-red-600 dark:border-red-400 font-bold remove-kerja-tambah-termin mt-4 px-4 py-2 rounded-lg">Hapus</button>
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

            function renderSectionNames() {
                sectionList.querySelectorAll('.kerja-tambah-section').forEach((section, secIdx) => {
                    // Nilai kontrak & debet
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
                    });
                });
            }

            function fillTerminRow(row, data) {
                if (!data) return;
                for (const key in data) {
                    const input = row.querySelector(`[name^='json_kerja_tambah'][name$='[${key}]']`);
                    if (input) input.value = data[key];
                }
            }
            function fillSection(section, data) {
                if (!data) return;
                for (const key in data) {
                    if (key === 'termin') continue;
                    const input = section.querySelector(`[name^='json_kerja_tambah'][name$='[${key}]']`);
                    if (input) input.value = data[key];
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
                renderSectionNames();
                toggleRemoveTerminButtons(section);
            }

            function toggleRemoveSectionButtons() {
                const sections = sectionList.querySelectorAll('.kerja-tambah-section');
                sections.forEach(section => {
                    const removeBtn = section.querySelector('.remove-kerja-tambah-section');
                    if (sections.length === 1) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = '';
                    }
                });
            }

            function toggleRemoveTerminButtons(section) {
                const rows = section.querySelectorAll('.kerja-tambah-termin-row');
                rows.forEach(row => {
                    const removeBtn = row.querySelector('.remove-kerja-tambah-termin');
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
                if (e.target.classList.contains('remove-kerja-tambah-section')) {
                    if (sectionList.querySelectorAll('.kerja-tambah-section').length > 1) {
                        e.target.closest('.kerja-tambah-section').remove();
                        renderSectionNames();
                        toggleRemoveSectionButtons();
                    }
                }
                // Add termin
                if (e.target.classList.contains('add-kerja-tambah-termin')) {
                    const section = e.target.closest('.kerja-tambah-section');
                    addTermin(section);
                }
                // Remove termin
                if (e.target.classList.contains('remove-kerja-tambah-termin')) {
                    const section = e.target.closest('.kerja-tambah-section');
                    const terminList = section.querySelector('.kerja-tambah-termin-list');
                    if (terminList.querySelectorAll('.kerja-tambah-termin-row').length > 1) {
                        e.target.closest('.kerja-tambah-termin-row').remove();
                        renderSectionNames();
                        toggleRemoveTerminButtons(section);
                    }
                }
            });

            addSectionBtn.addEventListener('click', addSection);

            // Inisialisasi dari old input jika ada
            if (window.oldKerjaTambah && Array.isArray(window.oldKerjaTambah) && window.oldKerjaTambah.length) {
                window.oldKerjaTambah.forEach(section => addSection(section));
            } else if (sectionList.querySelectorAll('.kerja-tambah-section').length === 0) {
                addSection();
            } else toggleRemoveSectionButtons();
        })();
    </script>
</div> 