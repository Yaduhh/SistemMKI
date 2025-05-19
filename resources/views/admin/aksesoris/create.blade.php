<x-layouts.app :title="__('Tambah Aksesoris')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Tambah Aksesoris')" :description="__('Masukkan detail aksesoris di bawah ini')" />

        <form action="{{ route('admin.aksesoris.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <!-- Type -->
            <flux:input name="type" :label="__('Type')" type="text" required autocomplete="off"
                :placeholder="__('Contoh: Laptop, Smartphone, dsb.')" />

            <!-- Satuan -->
            <flux:input name="satuan" :label="__('Satuan')" type="text" required autocomplete="off"
                :placeholder="__('Contoh: unit, pcs, dsb.')" />

            <!-- Harga -->
            <flux:input name="harga" :label="__('Harga')" type="number" required
                :placeholder="__('Masukkan harga aksesoris')" />

            <flux:select wire:model="status" :label="__('Status')" required>
                <option value="0">{{ __('Tersedia') }}</option>
                <option value="1">{{ __('Tidak Tersedia') }}</option>
            </flux:select>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Simpan') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
