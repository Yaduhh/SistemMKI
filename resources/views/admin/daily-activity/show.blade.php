<x-layouts.app>
    <div class="container mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Detail Kunjungan {{ $dailyActivity->creator->name }}</h1>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Informasi Kunjungan</p>
                </div>
                <a href="{{ route('admin.daily-activity.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-zinc-100 px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-200 dark:bg-zinc-600 dark:text-zinc-200 dark:hover:bg-zinc-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <div class="mb-8 overflow-hidden rounded-xl">
            <div class="border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        @if($dailyActivity->creator->profile)
                            <img src="{{ asset('storage/' . $dailyActivity->creator->profile) }}"
                                 alt="{{ $dailyActivity->creator->name }}"
                                 class="h-12 w-12 rounded-full object-cover">
                        @else
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-900/50 dark:text-zinc-400">
                                {{ substr($dailyActivity->creator->name, 0, 2) }}
                            </div>
                        @endif
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                    {{ $dailyActivity->creator->name }}
                                </h2>
                            </div>
                            <p class="mt-1 flex items-center gap-1.5 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $dailyActivity->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end my-4 gap-2">
                    <a href="{{ route('admin.daily-activity.edit', $dailyActivity) }}"
                       class="inline-flex items-center gap-1.5 rounded-lg bg-zinc-50 px-3 py-1.5 text-sm font-medium text-zinc-600 transition-colors hover:bg-zinc-100 dark:bg-zinc-900/50 dark:text-zinc-400 dark:hover:bg-zinc-900">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.daily-activity.destroy', $dailyActivity) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?')"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-100 dark:bg-red-900/50 dark:text-red-400 dark:hover:bg-red-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="pt-4">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <h3 class="flex items-center gap-2 text-lg font-semibold text-zinc-900 dark:text-white">
                            <svg class="h-5 w-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Tujuan Kunjungan
                        </h3>
                        <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-700/50">
                            <p class="text-zinc-700 dark:text-zinc-300">{{ $dailyActivity->perihal }}</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h3 class="flex items-center gap-2 text-lg font-semibold text-zinc-900 dark:text-white">
                            <svg class="h-5 w-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Pelanggan
                        </h3>
                        <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-700/50">
                            <p class="text-zinc-700 dark:text-zinc-300">{{ $dailyActivity->client ? $dailyActivity->client->nama : 'Client tidak ditemukan' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h3 class="flex items-center gap-2 text-lg font-semibold text-zinc-900 dark:text-white">
                            <svg class="h-5 w-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Pembahasan
                        </h3>
                        <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-700/50 text-justify">
                            <p class="text-zinc-700 dark:text-zinc-300">{{ $dailyActivity->summary }}</p>
                        </div>
                    </div>

                    @if($dailyActivity->lokasi)
                    <div class="space-y-2">
                        <h3 class="flex items-center gap-2 text-lg font-semibold text-zinc-900 dark:text-white">
                            <svg class="h-5 w-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lokasi
                        </h3>
                        <div class="rounded-lg bg-zinc-50 p-4 dark:bg-zinc-700/50">
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-900 dark:text-white">Lokasi</h4>
                                <div class="mt-1 text-gray-600 dark:text-gray-400">
                                    <div class="flex flex-col">
                                        <span class="font-mono">{{ $dailyActivity->lokasi }}</span>
                                        <span id="address-{{ $dailyActivity->id }}" class="text-gray-400 mt-1">Loading alamat...</span>
                                    </div>
                                    <a href="https://www.google.com/maps?q={{ $dailyActivity->lokasi }}" target="_blank" class="text-zinc-500 hover:underline flex items-center gap-1 mt-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        Buka di Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($dailyActivity->dokumentasi && is_array($dailyActivity->dokumentasi))
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                            @foreach($dailyActivity->dokumentasi as $index => $img)
                                <div class="relative group">
                                    <a href="{{ asset('storage/' . $img) }}" 
                                       data-lightbox="dokumentasi" 
                                       data-title="Dokumentasi {{ $index + 1 }}"
                                       class="block">
                                        <img src="{{ asset('storage/' . $img) }}" 
                                             alt="Dokumentasi" 
                                             class="w-full aspect-video object-cover rounded-lg transition-transform duration-300 hover:scale-105">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m4-3H6"/>
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Komentar Section -->
        <div class="mt-8">
            @php
                $comments = json_decode($dailyActivity->komentar ?? '[]', true) ?? [];
            @endphp

            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Komentar</h3>
                @if(count($comments) > 0)
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">({{ count($comments) }})</span>
                @endif
            </div>
            
            @if(empty($comments))
                <div class="flex flex-col items-center justify-center py-12 px-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h4 class="text-base font-medium text-zinc-900 dark:text-zinc-100 mb-1">Belum ada komentar</h4>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center max-w-sm">Jadilah yang pertama untuk memberikan komentar pada aktivitas ini</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($comments as $comment)
                        @php
                            $user = \App\Models\User::find($comment['user_id']);
                            $timestamp = \Carbon\Carbon::parse($comment['timestamp']);
                        @endphp
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                @if($user && $user->profile)
                                    <img src="{{ asset('storage/' . $user->profile) }}" 
                                        alt="{{ $user->name }}" 
                                        class="h-8 w-8 rounded-full object-cover">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-300">
                                            {{ strtoupper(substr($comment['user_name'], 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 border-b border-zinc-200 dark:border-zinc-700 pb-2">
                                <div class="flex justify-between items-baseline gap-2">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $comment['user_name'] }}
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $timestamp->format('d M Y H:i') }}
                                    </p>
                                </div>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $comment['message'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Form Komentar -->
            <div class="mt-6">
                <form action="{{ route('admin.daily-activity.comment', $dailyActivity) }}" method="POST">
                    @csrf
                    <div class="flex flex-col gap-3">
                        <div class="flex-1">
                            <flux:textarea
                                name="message"
                                id="message"
                                placeholder="Tulis komentar..."
                                rows="3"
                                :has-error="$errors->has('message')"
                                class="resize-none"
                            >{{ old('message') }}</flux:textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex-shrink-0 flex justify-end mt-4">
                            <flux:button type="submit" variant="primary" class="h-full">
                                <div class="flex items-center gap-2 py-3 px-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    {{ __('Kirim') }}
                                </div>
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-white" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm" onclick="closeImageModal()"></div>

        <div class="relative h-full flex items-center bg-red-400 justify-center">
            <button type="button"
                    onclick="closeImageModal()"
                    class="absolute top-4 right-4 z-10 rounded-full bg-white/10 p-2 text-white backdrop-blur-sm transition-colors hover:bg-white/20">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <button type="button"
                    onclick="toggleFullscreen()"
                    class="absolute top-4 right-20 z-10 rounded-full bg-white/10 p-2 text-white backdrop-blur-sm transition-colors hover:bg-white/20">
                <svg id="fullscreenIcon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                </svg>
            </button>

            <button type="button"
                    onclick="navigateImage('prev')"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition-colors hover:bg-white/20">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <button type="button"
                    onclick="navigateImage('next')"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition-colors hover:bg-white/20">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <div class="relative -z-20 max-w-7xl mx-auto px-4" onclick="event.stopPropagation()">
                <img id="modalImage" src="" alt="Dokumentasi" class="max-h-[90vh] w-auto object-contain">
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <script>
        let currentImageIndex = 0;
        let imageArray = [];

        function openImageModal(imageUrl, index, images) {
            currentImageIndex = index;
            imageArray = images;
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            // imageUrl sudah lengkap, tidak perlu penambahan 'storage/' lagi
            modalImage.src = imageUrl;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            if (document.fullscreenElement) {
                document.exitFullscreen();
            }
        }

        function navigateImage(direction) {
            if (direction === 'next') {
                currentImageIndex = (currentImageIndex + 1) % imageArray.length;
            } else {
                currentImageIndex = (currentImageIndex - 1 + imageArray.length) % imageArray.length;
            }
            const modalImage = document.getElementById('modalImage');
            // Cukup gunakan imageArray[currentImageIndex] karena sudah berisi path yang lengkap
            modalImage.src = '{{ asset('') }}' + imageArray[currentImageIndex];
        }

        function toggleFullscreen() {
            const modal = document.getElementById('imageModal');
            const fullscreenIcon = document.getElementById('fullscreenIcon');

            if (!document.fullscreenElement) {
                modal.requestFullscreen().catch(err => {
                    console.log(`Error attempting to enable fullscreen: ${err.message}`);
                });
                fullscreenIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M5 20h14a2 2 0 002-2v-4M5 20v-4m0 0l5-5m-5 5l5 5"/>
                `;
            } else {
                document.exitFullscreen();
                fullscreenIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                `;
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            } else if (event.key === 'ArrowLeft') {
                navigateImage('prev');
            } else if (event.key === 'ArrowRight') {
                navigateImage('next');
            }
        });

        // Update fullscreen icon when fullscreen state changes
        document.addEventListener('fullscreenchange', function() {
            const fullscreenIcon = document.getElementById('fullscreenIcon');
            if (!document.fullscreenElement) {
                fullscreenIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                `;
            }
        });

        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'fadeDuration': 200,
            'imageFadeDuration': 200,
            'positionFromTop': 100,
            'maxWidth': 1200,
            'maxHeight': 800,
            'disableScrolling': true,
            'albumLabel': 'Gambar %1 dari %2',
            'alwaysShowNavOnTouchDevices': true,
            'showImageNumberLabel': true,
            'fitImagesInViewport': true
        });
    </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
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
    @endpush
</x-layouts.app>
