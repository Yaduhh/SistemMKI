<x-layouts.supervisi title="Daftar RAB">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar RAB') }}
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                RAB yang ditugaskan kepada Anda
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full">
            <!-- RAB List -->
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-zinc-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">RAB yang Ditugaskan</h3>
                </div>
                
                @if($rabs->count() > 0)
                    <div class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @foreach($rabs as $rab)
                            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors duration-200">
                                <div class="flex flex-col lg:flex-row items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                                                <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                                    {{ strtoupper(substr($rab->proyek, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $rab->proyek }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $rab->pekerjaan }} • {{ $rab->lokasi }}
                                            </p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                                Dibuat oleh: {{ $rab->user->name ?? 'Unknown' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center gap-2 max-sm:mt-4">
                                            @php
                                                $statusColors = [
                                                    'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                ];
                                                $statusText = [
                                                    'draft' => 'Draft',
                                                    'approved' => 'Disetujui',
                                                    'rejected' => 'Ditolak',
                                                ];
                                                $color = $statusColors[$rab->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                                $text = $statusText[$rab->status] ?? $rab->status;
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                                {{ $text }}
                                            </span>
                                            <a href="{{ route('supervisi.rab.show', $rab) }}" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-500 dark:hover:text-amber-300">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-zinc-700 border-t border-gray-200 dark:border-zinc-700">
                        {{ $rabs->links() }}
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada RAB</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">RAB yang ditugaskan akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.supervisi>
