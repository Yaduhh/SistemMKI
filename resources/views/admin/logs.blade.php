<x-layouts.app :title="__('Log Aktivitas Sistem')">
    <div class="w-full">
        <div class="mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Log Aktivitas Sistem</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Riwayat lengkap aktivitas sistem MKI
                        </p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Logs Card -->
            <div class="bg-white dark:bg-zinc-900/30 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Aktivitas</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Log aktivitas terbaru sistem</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    @if($allLogs->count() > 0)
                        <div class="space-y-4">
                            @foreach($allLogs as $log)
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 border-l-4 hover:shadow-md transition-shadow duration-200
                                    @if($log->action === 'CREATE') border-green-500
                                    @elseif($log->action === 'UPDATE') border-yellow-500
                                    @elseif($log->action === 'DELETE') border-red-500
                                    @elseif($log->action === 'LOGIN') border-blue-500
                                    @elseif($log->action === 'LOGOUT') border-gray-500
                                    @else border-blue-500
                                    @endif">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                    @if($log->action === 'CREATE') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                    @elseif($log->action === 'UPDATE') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                    @elseif($log->action === 'DELETE') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                    @elseif($log->action === 'LOGIN') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                    @elseif($log->action === 'LOGOUT') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                                    @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                    @endif">
                                                    {{ ucfirst(strtolower($log->action)) }}
                                                </span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                    {{ $log->module }}
                                                </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $log->created_at->format('d M Y, H:i:s') }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <p class="text-sm text-gray-900 dark:text-white font-medium">
                                                    {{ $log->description }}
                                                </p>
                                            </div>
                                            <div class="flex items-center space-x-2 text-sm">
                                                <span class="text-gray-500 dark:text-gray-400">oleh</span>
                                                <span class="text-gray-900 dark:text-white font-medium">{{ $log->user->name ?? 'System' }}</span>
                                                <span class="text-xs text-gray-400 ml-2">IP: {{ $log->ip_address }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            {{ $allLogs->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada log aktivitas</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Belum ada aktivitas sistem yang tercatat.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 