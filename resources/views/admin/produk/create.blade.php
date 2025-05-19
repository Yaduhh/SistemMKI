<x-layouts.app :title="__('Tambah Produk')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Tambah Produk')" :description="__('Masukkan detail produk Anda di bawah ini')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form action="{{ route('admin.produk.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <!-- Type -->
            <flux:input
                name="type"
                :label="__('Type')"
                type="text"
                required
                autocomplete="off"
                :placeholder="__('Contoh: Laptop, Smartphone, dsb.')"
            />

            <!-- Dimensi Lebar -->
            <flux:input
                name="dimensi_lebar"
                :label="__('Dimensi Lebar')"
                type="number"
                required
                :placeholder="__('Masukkan lebar produk')"
            />

            <!-- Dimensi Tinggi -->
            <flux:input
                name="dimensi_tinggi"
                :label="__('Dimensi Tinggi')"
                type="number"
                :placeholder="__('Masukkan tinggi produk')"
            />

            <!-- Panjang -->
            <flux:input
                name="panjang"
                :label="__('Panjang')"
                type="number"
                required
                :placeholder="__('Masukkan panjang produk')"
            />

            <!-- Warna -->
            <flux:input
                name="warna"
                :label="__('Warna')"
                type="text"
                required
                autocomplete="off"
                :placeholder="__('Masukkan warna produk')"
            />

            <!-- Harga -->
            <flux:input
                name="harga"
                :label="__('Harga')"
                type="number"
                required
                :placeholder="__('Masukkan harga produk')"
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Simpan') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Kembali ke') }}
            <flux:link :href="route('admin.produk.index')" wire:navigate>{{ __('Daftar Produk') }}</flux:link>
        </div>
    </div>
</x-layouts.app>
