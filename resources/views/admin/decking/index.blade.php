<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Decking Management') }}
            </h2>
            <x-button href="{{ route('admin.decking.create') }}" class="bg-white/30 hover:bg-gray-700">
                <x-icon name="plus" class="w-4 h-4 mr-2" />
                {{ __('Add New Decking') }}
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-6">
        <div class="w-full mx-auto">
            <x-card>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-accent-foreground dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">{{ __('NO') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Code') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Dimensions') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Luas/btg') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Luas/m2') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Created By') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deckings as $decking)
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $decking->code }}</td>
                                    <td class="px-6 py-4">
                                        {{ $decking->lebar }} mm x {{ $decking->tebal }} mm x {{ $decking->panjang }} cm
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $decking->luas_btg }} btg
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $decking->luas_m2 }} m²
                                    </td>
                                    <td class="px-6 py-4">{{ $decking->creator->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <x-button href="{{ route('admin.decking.edit', $decking) }}" size="sm" variant="secondary">
                                                <x-icon name="pencil" class="w-4 h-4" />
                                            </x-button>
                                            <form action="{{ route('admin.decking.destroy', $decking) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" size="sm" variant="danger" onclick="return confirm('Are you sure you want to delete this decking?')">
                                                    <x-icon name="trash" class="w-4 h-4" />
                                                </x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                    <td colspan="6" class="px-6 py-4 text-center">
                                        {{ __('No decking found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>

            <div class="pt-10">
                <div class="flex justify-between items-center mb-6 px-9">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Aksesoris Decking') }}
                    </h2>
                </div>
                <x-card>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-accent-foreground dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center">{{ __('NO') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Code') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Dimensions') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Luas/btg') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Luas/m2') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Created By') }}</th>
                                    <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aksesorisDeckings as $decking)
                                    <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $decking->code }}</td>
                                        <td class="px-6 py-4">
                                            {{ $decking->lebar }} mm x {{ $decking->tebal }} mm x {{ $decking->panjang }} cm
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $decking->luas_btg }} btg
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $decking->luas_m2 }} m²
                                        </td>
                                        <td class="px-6 py-4">{{ $decking->creator->name ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-2">
                                                <x-button href="{{ route('admin.decking.edit', $decking) }}" size="sm" variant="secondary">
                                                    <x-icon name="pencil" class="w-4 h-4" />
                                                </x-button>
                                                <form action="{{ route('admin.decking.destroy', $decking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" size="sm" variant="danger" onclick="return confirm('Are you sure you want to delete this decking?')">
                                                        <x-icon name="trash" class="w-4 h-4" />
                                                    </x-button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                        <td colspan="6" class="px-6 py-4 text-center">
                                            {{ __('No aksesoris decking found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-layouts.app> 