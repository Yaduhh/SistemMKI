<x-layouts.app :title="__('Edit Surat Jalan')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Edit Surat Jalan')" :description="__('Please update the details of Surat Jalan below')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form action="{{ route('admin.surat_jalan.update', $suratJalan->id) }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @method('PUT') <!-- Method PUT untuk update -->

            <!-- No PO -->
            <flux:input name="no_po" :label="__('No PO')" type="text" value="{{ old('no_po', $suratJalan->no_po) }}" required autocomplete="off" :placeholder="__('Enter PO Number')" />

            <!-- No SPP -->
            <flux:input name="no_spp" :label="__('No SPP')" type="text" value="{{ old('no_spp', $suratJalan->no_spp) }}" required autocomplete="off" :placeholder="__('Enter SPP Number')" />

            <!-- Keterangan -->
            <flux:input name="keterangan" :label="__('Keterangan')" type="text" value="{{ old('keterangan', $suratJalan->keterangan) }}" required autocomplete="off" :placeholder="__('Enter Description')" />

            <!-- Tujuan -->
            <flux:input name="tujuan" :label="__('Tujuan')" type="text" value="{{ old('tujuan', $suratJalan->tujuan) }}" required autocomplete="off" :placeholder="__('Enter Destination')" />

            <!-- Proyek -->
            <flux:input name="proyek" :label="__('Proyek')" type="text" value="{{ old('proyek', $suratJalan->proyek) }}" required autocomplete="off" :placeholder="__('Enter Project')" />

            <!-- Penerima -->
            <flux:input name="penerima" :label="__('Penerima')" type="text" value="{{ old('penerima', $suratJalan->penerima) }}" required autocomplete="off" :placeholder="__('Enter Recipient')" />

            <!-- Item Details -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-4">Item Details</h2>

                <div class="item-container mb-4">
                    @foreach ($items as $key => $item)
                        <div class="flex space-x-4 justify-between items-center" id="item-{{ $key }}">
                            <flux:input name="items[{{ $key }}][item]" :label="__('Item')" type="text" value="{{ old('items.' . $key . '.item', $item['item']) }}" required placeholder="Enter Item" />
                            <flux:input name="items[{{ $key }}][kode]" :label="__('Kode')" type="text" value="{{ old('items.' . $key . '.kode', $item['kode']) }}" required placeholder="Enter Code" />
                            <flux:input name="items[{{ $key }}][panjang]" :label="__('Panjang')" type="number" value="{{ old('items.' . $key . '.panjang', $item['panjang']) }}" required placeholder="Enter Length" />
                            <flux:input name="items[{{ $key }}][jumlah]" :label="__('Jumlah')" type="number" value="{{ old('items.' . $key . '.jumlah', $item['jumlah']) }}" required placeholder="Enter Quantity" />
                            <flux:input name="items[{{ $key }}][satuan]" :label="__('Satuan')" type="text" value="{{ old('items.' . $key . '.satuan', $item['satuan']) }}" required placeholder="Enter Unit" />
                            <flux:input name="items[{{ $key }}][keterangan]" :label="__('Keterangan')" type="text" value="{{ old('items.' . $key . '.keterangan', $item['keterangan']) }}" required placeholder="Enter Description" />
                            <button type="button" class="remove-item bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none mt-6" data-index="{{ $key }}">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-item" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Item</button>
            </div>

            <!-- Author -->
            <flux:input name="author" :label="__('Author')" type="text" value="{{ old('author', $suratJalan->author) }}" required autocomplete="off" :placeholder="__('Enter Author')" />

            <!-- Pengirim -->
            <flux:input name="pengirim" :label="__('Pengirim')" type="text" value="{{ old('pengirim', $suratJalan->pengirim) }}" required autocomplete="off" :placeholder="__('Enter Sender')" />

            <!-- Security -->
            <flux:input name="security" :label="__('Security')" type="text" value="{{ old('security', $suratJalan->security) }}" required autocomplete="off" :placeholder="__('Enter Security Officer')" />

            <!-- Diketahui -->
            <flux:input name="diketahui" :label="__('Diketahui')" type="text" value="{{ old('diketahui', $suratJalan->diketahui) }}" required autocomplete="off" :placeholder="__('Enter Known By')" />

            <!-- Disetujui -->
            <flux:input name="disetujui" :label="__('Disetujui')" type="text" value="{{ old('disetujui', $suratJalan->disetujui) }}" required autocomplete="off" :placeholder="__('Enter Approved By')" />

            <!-- Diterima -->
            <flux:input name="diterima" :label="__('Diterima')" type="text" value="{{ old('diterima', $suratJalan->diterima) }}" required autocomplete="off" :placeholder="__('Enter Received By')" />

            <!-- Submit Button -->
            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">{{ __('Save') }}</flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Back to') }}
            <flux:link :href="route('admin.surat_jalan.index')" wire:navigate>{{ __('Surat Jalan List') }}</flux:link>
        </div>
    </div>

    <script>
        // Add new item input fields dynamically
        document.getElementById('add-item').addEventListener('click', function() {
            let container = document.querySelector('.item-container');
            let newItemIndex = container.children.length; // Get the next index for items
            let newItem = document.createElement('div');
            newItem.classList.add('flex', 'space-x-4', 'mt-4', 'items-center', 'justify-between');
            newItem.innerHTML = `
                <flux:input name="items[${newItemIndex}][item]" :label="__('Item')" type="text" required placeholder="Enter Item" />
                <flux:input name="items[${newItemIndex}][kode]" :label="__('Kode')" type="text" required placeholder="Enter Code" />
                <flux:input name="items[${newItemIndex}][panjang]" :label="__('Panjang')" type="number" required placeholder="Enter Length" />
                <flux:input name="items[${newItemIndex}][jumlah]" :label="__('Jumlah')" type="number" required placeholder="Enter Quantity" />
                <flux:input name="items[${newItemIndex}][satuan]" :label="__('Satuan')" type="text" required placeholder="Enter Unit" />
                <flux:input name="items[${newItemIndex}][keterangan]" :label="__('Keterangan')" type="text" required placeholder="Enter Description" />
                <button type="button" class="remove-item bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none mt-6" data-index="${newItemIndex}">Remove</button>
            `;
            container.appendChild(newItem);
        });

        // Remove item dynamically
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                let index = e.target.getAttribute('data-index');
                document.querySelector(`#item-${index}`).remove(); // Remove the item container
            }
        });
    </script>
</x-layouts.app>
