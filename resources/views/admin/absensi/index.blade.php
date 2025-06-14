<x-layouts.app :title="__('Absensi')">
    <div class="flex flex-col gap-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-emerald-800/10 text-zinc dark:bg-emerald-800/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Absensi') }}</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Kelola dan pantau absensi pengguna') }}</p>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Attendance Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-zinc-900/50 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Hadir</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalHadir->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900/50 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Izin</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalIzin->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900/50 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sakit</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalSakit->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900/50 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alpha</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalAlpha->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div
            class="bg-white dark:bg-zinc-900/50 rounded-xl border border-gray-200 dark:border-gray-700/50 shadow-sm backdrop-blur-sm">
            <div class="p-4 sm:p-6">
                <form action="{{ route('admin.absensi.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- User Filter -->
                        <div class="space-y-2">
                            <label for="user" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Filter Pengguna') }}
                                </div>
                            </label>
                            <select name="user" id="user"
                                class="w-full mt-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-zinc-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-zinc focus:ring-2 focus:ring-zinc/20 dark:focus:ring-zinc/30">
                                <option value="">{{ __('Semua Pengguna') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }} class="bg-zinc-800">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Single Date Filter -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="filter_date" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('Filter Tanggal') }}
                                </div>
                            </label>

                            <div class="w-full mt-2">
                                <input type="date" name="filter_date" id="filter_date" value="{{ $startDate }}"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-zinc-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-zinc focus:ring-2 focus:ring-zinc/20 dark:focus:ring-zinc/30">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-2 md:col-span-3">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-800 text-white hover:bg-emerald-800/90 dark:bg-emerald-800/90 dark:hover:bg-emerald-800 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('Filter') }}
                            </button>
                            <a href="{{ route('admin.absensi.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-zinc-100 text-gray-700 hover:bg-zinc-200 dark:bg-zinc-700/50 dark:text-gray-200 dark:hover:bg-zinc-700 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                {{ __('Reset') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Absensi Table -->
        <div class="overflow-hidden bg-white dark:bg-zinc-900/50 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700/50">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-zinc-800/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('NO') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Tanggal') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Pengguna') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Kunjungan Harian') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('Aksi') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900/50 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $displayUsers = request('user') ? $users->where('id', request('user')) : $users;
                            $hasData = false;
                        @endphp
                        
                        @foreach ($displayUsers as $user)
                            @php
                                // Find absensi for this user on the selected date
                                $userAbsensi = $absensi->where('id_user', $user->id)->first();
                            @endphp
                            
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        @if ($user->profile)
                                            <img src="{{ asset('storage/' . $user->profile) }}"
                                                alt="{{ $user->name }}"
                                                class="h-8 w-8 rounded-full aspect-square object-cover mr-3">
                                        @else
                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-600/50 dark:text-zinc-400 uppercase mr-3">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                        @endif
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($userAbsensi)
                                        @php $hasData = true; @endphp
                                        @if ($userAbsensi->status_absen == 0)
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-400">
                                                {{ __('Alpha') }}
                                            </span>
                                        @elseif ($userAbsensi->status_absen == 1)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-400">
                                                {{ __('Hadir') }}
                                            </span>
                                        @elseif ($userAbsensi->status_absen == 2)
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-400">
                                                {{ __('Izin') }}
                                            </span>
                                        @elseif ($userAbsensi->status_absen == 3)
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-400">
                                                {{ __('Sakit') }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ __('Tidak Ada Data') }}  
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    @if ($userAbsensi && $userAbsensi->dailyActivity)
                                        <div class="space-x-4">
                                            <span class="text-gray-500 dark:text-gray-400">{{ $userAbsensi->count }} Kunjugan</span>
                                            <a href="{{ route('admin.daily-activity.show', $userAbsensi->dailyActivity->id) }}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                                                {{ $userAbsensi->dailyActivity->perihal }}
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        @if ($userAbsensi)
                                            <a href="{{ route('admin.absensi.edit', $userAbsensi->id) }}"
                                                class="flex items-center gap-4 bg-emerald-950 px-4 py-2 rounded-xl text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                {{ __('Edit') }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        
                        @if ($displayUsers->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Tidak ada pengguna yang ditemukan') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $absensi->links() }}
            </div>
        </div>
    </div>


</x-layouts.app>