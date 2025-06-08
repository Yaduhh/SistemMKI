<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Daftar Penawaran</h1>
            <x-button href="{{ route('admin.penawaran.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white">
                <x-icon name="plus" class="w-4 h-4 mr-2" />
                Buat Penawaran
            </x-button>
        </div>
    </x-slot>
    <div class="py-4">
        <div class="overflow-x-auto rounded-lg shadow bg-white dark:bg-zinc-900">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">Nomor Penawaran</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 dark:text-gray-200 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($penawarans as $no => $penawaran)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4">{{ $no + $penawarans->firstItem() }}</td>
                        <td class="px-6 py-4">{{ $penawaran->nomor_penawaran }}</td>
                        <td class="px-6 py-4">{{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('d-m-Y') : '-' }}</td>
                        <td class="px-6 py-4">{{ $penawaran->client->nama ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $penawaran->judul_penawaran }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($penawaran->grand_total,0,',','.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2 py-1 rounded-full text-xs {{ $penawaran->status ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                                {{ $penawaran->status ? 'Aktif' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center flex gap-2 justify-center">
                            <x-button href="{{ route('admin.penawaran.show', $penawaran) }}" class="bg-blue-500 hover:bg-blue-700 text-white">
                                <x-icon name="eye" class="w-4 h-4 mr-1" />Lihat
                            </x-button>
                            <x-button href="{{ route('admin.penawaran.edit', $penawaran) }}" class="bg-yellow-400 hover:bg-yellow-500 text-black">
                                <x-icon name="pencil" class="w-4 h-4 mr-1" />Edit
                            </x-button>
                            <form action="{{ route('admin.penawaran.destroy', $penawaran) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <x-button type="submit" class="bg-red-600 hover:bg-red-700 text-white">
                                    <x-icon name="trash" class="w-4 h-4 mr-1" />Hapus
                                </x-button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data penawaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $penawarans->links() }}</div>
        </div>
    </div>
</x-layouts.app> 