<x-layouts.app :title="__('Tambah Syarat Ketentuan')">
    <div class="text-white">
        <h1 class="text-3xl font-semibold mb-6">Tambah Syarat Ketentuan</h1>

        <!-- Form -->
        <form action="{{ route('admin.syarat_ketentuan.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Syarat -->
            <div>
                <label for="syarat" class="block text-sm font-medium text-gray-300">Syarat</label>
                <textarea id="syarat" name="syarat" rows="4" class="w-full mt-2 p-3 border border-gray-600 bg-gray-800 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('syarat') }}</textarea>
            </div>
            
            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Simpan Syarat Ketentuan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
