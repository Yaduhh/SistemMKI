<x-layouts.app :title="__('File Purchase Order')">
    <div class="container mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-xl lg:text-3xl font-bold text-gray-900 dark:text-white">{{ __('File Purchase Order') }}</h1>
                    <p class="text-zinc-600 dark:text-zinc-400 text-sm lg:text-base mt-2">{{ __('Kelola semua file arsip pelanggan dalam satu tempat') }}</p>
                </div>
                <div class="flex items-center space-x-3 mt-4 lg:mt-0">
                    <flux:modal.trigger name="arsip-file-modal">
                        <button type="button"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'arsip-file-modal')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Tambah File Baru') }}
                        </button>
                    </flux:modal.trigger>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Total File') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $arsipFiles->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Client Aktif') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Client::where('status_deleted', false)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Update Terakhir') }}</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $arsipFiles->first() ? $arsipFiles->first()->updated_at->diffForHumans() : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full">
            <div class="bg-white dark:bg-zinc-800">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Daftar File Arsip') }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Semua file arsip pelanggan yang tersedia') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Menampilkan') }} {{ $arsipFiles->count() }} {{ __('file') }}</span>
                    </div>
                </div>
            </div>

            <div class="py-6">
                @if($groupedFiles->count() > 0)
                    <div class="space-y-6">
                        @foreach($groupedFiles as $userId => $months)
                            @php 
                                $user = $months->first()->first()->creator; 
                                $totalFilesForUser = $months->sum(fn($monthFiles) => $monthFiles->count());
                            @endphp
                            <div x-data="{ openUser: false }" class="bg-white dark:bg-zinc-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                                <!-- User Header -->
                                <button @click="openUser = !openUser" class="w-full flex items-center justify-between p-4 lg:p-6 bg-gray-50/50 dark:bg-zinc-900/20 hover:bg-gray-50 dark:hover:bg-zinc-900/40 transition-colors">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                            @if($user && $user->profile)
                                                <img src="{{ asset('storage/' . $user->profile) }}" class="w-full h-full rounded-full object-cover">
                                            @else
                                                <span class="text-lg font-bold">{{ $user ? strtoupper(substr($user->name, 0, 1)) : '?' }}</span>
                                            @endif
                                        </div>
                                        <div class="text-left">
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->name ?? 'Unknown' }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $totalFilesForUser }} {{ __('Arsip File') }}</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" :class="{ 'rotate-180': openUser }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Month Sections -->
                                <div x-show="openUser" x-collapse class="border-t border-gray-200 dark:border-gray-700">
                                    <div class="p-4 lg:p-6 space-y-6">
                                        @foreach($months as $month => $files)
                                            <div x-data="{ openMonth: true }" class="space-y-4">
                                                <button @click="openMonth = !openMonth" class="flex items-center space-x-2 group">
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" :class="{ 'rotate-90': openMonth }" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M6 6L14 10L6 14V6Z"></path>
                                                    </svg>
                                                    <span class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 group-hover:text-blue-500 transition-colors">{{ $month }}</span>
                                                    <span class="text-xs bg-gray-100 dark:bg-zinc-700 px-2 py-0.5 rounded-full text-gray-600 dark:text-gray-300">{{ $files->count() }}</span>
                                                </button>

                                                <div x-show="openMonth" x-collapse class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                    @foreach($files as $arsip)
                                                        <div class="bg-white dark:bg-zinc-900 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all duration-200 group/card">
                                                            <!-- Card Header -->
                                                            <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-zinc-800/30">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center space-x-3 min-w-0">
                                                                        @php
                                                                            $extension = pathinfo($arsip->file, PATHINFO_EXTENSION);
                                                                            $iconClass = match (strtolower($extension)) {
                                                                                'pdf' => 'text-red-500 bg-red-100 dark:bg-red-900/30',
                                                                                'doc', 'docx' => 'text-blue-500 bg-blue-100 dark:bg-blue-900/30',
                                                                                'jpg', 'jpeg', 'png' => 'text-green-500 bg-green-100 dark:bg-green-900/30',
                                                                                'zip', 'rar' => 'text-purple-500 bg-purple-100 dark:bg-purple-900/30',
                                                                                default => 'text-gray-500 bg-gray-100 dark:bg-gray-900/30',
                                                                            };
                                                                        @endphp
                                                                        <div class="p-2 rounded-lg {{ $iconClass }}">
                                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="min-w-0">
                                                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate" title="{{ $arsip->nama }}">{{ $arsip->nama }}</h4>
                                                                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-tight">{{ $extension }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="relative" x-data="{ openOptions: false }">
                                                                        <button @click="openOptions = !openOptions" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                                                        </button>
                                                                        <div x-show="openOptions" @click.away="openOptions = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-600 z-10">
                                                                            <div class="py-1">
                                                                                @foreach(\App\Models\ArsipFile::getStatusOptions() as $val => $lab)
                                                                                    <form action="{{ route('admin.arsip-file.update', $arsip->id) }}" method="POST">
                                                                                        @csrf @method('PUT')
                                                                                        <input type="hidden" name="status" value="{{ $val }}">
                                                                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700 {{ $arsip->status === $val ? 'bg-gray-100 dark:bg-zinc-700' : '' }}">
                                                                                            {{ $lab }}
                                                                                        </button>
                                                                                    </form>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Card Body -->
                                                            <div class="p-4 space-y-4">
                                                                <div class="space-y-2">
                                                                    <div class="flex items-center justify-between text-xs">
                                                                        <span class="text-gray-500">{{ __('Status') }}</span>
                                                                        <span class="px-2 py-0.5 rounded-full font-bold {{ $arsip->getStatusBadgeClass() }}">
                                                                            {{ ucfirst($arsip->status) }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center justify-between text-xs">
                                                                        <span class="text-gray-500">{{ __('Client') }}</span>
                                                                        <span class="font-semibold text-gray-900 dark:text-white truncate max-w-[150px]">{{ $arsip->client->nama ?? '-' }}</span>
                                                                    </div>
                                                                    <div class="flex items-center justify-between text-xs">
                                                                        <span class="text-gray-500">{{ __('Ditambahkan') }}</span>
                                                                        <span class="font-medium text-gray-700 dark:text-zinc-400">{{ $arsip->created_at->format('d/m/Y H:i') }}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="flex flex-col space-y-2">
                                                                    <a href="{{ Storage::url($arsip->file) }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-bold hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                                        {{ __('Download File') }}
                                                                    </a>
                                                                    <form action="{{ route('admin.arsip-file.destroy', $arsip->id) }}" method="POST" onsubmit="return confirm('Hapus file ini?')">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-xs font-bold hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                            {{ __('Hapus Permanen') }}
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="mx-auto w-20 h-20 bg-gray-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            {{ __('Belum ada file arsip') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            {{ __('Mulai dengan menambahkan file arsip pertama untuk mengelola dokumen pelanggan Anda.') }}</p>
                        <flux:modal.trigger name="arsip-file-modal">
                            <button type="button"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'arsip-file-modal')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('Tambah File Pertama') }}
                            </button>
                        </flux:modal.trigger>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Arsip File -->
    <flux:modal name="arsip-file-modal" class="w-full max-w-2xl">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Tambah File Arsip Baru') }}</flux:heading>
                <flux:subheading>{{ __('Upload file arsip untuk pelanggan') }}</flux:subheading>
            </div>

            <form action="{{ route('admin.arsip-file.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4"
                x-data="arsipFileForm(@js($sales))">
                @csrf

                <flux:field>
                    <flux:label>{{ __('Nama Arsip') }}</flux:label>
                    <flux:input name="nama" placeholder="Masukkan nama arsip yang deskriptif" required />
                </flux:field>

                <!-- Select Sales Button -->
                <div class="space-y-2">
                    <flux:label>{{ __('Sales Representative') }}</flux:label>
                    <input type="hidden" name="created_by" :value="selectedSales" required>
                    <button type="button" @click="showSalesModal = true"
                        class="w-full flex items-center justify-between px-3 py-2 bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-lg text-sm text-left shadow-sm hover:border-blue-500 focus:outline-none transition-all">
                        <span x-text="selectedSalesName || '{{ __('Cari & Pilih Sales Representative') }}'" :class="!selectedSalesName && 'text-zinc-500'"></span>
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <p class="mt-1 text-[10px] text-gray-500 uppercase font-bold tracking-tight bg-gray-50 dark:bg-zinc-900 px-2 py-0.5 rounded-sm inline-block">
                        {{ __('Kepemilikan File') }}
                    </p>
                </div>

                <!-- Select Client Button -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <flux:label>{{ __('Client (Opsional)') }}</flux:label>
                        <template x-if="loadingClients">
                            <span class="text-[10px] text-blue-500 animate-pulse font-bold uppercase">{{ __('Loading Clients...') }}</span>
                        </template>
                    </div>
                    <input type="hidden" name="id_client" :value="selectedClient">
                    <button type="button" @click="if(selectedSales) showClientModal = true"
                        :disabled="!selectedSales || loadingClients"
                        class="w-full flex items-center justify-between px-3 py-2 bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-lg text-sm text-left shadow-sm hover:border-blue-500 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                        <span x-text="selectedClientName || (selectedSales ? '{{ __('Cari & Pilih Client') }}' : '{{ __('Pilih sales dulu...') }}')" :class="!selectedClientName && 'text-zinc-500'"></span>
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <p class="mt-1 text-[10px] text-gray-500 uppercase font-bold tracking-tight bg-gray-50 dark:bg-zinc-900 px-2 py-0.5 rounded-sm inline-block">
                        {{ __('Pelanggan Terkait') }}
                    </p>
                </div>

                <!-- Sales Picker Modal Overlay -->
                <div x-show="showSalesModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-zinc-950/50 backdrop-blur-sm" @click="showSalesModal = false"></div>
                    <div class="relative w-full max-w-lg bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 animate-in fade-in zoom-in-95 duration-200">
                        <div class="p-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                            <h4 class="font-bold text-lg">{{ __('Pilih Sales') }}</h4>
                            <button type="button" @click="showSalesModal = false" class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="p-4">
                            <input type="text" x-model="searchSales" placeholder="{{ __('Cari nama sales...') }}" 
                                class="w-full px-4 py-2 bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl focus:ring-2 focus:ring-blue-500 text-sm mb-4">
                            <div class="max-h-80 overflow-y-auto space-y-1">
                                <template x-if="filteredSales.length === 0">
                                    <div class="py-10 text-center text-zinc-400 italic">{{ __('Tidak ada sales ditemukan') }}</div>
                                </template>
                                <template x-for="s in filteredSales" :key="s.id">
                                    <button type="button" @click="selectSales(s.id, s.name)"
                                        class="w-full text-left px-4 py-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 flex items-center space-x-3 transition-colors">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 font-bold uppercase" x-text="s.name.substring(0,1)"></div>
                                        <div class="flex-1">
                                            <div class="text-sm font-bold text-zinc-900 dark:text-zinc-100" x-text="s.name"></div>
                                            <div class="text-xs text-zinc-500" x-text="s.email"></div>
                                        </div>
                                        <div x-show="selectedSales == s.id">
                                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client Picker Modal Overlay -->
                <div x-show="showClientModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                    <div class="absolute inset-0 bg-zinc-950/50 backdrop-blur-sm" @click="showClientModal = false"></div>
                    <div class="relative w-full max-w-lg bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800 animate-in fade-in zoom-in-95 duration-200">
                        <div class="p-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-lg">{{ __('Pilih Client') }}</h4>
                                <p class="text-xs text-zinc-500">{{ __('Terdaftar untuk:') }} <span class="font-bold text-blue-500" x-text="selectedSalesName"></span></p>
                            </div>
                            <button type="button" @click="showClientModal = false" class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="p-4">
                            <input type="text" x-model="searchClient" placeholder="{{ __('Cari nama client atau perusahaan...') }}" 
                                class="w-full px-4 py-2 bg-zinc-50 dark:bg-zinc-800 border-none rounded-xl focus:ring-2 focus:ring-blue-500 text-sm mb-4">
                            <div class="max-h-80 overflow-y-auto space-y-1">
                                <template x-if="filteredClients.length === 0">
                                    <div class="py-10 text-center text-zinc-400 italic uppercase font-bold text-xs">{{ __('Tidak ada client ditemukan') }}</div>
                                </template>
                                <template x-for="c in filteredClients" :key="c.id">
                                    <button type="button" @click="selectClient(c.id, c.nama + (c.nama_perusahaan ? ' - ' + c.nama_perusahaan : ''))"
                                        class="w-full text-left px-4 py-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 flex items-center space-x-3 transition-colors">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 font-bold uppercase" x-text="c.nama.substring(0,1)"></div>
                                        <div class="flex-1">
                                            <div class="text-sm font-bold text-zinc-900 dark:text-zinc-100" x-text="c.nama"></div>
                                            <div class="text-xs text-zinc-500" x-show="c.nama_perusahaan" x-text="c.nama_perusahaan"></div>
                                        </div>
                                        <div x-show="selectedClient == c.id">
                                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <flux:field>
                    <flux:label>{{ __('Status') }}</flux:label>
                    <flux:select name="status" required>
                        @foreach(\App\Models\ArsipFile::getStatusOptions() as $value => $label)
                            <option value="{{ $value }}" {{ $value === 'draft' ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Pilih status untuk file arsip ini') }}
                    </p>
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('File') }}</flux:label>
                    <flux:input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar" required />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG, ZIP, RAR. Maksimal 10MB') }}
                    </p>
                </flux:field>

                <div class="flex space-x-3 justify-end pt-4">
                    <flux:modal.close>
                        <flux:button variant="ghost">{{ __('Batal') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        {{ __('Simpan File') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
    <script>
        function arsipFileForm(salesData) {
            return {
                sales: salesData,
                selectedSales: '',
                selectedSalesName: '',
                searchSales: '',
                showSalesModal: false,

                selectedClient: '',
                selectedClientName: '',
                searchClient: '',
                showClientModal: false,

                clients: [],
                loadingClients: false,

                get filteredSales() {
                    if (!this.searchSales) return this.sales;
                    const q = this.searchSales.toLowerCase();
                    return this.sales.filter(s => s.name.toLowerCase().includes(q));
                },

                get filteredClients() {
                    if (!this.searchClient) return this.clients;
                    const q = this.searchClient.toLowerCase();
                    return this.clients.filter(c => 
                        (c.nama && c.nama.toLowerCase().includes(q)) || 
                        (c.nama_perusahaan && c.nama_perusahaan.toLowerCase().includes(q))
                    );
                },

                async fetchClients() {
                    if (!this.selectedSales) return;
                    this.loadingClients = true;
                    try {
                        const response = await fetch(`/admin/penawaran/clients/${this.selectedSales}`);
                        this.clients = await response.json();
                    } catch (error) {
                        console.error('Error fetching clients:', error);
                    } finally {
                        this.loadingClients = false;
                    }
                },

                selectSales(id, name) {
                    this.selectedSales = id;
                    this.selectedSalesName = name;
                    this.showSalesModal = false;
                    this.searchSales = '';
                    this.selectedClient = '';
                    this.selectedClientName = '';
                    this.fetchClients();
                },

                selectClient(id, name) {
                    this.selectedClient = id;
                    this.selectedClientName = name;
                    this.showClientModal = false;
                    this.searchClient = '';
                }
            }
        }
    </script>
</x-layouts.app>
 