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

    <div class="w-full">
        <div class="max-w-7xl mx-auto">
            <!-- RAB yang Terhubung -->
            <div class="w-full">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">RAB yang Ditugaskan</h3>
                        <a href="{{ route('supervisi.rab.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
                <div class="w-full pt-6">
                    @if($recentRABs && $recentRABs->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($recentRABs->take(6) as $rab)
                                <div class="bg-white dark:bg-zinc-900/50 border border-gray-200 dark:border-zinc-600 rounded-lg p-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                    {{ strtoupper(substr($rab->proyek ?? 'RAB', 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            @php
                                                $statusColors = [
                                                    'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                                                    'on_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                                                    'selesai' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                                ];
                                                $statusText = [
                                                    'draft' => 'Draft',
                                                    'on_progress' => 'On Progress',
                                                    'selesai' => 'Selesai',
                                                ];
                                                $color = $statusColors[$rab->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300';
                                                $text = $statusText[$rab->status] ?? ucfirst($rab->status);
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">
                                                {{ $text }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-1 line-clamp-2">
                                            {{ $rab->proyek ?? 'Nama Proyek' }}
                                        </h4>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                            {{ $rab->pekerjaan ?? 'Pekerjaan' }} • {{ $rab->lokasi ?? 'Lokasi' }}
                                        </p>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Dibuat: {{ $rab->created_at ? $rab->created_at->format('d M Y') : 'N/A' }}
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <a href="{{ route('supervisi.rab.show', $rab) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada RAB</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">RAB yang ditugaskan akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 w-full">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Aksi Cepat</h3>
                </div>
                <div class="w-full pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('supervisi.rab.index') }}" class="flex items-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors duration-200 border border-indigo-200 dark:border-indigo-800">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Lihat Semua RAB</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola semua RAB yang ditugaskan</p>
                            </div>
                        </a>

                        <a href="{{ route('supervisi.logs') }}" class="flex items-center p-4 bg-gray-50 dark:bg-gray-900/20 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900/30 transition-colors duration-200 border border-gray-200 dark:border-gray-800">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Log Aktivitas</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Lihat riwayat aktivitas sistem</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.supervisi>
