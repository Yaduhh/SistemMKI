<x-layouts.app :title="__('File Purchase Order')">
    <div class="container mx-auto px-4 py-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('File Purchase Order') }}</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">{{ __('Kelola semua file arsip pelanggan dalam satu tempat') }}</p>
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
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $arsipFiles->total() }}</p>
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
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-zinc-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Daftar File Arsip') }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Semua file arsip pelanggan yang tersedia') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Menampilkan') }} {{ $arsipFiles->count() }} {{ __('dari') }} {{ $arsipFiles->total() }} {{ __('file') }}</span>
                    </div>
                </div>
            </div>

            <div class="py-6">
                @if($arsipFiles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($arsipFiles as $arsip)
                            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200">
                                <!-- File Header -->
                                <div class="p-4 bg-gray-50 dark:bg-zinc-900/30 border-b border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
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
                                            <div class="p-2 rounded-md {{ $iconClass }}">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-medium text-gray-900 dark:text-white text-sm truncate">
                                                    {{ $arsip->nama }}
                                                </h3>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-medium">
                                                    {{ $extension }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $arsip->getStatusBadgeClass() }}">
                                                {{ ucfirst($arsip->status) }}
                                            </span>
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                                    </svg>
                                                </button>
                                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-600 z-10">
                                                    <div class="py-1">
                                                        <form action="{{ route('admin.arsip-file.update', $arsip->id) }}" method="POST" class="block">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="draft">
                                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700 {{ $arsip->status === 'draft' ? 'bg-gray-100 dark:bg-zinc-700' : '' }}">
                                                                Draft
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.arsip-file.update', $arsip->id) }}" method="POST" class="block">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="on progress">
                                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700 {{ $arsip->status === 'on progress' ? 'bg-gray-100 dark:bg-zinc-700' : '' }}">
                                                                On Progress
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.arsip-file.update', $arsip->id) }}" method="POST" class="block">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="done">
                                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-700 {{ $arsip->status === 'done' ? 'bg-gray-100 dark:bg-zinc-700' : '' }}">
                                                                Done
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Details -->
                                <div class="p-4 space-y-3">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-500 dark:text-gray-400">{{ __('Client') }}</span>
                                            <span class="font-medium text-gray-900 dark:text-white truncate max-w-32">
                                                {{ $arsip->client->nama ?? 'N/A' }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-500 dark:text-gray-400">{{ __('Dibuat oleh') }}</span>
                                            <span class="font-medium text-gray-900 dark:text-white truncate max-w-32">
                                                {{ $arsip->creator->name ?? 'Unknown' }}
                                            </span>
                                        </div>

                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-500 dark:text-gray-400">{{ __('Tanggal') }}</span>
                                            <span class="font-medium text-gray-900 dark:text-white">
                                                {{ $arsip->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="pt-3 border-t border-gray-200 dark:border-gray-600">
                                        <div class="flex space-x-2 mb-2">
                                            <a href="{{ Storage::url($arsip->file) }}" target="_blank"
                                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-900/30 dark:text-blue-200 dark:hover:bg-blue-800/50 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                {{ __('Download') }}
                                            </a>
                                            
                                            @if($arsip->client)
                                                <a href="{{ route('admin.client.show', $arsip->client) }}"
                                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-900/30 dark:text-green-200 dark:hover:bg-green-800/50 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                    {{ __('Client') }}
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.arsip-file.destroy', $arsip->id) }}"
                                            method="POST" class="w-full"
                                            onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus file ini?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-3 py-2 text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-900/30 dark:text-red-200 dark:hover:bg-red-800/50 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                {{ __('Hapus File') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $arsipFiles->links() }}
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
                class="space-y-4">
                @csrf

                <flux:field>
                    <flux:label>{{ __('Nama Arsip') }}</flux:label>
                    <flux:input name="nama" placeholder="Masukkan nama arsip yang deskriptif" required />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Berikan nama yang jelas untuk memudahkan pencarian') }}
                    </p>
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Client (Opsional)') }}</flux:label>
                    <flux:select name="id_client">
                        <option value="">{{ __('Pilih Client (Opsional)') }}</option>
                        @foreach(\App\Models\Client::where('status_deleted', false)->orderBy('nama')->get() as $client)
                            <option value="{{ $client->id }}">{{ $client->nama }}</option>
                        @endforeach
                    </flux:select>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Pilih client jika file terkait dengan pelanggan tertentu') }}
                    </p>
                </flux:field>

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
</x-layouts.app> 