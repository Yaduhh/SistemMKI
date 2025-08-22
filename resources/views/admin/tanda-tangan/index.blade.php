<x-layouts.app :title="__('Kelola Tanda Tangan')">
    <div class="container mx-auto">
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Kelola Tanda Tangan</h1>
                    <p class="text-zinc-600 dark:text-zinc-400">Kelola tanda tangan untuk semua user</p>
                </div>
            </div>
        </div>

        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Action Buttons -->
        <div class="mb-6 flex justify-between items-center">
            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                Total: {{ $tandaTangan->count() }} tanda tangan
            </div>
            <a href="{{ route('admin.tanda-tangan.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Tanda Tangan
            </a>
        </div>

        <!-- Table -->
        <div
            class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                No
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                User
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                Tanda Tangan
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                Tanggal Dibuat
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($tandaTangan as $index => $ttd)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                    <div>
                                        <div class="font-medium">{{ $ttd->user->name }}</div>
                                        <div class="text-zinc-500 dark:text-zinc-400">{{ $ttd->user->email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                    @if ($ttd->ttd)
                                        <img src="{{ Storage::url($ttd->ttd) }}" alt="Tanda Tangan"
                                            class="w-20 h-16 object-contain border border-zinc-200 rounded">
                                    @else
                                        <span class="text-zinc-400">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                    {{ $ttd->created_at->format('j F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.tanda-tangan.edit', $ttd->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tanda-tangan.destroy', $ttd->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus tanda tangan ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-zinc-500 dark:text-zinc-400">
                                    Belum ada tanda tangan yang diupload
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Users without TTD -->
        @if ($users->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">User yang Belum Punya Tanda Tangan</h3>
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($users as $user)
                            <div class="flex items-center justify-between py-2 px-3 hover:bg-zinc-50 dark:hover:bg-zinc-700 rounded-md transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-zinc-100 dark:bg-zinc-700 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('admin.tanda-tangan.create') }}?user_id={{ $user->id }}"
                                    class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                    + Upload
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
