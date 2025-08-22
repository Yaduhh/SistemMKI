<x-layouts.app :title="__('Edit Tanda Tangan')">
    <div class="container mx-auto">
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Edit Tanda Tangan</h1>
                    <p class="text-zinc-600 dark:text-zinc-400">Update tanda tangan untuk {{ $tandaTangan->user->name }}</p>
                </div>
            </div>
        </div>

        <div class="max-w-2xl">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                <form action="{{ route('admin.tanda-tangan.update', $tandaTangan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            User
                        </label>
                        <div class="p-3 bg-zinc-50 dark:bg-zinc-700 rounded-md">
                            <div class="font-medium text-zinc-900 dark:text-white">{{ $tandaTangan->user->name }}</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $tandaTangan->user->email }}</div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Tanda Tangan Saat Ini
                        </label>
                        @if($tandaTangan->ttd)
                            <img src="{{ Storage::url($tandaTangan->ttd) }}" alt="Tanda Tangan Saat Ini" 
                                 class="max-w-xs border border-zinc-200 rounded-lg">
                        @else
                            <span class="text-zinc-400">Tidak ada gambar</span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <label for="ttd" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Upload Tanda Tangan Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg p-6 text-center">
                            <input type="file" name="ttd" id="ttd" accept="image/*" required
                                class="hidden" onchange="previewImage(this)">
                            <label for="ttd" class="cursor-pointer">
                                <svg class="mx-auto h-12 w-12 text-zinc-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                    Klik untuk upload gambar tanda tangan baru
                                </p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">
                                    PNG, JPG, GIF hingga 2MB
                                </p>
                            </label>
                        </div>
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="preview" src="" alt="Preview" class="max-w-xs mx-auto border border-zinc-200 rounded-lg">
                        </div>
                        @error('ttd')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.tanda-tangan.index') }}"
                            class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Update Tanda Tangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-layouts.app>
