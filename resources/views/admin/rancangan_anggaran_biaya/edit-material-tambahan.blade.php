<x-layouts.app :title="__('Edit Pengeluaran Material Tambahan')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Edit Pengeluaran Material Tambahan</h1>
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
                window.oldMaterialTambahan = @json(old('json_pengeluaran_material_tambahan'));
                window.existingMaterialTambahan = @json($rancanganAnggaranBiaya->json_pengeluaran_material_tambahan ?? []);
            </script>

            <form action="{{ route('admin.rancangan-anggaran-biaya.update-material-tambahan', $rancanganAnggaranBiaya) }}"
                method="POST">
                @csrf
                @method('PATCH')

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4">
                        <h2
                            class="text-lg font-semibold w-full text-center bg-indigo-600 dark:bg-indigo-600 py-2 uppercase">
                            Pengeluaran Material Tambahan
                        </h2>
                    </div>
                    <x-rab.material-tambahan-table />
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" onclick="prepareFormData()"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Simpan Pengeluaran Material Tambahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Prepare form data before submit - component will handle its own data
        function prepareFormData() {
            // Component material-tambahan-table handles its own form submission
            // No additional preparation needed
        }

        // Load existing data after component is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit for component to initialize
            setTimeout(() => {
                if (window.existingMaterialTambahan && window.existingMaterialTambahan.length > 0) {
                    if (window.materialTambahanFunctions && window.materialTambahanFunctions.loadExistingData) {
                        window.materialTambahanFunctions.loadExistingData(window.existingMaterialTambahan);
                    }
                }
            }, 500);
        });
    </script>
</x-layouts.app>

