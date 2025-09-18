<x-layouts.supervisi title="Edit Kerja Tambah - {{ $rab->proyek }}">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Kerja Tambah') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm sm:text-base">
                    {{ $rab->proyek }} • {{ $rab->pekerjaan }}
                </p>
            </div>
            <div class="flex items-center">
                <a href="{{ route('supervisi.rab.show', $rab) }}"
                    class="inline-flex items-center px-3 sm:px-4 py-2 bg-gray-600 dark:bg-zinc-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-zinc-600 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-900 disabled:opacity-25 transition">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="w-full">
        <div class="max-w-7xl mx-auto">
            <!-- Informasi Proyek -->
            <div class="mb-4 sm:mb-6">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4">Informasi Proyek</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-zinc-700 dark:text-zinc-300">Proyek</label>
                            <p class="mt-1 text-xs sm:text-sm text-zinc-900 dark:text-white break-words">{{ $rab->proyek }}</p>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-zinc-700 dark:text-zinc-300">Pekerjaan</label>
                            <p class="mt-1 text-xs sm:text-sm text-zinc-900 dark:text-white break-words">{{ $rab->pekerjaan }}</p>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-zinc-700 dark:text-zinc-300">Lokasi</label>
                            <p class="mt-1 text-xs sm:text-sm text-zinc-900 dark:text-white break-words">{{ $rab->lokasi }}</p>
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-zinc-700 dark:text-zinc-300">Status</label>
                            <div class="mt-1">
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $statusText = [
                                        'draft' => 'Draft',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                    ];
                                    $color = $statusColors[$rab->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                    $text = $statusText[$rab->status] ?? $rab->status;
                                @endphp
                                <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ $text }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                window.oldKerjaTambah = @json(old('json_kerja_tambah'));
                window.existingKerjaTambah = @json($rab->json_kerja_tambah ?? []);
            </script>

            <form action="{{ route('supervisi.rab.update-kerja-tambah', $rab) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="rancangan_anggaran_biaya_id" value="{{ $rab->id }}">

                <div class="mt-6 sm:mt-8">
                    <div class="flex items-center justify-between gap-2 sm:gap-4 mb-4 sm:mb-6">
                        <h2 class="text-sm sm:text-lg font-semibold w-full text-center bg-orange-600 dark:bg-orange-600/30 py-2 px-2 sm:px-4 uppercase text-white">
                            Kerja Tambah
                        </h2>
                    </div>
                    <div class="overflow-x-auto">
                        <x-rab.kerja-tambah-table />
                    </div>
                </div>

                <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row justify-end gap-3 sm:gap-0">
                    <button type="submit"
                        class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-sm sm:text-base">
                        Simpan Kerja Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.supervisi>
