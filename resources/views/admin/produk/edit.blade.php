<x-layouts.app :title="__('Edit Produk')">
    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="type" class="block text-sm font-medium">Type</label>
            <input type="text" name="type" id="type" class="mt-1 block w-full" value="{{ old('type', $produk->type) }}" required>
        </div>

        <div class="mb-4">
            <label for="dimensi_lebar" class="block text-sm font-medium">Dimensi Lebar</label>
            <input type="number" name="dimensi_lebar" id="dimensi_lebar" class="mt-1 block w-full" value="{{ old('dimensi_lebar', $produk->dimensi_lebar) }}" required>
        </div>

        <div class="mb-4">
            <label for="dimensi_tinggi" class="block text-sm font-medium">Dimensi Tinggi</label>
            <input type="number" name="dimensi_tinggi" id="dimensi_tinggi" class="mt-1 block w-full" value="{{ old('dimensi_tinggi', $produk->dimensi_tinggi) }}">
        </div>

        <div class="mb-4">
            <label for="panjang" class="block text-sm font-medium">Panjang</label>
            <input type="number" name="panjang" id="panjang" class="mt-1 block w-full" value="{{ old('panjang', $produk->panjang) }}" required>
        </div>

        <div class="mb-4">
            <label for="warna" class="block text-sm font-medium">Warna</label>
            <input type="text" name="warna" id="warna" class="mt-1 block w-full" value="{{ old('warna', $produk->warna) }}" required>
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-sm font-medium">Harga</label>
            <input type="number" name="harga" id="harga" class="mt-1 block w-full" value="{{ old('harga', $produk->harga) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-layouts.app>
