<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Pintu') }}
            </h2>
            <div class="flex space-x-2">
                <x-button href="{{ route('admin.pintu.edit', $pintu) }}" variant="secondary">
                    <x-icon name="pencil" class="w-4 h-4 mr-2" />
                    {{ __('Edit') }}
                </x-button>
                <x-button href="{{ route('admin.pintu.index') }}" variant="secondary">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                    {{ __('Back to List') }}
                </x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto">
            <x-card>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Dasar</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->code }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->nama_produk ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->slug }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Dimensi & Spesifikasi</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lebar</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->lebar ?? '-' }} cm</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tebal</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->tebal ?? '-' }} cm</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tinggi</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->tinggi ?? '-' }} cm</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Warna</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->warna ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Harga & Status</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Satuan</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">Rp {{ number_format($pintu->harga_satuan ?? 0, 0, ',', '.') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Aksesoris</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($pintu->status_aksesoris)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Aksesoris
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Regular
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Sistem</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created By</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->creator->name ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created At</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->created_at->format('d M Y H:i') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Updated At</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $pintu->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-layouts.app>
