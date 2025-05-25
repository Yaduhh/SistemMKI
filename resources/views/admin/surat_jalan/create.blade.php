<x-layouts.app :title="__('Create Surat Jalan')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create Surat Jalan')" :description="__('Please enter the details of Surat Jalan below')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form action="{{ route('admin.surat_jalan.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- No PO -->
                <flux:input name="no_po" :label="__('No PO')" type="text" required autocomplete="off"
                    :placeholder="__('Enter PO Number')" />

                <!-- No SPP -->
                <flux:input name="no_spp" :label="__('No SPP')" type="text" required autocomplete="off"
                    :placeholder="__('Enter SPP Number')" />

                <!-- Keterangan -->
                <flux:input name="keterangan" :label="__('Keterangan')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Description')" />

                <!-- Tujuan -->
                <flux:input name="tujuan" :label="__('Tujuan')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Destination')" />

                <!-- Proyek -->
                <flux:input name="proyek" :label="__('Proyek')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Project')" />

                <!-- Penerima -->
                <flux:input name="penerima" :label="__('Penerima')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Recipient')" />
            </div>

            <!-- Item Details -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-4">Item Details (JSON)</h2>

                <div class="item-container mb-4">
                    <div class="grid grid-cols-6 space-x-4">
                        <flux:input name="items[0][item]" :label="__('Item')" type="text" required
                            placeholder="Enter Item" />
                        <flux:input name="items[0][kode]" :label="__('Kode')" type="text" required
                            placeholder="Enter Code" />
                        <flux:input name="items[0][panjang]" :label="__('Panjang')" type="number" required
                            placeholder="Enter Length" />
                        <flux:input name="items[0][jumlah]" :label="__('Jumlah')" type="number" required
                            placeholder="Enter Quantity" />
                        <flux:input name="items[0][satuan]" :label="__('Satuan')" type="text" required
                            placeholder="Enter Unit" />
                        <flux:input name="items[0][keterangan]" :label="__('Keterangan')" type="text" required
                            placeholder="Enter Description" />
                    </div>
                </div>

                <button type="button" id="add-item"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Add
                    Item</button>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Author -->
                <flux:input name="author" :label="__('Author')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Author')" />

                <!-- Pengirim -->
                <flux:input name="pengirim" :label="__('Pengirim')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Sender')" />

                <!-- Security -->
                <flux:input name="security" :label="__('Security')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Security Officer')" />

                <!-- Diketahui -->
                <flux:input name="diketahui" :label="__('Diketahui')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Known By')" />

                <!-- Disetujui -->
                <flux:input name="disetujui" :label="__('Disetujui')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Approved By')" />

                <!-- Diterima -->
                <flux:input name="diterima" :label="__('Diterima')" type="text" required autocomplete="off"
                    :placeholder="__('Enter Received By')" />
            </div>

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
            newItem.classList.add('flex', 'space-x-4', 'mt-4');
            newItem.innerHTML = `
                <flux:input name="items[${newItemIndex}][item]" :label="__('Item')" type="text" required placeholder="Enter Item" />
                <flux:input name="items[${newItemIndex}][kode]" :label="__('Kode')" type="text" required placeholder="Enter Code" />
                <flux:input name="items[${newItemIndex}][panjang]" :label="__('Panjang')" type="number" required placeholder="Enter Length" />
                <flux:input name="items[${newItemIndex}][jumlah]" :label="__('Jumlah')" type="number" required placeholder="Enter Quantity" />
                <flux:input name="items[${newItemIndex}][satuan]" :label="__('Satuan')" type="text" required placeholder="Enter Unit" />
                <flux:input name="items[${newItemIndex}][keterangan]" :label="__('Keterangan')" type="text" required placeholder="Enter Description" />
            `;
            container.appendChild(newItem);
        });
    </script>
</x-layouts.app>
