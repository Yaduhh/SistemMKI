<x-layouts.app :title="__('Tambah Pengeluaran Tukang')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Tambah Pengeluaran Tukang</h1>
                    <p class="text-zinc-600 dark:text-zinc-400">RAB: {{ $rancanganAnggaranBiaya->proyek }} - {{ $rancanganAnggaranBiaya->pekerjaan }}</p>
                </div>
                <a href="{{ route('admin.rancangan-anggaran-biaya.show', $rancanganAnggaranBiaya) }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Kembali ke Detail RAB
                </a>
            </div>

            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="font-medium">Nomor Penawaran:</div>
                    <div class="font-medium">Nomor Pemasangan:</div>
                    <div class="font-medium">{{ $rancanganAnggaranBiaya->penawaran->nomor_penawaran ?? '-' }}</div>
                    <div class="font-medium">{{ $rancanganAnggaranBiaya->pemasangan->nomor_pemasangan ?? '-' }}</div>
                </div>
            </div>

            <script>
                window.oldTukang = @json(old('json_pengeluaran_tukang'));
            </script>

            <form action="{{ route('admin.rancangan-anggaran-biaya.store-tukang', $rancanganAnggaranBiaya) }}" method="POST">
                @csrf
                <input type="hidden" name="rancangan_anggaran_biaya_id" value="{{ $rancanganAnggaranBiaya->id }}">

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                        </div>
                        <h2 class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600/30 py-2 uppercase text-white">
                            Pengeluaran Tukang</h2>
                        <div class="w-full">
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30"></div>
                            <div class="w-full h-[0.5px] bg-purple-600 dark:bg-purple-600/30 mt-2"></div>
                        </div>
                    </div>
                    <x-rab.tukang-table />
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Simpan Tukang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
