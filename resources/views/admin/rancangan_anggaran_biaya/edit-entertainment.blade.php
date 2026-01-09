<x-layouts.app :title="__('Edit Pengeluaran Non Material')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Edit Pengeluaran Non Material</h1>
                    <p class="text-zinc-600 dark:text-zinc-400">RAB: {{ $rancanganAnggaranBiaya->proyek }} -
                        {{ $rancanganAnggaranBiaya->pekerjaan }}</p>
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

            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <script>
                // Set data existing sebelum component di-render
                window.oldEntertaiment = @json(old('json_pengeluaran_entertaiment'));
                window.existingEntertaiment = @json($rancanganAnggaranBiaya->json_pengeluaran_entertaiment ?? []);
                // Flag: di halaman edit-entertainment, data existing BISA diedit (tapi status tetap readonly)
                window.entertainmentAllowEditExisting = true;
            </script>

            <form action="{{ route('admin.rancangan-anggaran-biaya.update-entertainment', $rancanganAnggaranBiaya) }}"
                method="POST">
                @csrf
                @method('PATCH')

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2
                            class="text-lg font-semibold w-full text-center bg-teal-600 dark:bg-teal-600 py-2 uppercase">
                            Pengeluaran Non Material
                        </h2>
                    </div>
                    <x-rab.entertaiment-table />
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition">
                        Simpan Pengeluaran Non Material
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 
        Data existing akan otomatis dimuat oleh component dari window.existingEntertaiment
        Dengan window.entertainmentAllowEditExisting = true (di-set di atas):
        - Semua field (MR, tanggal, supplier, item, qty, satuan, harga_satuan) BISA diedit
        - Field status TIDAK bisa diubah (readonly di template)
        - Tombol hapus MR, tambah material, hapus material tetap berfungsi
        Component akan handle konversi format Rupiah ke angka pada form submit
    --}}
</x-layouts.app>

