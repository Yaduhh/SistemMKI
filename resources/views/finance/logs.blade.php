<x-layouts.app>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Log Aktivitas</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Modul</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($logs as $log)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $log->user->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $log->action }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $log->module }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $log->description }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 