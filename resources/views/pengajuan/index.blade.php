<x-layouts.app :title="__('Daftar Pengajuan')">
    <div class="flex flex-col gap-8">
        <!-- Header -->

        <div class="flex justify-between items-center">
            <h1 class="font-bold text-lg">{{ 'Daftar Pengajuan' }}</h1>

            <!-- Tombol untuk tambah pengajuan -->
            <div class="flex justify-end">
                <a href="{{ route('admin.pengajuan.create') }}"
                    class="bg-blue-600 text-white hover:bg-blue-700 transition duration-300 ease-in-out text-sm px-5 py-2 rounded-md">
                    {{ __('Tambah Pengajuan') }}
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Tabel Daftar Pengajuan -->
        <div class="overflow-x-auto rounded-lg shadow-lg bg-accent-foreground text-white border border-gray-700">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-gray-700">
                    <tr class="text-left">
                        <th class="px-6 py-4 font-medium text-sm text-gray-300">Nomor Pengajuan</th>
                        <th class="px-6 py-4 font-medium text-sm text-gray-300">Judul Pengajuan</th>
                        <th class="px-6 py-4 font-medium text-sm text-gray-300">Client</th>
                        <th class="px-6 py-4 font-medium text-sm text-gray-300">Status</th>
                        <th class="px-6 py-4 font-medium text-sm text-gray-300">Tanggal Pengajuan</th>
                        <th class="px-6 py-4 font-medium text-sm text-gray-300">Aksi</th>
                        <th class="px-6 py-4 font-medium text-sm text-gray-300">Cetak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @foreach ($pengajuan as $item)
                        <tr class="hover:bg-gray-700 transition duration-300 ease-in-out">
                            <td class="px-6 py-4">{{ $item->nomor_pengajuan }}</td>
                            <td class="px-6 py-4">{{ $item->judul_pengajuan }}</td>
                            <td class="px-6 py-4">{{ $item->client }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-3 py-1 text-xs rounded-full {{ $item->status == 0 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $item->status == 0 ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $item->date_pengajuan->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <!-- Edit and Delete Buttons -->
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.pengajuan.edit', $item->id) }}"
                                        class="bg-yellow-500 text-white py-1 px-3 rounded-md hover:bg-yellow-600 transition duration-300 text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.pengajuan.destroy', $item->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white py-1 px-3 rounded-md hover:bg-red-600 transition duration-300 text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pengajuan.cetak', $item->id) }}"
                                    class="bg-green-600 text-white py-1 px-3 rounded-md hover:bg-green-700 transition duration-300 text-xs">
                                    Cetak PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $pengajuan->links() }}
        </div>
    </div>
</x-layouts.app>
