<x-layouts.app :title="__('Detail Syarat Pemasangan')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <!-- Header Section -->
            <div class="mb-4">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center">
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Syarat Pemasangan</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Lihat detail syarat pemasangan</p>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Detail Section -->
            <div class="bg-white dark:bg-zinc-900/30 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="space-y-6">
                    <!-- Syarat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Syarat Pemasangan</label>
                        <div class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white whitespace-pre-line font-mono text-sm">
                            {!! nl2br(e($syaratPemasangan->syarat)) !!}
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ID</label>
                            <div class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                                {{ $syaratPemasangan->id }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Dibuat</label>
                            <div class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                                {{ $syaratPemasangan->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Terakhir Diperbarui</label>
                            <div class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                                {{ $syaratPemasangan->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <div class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $syaratPemasangan->status_deleted ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                    {{ $syaratPemasangan->status_deleted ? 'Dihapus' : 'Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('admin.syarat-pemasangan.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('admin.syarat-pemasangan.edit', $syaratPemasangan->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-yellow-600 dark:bg-yellow-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-yellow-700 dark:hover:bg-yellow-600 focus:bg-yellow-700 dark:focus:bg-yellow-600 active:bg-yellow-900 dark:active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 