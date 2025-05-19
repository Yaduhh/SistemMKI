<x-layouts.app :title="__('Produk List')">
    <div class="text-white">
        <h1 class="text-3xl font-semibold mb-6">Daftar Produk</h1>
        
        <!-- Add Product Button -->
        <a href="{{ route('admin.produk.create') }}" class="inline-block px-6 py-2 mb-4 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Tambah Produk
        </a>

        <!-- Produk Table -->
        @if($produks->isEmpty())
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <p class="text-center text-lg text-gray-300">Tidak ada produk tersedia. Silakan tambah produk baru.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-gray-700 rounded-lg shadow-lg">
                <table class="min-w-full table-auto text-sm">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">ID</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">Type</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">Harga</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @foreach($produks as $produk)
                            <tr class="hover:bg-gray-600">
                                <td class="px-6 py-4 text-gray-100">{{ $produk->id }}</td>
                                <td class="px-6 py-4 text-gray-100">{{ $produk->type }}</td>
                                <td class="px-6 py-4 text-gray-100">{{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="px-4 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
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
