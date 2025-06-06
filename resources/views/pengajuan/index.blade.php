<x-layouts.app :title="__('Daftar Pengajuan')">
    <div class="flex flex-col gap-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-100">{{ 'Daftar Pengajuan' }}</h1>

            <!-- Tombol untuk tambah pengajuan -->
            <div class="flex justify-end">
                <a href="{{ route('admin.pengajuan.create') }}"
                    class="bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300 ease-in-out text-sm px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg">
                    {{ __('Tambah Pengajuan') }}
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Search and Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.pengajuan.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent"
                            placeholder="Cari pengajuan...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- User Filter -->
                <div class="w-full md:w-48">
                    <select name="user" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent">
                        <option value="">Semua Sales</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full md:w-48">
                    <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sukses</option>
                        <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300">
                        Filter
                    </button>
                    <a href="{{ route('admin.pengajuan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($pengajuan as $item)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-1">{{ $item->client }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No: {{ $item->nomor_pengajuan }}</p>
                            </div>
                            <span class="inline-block px-3 py-1 text-xs rounded-full 
                                @if($item->status == 0)
                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($item->status == 1)
                                    bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else
                                    bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                @if($item->status == 0)
                                    Pending
                                @elseif($item->status == 1)
                                    Sukses
                                @else
                                    Ditolak
                                @endif
                            </span>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $item->nama_client }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $item->date_pengajuan->locale('id')->isoFormat('ddd, DD MMMM YYYY') }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-medium">Penanggung Jawab:</span>
                                <span class="ml-1">{{ $item->user->name }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.pengajuan.edit', $item->id) }}"
                                    class="bg-yellow-50 text-yellow-600 hover:bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50 transition duration-300 text-xs px-3 py-1.5 rounded-lg">
                                    Edit
                                </a>
                                <form action="{{ route('admin.pengajuan.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition duration-300 text-xs px-3 py-1.5 rounded-lg">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                            <div class="flex space-x-2">
                                @if($item->status == 0)
                                    <form action="{{ route('admin.pengajuan.approve', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="bg-green-50 text-green-600 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition duration-300 text-xs px-3 py-1.5 rounded-lg">
                                            Setuju
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pengajuan.reject', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition duration-300 text-xs px-3 py-1.5 rounded-lg">
                                            Tolak
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.pengajuan.cetak', $item->id) }}"
                                    class="bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition duration-300 text-xs px-3 py-1.5 rounded-lg">
                                    Cetak PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col items-center justify-center text-center">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Tidak ada data pengajuan</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada pengajuan yang dibuat atau data tidak ditemukan.</p>
                            <a href="{{ route('admin.pengajuan.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Buat Pengajuan Baru
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $pengajuan->appends(request()->query())->links() }}
        </div>
    </div>
</x-layouts.app>
