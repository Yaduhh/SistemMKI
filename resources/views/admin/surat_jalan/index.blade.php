<x-layouts.app :title="__('Surat Jalan List')">
    <div class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Header Section -->
        <div class="backdrop-blur-sm border-b border-white/10 dark:border-gray-300/50 mb-8 transition-colors duration-300">
            <div class="pb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold dark:text-white text-gray-800 transition-colors duration-300">Manajemen Surat Jalan</h1>
                            <p class="text-sm dark:text-slate-300 text-gray-600 transition-colors duration-300">Kelola dan pantau semua surat jalan dengan mudah</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 max-sm:justify-end max-sm:mt-2">
                        <div class="text-right">
                            <p class="text-sm dark:text-slate-400 text-gray-600 transition-colors duration-300">Total Surat Jalan</p>
                            <p class="text-2xl font-bold dark:text-white text-gray-800 transition-colors duration-300">{{ $suratJalans->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <!-- Action Bar -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.surat_jalan.create') }}"
                        class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Surat Jalan
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    </a>
                </div>
            </div>

            @if ($suratJalans->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="dark:bg-white/5 bg-white backdrop-blur-sm rounded-2xl border border-white/10 dark:border-gray-300 p-12 max-w-md mx-auto shadow-lg dark:shadow-md">
                        <div class="w-20 h-20 bg-slate-700/50 dark:bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold dark:text-white text-gray-800 mb-3">Belum Ada Surat Jalan</h3>
                        <p class="dark:text-slate-400 text-gray-600 mb-6">Mulai dengan membuat surat jalan pertama Anda</p>
                        <a href="{{ route('admin.surat_jalan.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-500 dark:to-purple-500 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 dark:hover:from-blue-600 dark:hover:to-purple-600 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Surat Jalan
                        </a>
                    </div>
                </div>
            @else
                <!-- Modern Card Grid Layout -->
                 <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                     @foreach ($suratJalans as $suratJalan)
                         <div class="group dark:bg-white/5 dark:border-gray-300 dark:border border-white/10 bg-white backdrop-blur-sm rounded-2xl p-6 hover:bg-white/10 dark:hover:bg-zinc-800 hover:border-white/20 dark:hover:border-zinc-600 transition-all duration-300 hover:shadow-2xl hover:shadow-zinc-500/10 dark:hover:shadow-zinc-400/10 shadow-lg dark:shadow-md">
                            <!-- Card Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold dark:text-white text-gray-800 transition-colors duration-300">{{ $suratJalan->nomor_surat }}</h3>
                                         <p class="text-sm dark:text-slate-400 text-gray-500 transition-colors duration-300">ID: #{{ $suratJalan->id }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 dark:bg-green-500/20 dark:text-green-400 bg-green-100 text-green-800 text-xs font-medium rounded-full border border-green-500/30 dark:border-green-300 transition-colors duration-300">
                                     Aktif
                                 </span>
                            </div>

                            <!-- Card Content -->
                            <div class="space-y-3 mb-6">
                                 <div class="flex items-center justify-between">
                                     <span class="text-sm dark:text-slate-400 text-gray-600 transition-colors duration-300">No. PO</span>
                                     <span class="text-sm font-medium dark:text-white text-gray-700 transition-colors duration-300">{{ $suratJalan->no_po ?: '-' }}</span>
                                 </div>
                                 <div class="flex items-center justify-between">
                                     <span class="text-sm dark:text-slate-400 text-gray-600 transition-colors duration-300">No. SPP</span>
                                     <span class="text-sm font-medium dark:text-white text-gray-700 transition-colors duration-300">{{ $suratJalan->no_spp ?: '-' }}</span>
                                 </div>
                                 <div class="flex items-start justify-between">
                                     <span class="text-sm dark:text-slate-400 text-gray-600 transition-colors duration-300">Tujuan</span>
                                     <span class="text-sm font-medium dark:text-white text-gray-700 text-right max-w-[150px] truncate transition-colors duration-300" title="{{ $suratJalan->tujuan }}">{{ $suratJalan->tujuan }}</span>
                                 </div>
                                 <div class="flex items-start justify-between">
                                     <span class="text-sm dark:text-slate-400 text-gray-600 transition-colors duration-300">Keterangan</span>
                                     <span class="text-sm font-medium dark:text-white text-gray-700 text-right max-w-[150px] truncate transition-colors duration-300" title="{{ $suratJalan->keterangan }}">{{ $suratJalan->keterangan }}</span>
                                 </div>
                             </div>

                            <!-- Card Actions -->
                             <div class="flex items-center justify-between pt-4 border-t dark:border-gray-300 border-white/10 transition-colors duration-300">
                                <div class="flex items-center space-x-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.surat_jalan.edit', $suratJalan->id) }}"
                                        class="group/btn relative inline-flex items-center px-3 py-2 bg-amber-500/20 dark:bg-amber-100 text-amber-400 dark:text-amber-700 text-sm font-medium rounded-lg border border-amber-500/30 dark:border-amber-300 hover:bg-amber-500/30 dark:hover:bg-amber-200 hover:border-amber-500/50 dark:hover:border-amber-400 transition-all duration-200"
                                        title="Edit Surat Jalan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.surat_jalan.destroy', $suratJalan->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus Surat Jalan ini?')"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="group/btn relative inline-flex items-center px-3 py-2 bg-red-500/20 dark:bg-red-100 text-red-400 dark:text-red-700 text-sm font-medium rounded-lg border border-red-500/30 dark:border-red-300 hover:bg-red-500/30 dark:hover:bg-red-200 hover:border-red-500/50 dark:hover:border-red-400 transition-all duration-200"
                                            title="Hapus Surat Jalan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <!-- Print Button -->
                                <a href="{{ route('admin.surat_jalan.cetak', $suratJalan->id) }}"
                                    class="group/btn relative inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 dark:from-emerald-500 dark:to-green-500 text-white text-sm font-medium rounded-lg shadow-lg hover:shadow-xl hover:from-emerald-700 hover:to-green-700 dark:hover:from-emerald-600 dark:hover:to-green-600 transform hover:-translate-y-0.5 transition-all duration-200"
                                    title="Cetak PDF">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Cetak
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
     </div>
 </x-layouts.app>
