<x-layouts.app :title="__('Edit Absensi')">
    <div class="flex flex-col gap-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-xl bg-emerald-800/10 text-emerald-800 dark:bg-emerald-800/20 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('Edit Absensi') }}</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Ubah status absensi pengguna') }}</p>
                </div>
            </div>

            <a href="{{ route('admin.absensi.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-zinc-100 text-gray-700 hover:bg-zinc-200 dark:bg-zinc-700/50 dark:text-gray-200 dark:hover:bg-zinc-700 rounded-lg transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Kembali') }}
            </a>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Edit Form -->
        <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-zinc-700/30 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Informasi Absensi') }}</h2>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Info -->
                        <div class="space-y-5 bg-gray-50 dark:bg-zinc-700/20 p-5 rounded-lg">
                            <h3 class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">{{ __('Detail Pengguna') }}</h3>
                            
                            <div class="flex items-center gap-4">
                                @if ($absensi->user->profile)
                                    <img src="{{ asset('storage/' . $absensi->user->profile) }}"
                                        alt="{{ $absensi->user->name }}"
                                        class="h-14 w-14 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-sm">
                                @else
                                    <div
                                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-md font-medium text-emerald-600 dark:bg-emerald-700/30 dark:text-emerald-400 uppercase border-2 border-white dark:border-gray-700 shadow-sm">
                                        {{ substr($absensi->user->name, 0, 2) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $absensi->user->name }}</h4>
                                    @if($absensi->user->email)
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $absensi->user->email }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Tanggal Absensi') }}</label>
                                </div>
                                <div class="ml-7">
                                    <span class="text-gray-900 dark:text-white font-medium">{{ $absensi->tgl_absen->format('d F Y') }}</span>
                                </div>
                            </div>

                            @if ($absensi->dailyActivity)
                                <div class="mt-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Aktivitas Harian') }}</label>
                                    </div>
                                    <div class="ml-7">
                                        <a href="{{ route('admin.daily-activity.show', $absensi->dailyActivity->id) }}" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-300 flex items-center gap-1">
                                            <span>{{ $absensi->dailyActivity->perihal }}</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Status Absensi -->
                        <div class="space-y-5 bg-gray-50 dark:bg-zinc-700/20 p-5 rounded-lg">
                            <h3 class="text-md font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">{{ __('Status Kehadiran') }}</h3>
                            
                            <div>
                                <label for="status_absen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Pilih Status Absensi') }}</label>
                                
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="status-radio relative flex cursor-pointer rounded-lg border bg-white dark:bg-zinc-800 p-4 shadow-sm focus:outline-none {{ $absensi->status_absen == 1 ? 'border-emerald-500 ring-2 ring-emerald-500' : 'border-gray-300 dark:border-gray-600 dark:bg-zinc-700/50' }}">
                                        <input type="radio" name="status_absen" value="1" class="sr-only status-input" {{ $absensi->status_absen == 1 ? 'checked' : '' }}>
                                        <span class="flex flex-1 items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Hadir</span>
                                        </span>
                                    </label>
                                    
                                    <label class="status-radio relative flex cursor-pointer rounded-lg border bg-white dark:bg-zinc-800 p-4 shadow-sm focus:outline-none {{ $absensi->status_absen == 2 ? 'border-emerald-500 ring-2 ring-emerald-500' : 'border-gray-300 dark:border-gray-600 dark:bg-zinc-700/50' }}">
                                        <input type="radio" name="status_absen" value="2" class="sr-only status-input" {{ $absensi->status_absen == 2 ? 'checked' : '' }}>
                                        <span class="flex flex-1 items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Izin</span>
                                        </span>
                                    </label>
                                    
                                    <label class="status-radio relative flex cursor-pointer rounded-lg border bg-white dark:bg-zinc-800 p-4 shadow-sm focus:outline-none {{ $absensi->status_absen == 3 ? 'border-emerald-500 ring-2 ring-emerald-500' : 'border-gray-300 dark:border-gray-600 dark:bg-zinc-700/50' }}">
                                        <input type="radio" name="status_absen" value="3" class="sr-only status-input" {{ $absensi->status_absen == 3 ? 'checked' : '' }}>
                                        <span class="flex flex-1 items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Sakit</span>
                                        </span>
                                    </label>
                                    
                                    <label class="status-radio relative flex cursor-pointer rounded-lg border bg-white dark:bg-zinc-800 p-4 shadow-sm focus:outline-none {{ $absensi->status_absen == 0 ? 'border-emerald-500 ring-2 ring-emerald-500' : 'border-gray-300 dark:border-gray-600 dark:bg-zinc-700/50' }}">
                                        <input type="radio" name="status_absen" value="0" class="sr-only status-input" {{ $absensi->status_absen == 0 ? 'checked' : '' }}>
                                        <span class="flex flex-1 items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Alpha</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit"
                            class="inline-flex items-center hover:cursor-pointer justify-center gap-2 px-5 py-2.5 bg-emerald-800 text-white hover:bg-emerald-800/90 dark:bg-emerald-800/90 dark:hover:bg-emerald-800 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Simpan Perubahan') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk menangani perubahan status radio button -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dapatkan semua radio button
            const radioInputs = document.querySelectorAll('.status-input');
            
            // Tambahkan event listener untuk setiap radio button
            radioInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Hapus class styling dari semua label
                    document.querySelectorAll('.status-radio').forEach(label => {
                        label.classList.remove('border-emerald-500', 'ring-2', 'ring-emerald-500');
                        label.classList.add('border-gray-300', 'dark:border-gray-600');
                    });
                    
                    // Tambahkan class styling ke label yang dipilih
                    if (this.checked) {
                        this.closest('.status-radio').classList.remove('border-gray-300', 'dark:border-gray-600');
                        this.closest('.status-radio').classList.add('border-emerald-500', 'ring-2', 'ring-emerald-500');
                    }
                });
            });
        });
    </script>
</x-layouts.app>