<x-layouts.app :title="__('Daftar Syarat Pemasangan')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <!-- Header Section -->
            <div class="mb-4">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
                    <div class="mb-4 lg:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Daftar Syarat Pemasangan</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelola semua syarat pemasangan yang berlaku untuk layanan Anda</p>
                    </div>
                    <a href="{{ route('admin.syarat-pemasangan.create') }}"
                        class="inline-flex w-fit items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-900 border border-transparent rounded-lg font-semibold text-sm text-white dark:text-emerald-400 hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Syarat Pemasangan
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Syarat Pemasangan Biasa Section -->
            <div class="mb-8">
                <div class="mb-4 bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Syarat Pemasangan Biasa
                    </h2>
                </div>

                @php
                    $syaratBiasa = $syaratPemasangan->where('syarat_pintu', 0);
                @endphp

                @if($syaratBiasa->isEmpty())
                    <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-3 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-1">Belum ada syarat pemasangan biasa</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tambahkan syarat pemasangan untuk produk non-pintu</p>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Table Header -->
                        <div class="hidden md:block bg-green-50 dark:bg-green-900/20 px-6 py-4 border-b border-green-200 dark:border-green-800">
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-1">
                                    <span class="text-xs font-medium text-green-600 dark:text-green-400 uppercase tracking-wider">No</span>
                                </div>
                                <div class="col-span-9">
                                    <span class="text-xs font-medium text-green-600 dark:text-green-400 uppercase tracking-wider">Syarat Pemasangan</span>
                                </div>
                                <div class="col-span-1 text-right">
                                    <span class="text-xs font-medium text-green-600 dark:text-green-400 uppercase tracking-wider">Aksi</span>
                                </div>
                            </div>
                        </div>

                        <!-- Table Body -->
                        <div class="divide-y divide-green-200 dark:divide-green-800">
                            @foreach($syaratBiasa as $index => $item)
                                <div class="px-4 md:px-6 py-4 hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors duration-200">
                                    <!-- Mobile Layout -->
                                    <div class="md:hidden space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    Biasa
                                                </span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.syarat-pemasangan.edit', $item->id) }}"
                                                    class="inline-flex items-center p-1.5 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-200"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.syarat-pemasangan.destroy', $item->id) }}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus syarat pemasangan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200"
                                                        title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $index + 1 }}. {!! nl2br(e($item->syarat)) !!}</div>
                                    </div>

                                    <!-- Desktop Layout -->
                                    <div class="hidden md:grid grid-cols-12 gap-4 items-start">
                                        <div class="col-span-1">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="col-span-9">
                                            <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{!! nl2br(e($item->syarat)) !!}</div>
                                        </div>
                                        <div class="col-span-1">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('admin.syarat-pemasangan.edit', $item->id) }}"
                                                    class="inline-flex items-center p-1.5 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-200"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.syarat-pemasangan.destroy', $item->id) }}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus syarat pemasangan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200"
                                                        title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Syarat Pemasangan Pintu Section -->
            <div class="mb-8">
                <div class="mb-4 bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Syarat Pemasangan Pintu
                    </h2>
                </div>

                @php
                    $syaratPintu = $syaratPemasangan->where('syarat_pintu', 1);
                @endphp

                @if($syaratPintu->isEmpty())
                    <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-3 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-1">Belum ada syarat pemasangan pintu</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tambahkan syarat pemasangan khusus untuk produk pintu</p>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Table Header -->
                        <div class="hidden md:block bg-blue-50 dark:bg-blue-900/20 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-1">
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider">No</span>
                                </div>
                                <div class="col-span-9">
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider">Syarat Pemasangan</span>
                                </div>
                                <div class="col-span-1 text-right">
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider">Aksi</span>
                                </div>
                            </div>
                        </div>

                        <!-- Table Body -->
                        <div class="divide-y divide-blue-200 dark:divide-blue-800">
                            @foreach($syaratPintu as $index => $item)
                                <div class="px-4 md:px-6 py-4 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors duration-200">
                                    <!-- Mobile Layout -->
                                    <div class="md:hidden space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    Pintu
                                                </span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.syarat-pemasangan.edit', $item->id) }}"
                                                    class="inline-flex items-center p-1.5 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-200"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.syarat-pemasangan.destroy', $item->id) }}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus syarat pemasangan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200"
                                                        title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $index + 1 }}. {!! nl2br(e($item->syarat)) !!}</div>
                                    </div>

                                    <!-- Desktop Layout -->
                                    <div class="hidden md:grid grid-cols-12 gap-4 items-start">
                                        <div class="col-span-1">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="col-span-9">
                                            <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{!! nl2br(e($item->syarat)) !!}</div>
                                        </div>
                                        <div class="col-span-1">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('admin.syarat-pemasangan.edit', $item->id) }}"
                                                    class="inline-flex items-center p-1.5 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-200"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.syarat-pemasangan.destroy', $item->id) }}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus syarat pemasangan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center p-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200"
                                                        title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Empty State jika tidak ada data sama sekali -->
            @if($syaratPemasangan->isEmpty())
                <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto mb-4 bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada syarat pemasangan</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Mulai dengan menambahkan syarat pemasangan pertama Anda</p>
                        <a href="{{ route('admin.syarat-pemasangan.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Syarat Pemasangan
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app> 