<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pintu Management') }}
            </h2>
            <x-button href="{{ route('admin.pintu.create') }}" class="bg-white/30 hover:bg-gray-700">
                <x-icon name="plus" class="w-4 h-4 mr-2" />
                {{ __('Add New Pintu') }}
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-6 space-y-6">
        <!-- Regular Pintu Section -->
        <div class="w-full mx-auto">
            <x-card>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pintu Regular</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-accent-foreground dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('NO') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Code') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Nama Produk') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Dimensions') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Warna') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Harga Satuan') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pintus as $pintu)
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $pintu->code }}</td>
                                    <td class="px-6 py-4">{{ $pintu->nama_produk ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($pintu->lebar && $pintu->tebal && $pintu->tinggi)
                                            {{ $pintu->lebar }} x {{ $pintu->tebal }} x {{ $pintu->tinggi }} cm
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $pintu->warna ?? '-' }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($pintu->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <x-button href="{{ route('admin.pintu.edit', $pintu) }}" size="sm" variant="secondary">
                                                <x-icon name="pencil" class="w-4 h-4" />
                                            </x-button>
                                            <form action="{{ route('admin.pintu.destroy', $pintu) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" size="sm" variant="danger" onclick="return confirm('Are you sure you want to delete this pintu?')">
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td colspan="8" class="px-6 py-4 text-center">
                                        {{ __('No pintu found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Aksesoris Pintu Section -->
        <div class="w-full mx-auto">
            <x-card>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pintu Aksesoris</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-accent-foreground dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('NO') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Code') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Nama Produk') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Dimensions') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Warna') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Harga Satuan') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aksesorisPintus as $pintu)
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $pintu->code }}</td>
                                    <td class="px-6 py-4">{{ $pintu->nama_produk ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($pintu->lebar && $pintu->tebal && $pintu->tinggi)
                                            {{ $pintu->lebar }} x {{ $pintu->tebal }} x {{ $pintu->tinggi }} cm
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $pintu->warna ?? '-' }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($pintu->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <x-button href="{{ route('admin.pintu.edit', $pintu) }}" size="sm" variant="secondary">
                                                <x-icon name="pencil" class="w-4 h-4" />
                                            </x-button>
                                            <form action="{{ route('admin.pintu.destroy', $pintu) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" size="sm" variant="danger" onclick="return confirm('Are you sure you want to delete this pintu?')">
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td colspan="8" class="px-6 py-4 text-center">
                                        {{ __('No aksesoris pintu found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.app>
