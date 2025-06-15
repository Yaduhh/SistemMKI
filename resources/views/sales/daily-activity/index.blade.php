<x-layouts.sales :title="__('Kunjungan Harian')">
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
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Kunjungan Harian') }}</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Kelola dan pantau Kunjungan Harian Anda') }}</p>
                </div>
            </div>

            <a href="{{ route('sales.daily-activity.create') }}"
                class="inline-flex items-center justify-center bg-emerald-900 gap-2 px-4 py-2.5 text-emerald-400 hover:bg-emerald-900/90 dark:bg-emerald-900/90 dark:hover:bg-emerald-950 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
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
        <div
            class="bg-white dark:bg-zinc-900/50 rounded-xl border border-gray-200 dark:border-gray-700/50 shadow-sm backdrop-blur-sm">
            <div class="p-4 sm:p-6">
                <form action="{{ route('sales.daily-activity.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4">
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

                            <div class="flex w-full gap-2 mt-4">
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                                    class="w-full md:w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-zinc-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-zinc focus:ring-2 focus:ring-zinc/20 dark:focus:ring-zinc/30"
                                    max="{{ $endDate }}" onchange="updateEndDateMin(this.value)">
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                                    class="w-full md:w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-zinc-700/50 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-zinc focus:ring-2 focus:ring-zinc/20 dark:focus:ring-zinc/30"
                                    min="{{ $startDate }}" onchange="updateStartDateMax(this.value)">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-800 text-white hover:bg-emerald-800/90 dark:bg-emerald-800/90 dark:hover:bg-emerald-800 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('Filter') }}
                            </button>
                            <a href="{{ route('sales.daily-activity.index') }}"
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

        <!-- Activities Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @forelse ($activities as $activity)
                <div class="grid gap-6 grid-cols-1">
                    <div
                        class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-zinc-900/50 border border-emerald-800">
                        <div class="border-b border-gray-200 p-4 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @if ($activity->creator->profile)
                                        <img src="{{ asset('storage/' . $activity->creator->profile) }}"
                                            alt="{{ $activity->creator->name }}"
                                            class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div
                                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-600/50 dark:text-zinc-400 uppercase">
                                            {{ substr($activity->creator->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $activity->creator->name }}
                                            </h3>
                                        </div>
                                        <p
                                            class="mt-1 flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $activity->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if (auth()->id() === $activity->created_by)
                                <div class="flex items-center gap-2 justify-end mt-4">
                                    <a href="{{ route('sales.daily-activity.edit', $activity) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-zinc-50 px-2.5 py-1 text-xs font-medium text-zinc-600 transition-colors hover:bg-zinc-100 dark:bg-zinc-900/50 dark:text-zinc-400 dark:hover:bg-zinc-900">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('sales.daily-activity.destroy', $activity) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?')"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 transition-colors hover:bg-red-100 dark:bg-red-900/50 dark:text-red-400 dark:hover:bg-red-900">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>


                        <div class="grid grid-cols-1 gap-4 p-4">
                            <!-- Perihal -->
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 justify-center rounded-full">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Perihal Kegiatan</h4>
                                        <p class="mt-1 text-gray-600 dark:text-gray-400">
                                            {{ Str::limit($activity->perihal, 100) }}</p>
                                    </div>
                                </div>

                                <!-- Pihak Bersangkutan -->
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 justify-center rounded-full">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Pelanggan</h4>
                                        <p class="mt-1 text-gray-600 dark:text-gray-400">
                                            @if ($activity->client)
                                                {{ Str::limit($activity->client->nama, 100) }}
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">Pelanggan tidak
                                                    ditemukan</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 justify-center rounded-full">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="mb-4">
                                        <h4 class="font-medium text-gray-900 dark:text-white">Lokasi</h4>
                                        <div class="mt-1 text-gray-600 dark:text-gray-400">
                                            <div class="flex flex-col">
                                                <span class="font-mono">{{ $activity->lokasi }}</span>
                                                <span id="address-{{ $activity->id }}"
                                                    class="text-gray-400 mt-1">Loading alamat...</span>
                                            </div>
                                            <a href="https://www.google.com/maps?q={{ $activity->lokasi }}"
                                                target="_blank"
                                                class="text-blue-500 hover:underline flex items-center gap-1 mt-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                                Buka di Google Maps
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <!-- Dokumentasi -->
                                @if ($activity->dokumentasi && is_array($activity->dokumentasi))
                                    <div class="flex items-start gap-3 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-700/50">
                                        <div class="flex h-10 w-10 shrink-0 justify-center rounded-full">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Dokumentasi
                                            </h4>
                                            <div class="mt-2 flex gap-2">
                                                @foreach (array_slice($activity->dokumentasi, 0, 3) as $index => $image)
                                                    <div class="relative">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Dokumentasi"
                                                            class="h-16 w-16 rounded-lg object-cover cursor-zoom-in transition-transform duration-300 hover:scale-105"
                                                            onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                                        @if ($index === 2 && count($activity->dokumentasi) > 3)
                                                            <div
                                                                class="absolute inset-0 flex items-center justify-center rounded-lg bg-black/60 text-white font-medium">
                                                                +{{ count($activity->dokumentasi) - 3 }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Komentar -->
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 justify-center rounded-full">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div class="flex items-center justify-between flex-1">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Komentar</h4>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            {{ count(json_decode($activity->komentar ?? '[]', true)) }} komentar
                                        </p>
                                    </div>
                                    <a href="{{ route('sales.daily-activity.show', $activity) }}"
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-zinc-600 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300">
                                        Lihat detail
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="lg:col-span-3 bg-white dark:bg-zinc-900/50 rounded-xl border border-gray-200 dark:border-gray-700/50 shadow-sm backdrop-blur-sm">
                    <div class="p-8">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="rounded-full bg-emerald-800/10 dark:bg-emerald-800/20 p-3">
                                <svg class="w-6 h-6 text-zinc dark:text-zinc/90" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                                {{ __('Tidak ada aktivitas') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Belum ada aktivitas yang ditambahkan.') }}</p>
                            <a href="{{ route('sales.daily-activity.create') }}"
                                class="mt-4 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-800 text-white hover:bg-emerald-800/90 dark:bg-emerald-800/90 dark:hover:bg-emerald-800 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
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

    <!-- Modal Gambar -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="relative w-full h-full flex items-center justify-center">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300">
                <flux:icon name="x-mark" class="w-6 h-6" />
            </button>
            <img id="modalImage" src="" alt="Full size image" class="max-h-[90vh] max-w-[90vw] object-contain">
        </div>
    </div>

    @push('scripts')
    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            if (modal && modalImage) {
                modalImage.src = imageSrc;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
    @endpush

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Script jalan bos 🔥");

            const lokasiElements = document.querySelectorAll("[id^=address-]");

            lokasiElements.forEach((addressSpan) => {
                const id = addressSpan.id.split("-")[1];
                const lokasiElement = addressSpan.previousElementSibling;
                if (!lokasiElement) return;

                const lokasiText = lokasiElement.textContent.trim();
                const [latitude, longitude] = lokasiText.split(",").map(parseFloat);

                if (isNaN(latitude) || isNaN(longitude)) {
                    addressSpan.textContent = "Format lokasi tidak valid";
                    return;
                }

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`, {
                        headers: {
                            'User-Agent': 'AktivitasApp/1.0 (your@email.com)'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        addressSpan.textContent = data.display_name || "Alamat tidak ditemukan";
                    })
                    .catch(() => {
                        addressSpan.textContent = "Gagal memuat alamat";
                    });
            });
        });
    </script>
</x-layouts.sales>
