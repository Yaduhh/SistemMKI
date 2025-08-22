<x-layouts.app>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row justify-between lg:items-center mb-6 gap-4">
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

        <div class="w-full">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700">
                <div class="w-full">
                    <h3 class="text-lg font-semibold p-4 text-gray-900 dark:text-white">Decking</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
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
                                @forelse ($deckings as $decking)
                                    <tr class="bg-white border-b dark:bg-accent-foreground dark:border-gray-700">
                                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $decking->code }}</td>
                                        <td class="px-6 py-4">{{ $decking->nama_produk ?? '-' }}</td>
                                        <td class="px-6 py-4 truncate">
                                            {{ $decking->lebar }} x {{ $decking->tebal }} x {{ $decking->panjang }} cm/btg
                                        </td>
                                        <td class="px-6 py-4 truncate">
                                            {{ $decking->luas_btg }} m2 | {{ $decking->luas_m2 }}btg
                                        </td>
                                        <td class="px-6 py-4 truncate">Rp {{ number_format($decking->harga ?? 0, 0, ',', '.') }}</td>
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
                                        <td colspan="8" class="px-6 py-4 text-center">
                                            {{ __('No decking found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700">
                <div class="w-full">
                    <h3 class="text-lg font-semibold p-4 text-gray-900 dark:text-white">Aksesoris Decking</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-zinc-700 dark:bg-zinc-800">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NO</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Code</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Dimensions</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Luas/btg</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Luas/m2</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aksesorisDeckings as $index => $aksesoris)
                                    <tr class="border-b border-gray-100 dark:bg-zinc-800 dark:border-zinc-800 hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors duration-200">
                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $aksesoris->code }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $aksesoris->nama_produk ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $aksesoris->lebar }}x{{ $aksesoris->tebal }}x{{ $aksesoris->panjang }} {{ $aksesoris->satuan }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $aksesoris->luas_btg }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $aksesoris->luas_m2 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                                <a href="{{ route('admin.decking.edit', $aksesoris->id) }}" 
                                                   class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 hover:border-blue-300 dark:text-blue-400 dark:bg-blue-900/20 dark:border-blue-800 dark:hover:bg-blue-900/30 transition-all duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.decking.destroy', $aksesoris->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this accessory?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 border border-red-200 rounded-md hover:bg-red-100 hover:border-red-300 dark:text-red-400 dark:bg-red-900/20 dark:border-red-800 dark:hover:bg-red-900/30 transition-all duration-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4.5M9 5v-.5"></path>
                                                </svg>
                                                <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada data aksesoris</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dark Mode Toggle Script -->
    <script>
        // Check for saved theme preference or default to 'light' mode
        const theme = localStorage.getItem('theme') || 'light';
        
        // Apply theme on page load
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
            document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            document.getElementById('theme-toggle-light-icon').classList.add('hidden');
            document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
        }
        
        // Theme toggle functionality
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const isDark = document.documentElement.classList.contains('dark');
            
            if (isDark) {
                // Switch to light mode
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                document.getElementById('theme-toggle-light-icon').classList.add('hidden');
                document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            } else {
                // Switch to dark mode
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
                document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
            }
        });
    </script>
</x-layouts.app>