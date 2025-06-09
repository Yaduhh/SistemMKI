<x-layouts.app :title="__('Aktivitas Harian')">
    <div class="flex flex-col gap-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-primary/10 text-primary dark:bg-primary/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Aktivitas Harian') }}</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Kelola dan pantau aktivitas harian Anda') }}</p>
                </div>
            </div>

            <a href="{{ route('admin.daily-activity.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white hover:bg-primary/90 dark:bg-primary/90 dark:hover:bg-primary rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Tambah Aktivitas') }}
            </a>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Filters Section -->
        <div class="bg-white dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700/50 shadow-sm backdrop-blur-sm">
            <div class="p-4 sm:p-6">
                <form action="{{ route('admin.daily-activity.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- User Filter -->
                        <div class="space-y-2">
                            <label for="user" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Filter User') }}
                                </div>
                            </label>
                            <select name="user" id="user"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:focus:ring-primary/30">
                                <option value="">{{ __('Semua User') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="space-y-2">
                            <label for="start_date" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('Tanggal Mulai') }}
                                </div>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:focus:ring-primary/30"
                                max="{{ $endDate }}" onchange="updateEndDateMin(this.value)">
                        </div>

                        <div class="space-y-2">
                            <label for="end_date" class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('Tanggal Akhir') }}
                                </div>
                            </label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:focus:ring-primary/30"
                                min="{{ $startDate }}" onchange="updateStartDateMax(this.value)">
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white hover:bg-primary/90 dark:bg-primary/90 dark:hover:bg-primary rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('Filter') }}
                            </button>
                            <a href="{{ route('admin.daily-activity.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700/50 dark:text-gray-200 dark:hover:bg-gray-700 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                {{ __('Reset') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activities Grid -->
        <div class="grid grid-cols-1 gap-6">
            @forelse ($activities as $activity)
                <div class="bg-white dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700/50 shadow-sm hover:shadow-md transition-all duration-200 backdrop-blur-sm">
                    <div class="p-4 sm:p-6">
                        <!-- Activity Header -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-primary/10 dark:bg-primary/20">
                                    <span class="flex h-full w-full items-center justify-center text-sm font-medium text-primary dark:text-primary/90">
                                        {{ substr($activity->creator->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $activity->creator->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $activity->created_at->locale('id')->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @if ($activity->created_by === Auth::id())
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.daily-activity.edit', $activity->id) }}"
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-sm bg-yellow-50 text-yellow-600 hover:bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50 rounded-lg transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.daily-activity.destroy', $activity->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-sm bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Activity Content -->
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                            <!-- Dokumentasi Image -->
                            <div class="lg:col-span-3">
                                <div class="relative aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700/50 group">
                                    <img src="{{ asset($activity->dokumentasi) }}" alt="Dokumentasi"
                                        class="object-cover w-full h-full cursor-pointer transition-transform duration-300 group-hover:scale-105"
                                        onclick="openImageModal(this.src)">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Details and Comments -->
                            <div class="lg:col-span-9 space-y-6">
                                <!-- Activity Details -->
                                <div class="space-y-2">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __('Perihal') }}
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-300">{{ $activity->perihal }}</p>
                                </div>

                                <div class="space-y-2">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        {{ __('Pihak Bersangkutan') }}
                                    </h4>
                                    <p class="text-gray-600 dark:text-gray-300">{{ $activity->pihak_bersangkutan }}</p>
                                </div>

                                <!-- Comments Section -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white flex items-center gap-2">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        {{ __('Komentar') }}
                                    </h4>
                                    
                                    <!-- Comments List -->
                                    <div class="space-y-4">
                                        @foreach (json_decode($activity->komentar ?? '[]', true) as $comment)
                                            <div class="flex gap-3">
                                                <div class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full bg-primary/10 dark:bg-primary/20">
                                                    <span class="flex h-full w-full items-center justify-center text-sm font-medium text-primary dark:text-primary/90">
                                                        {{ substr($comment['user_name'], 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="flex-1 space-y-1">
                                                    <div class="flex items-center justify-between">
                                                        <h6 class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment['user_name'] }}</h6>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($comment['timestamp'])->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                                        {{ $comment['message'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Comment Form -->
                                    <form action="{{ route('admin.daily-activity.comment', $activity->id) }}" method="POST" class="mt-4">
                                        @csrf
                                        <div class="flex gap-3">
                                            <div class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full bg-primary/10 dark:bg-primary/20">
                                                <span class="flex h-full w-full items-center justify-center text-sm font-medium text-primary dark:text-primary/90">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <textarea name="message" rows="1"
                                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 dark:focus:ring-primary/30 resize-none"
                                                    placeholder="{{ __('Tulis komentar...') }}"></textarea>
                                                <div class="flex justify-end mt-2">
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-white hover:bg-primary/90 dark:bg-primary/90 dark:hover:bg-primary rounded-lg transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                        </svg>
                                                        {{ __('Kirim') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700/50 shadow-sm backdrop-blur-sm">
                    <div class="p-8">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="rounded-full bg-primary/10 dark:bg-primary/20 p-3">
                                <svg class="w-6 h-6 text-primary dark:text-primary/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('Tidak ada aktivitas') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada aktivitas yang ditambahkan.') }}</p>
                            <a href="{{ route('admin.daily-activity.create') }}"
                                class="mt-4 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white hover:bg-primary/90 dark:bg-primary/90 dark:hover:bg-primary rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('Tambah Aktivitas') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $activities->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center backdrop-blur-sm"
        onclick="closeImageModal()">
        <div class="max-w-4xl w-full mx-4">
            <img id="modalImage" src="" alt="Full size image" class="w-full h-auto rounded-xl shadow-2xl">
        </div>
    </div>

    <script>
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.classList.remove('hidden');
            modalImg.src = src;
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function updateEndDateMin(startDate) {
            const endDateInput = document.querySelector('input[name="end_date"]');
            endDateInput.min = startDate;
            if (endDateInput.value < startDate) {
                endDateInput.value = startDate;
            }
        }

        function updateStartDateMax(endDate) {
            const startDateInput = document.querySelector('input[name="start_date"]');
            startDateInput.max = endDate;
            if (startDateInput.value > endDate) {
                startDateInput.value = endDate;
            }
        }
    </script>
</x-layouts.app> 