<x-layouts.app :title="__('Daftar Pemasangan')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="mb-6 flex flex-col lg:flex-row lg:justify-between lg:items-center">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Daftar Pemasangan</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Semua pemasangan yang sudah dibuat dari penawaran
                    </p>
                </div>
            </div>
            <form method="GET"
                class="sticky top-0 z-10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md rounded-lg shadow-sm border border-gray-100 dark:border-zinc-800 p-4 mb-6 flex flex-col md:flex-row md:items-end gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Client</label>
                    <select name="client"
                        class="w-full py-2 px-3 rounded-lg border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        <option value="">Semua Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @if (request('client') == $client->id) selected @endif>
                                {{ $client->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Sales</label>
                    <select name="sales"
                        class="w-full py-2 px-3 rounded-lg border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        <option value="">Semua Sales</option>
                        @foreach ($salesList as $sales)
                            <option value="{{ $sales->id }}" @if (request('sales') == $sales->id) selected @endif>
                                {{ $sales->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Periode
                        Tanggal</label>
                    <div class="flex gap-2">
                        <input type="date" name="start" value="{{ request('start') }}"
                            class="w-full py-2 px-3 rounded-lg border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        <span class="text-gray-400 dark:text-gray-500 flex items-center">-</span>
                        <input type="date" name="end" value="{{ request('end') }}"
                            class="w-full py-2 px-3 rounded-lg border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2 text-white opacity-80" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
            @if ($pemasangans->count())
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach ($pemasangans as $pemasangan)
                        <div
                            class="rounded-2xl border border-gray-200 dark:border-zinc-800 bg-white dark:bg-zinc-900/60 shadow-sm hover:shadow-md transition-shadow duration-200 p-0 flex flex-col h-full overflow-hidden">
                            <!-- Icon utama center atas -->
                            <div class="flex flex-row items-center bg-emerald-50 dark:bg-emerald-900/20 p-4 gap-4">
                                <div
                                    class="w-14 h-12 rounded-full bg-white dark:bg-zinc-900 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>

                                <div class="flex flex-col">
                                    <!-- Nomor & Judul -->
                                    <div class="flex flex-col">
                                        <div
                                            class="flex items-center justify-start gap-2 text-lg font-bold text-gray-900 dark:text-white tracking-tight">
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <rect x="4" y="4" width="16" height="16" rx="2"
                                                    stroke-width="2" />
                                                <path d="M8 2v4M16 2v4" stroke-width="2" />
                                            </svg>
                                            {{ $pemasangan->nomor_pemasangan }}
                                            <span
                                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold ml-2
                                                {{ $pemasangan->status == 1
                                                    ? 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-200'
                                                    : ($pemasangan->status == 2
                                                        ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-200'
                                                        : ($pemasangan->status == 0
                                                            ? 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-200'
                                                            : 'bg-gray-50 text-gray-700 dark:bg-gray-900/30 dark:text-gray-200')) }}">
                                                {{ $pemasangan->status == 1
                                                    ? 'Aktif'
                                                    : ($pemasangan->status == 2
                                                        ? 'Nonaktif'
                                                        : ($pemasangan->status == 0
                                                            ? 'Draft'
                                                            : 'Draft')) }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-800 dark:text-gray-400 font-medium line-clamp-2">
                                            {{ $pemasangan->judul_pemasangan }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Info utama horizontal -->
                            <div
                                class="flex flex-row justify-between items-center gap-2 px-6 py-3 border-t border-b border-gray-100 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-900/40 text-sm text-gray-600 dark:text-gray-300">
                                <div class="flex-1 text-center flex flex-col items-center gap-1">
                                    <div class="flex flex-row items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-400 mb-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <div class="font-semibold">Pelanggan</div>
                                    </div>
                                    <div class="truncate">{{ $pemasangan->client->nama ?? '-' }}</div>
                                </div>
                                <div class="w-px h-8 bg-gray-200 dark:bg-zinc-800"></div>
                                <div class="flex-1 text-center flex flex-col items-center gap-1">
                                    <div class="flex flex-row items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-400 mb-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                        <div class="font-semibold">Sales</div>
                                    </div>
                                    <div class="truncate">{{ $pemasangan->sales->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="flex-1 text-center flex flex-col items-center gap-1 bg-zinc-100 dark:bg-zinc-900/40 py-2 border-b border-gray-100 dark:border-zinc-800">
                                <div class="flex flex-row items-center gap-2">
                                    <svg class="w-4 h-4 text-yellow-400 mb-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 21c4.97 0 9-3.58 9-8 0-2.21-1.79-4-4-4H7c-2.21 0-4 1.79-4 4 0 4.42 4.03 8 9 8zm0-10V3m0 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                    </svg>
                                    <div class="font-semibold">Total</div>
                                </div>
                                <div class="text-gray-900 dark:text-white font-bold">Rp
                                    {{ number_format((float) ($pemasangan->total ?? 0), 0, ',', '.') }}</div>
                            </div>
                            <!-- Tombol detail -->
                            <div class="p-6 flex flex-col flex-1 justify-end">
                                <a href="{{ route('admin.pemasangan.show', $pemasangan->id) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 rounded-lg font-semibold text-sm text-blue-700 dark:text-blue-200 hover:bg-blue-100 dark:hover:bg-blue-800 focus:outline-none transition">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10" stroke-width="2" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="text-center py-12">
                        <div
                            class="w-24 h-24 mx-auto mb-4 bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada pemasangan</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Belum ada pemasangan yang dibuat dari
                            penawaran</p>
                    </div>
                </div>
            @endif
            <div class="mt-6">
                {{ $pemasangans->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
