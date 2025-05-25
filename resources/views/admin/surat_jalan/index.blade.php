<x-layouts.app :title="__('Surat Jalan List')">
    <div class="text-white">
        <h1 class="text-3xl font-semibold mb-6">Daftar Surat Jalan</h1>

        <a href="{{ route('admin.surat_jalan.create') }}"
            class="inline-block px-6 py-2 mb-4 bg-indigo-600 text-white rounded-lg">Tambah Surat Jalan</a>

        @if ($suratJalans->isEmpty())
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <p class="text-center text-lg text-gray-300">Tidak ada Surat Jalan tersedia. Silakan tambah Surat Jalan
                    baru.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-accent-foreground border border-gray-600 rounded-lg shadow-lg">
                <table class="min-w-full table-auto text-sm">
                    <thead class="bg-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">ID</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">Nomor Surat</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">No PO</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">No SPP</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">Tujuan</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">Aksi</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-300">Cetak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @foreach ($suratJalans as $suratJalan)
                            <tr class="hover:bg-gray-600">
                                <td class="px-6 py-4 text-gray-100">{{ $suratJalan->id }}</td>
                                <td class="px-6 py-4 text-gray-100">{{ $suratJalan->nomor_surat }}</td>
                                <td class="px-6 py-4 text-gray-100">{{ $suratJalan->no_po }}</td>
                                <td class="px-6 py-4 text-gray-100">{{ $suratJalan->no_spp }}</td>
                                <td class="px-6 py-4 text-gray-100">{{ $suratJalan->tujuan }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.surat_jalan.edit', $suratJalan->id) }}"
                                            class="px-4 py-2 text-white bg-yellow-500 rounded-md">Edit</a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.surat_jalan.destroy', $suratJalan->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus Surat Jalan ini?')"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-red-600 rounded-md">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.surat_jalan.cetak', $suratJalan->id) }}"
                                        class="bg-green-600 text-white py-2 px-3 rounded-md hover:bg-green-700 transition duration-300 text-xs">
                                        Cetak PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
