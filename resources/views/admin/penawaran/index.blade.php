<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Penawaran</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kelola semua penawaran aktif yang telah dibuat
                </p>
            </div>
            <x-button href="{{ route('admin.penawaran.create') }}"
                class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <x-icon name="plus-circle" class="w-5 h-5 mr-2" />
                Buat Penawaran
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="pb-6 space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 dark:text-blue-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Penawaran Aktif
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $penawarans->total() }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 dark:text-green-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Penawaran WIN
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $penawarans->where('status', 1)->count() }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-6 border border-red-200 dark:border-red-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-600 dark:text-red-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Penawaran LOSE
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $penawarans->where('status', 2)->count() }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-red-100 dark:bg-red-900/30">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-6 border border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-600 dark:text-yellow-400 text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Draft
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $penawarans->where('status', 0)->count() }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div
            class="bg-white dark:bg-zinc-900/30 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pencarian & Filter</h3>
            </div>
            <form method="GET" action="{{ route('admin.penawaran.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Penawaran
                            </div>
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nomor, client, atau judul penawaran..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Filter by Sales -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Filter Sales
                            </div>
                        </label>
                        <select name="user"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Sales</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                    </path>
                                </svg>
                                Filter Status
                            </div>
                        </label>
                        <select name="status"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>WIN</option>
                            <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>LOSE</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex justify-between items-center mt-4">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.penawaran.index') }}"
                        class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 flex items-center gap-2 transition-all duration-300 hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- Penawaran Cards -->
        <div class="space-y-6">
            @forelse($penawarans as $penawaran)
                <div
                    class="bg-white dark:bg-zinc-900/30 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $penawaran->judul_penawaran }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 font-mono">
                                        {{ $penawaran->nomor_penawaran }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold 
                                {{ $penawaran->status == 1
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                    : ($penawaran->status == 2
                                        ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'
                                        : ($penawaran->status == 0
                                            ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'
                                            : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400')) }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="
                                        {{ $penawaran->status == 1
                                            ? 'M5 13l4 4L19 7'
                                            : ($penawaran->status == 2
                                                ? 'M6 18L18 6M6 6l12 12'
                                                : ($penawaran->status == 0
                                                    ? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                                    : 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z')) }}">
                                        </path>
                                    </svg>
                                    {{ $penawaran->status == 1
                                        ? 'WIN'
                                        : ($penawaran->status == 2
                                            ? 'LOSE'
                                            : ($penawaran->status == 0
                                                ? 'Draft'
                                                : 'Draft')) }}
                                </span>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- Client Info -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Client</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $penawaran->client->nama ?? 'Client tidak ditemukan' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sales Info -->
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Sales</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $penawaran->user->name ?? 'Sales tidak ditemukan' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Info -->
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $penawaran->tanggal_penawaran ? $penawaran->tanggal_penawaran->format('d M Y') : 'Belum ditentukan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            <x-button href="{{ route('admin.penawaran.show', $penawaran) }}"
                                class="bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Detail
                            </x-button>
                            <x-button href="{{ route('admin.penawaran.edit', $penawaran) }}"
                                class="bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 dark:hover:bg-amber-900/30 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit
                            </x-button>
                            <x-button href="{{ route('admin.penawaran.cetak', $penawaran) }}"
                                class="bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                    </path>
                                </svg>
                                Cetak
                            </x-button>
                            @if ($penawaran->status != 1)
                                <form action="{{ route('admin.penawaran.destroy', $penawaran) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus penawaran ini?')">
                                    @csrf @method('DELETE')
                                    <x-button type="submit"
                                        class="bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 px-4 py-2 rounded-lg transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Hapus
                                    </x-button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div
                        class="bg-white dark:bg-zinc-900/30 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <div
                            class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Belum ada penawaran aktif
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-8">Mulai dengan membuat penawaran pertama Anda
                            untuk mengelola bisnis dengan lebih efisien</p>
                        <x-button href="{{ route('admin.penawaran.create') }}"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 px-8 py-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Penawaran Pertama
                        </x-button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($penawarans->hasPages())
            <div class="mt-8 flex justify-center">
                <div
                    class="bg-white dark:bg-zinc-900/30 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 px-6 py-4">
                    {{ $penawarans->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        // Form validation and debugging
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[method="GET"]');
            const searchInput = document.querySelector('input[name="search"]');
            const userSelect = document.querySelector('select[name="user"]');
            const statusSelect = document.querySelector('select[name="status"]');

            // Debug: Log form elements
            console.log('Form elements found:', {
                form: form,
                searchInput: searchInput,
                userSelect: userSelect,
                statusSelect: statusSelect
            });

            // Form submit handler for debugging
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submitted with data:', {
                        search: searchInput ? searchInput.value : 'not found',
                        user: userSelect ? userSelect.value : 'not found',
                        status: statusSelect ? statusSelect.value : 'not found'
                    });
                });
            }
        });
    </script>
</x-layouts.app>
