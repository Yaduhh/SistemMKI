<x-layouts.app :title="__('Daftar Pengajuan')">
    <div class="flex flex-col gap-6">
        <x-auth-header 
            :title="__('Daftar Pengajuan')" 
            :description="__('Berikut adalah daftar semua pengajuan yang telah dibuat')" 
        />

        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end">
            <a href="{{ route('admin.pengajuan.create') }}">
                <flux:button variant="primary">
                    {{ __('Tambah Pengajuan') }}
                </flux:button>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border rounded">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">{{ __('No') }}</th>
                        <th class="px-4 py-2 border">{{ __('Nomor Pengajuan') }}</th>
                        <th class="px-4 py-2 border">{{ __('Judul') }}</th>
                        <th class="px-4 py-2 border">{{ __('Client') }}</th>
                        <th class="px-4 py-2 border">{{ __('Tanggal') }}</th>
                        <th class="px-4 py-2 border">{{ __('Status') }}</th>
                        <th class="px-4 py-2 border">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $item)
                        <tr>
                            <td class="px-4 py-2 border">{{ $loop->iteration + ($pengajuan->currentPage()-1)*$pengajuan->perPage() }}</td>
                            <td class="px-4 py-2 border">{{ $item->nomor_pengajuan }}</td>
                            <td class="px-4 py-2 border">{{ $item->judul_pengajuan }}</td>
                            <td class="px-4 py-2 border">{{ $item->client }}</td>
                            <td class="px-4 py-2 border">{{ $item->date_pengajuan }}</td>
                            <td class="px-4 py-2 border">
                                @if($item->status == 1)
                                    <span class="text-red-600">{{ __('Tidak Aktif') }}</span>
                                @else
                                    <span class="text-green-600">{{ __('Aktif') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border flex gap-2">
                                <a href="{{ route('admin.pengajuan.edit', $item->id) }}">
                                    <flux:button size="sm" variant="secondary">
                                        {{ __('Edit') }}
                                    </flux:button>
                                </a>
                                <form action="{{ route('admin.pengajuan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" size="sm" variant="danger">
                                        {{ __('Hapus') }}
                                    </flux:button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 border text-center">
                                {{ __('Belum ada data pengajuan.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pengajuan->links() }}
        </div>
    </div>
</x-layouts.app>
