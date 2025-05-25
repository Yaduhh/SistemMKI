<x-layouts.app :title="__('Produk List')">
    <div class="">

        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-semibold text-white">Daftar Produk</h1>
            <!-- Add Product Button -->
            <div class="flex justify-end">
                <a href="{{ route('admin.produk.create') }}"
                    class="inline-block px-6 py-3 mb-4 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Tambah Produk
                </a>
            </div>
        </div>

        <!-- Produk Table -->
        @if ($produks->isEmpty())
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <p class="text-center text-lg text-gray-300">Tidak ada produk tersedia. Silakan tambah produk baru.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-xl border border-gray-600">
                <table class="min-w-full table-auto text-sm text-gray-300">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">ID</th>
                            <th class="px-6 py-3 text-left font-semibold">Produk</th>
                            <th class="px-6 py-3 text-left font-semibold">Nama Produk</th>
                            <th class="px-6 py-3 text-left font-semibold">Dimensi</th>
                            <th class="px-6 py-3 text-left font-semibold">Warna</th>
                            <th class="px-6 py-3 text-left font-semibold">Harga</th>
                            <th class="px-6 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @foreach ($produks as $produk)
                            <tr class="hover:bg-gray-800 transition duration-150 ease-in-out">
                                <td class="px-6 py-4">{{ $produk->id }}</td>
                                <td class="px-6 py-4">
                                    @if ($produk->image_produk)
                                        <img src="{{ asset('storage/' . $produk->image_produk) }}" alt="Gambar Produk"
                                            class="w-auto h-32 object-cover rounded-md">
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-4">
                                        <p>Nama Produk: <br>{{ $produk->nama_produk }}</p>
                                        <p>Type Produk: <br>{{ $produk->type }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 space-y-4">
                                    <div>
                                        <p>Lebar:</p>
                                        <p>{{ $produk->dimensi_lebar }}</p>
                                    </div>
                                    <div>
                                        <p>Tinggi:</p>
                                        <p>{{ $produk->dimensi_tinggi }}</p>
                                    </div>
                                    <div>
                                        <p>Panjang:</p>
                                        <p>{{ $produk->panjang }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $produk->warna }}</td>
                                <td class="px-6 py-4">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.produk.edit', $produk->id) }}"
                                            class="px-4 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
