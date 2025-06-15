<x-layouts.sales :title="__('Daftar Pelanggan Saya')">
    @php
        function formatWhatsAppNumber($phoneNumber) {
            // Remove all non-numeric characters
            $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
            
            // If number starts with 0, replace with +62
            if (substr($cleanNumber, 0, 1) === '0') {
                return '+62' . substr($cleanNumber, 1);
            }
            
            // If number starts with 62, add +
            if (substr($cleanNumber, 0, 2) === '62') {
                return '+' . $cleanNumber;
            }
            
            // If number starts with 8 (Indonesian mobile), add +62
            if (substr($cleanNumber, 0, 1) === '8') {
                return '+62' . $cleanNumber;
            }
            
            // Default: just add +62
            return '+62' . $cleanNumber;
        }
    @endphp

    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Pelanggan Saya</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelola semua pelanggan yang telah Anda tambahkan</p>
                    </div>
                    <a href="{{ route('sales.client.create') }}"
                        class="inline-flex w-fit items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-900 border border-transparent rounded-lg font-semibold text-sm text-white dark:text-emerald-400 hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Pelanggan
                    </a>
                </div>
            </div>
            
            <!-- Flash Messages -->
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Search and Filter Section -->
            <div class="mb-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form method="GET" action="{{ route('sales.client.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search Input -->
                        <div>
                            <flux:input 
                                name="search" 
                                :label="__('Cari Pelanggan')" 
                                type="text" 
                                :placeholder="__('Cari pelanggan')"
                                :value="request('search')"
                            />
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <flux:select 
                                name="status" 
                                :label="__('Status')"
                            >
                                <option value="">{{ __('Semua Status') }}</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('Aktif') }}</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('Nonaktif') }}</option>
                            </flux:select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end space-x-2 w-full">
                            <button type="submit"
                                class="inline-flex lg:w-full items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari
                            </button>
                            <a href="{{ route('sales.client.index') }}"
                                class="inline-flex lg:w-full items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            @if(request('search') || request('status'))
                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Menampilkan {{ $clients->total() }} pelanggan
                        @if(request('search'))
                            untuk pencarian "{{ request('search') }}"
                        @endif
                        @if(request('status'))
                            dengan status {{ request('status') === 'active' ? 'Aktif' : 'Nonaktif' }}
                        @endif
                    </p>
                </div>
            @endif

            <!-- Client Cards Grid -->
            @if($clients->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($clients as $client)
                        <div class="bg-white h-full flex flex-col justify-between dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <!-- Card Header -->
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ $client->nama }}</h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $client->status ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ $client->status ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="px-6 py-4 space-y-2">
                                <!-- Email -->
                                @if($client->email)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="mailto:{{ $client->email }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 truncate">
                                        {{ $client->email }}
                                    </a>
                                </div>
                                @endif
                                <!-- Phone -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $client->notelp }}</span>
                                </div>

                                <!-- Company -->
                                @if($client->nama_perusahaan)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $client->nama_perusahaan }}</span>
                                </div>
                                @endif

                                <!-- Address -->
                                @if($client->alamat)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1">{{ $client->alamat }}</span>
                                </div>
                                @endif

                                <!-- Created Date -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Dibuat: {{ $client->created_at->format('d/m/Y') }}</span>
                                </div>

                                <!-- Visit Count -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Kunjungan: {{ $client->dailyActivities()->where('deleted_status', false)->count() }}</span>
                                </div>

                                <!-- Description (if exists) -->
                                @if($client->description && count($client->description) > 0)
                                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <div class="space-y-2">
                                            @foreach($client->description as $desc)
                                                <div class="flex items-start">
                                                    <svg class="w-4 h-4 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $desc }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Footer -->
                            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-700 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <!-- Left Side: WhatsApp and Download -->
                                    <div class="flex items-center space-x-2">
                                        <!-- WhatsApp Button -->
                                        <a href="https://wa.me/{{ formatWhatsAppNumber($client->notelp) }}?text=Halo {{ $client->nama }}, saya ingin berbicara tentang penawaran produk kami." 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                        </a>

                                        <!-- Download File Button (if file exists) -->
                                        @if($client->file_input)
                                            <a href="{{ Storage::url($client->file_input) }}" 
                                               target="_blank"
                                               class="inline-flex items-center px-3 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                               title="Download File">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Right Side: Action Buttons -->
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('sales.client.show', $client) }}"
                                            class="inline-flex items-center p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors duration-200"
                                            title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('sales.client.edit', $client) }}"
                                            class="inline-flex items-center p-2 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-200"
                                            title="Edit Client">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('sales.client.destroy', $client) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus client ini? Client akan diarsipkan dan tidak akan muncul di daftar utama.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200"
                                                title="Hapus Client">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $clients->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-4 bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        @if(request('search') || request('status'))
                            Tidak ada client yang ditemukan
                        @else
                            Belum ada client
                        @endif
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        @if(request('search') || request('status'))
                            Coba ubah kriteria pencarian atau filter Anda
                        @else
                            Mulai dengan menambahkan client pertama Anda
                        @endif
                    </p>
                    @if(!request('search') && !request('status'))
                        <a href="{{ route('sales.client.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:bg-emerald-700 dark:focus:bg-emerald-600 active:bg-emerald-900 dark:active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Client Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.sales> 