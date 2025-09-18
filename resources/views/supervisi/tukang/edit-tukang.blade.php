<x-layouts.supervisi title="Edit Pengeluaran Tukang - {{ $rab->proyek }}">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit Pengeluaran Tukang') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ $rab->proyek }} • {{ $rab->pekerjaan }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('supervisi.rab.show', $rab) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-zinc-700 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-zinc-600 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-900 disabled:opacity-25 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="w-full">
        <div class="max-w-7xl mx-auto">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Informasi Proyek -->
            <div class="mb-6">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Proyek</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Proyek</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->proyek }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pekerjaan</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->pekerjaan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Lokasi</label>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $rab->lokasi }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status</label>
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                    {{ $text }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                window.oldTukang = @json(old('json_pengeluaran_tukang'));
                window.existingTukang = @json($rab->json_pengeluaran_tukang ?? []);
            </script>

            <!-- Form Tukang -->
            <form action="{{ route('supervisi.rab.update-tukang', $rab) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="rancangan_anggaran_biaya_id" value="{{ $rab->id }}">

                <div class="mt-8">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h2 class="text-lg font-semibold w-full text-center bg-purple-600 dark:bg-purple-600/30 py-2 uppercase text-white">
                            Pengeluaran Tukang
                        </h2>
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

            <!-- Section Dokumentasi -->
            <div class="mt-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <h2 class="text-lg font-semibold w-full text-center bg-blue-600 dark:bg-blue-600/30 py-2 uppercase text-white">
                        Dokumentasi
                    </h2>
                </div>
                
                <!-- Upload Form -->
                <div class="bg-white dark:bg-zinc-800 mb-6">
                    <form action="{{ route('supervisi.rab.upload-dokumentasi', $rab) }}" method="POST" enctype="multipart/form-data" id="dokumentasiForm">
                        @csrf
                        <div class="mb-4">
                            <label for="dokumentasi" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                Upload Dokumentasi
                            </label>
                            <p class="text-gray-500 text-xs mb-2">(bisa lebih dari satu, format: gambar)</p>
                            
                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="dokumentasi" class="relative cursor-pointer bg-white dark:bg-zinc-900/30 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file</span>
                                            <input type="file" name="dokumentasi[]" id="dokumentasi" multiple accept="image/*" class="sr-only" onchange="previewImages(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG, GIF sampai 10MB
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Preview Container -->
                            <div id="preview-container" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                <!-- Preview images will be added here -->
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                Upload Dokumentasi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Display Existing Dokumentasi -->
                @if($rab->dokumentasi && count($rab->dokumentasi) > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Dokumentasi Terupload</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($rab->dokumentasi as $dokumentasi)
                                @if($dokumentasi->file_paths && count($dokumentasi->file_paths) > 0)
                                    @foreach($dokumentasi->file_paths as $filePath)
                                        <div class="relative group">
                                            <img src="{{ $filePath }}" alt="Dokumentasi" class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                <button type="button" onclick="deleteImage('{{ $dokumentasi->id }}', '{{ $filePath }}')" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function previewImages(input) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'relative group';
                            previewDiv.innerHTML = `
                                <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <button type="button" onclick="removePreview(this)" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition">
                                        Hapus
                                    </button>
                                </div>
                            `;
                            previewContainer.appendChild(previewDiv);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        function removePreview(button) {
            button.closest('.relative').remove();
        }

        function deleteImage(dokumentasiId, filePath) {
            if (confirm('Yakin mau hapus gambar ini?')) {
                // Implement delete functionality
                fetch(`/supervisi/rab/dokumentasi/${dokumentasiId}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ file_path: filePath })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus gambar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus gambar');
                });
            }
        }
    </script>
</x-layouts.supervisi>
