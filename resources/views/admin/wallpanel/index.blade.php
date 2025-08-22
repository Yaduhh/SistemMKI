<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Wallpanel Management') }}
            </h2>
            <x-button href="{{ route('admin.wallpanel.create') }}" class="bg-white/30 hover:bg-gray-700">
                <x-icon name="plus" class="w-4 h-4 mr-2" />
                {{ __('Add New Wallpanel') }}
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-6 space-y-6">
        <!-- Regular Wallpanel Section -->
        <div class="w-full mx-auto">
            <x-card>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Wallpanel Regular</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-accent-foreground dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('NO') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Code') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Nama Produk') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Dimensions') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Luas/btg') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Harga') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($wallpanels as $wallpanel)
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $wallpanel->code }}</td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">{{ $wallpanel->nama_produk ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">
                                            {{ $wallpanel->lebar }} {{ $wallpanel->satuan }} x {{ $wallpanel->tebal }} {{ $wallpanel->satuan }} x {{ $wallpanel->panjang }} cm/btg
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">
                                            {{ $wallpanel->luas_btg }} m2 | {{ $wallpanel->luas_m2 }} btg
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">Rp {{ number_format($wallpanel->harga ?? 0, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <x-button href="{{ route('admin.wallpanel.edit', $wallpanel) }}" size="sm" variant="secondary">
                                                <x-icon name="pencil" class="w-4 h-4" />
                                            </x-button>
                                            <form action="{{ route('admin.wallpanel.destroy', $wallpanel) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" size="sm" variant="danger" onclick="return confirm('Are you sure you want to delete this wallpanel?')">
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td colspan="8" class="px-6 py-4 text-center">
                                        {{ __('No wallpanel found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Aksesoris Wallpanel Section -->
        <div class="w-full mx-auto">
            <x-card>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Wallpanel Aksesoris</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-accent-foreground dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('NO') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Code') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Nama Produk') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Dimensions') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Luas/btg') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Harga') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aksesorisWallpanels as $wallpanel)
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $wallpanel->code }}</td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">{{ $wallpanel->nama_produk ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">
                                            {{ $wallpanel->lebar }} {{ $wallpanel->satuan }} x {{ $wallpanel->tebal }} {{ $wallpanel->satuan }} x {{ $wallpanel->panjang }} cm/btg
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">
                                            {{ $wallpanel->luas_btg }} m2 | {{ $wallpanel->luas_m2 }} btg
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="truncate">Rp {{ number_format($wallpanel->harga ?? 0, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <x-button href="{{ route('admin.wallpanel.edit', $wallpanel) }}" size="sm" variant="secondary">
                                                <x-icon name="pencil" class="w-4 h-4" />
                                            </x-button>
                                            <form action="{{ route('admin.wallpanel.destroy', $wallpanel) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" size="sm" variant="danger" onclick="return confirm('Are you sure you want to delete this wallpanel?')">
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td colspan="8" class="px-6 py-4 text-center">
                                        {{ __('No aksesoris wallpanel found.') }}
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