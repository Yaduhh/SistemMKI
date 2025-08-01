<x-layouts.sales>
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="flex flex-col lg:flex-row lg:items-center space-x-4 mb-6">
            <div class="w-12 h-12 max-sm:hidden bg-gradient-to-br from-emerald-500 to-emerald-600 dark:from-emerald-600 dark:to-emerald-700 rounded-xl flex items-center justify-center shadow-lg relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <svg class="w-6 h-6 text-white transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1 max-sm:hidden">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Selamat datang, <span class="bg-gradient-to-r from-emerald-600 to-emerald-500 dark:from-emerald-500 dark:to-emerald-400 bg-clip-text text-transparent">{{ auth()->user()->name }}</span></h1>
                <div class="flex flex-col lg:flex-row lg:items-center mt-1 space-x-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Berikut adalah ringkasan aktivitas penjualan Anda hari ini</p>
                    <div class="flex  items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-zinc-800/50 lg:px-3 py-1 rounded-lg">
                        <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">{{ now()->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex-1 md:hidden">
                <h1 class="font-bold text-gray-900 dark:text-white tracking-tight">Selamat datang, <br> <span class="text-2xl bg-gradient-to-r from-emerald-600 to-emerald-500 dark:from-emerald-500 dark:to-emerald-400 bg-clip-text text-transparent">{{ auth()->user()->name }}</span></h1>
                <div class="flex flex-col lg:flex-row lg:items-center space-x-4 mt-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Berikut adalah ringkasan aktivitas penjualan Anda hari ini</p>
                    <div class="flex  items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-zinc-800/50 lg:px-3 py-1 rounded-lg">
                        <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">{{ now()->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Event Mendatang -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 dark:from-orange-600 dark:to-orange-700 shadow-lg">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Event Mendatang</dt>
                                <dd class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $upcomingEventsCount }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('sales.events.dashboard') }}" class="inline-flex items-center text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-500 dark:hover:text-orange-300 transition-colors duration-200">
                            {{ __('Lihat semua event') }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Jumlah Klien -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 dark:from-purple-600 dark:to-purple-700 shadow-lg">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Klien</dt>
                                <dd class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $clientCount }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('sales.client.index') }}" class="inline-flex items-center text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500 dark:hover:text-purple-300 transition-colors duration-200">
                            {{ __('Kelola klien') }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media & Website Links -->
        <div class="mt-8">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-gray-500 to-gray-600 dark:from-gray-600 dark:to-gray-700 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Media Sosial & Website</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Akses cepat ke platform digital kami</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                <!-- Instagram -->
                <a href="https://instagram.com/wpcmegakomposit" target="_blank" class="group relative bg-white dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-pink-300 dark:hover:border-pink-600 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-pink-500 to-purple-600 group-hover:from-pink-600 group-hover:to-purple-700 transition-all duration-200 shadow-lg">
                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors duration-200">MKI</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">@wpcmegakomposit</p>
                        </div>
                        <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- MekoFlooring Instagram -->
                <a href="https://www.instagram.com/mekoflooring.id/" target="_blank" class="group relative bg-white dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-pink-300 dark:hover:border-pink-600 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-pink-500 to-purple-600 group-hover:from-pink-600 group-hover:to-purple-700 transition-all duration-200 shadow-lg">
                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors duration-200">MekoFlooring</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">@mekoflooring.id</p>
                        </div>
                        <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- TikTok -->
                <a href="https://tiktok.com/@wpc_mki" target="_blank" class="group relative bg-white dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-gray-900 to-gray-800 group-hover:from-gray-800 group-hover:to-gray-700 transition-all duration-200 shadow-lg">
                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-.88-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-200">TikTok</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">@wpc_mki</p>
                        </div>
                        <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Website -->
                <a href="https://megakomposit.com" target="_blank" class="group relative bg-white dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-blue-300 dark:hover:border-blue-600/30 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600/30 to-blue-700/30 group-hover:from-blue-700/30 group-hover:to-blue-800/30 transition-all duration-200 shadow-lg overflow-hidden">
                                <img src="{{ asset('assets/images/logomkiOnly.png') }}" alt="MKI Logo" class="h-6 w-6 object-contain">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200 line-clamp-1">Mega Komposit</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">megakomposit.com</p>
                        </div>
                        <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- MekoFlooring Website -->
                <a href="https://mekoflooring.id" target="_blank" class="group relative bg-white dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-blue-300 dark:hover:border-blue-600/30 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600/30 to-emerald-700/30 group-hover:from-emerald-700/30 group-hover:to-emerald-800/30 transition-all duration-200 shadow-lg overflow-hidden">
                                <img src="{{ asset('assets/images/logoMekoFlooring.png') }}" alt="MKI Logo" class="h-6 w-6 object-contain">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200 line-clamp-1">Meko Flooring</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">mekoflooring.id</p>
                        </div>
                        <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Mega Door Website -->
                <a href="https://megadoor.id" target="_blank" class="group relative bg-white dark:bg-zinc-900/30 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-blue-300 dark:hover:border-blue-600/30 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-pink-600/30 to-pink-700/30 group-hover:from-pink-700/30 group-hover:to-pink-800/30 transition-all duration-200 shadow-lg overflow-hidden">
                                <img src="{{ asset('assets/images/logoWithoutText.png') }}" alt="MKI Logo" class="h-6 w-6 object-contain">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200 line-clamp-1">Mega Door</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">megadoor.id</p>
                        </div>
                        <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Menu Event -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Menu Event</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Event Mendatang -->
                <a href="{{ route('sales.events.upcoming') }}"
                    class="group relative rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-zinc-900/30 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900 group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors duration-200">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3
                                class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                                Event Mendatang</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Lihat semua event yang akan datang</p>
                        </div>
                    </div>
                </a>

                <!-- Event Saya Mendatang -->
                <a href="{{ route('sales.events.my-upcoming') }}"
                    class="group relative rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-zinc-900/30 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900 group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors duration-200">
                                <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3
                                class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors duration-200">
                                Event Saya</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Event yang Anda diundang</p>
                        </div>
                    </div>
                </a>

                <!-- Event Terlalu -->
                <a href="{{ route('sales.events.past') }}"
                    class="group relative rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-zinc-900/30 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-900 group-hover:bg-gray-200 dark:group-hover:bg-zinc-900/30 transition-colors duration-200">
                                <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3
                                class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-400 transition-colors duration-200">
                                Event Terlalu</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Riwayat event yang sudah berlalu</p>
                        </div>
                    </div>
                </a>

                <!-- Dashboard Event -->
                <a href="{{ route('sales.events.dashboard') }}"
                    class="group relative rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-zinc-900/30 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900 group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors duration-200">
                                <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3
                                class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-200">
                                Dashboard Event</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Ringkasan dan statistik event</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Daily Activities -->
        <div class="mt-8">
            <div class="flex flex-col sm:flex-row lg:items-center justify-between mb-6">
                <div class="flex items-center mb-4 sm:mb-0">
                    <div class="flex-shrink-0">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Aktivitas Harian Terbaru</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ringkasan aktivitas terbaru Anda</p>
                    </div>
                </div>
                <a href="{{ route('sales.daily-activity.index') }}"
                    class="w-fit inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                    Lihat Semua
                </a>
            </div>

            @if ($recentActivities->count() > 0)
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-3">
                    @foreach ($recentActivities as $activity)
                        <div class="space-y-4 w-full col-span-1">
                            <div
                                class="bg-white dark:bg-zinc-900/30 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-all duration-200 group">
                                <div class="flex flex-col items-start space-x-4">
                                    <!-- Activity Icon -->
                                    <div class="w-full flex flex-row justify-between items-center">
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900 dark:to-emerald-800 group-hover:from-emerald-200 group-hover:to-emerald-300 dark:group-hover:from-emerald-800 dark:group-hover:to-emerald-700 transition-all duration-200">
                                            <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 h-fit rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $activity->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <!-- Activity Content -->
                                    <div class="flex-1 min-w-0 mt-2 w-full">
                                        <div class="flex flex-col sm:flex-row lg:items-center justify-between mb-2">
                                            <h3
                                                class="text-base font-semibold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-200">
                                                {{ $activity->perihal }}
                                            </h3>
                                        </div>

                                        <div class="space-y-2 w-full">
                                            <!-- Client Info -->
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                                <span class="font-medium">Pelanggan:</span>
                                                <span
                                                    class="ml-1">{{ $activity->client ? $activity->client->nama : 'Client tidak ditemukan' }}</span>
                                            </div>

                                            <!-- Date Info -->
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span class="font-medium">Tanggal:</span>
                                                <span
                                                    class="ml-1">{{ $activity->created_at->format('d M Y H:i') }}</span>
                                            </div>

                                            <!-- Summary if exists -->
                                            @if ($activity->summary)
                                                <div
                                                    class="flex items-start text-justify text-sm text-gray-600 dark:text-gray-400">
                                                    <div>
                                                        <span class="font-medium">Ringkasan:</span>
                                                        <p class="mt-1 text-gray-500 dark:text-gray-400 line-clamp-2">
                                                            {{ $activity->summary }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="w-full flex items-center justify-end space-x-2 mt-2">
                                        <a href="{{ route('sales.daily-activity.show', $activity) }}"
                                            class="inline-flex items-center p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors duration-200 group-hover:scale-105"
                                            title="Lihat detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('sales.daily-activity.edit', $activity) }}"
                                            class="inline-flex items-center p-2 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-200 group-hover:scale-105"
                                            title="Edit aktivitas">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12">
                        <div
                            class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Belum ada aktivitas</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">Mulai dengan menambahkan
                            aktivitas harian Anda untuk melacak kegiatan dan kemajuan penjualan</p>
                        <a href="{{ route('sales.daily-activity.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-500 dark:to-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-blue-700 hover:to-blue-800 dark:hover:from-blue-600 dark:hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Aktivitas Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.sales>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
