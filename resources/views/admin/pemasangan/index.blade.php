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

        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />


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
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach ($pemasangans as $pemasangan)
                        <div class="rounded-lg border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden flex flex-col h-full">
                            <!-- Header -->
                            <div class="px-5 py-4 border-b border-gray-200 dark:border-zinc-700">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $pemasangan->nomor_pemasangan }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-1">
                                            {{ $pemasangan->judul_pemasangan }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2 flex-shrink-0
                                        {{ $pemasangan->status == 1
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200'
                                            : ($pemasangan->status == 2
                                                ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200'
                                                : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200') }}">
                                        {{ $pemasangan->status == 1 ? 'Aktif' : ($pemasangan->status == 2 ? 'Nonaktif' : 'Draft') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Informasi Penawaran Terkait -->
                            @if($pemasangan->penawaran)
                            <div class="px-5 py-3 bg-gray-50 dark:bg-zinc-800/50 border-b border-gray-200 dark:border-zinc-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Penawaran Terkait</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $pemasangan->penawaran->nomor_penawaran }}</p>
                                    </div>
                                    <a href="{{ route('admin.penawaran.show', $pemasangan->penawaran->id) }}"
                                        class="ml-3 inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white border border-gray-300 dark:border-zinc-600 rounded-md hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Lihat
                                    </a>
                                </div>
                            </div>
                            @endif

                            <!-- Info Detail -->
                            <div class="px-5 py-4 space-y-3 flex-1">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pelanggan</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $pemasangan->client->nama ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Sales</p>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $pemasangan->sales->name ?? '-' }}</p>
                                    </div>
                                </div>
                                
                                <div class="pt-3 border-t border-gray-200 dark:border-zinc-700">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Grand Total</p>
                                        <p class="text-base font-semibold text-gray-900 dark:text-white">
                                            Rp {{ number_format((float) ($pemasangan->grand_total ?? 0), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="px-5 py-4 bg-gray-50 dark:bg-zinc-800/30 border-t border-gray-200 dark:border-zinc-700 space-y-2">
                                <a href="{{ route('admin.pemasangan.show', $pemasangan->id) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-900 dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-100 text-white dark:text-gray-900 rounded-md font-medium text-sm transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                                @if ($pemasangan->status == 0)
                                    <div class="grid grid-cols-2 gap-2">
                                        <a href="{{ route('admin.pemasangan.edit', $pemasangan->id) }}"
                                            class="inline-flex items-center justify-center px-3 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 text-gray-700 dark:text-gray-300 rounded-md font-medium text-sm hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pemasangan.destroy', $pemasangan->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemasangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-3 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 text-gray-700 dark:text-gray-300 rounded-md font-medium text-sm hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
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
