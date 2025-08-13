<x-layouts.supervisi title="Dashboard Supervisi">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ now()->format('d M Y, H:i') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl shadow-lg mb-8 overflow-hidden">
                <div class="px-6 py-8">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h1 class="text-3xl font-bold text-white">
                                Selamat Datang, {{ auth()->user()->name }}!
                            </h1>
                            <p class="text-amber-100 text-lg">Dashboard Supervisi - Monitor dan kelola aktivitas tim</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Client -->
                <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Client</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $clientCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Daily Activity -->
                <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Aktivitas</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $dailyActivityCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pengajuan -->
                <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengajuan</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $pengajuanCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Produk -->
                <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produk</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $produkCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total RAB -->
                <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total RAB</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $rabCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Clients -->
                <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Client Terbaru</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($recentClients as $client)
                            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                                    {{ strtoupper(substr($client->nama_perusahaan ?? $client->nama, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $client->nama_perusahaan ?? $client->nama }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $client->alamat ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $client->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada client</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Client akan muncul di sini setelah ditambahkan.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="px-6 py-4 bg-gray-50 dark:bg-zinc-700 border-t border-gray-200 dark:border-zinc-700">
                        <a href="#" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-500 dark:hover:text-amber-300">
                            Lihat semua client →
                        </a>
                    </div>
                </div>

                <!-- Recent Daily Activities -->
                <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Aktivitas Harian Terbaru</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($recentActivities as $activity)
                            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600 dark:text-green-400">
                                                    {{ $activity->creator ? strtoupper(substr($activity->creator->name, 0, 2)) : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $activity->jenis_aktivitas ?? 'Aktivitas' }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                oleh {{ $activity->creator->name ?? 'Unknown' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada aktivitas</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Aktivitas harian akan muncul di sini setelah ditambahkan.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="px-6 py-4 bg-gray-50 dark:bg-zinc-700 border-t border-gray-200 dark:border-zinc-700">
                        <a href="#" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-500 dark:hover:text-amber-300">
                            Lihat semua aktivitas →
                        </a>
                    </div>
                </div>
            </div>

            <!-- RAB yang Terhubung -->
            <div class="mt-8 bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">RAB yang Ditugaskan</h3>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse($recentRABs as $rab)
                        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                                {{ strtoupper(substr($rab->proyek, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $rab->proyek }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $rab->pekerjaan }} • {{ $rab->lokasi }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center space-x-2">
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
                                        <a href="{{ route('supervisi.rab.show', $rab) }}" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-500 dark:hover:text-amber-300">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada RAB</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">RAB yang ditugaskan akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>
                @if($recentRABs->count() > 0)
                    <div class="px-6 py-4 bg-gray-50 dark:bg-zinc-700 border-t border-gray-200 dark:border-zinc-700">
                        <a href="{{ route('supervisi.rab.index') }}" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-500 dark:hover:text-amber-300">
                            Lihat semua RAB →
                        </a>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Aksi Cepat</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="#" class="flex items-center p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors duration-200 border border-amber-200 dark:border-amber-800">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Tambah Client</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Daftarkan client baru</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors duration-200 border border-blue-200 dark:border-blue-800">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Catat Aktivitas</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tambah aktivitas harian</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors duration-200 border border-green-200 dark:border-green-800">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Review Pengajuan</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tinjau pengajuan baru</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.supervisi>
