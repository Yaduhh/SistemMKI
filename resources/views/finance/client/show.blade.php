<x-layouts.finance :title="__('Detail Pelanggan')">
    @php
        function formatWhatsAppNumber($phoneNumber)
        {
            // Remove all non-numeric characters
            $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

            // If number starts with 0, replace with +62
            if (substr($cleanNumber, 0, 1) === '0') {
                return '+62' . substr($cleanNumber, 1);
            }

            // If number starts with 8, add +62
            if (substr($cleanNumber, 0, 1) === '8') {
                return '+62' . $cleanNumber;
            }

            // If number already starts with 62, add +
            if (substr($cleanNumber, 0, 2) === '62') {
                return '+' . $cleanNumber;
            }

            // Return as is if none of the above
            return $cleanNumber;
        }
    @endphp

    <div class="container mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Detail Pelanggan') }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Informasi lengkap tentang pelanggan') }}
                    </p>
                </div>
                <div class="flex items-center space-x-3 mt-4 lg:mt-0">
                    @if(Auth::id() === $client->created_by)
                    <a href="{{ route('finance.client.edit', $client) }}"
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 dark:bg-yellow-800 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-yellow-700 dark:hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        {{ __('Edit Pelanggan') }}
                    </a>
                    @endif
                    <a href="{{ route('finance.client.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Kembali ke Daftar') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Client Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Client Card -->
                <div
                    class="bg-white dark:bg-zinc-900/50 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Card Header -->
                    <div
                        class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-500 to-purple-600">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-white">{{ $client->nama }}</h2>
                                    <div class="flex items-center mt-2">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                                            @if ($client->status)
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Aktif
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Tidak Aktif
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 space-y-6">
                        <!-- Client Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                @if ($client->email)
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                {{ __('Email') }}</p>
                                            <a href="mailto:{{ $client->email }}"
                                                class="text-lg font-semibold text-blue-600 dark:text-blue-400 hover:underline">{{ $client->email }}</a>
                                        </div>
                                    </div>
                                @endif

                                <!-- Visit Count -->
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total') }}</p>
                                        <p class="text-lg font-semibold text-emerald-600 dark:text-emerald-400">{{ $client->dailyActivities()->where('deleted_status', false)->count() }} Kunjungan</p>
                                    </div>
                                </div>

                                @if ($client->notelp)
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                {{ __('Nomor Telepon') }}</p>
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="text-lg font-semibold text-gray-900 dark:text-white">{{ $client->notelp }}</span>
                                                <a href="https://wa.me/{{ formatWhatsAppNumber($client->notelp) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center px-2 py-1 bg-green-500 text-white text-xs rounded-md hover:bg-green-600 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                                    </svg>
                                                    WhatsApp
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($client->nama_perusahaan)
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                {{ __('Nama Perusahaan') }}</p>
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="text-lg font-semibold text-gray-900 dark:text-white">{{ $client->nama_perusahaan }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-gray-100 dark:bg-gray-900 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ __('Dibuat Pada') }}</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $client->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ __('Terakhir Diperbarui') }}</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $client->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                            {{ __('Dibuat Oleh') }}</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $client->creator->name ?? '-' }}</p>
                                    </div>
                                </div>

                                @if ($client->file_path)
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                                {{ __('File Lampiran') }}</p>
                                            <a href="{{ route('finance.client.download', $client) }}"
                                                class="inline-flex items-center text-lg font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                {{ __('Download File') }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Description Section -->
                        @if ($client->description)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <div class="flex items-start">
                                    <div
                                        class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                            {{ __('Daftar Proyek') }}</p>
                                        <div class="text-gray-900 dark:text-white leading-relaxed">
                                            @php
                                                $description = $client->description;
                                                if (is_string($description)) {
                                                    $decodedDescription = json_decode($description, true);
                                                    if (
                                                        json_last_error() === JSON_ERROR_NONE &&
                                                        is_array($decodedDescription)
                                                    ) {
                                                        $description = $decodedDescription;
                                                    }
                                                }

                                                if (is_array($description)) {
                                                    echo '<ul class="list-disc list-inside space-y-1">';
                                                    foreach ($description as $item) {
                                                        echo '<li>' . htmlspecialchars($item) . '</li>';
                                                    }
                                                    echo '</ul>';
                                                } else {
                                                    echo '<p>' . nl2br(htmlspecialchars($description)) . '</p>';
                                                }
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <!-- Arsip File Section -->
                <div
                    class="bg-white dark:bg-zinc-900/30 border border-zinc-600 mt-6 overflow-hidden shadow-sm rounded-xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ __('File Pelanggan') }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Daftar file arsip untuk pelanggan ini') }}</p>
                            </div>
                        </div>

                        @php
                            $arsipFiles = $client
                                ->arsipFiles()
                                ->where('status_deleted', false)
                                ->orderBy('created_at', 'desc')
                                ->get();
                        @endphp

                        @if ($arsipFiles->count() > 0)
                            <div class="space-y-3">
                                @foreach ($arsipFiles as $arsip)
                                    <div
                                        class="flex flex-col md:flex-row items-end lg:items-center justify-between p-4 bg-gray-50 dark:bg-zinc-800 rounded-xl">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $extension = pathinfo($arsip->file, PATHINFO_EXTENSION);
                                                    $iconClass = match (strtolower($extension)) {
                                                        'pdf' => 'text-red-500',
                                                        'doc', 'docx' => 'text-blue-500',
                                                        'jpg', 'jpeg', 'png' => 'text-green-500',
                                                        'zip', 'rar' => 'text-purple-500',
                                                        default => 'text-gray-500',
                                                    };
                                                @endphp
                                                <svg class="w-8 h-8 {{ $iconClass }}" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $arsip->nama }}</h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ __('Dibuat oleh') }} {{ $arsip->creator->name ?? 'Unknown' }} •
                                                    {{ $arsip->created_at->diffForHumans() }} •
                                                    {{ strtoupper($extension) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2 max-sm:mt-4">
                                            <a href="{{ Storage::url($arsip->file) }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                {{ __('Download') }}
                                            </a>
                                            <form action="{{ route('finance.arsip-file.destroy', $arsip->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus file ini?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ __('Belum ada file') }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Mulai dengan menambahkan file arsip pertama untuk client ini.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div
                    class="bg-white dark:bg-zinc-900/50 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Aksi Cepat') }}</h3>
                    <div class="space-y-3">
                        @if ($client->notelp)
                            <a href="https://wa.me/{{ formatWhatsAppNumber($client->notelp) }}" target="_blank"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                </svg>
                                {{ __('Chat WhatsApp') }}
                            </a>
                        @endif

                        @if ($client->email)
                            <a href="mailto:{{ $client->email }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ __('Kirim Email') }}
                            </a>
                        @endif

                        @if ($client->file_path)
                            <a href="{{ route('finance.client.download', $client) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                {{ __('Download File') }}
                            </a>
                        @endif

                        <!-- Tombol Arsip File -->
                        <flux:modal.trigger name="arsip-file-modal">
                            <button type="button"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'arsip-file-modal')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                {{ __('Tambah File') }}
                            </button>
                        </flux:modal.trigger>
                    </div>
                </div>

                <!-- Client Statistics -->
                <div
                    class="bg-white dark:bg-zinc-900/50 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ __('Statistik Pelanggan') }}</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Status') }}</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $client->status ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $client->status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Terakhir Update') }}</span>
                            <span
                                class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Activities Section -->
        <div class="mt-6">
            <div class="bg-white dark:bg-zinc-900/30 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Kunjungan</h3>
                </div>
                <div class="p-6">
                    @php
                        $activities = $client->dailyActivities()->where('deleted_status', false)->latest()->get();
                    @endphp

                    @if($activities->count() > 0)
                        <div class="space-y-4">
                            @foreach($activities as $activity)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-zinc-700/50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $activity->perihal }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $activity->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('finance.daily-activity.show', $activity->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        Lihat Detail
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada kunjungan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Client ini belum memiliki riwayat kunjungan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Arsip File -->
    <flux:modal name="arsip-file-modal" class="w-full max-w-2xl">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah Arsip </flux:heading>
                <flux:subheading>Tambahkan file arsip untuk client ini</flux:subheading>
            </div>

            <form action="{{ route('finance.arsip-file.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <input type="hidden" name="id_client" value="{{ $client->id }}">

                <flux:field>
                    <flux:label>Nama Arsip</flux:label>
                    <flux:input name="nama" placeholder="Masukkan nama arsip" required />
                </flux:field>

                <flux:field>
                    <flux:label>File</flux:label>
                    <flux:input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar"
                        required />
                </flux:field>

                <div class="flex space-x-2 justify-end">
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Simpan Arsip</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
</x-layouts.finance>
