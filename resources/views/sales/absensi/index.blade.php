<x-layouts.sales :title="__('Absensi Sales')">
    <div class="container mx-auto">
        <div class="w-full mx-auto">
            <!-- Header Section -->
            <div class="mb-4">
                <div class="flex flex-col">
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Absensi</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelola dan pantau kehadiran anda</p>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            <x-flash-message type="success" :message="session('success')" />
            <x-flash-message type="error" :message="session('error')" />

            <!-- Attendance Summary -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Hadir</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalHadir }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Izin</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalIzin }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sakit</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalSakit }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alpha</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $totalAlpha }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form method="GET" action="{{ route('sales.absensi.index') }}" class="space-y-4">
                    <!-- Date Range -->
                    <div class="space-y-2">
                        <label for="start_date" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('Filter Tanggal') }}
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <div class="flex w-full gap-4">
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                    class="w-full md:w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-zinc-700/50 px-3 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-zinc focus:ring-2 focus:ring-zinc/20 dark:focus:ring-zinc/30"
                                    max="{{ $endDate }}" onchange="updateEndDateMin(this.value)">
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                    class="w-full md:w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-zinc-700/50 px-3 py-3 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-zinc focus:ring-2 focus:ring-zinc/20 dark:focus:ring-zinc/30"
                                    min="{{ $startDate }}" onchange="updateStartDateMax(this.value)">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-4">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-800 text-white hover:bg-emerald-800/90 dark:bg-emerald-800/90 dark:hover:bg-emerald-800 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('Filter') }}
                            </button>
                            <a href="{{ route('sales.absensi.index') }}"
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

            <!-- Results Info -->
            @if(request('start_date') || request('end_date'))
                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Menampilkan {{ $absensi->total() }} absensi
                        @if(request('start_date') && request('end_date'))
                            dari {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} 
                            hingga {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }}
                        @endif
                    </p>
                </div>
            @endif

            <!-- Attendance List -->
            @if($absensi->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($absensi as $item)
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($item->status_absen == 1)
                                            <div class="p-2 rounded-full bg-green-100 dark:bg-green-900">
                                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        @elseif($item->status_absen == 2)
                                            <div class="p-2 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        @elseif($item->status_absen == 3)
                                            <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900">
                                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </div>
                                        @elseif($item->status_absen == 0 && $item->tgl_absen->isToday())
                                            <div class="p-2 rounded-full bg-gray-100 dark:bg-gray-900">
                                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="p-2 rounded-full bg-red-100 dark:bg-red-900">
                                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $item->user->name }}
                                        </h3>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->tgl_absen->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    @if($item->status_absen == 1)
                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($item->status_absen == 2)
                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($item->status_absen == 3)
                                        bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($item->status_absen == 0 && $item->tgl_absen->isToday())
                                        bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                    @else
                                        bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    @if($item->status_absen == 1)
                                        Hadir
                                    @elseif($item->status_absen == 2)
                                        Izin
                                    @elseif($item->status_absen == 3)
                                        Sakit
                                    @elseif($item->status_absen == 0 && $item->tgl_absen->isToday())
                                        Waiting
                                    @else
                                        Alpha
                                    @endif
                                </span>
                            </div>
                            @if($item->count > 0)
                                <div class="mt-4 flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <span>Jumlah aktivitas: {{ $item->count }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $absensi->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada absensi</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Absensi akan otomatis tercatat saat Anda menambahkan aktivitas harian.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.sales>

@push('scripts')
<script>
    function updateEndDateMin(value) {
        document.getElementById('end_date').min = value;
    }

    function updateStartDateMax(value) {
        document.getElementById('start_date').max = value;
    }
</script>
@endpush
