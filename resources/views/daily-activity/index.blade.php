<x-layouts.app :title="__('Aktivitas Harian')">
    <div class="flex flex-col gap-8">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="font-bold text-2xl text-gray-800 dark:text-gray-100">{{ 'Aktivitas Harian' }}</h1>

            <!-- Tombol untuk tambah aktivitas -->
            <div class="flex justify-end">
                <a href="{{ route('admin.daily-activity.create') }}"
                    class="bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300 ease-in-out text-sm px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg">
                    {{ __('Tambah Aktivitas') }}
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Search and Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
            <form action="{{ route('admin.daily-activity.index') }}" method="GET"
                class="flex flex-col md:flex-row gap-4">
                <!-- User Filter -->
                <div class="w-full">
                    <select name="user"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent">
                        <option value="">Semua User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Filter -->
                <div class="flex gap-4">
                    <div class="w-full md:w-48">
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent"
                            placeholder="Tanggal Mulai" max="{{ $endDate }}"
                            onchange="updateEndDateMin(this.value)">
                    </div>
                    <div class="w-full md:w-48">
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent"
                            placeholder="Tanggal Akhir" min="{{ $startDate }}"
                            onchange="updateStartDateMax(this.value)">
                    </div>
                </div>

                <!-- Filter Button -->
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300">
                        Filter
                    </button>
                    <a href="{{ route('admin.daily-activity.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 gap-6">
            @forelse ($activities as $activity)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                    <!-- Post Header -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                                        {{ substr($activity->creator->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                        {{ $activity->creator->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->created_at->locale('id')->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @if ($activity->created_by === Auth::id())
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.daily-activity.edit', $activity->id) }}"
                                        class="bg-yellow-50 text-yellow-600 hover:bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50 transition duration-300 text-xs px-3 py-1.5 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.daily-activity.destroy', $activity->id) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition duration-300 text-xs px-3 py-1.5 rounded-lg">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-12 gap-10">
                            <!-- Dokumentasi Image -->
                            <div class="col-span-3 relative rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <img src="{{ asset($activity->dokumentasi) }}" alt="Dokumentasi"
                                    class="object-cover w-full h-full cursor-pointer"
                                    onclick="openImageModal(this.src)">
                            </div>
                            <!-- Comments Section -->
                            <div class="space-y-6 col-span-9">
                                <div class="space-y-0">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Perihal:
                                        {{ $activity->perihal }}</h4>
                                    <p class="text-gray-600 dark:text-gray-300">Pihak: {{ $activity->pihak_bersangkutan }}
                                    </p>
                                </div>

                                <h5 class="font-semibold text-gray-800 dark:text-gray-100">Komentar</h5>

                                <div class="">
                                    <!-- Comments List -->
                                    <div class="space-y-4">
                                        @php
                                            $comments = json_decode($activity->komentar ?? '[]', true);
                                        @endphp
                                        @foreach ($comments as $comment)
                                            <div class="flex space-x-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                                                        {{ substr($comment['user_name'], 0, 1) }}
                                                    </span>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                                        <div class="flex items-center justify-between">
                                                            <h6 class="font-semibold text-gray-800 dark:text-gray-100">
                                                                {{ $comment['user_name'] }}</h6>
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ \Carbon\Carbon::parse($comment['timestamp'])->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                        <p class="text-gray-600 dark:text-gray-300 mt-1">
                                                            {{ $comment['message'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
    
                                    <!-- Comment Form -->
                                    <form action="{{ route('admin.daily-activity.comment', $activity->id) }}"
                                        method="POST" class="mt-4">
                                        @csrf
                                        <div class="flex space-x-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <textarea name="message" rows="1"
                                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent"
                                                    placeholder="Tulis komentar..."></textarea>
                                                <div class="flex justify-end mt-2">
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300 text-sm">
                                                        Kirim
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
                <div class="col-span-full">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col items-center justify-center text-center">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Tidak ada aktivitas
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada aktivitas yang ditambahkan.</p>
                            <a href="{{ route('admin.daily-activity.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Aktivitas
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
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center"
        onclick="closeImageModal()">
        <div class="max-w-4xl w-full mx-4">
            <img id="modalImage" src="" alt="Full size image" class="w-full h-auto rounded-lg">
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
