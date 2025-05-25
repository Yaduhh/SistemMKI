<x-layouts.app :title="__('Edit Produk')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Edit Produk')" :description="__('Ubah detail produk Anda di bawah ini')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" class="flex flex-col gap-6"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Type -->
            <flux:input name="type" :label="__('Type')" type="text" value="{{ old('type', $produk->type) }}"
                required autocomplete="off" :placeholder="__('Contoh: Laptop, Smartphone, dsb.')" />

            <!-- Dimensi Lebar -->
            <flux:input name="dimensi_lebar" :label="__('Dimensi Lebar')" type="number"
                value="{{ old('dimensi_lebar', $produk->dimensi_lebar) }}" required
                :placeholder="__('Masukkan lebar produk')" />

            <!-- Dimensi Tinggi -->
            <flux:input name="dimensi_tinggi" :label="__('Dimensi Tinggi')" type="number"
                value="{{ old('dimensi_tinggi', $produk->dimensi_tinggi) }}"
                :placeholder="__('Masukkan tinggi produk')" />

            <!-- Panjang -->
            <flux:input name="panjang" :label="__('Panjang')" type="number"
                value="{{ old('panjang', $produk->panjang) }}" required :placeholder="__('Masukkan panjang produk')" />

            <!-- Warna -->
            <flux:input name="warna" :label="__('Warna')" type="text" value="{{ old('warna', $produk->warna) }}"
                required autocomplete="off" :placeholder="__('Masukkan warna produk')" />

            <!-- Harga -->
            <flux:input name="harga" :label="__('Harga')" type="number" value="{{ old('harga', $produk->harga) }}"
                required :placeholder="__('Masukkan harga produk')" />

            <!-- Nama Produk -->
            <flux:input name="nama_produk" :label="__('Nama Produk')" type="text"
                value="{{ old('nama_produk', $produk->nama_produk) }}" required autocomplete="off"
                :placeholder="__('Masukkan nama produk')" />

            <!-- Image Produk -->
            <div>
                <flux:input name="image_produk" :label="__('Image Produk')" type="file" accept="image/*" />
                @if ($produk->image_produk)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $produk->image_produk) }}" alt="Image Produk"
                            class="w-32 h-32 object-cover mt-2 rounded-md">
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Perbarui Produk') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Kembali ke') }}
            <flux:link :href="route('admin.produk.index')" wire:navigate>{{ __('Daftar Produk') }}</flux:link>
        </div>
    </div>
</x-layouts.app>
