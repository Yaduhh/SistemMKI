<x-layouts.app :title="__('Edit Event')">
    <div class="container mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Event') }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Perbarui informasi event') }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.events.show', $event) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ __('Lihat Detail') }}
                    </a>
                    <a href="{{ route('admin.events.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Kembali ke Daftar') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        <!-- Form Section -->
        <div class="bg-white dark:bg-zinc-900/50 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.events.update', $event) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Informasi Dasar') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <flux:input 
                                name="nama_event" 
                                :label="__('Nama Event')" 
                                type="text" 
                                :placeholder="__('Masukkan nama event')"
                                :value="old('nama_event', $event->nama_event)"
                                :error="$errors->first('nama_event')"
                                required
                            />
                        </div>

                        <div>
                            <flux:input 
                                name="jadwal" 
                                :label="__('Jadwal Event')" 
                                type="datetime-local" 
                                :value="old('jadwal', $event->jadwal->format('Y-m-d\TH:i'))"
                                :error="$errors->first('jadwal')"
                                required
                            />
                        </div>

                        <div>
                            <flux:select 
                                name="status" 
                                :label="__('Status Event')"
                                :value="old('status', $event->status)"
                                :error="$errors->first('status')"
                            >
                                <option value="active" {{ $event->status === 'active' ? 'selected' : '' }}>{{ __('Aktif') }}</option>
                                <option value="cancelled" {{ $event->status === 'cancelled' ? 'selected' : '' }}>{{ __('Dibatalkan') }}</option>
                                <option value="completed" {{ $event->status === 'completed' ? 'selected' : '' }}>{{ __('Selesai') }}</option>
                            </flux:select>
                        </div>
                    </div>
                </div>

                <!-- Meeting Details -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ __('Lokasi & Detail Event') }}
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <flux:input 
                                name="location" 
                                :label="__('Lokasi/Link Meeting')" 
                                type="text" 
                                :placeholder="__('Contoh: Ruang Meeting Lt. 2, https://zoom.us/j/..., atau lokasi lainnya')"
                                :value="old('location', $event->location)"
                                :error="$errors->first('location')"
                            />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Masukkan lokasi event (kantor, ruang meeting) atau link meeting online (Zoom, Google Meet, dll)') }}
                            </p>
                        </div>

                        <div>
                            <flux:textarea 
                                name="deskripsi" 
                                :label="__('Deskripsi Event')" 
                                :placeholder="__('Masukkan deskripsi detail tentang event ini')"
                                :error="$errors->first('deskripsi')"
                                rows="4"
                            >{{ old('deskripsi', $event->deskripsi) }}</flux:textarea>
                        </div>
                    </div>
                </div>

                <!-- Participants -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        {{ __('Peserta Event') }}
                    </h3>

                    <div class="space-y-4">
                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <button type="button" id="selectAllBtn"
                                    class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('Pilih Semua') }}
                                </button>
                                <button type="button" id="deselectAllBtn"
                                    class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ __('Hapus Semua') }}
                                </button>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span id="selectedCount">0</span> {{ __('peserta dipilih') }}
                            </div>
                        </div>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="peserta" id="pesertaInput" value="{{ json_encode(old('peserta', $event->peserta)) }}" />

                        <!-- Error message -->
                        @if($errors->first('peserta'))
                            <div class="text-red-600 text-sm">{{ $errors->first('peserta') }}</div>
                        @endif

                        <!-- Participants Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            @foreach($users as $user)
                                <div class="participant-card bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 cursor-pointer transition-all duration-200 hover:shadow-md hover:border-purple-300 dark:hover:border-purple-600"
                                     data-user-id="{{ $user->id }}">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full transition-colors duration-200 participant-checkbox">
                                                <svg class="w-full h-full text-white hidden" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Klik pada kartu peserta untuk memilih atau menghapus pilihan') }}
                        </p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="{{ route('admin.events.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('Batal') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 dark:bg-emerald-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-emerald-700 dark:hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('Update Event') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const participantCards = document.querySelectorAll('.participant-card');
            const checkboxes = document.querySelectorAll('.participant-checkbox');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const deselectAllBtn = document.getElementById('deselectAllBtn');
            const selectedCountSpan = document.getElementById('selectedCount');
            const pesertaInput = document.getElementById('pesertaInput');
            
            let selectedParticipants = JSON.parse(pesertaInput.value || '[]');

            // Initialize selected participants from old input
            selectedParticipants.forEach(userId => {
                const card = document.querySelector(`[data-user-id="${userId}"]`);
                if (card) {
                    const checkbox = card.querySelector('.participant-checkbox');
                    checkbox.classList.add('bg-purple-600', 'border-purple-600');
                    checkbox.querySelector('svg').classList.remove('hidden');
                    card.classList.add('ring-2', 'ring-purple-500', 'ring-opacity-50');
                }
            });

            updateSelectedCount();

            // Participant card click handler
            participantCards.forEach(card => {
                card.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    const checkbox = this.querySelector('.participant-checkbox');
                    const isSelected = checkbox.classList.contains('bg-purple-600');

                    if (isSelected) {
                        // Deselect
                        checkbox.classList.remove('bg-purple-600', 'border-purple-600');
                        checkbox.classList.add('border-gray-300', 'dark:border-gray-600');
                        checkbox.querySelector('svg').classList.add('hidden');
                        this.classList.remove('ring-2', 'ring-purple-500', 'ring-opacity-50');
                        selectedParticipants = selectedParticipants.filter(id => id != userId);
                    } else {
                        // Select
                        checkbox.classList.add('bg-purple-600', 'border-purple-600');
                        checkbox.classList.remove('border-gray-300', 'dark:border-gray-600');
                        checkbox.querySelector('svg').classList.remove('hidden');
                        this.classList.add('ring-2', 'ring-purple-500', 'ring-opacity-50');
                        selectedParticipants.push(userId);
                    }

                    pesertaInput.value = JSON.stringify(selectedParticipants);
                    updateSelectedCount();
                });
            });

            // Select all button
            selectAllBtn.addEventListener('click', function() {
                participantCards.forEach(card => {
                    const userId = card.dataset.userId;
                    const checkbox = card.querySelector('.participant-checkbox');
                    
                    if (!checkbox.classList.contains('bg-purple-600')) {
                        checkbox.classList.add('bg-purple-600', 'border-purple-600');
                        checkbox.classList.remove('border-gray-300', 'dark:border-gray-600');
                        checkbox.querySelector('svg').classList.remove('hidden');
                        card.classList.add('ring-2', 'ring-purple-500', 'ring-opacity-50');
                        
                        if (!selectedParticipants.includes(userId)) {
                            selectedParticipants.push(userId);
                        }
                    }
                });
                
                pesertaInput.value = JSON.stringify(selectedParticipants);
                updateSelectedCount();
            });

            // Deselect all button
            deselectAllBtn.addEventListener('click', function() {
                participantCards.forEach(card => {
                    const userId = card.dataset.userId;
                    const checkbox = card.querySelector('.participant-checkbox');
                    
                    checkbox.classList.remove('bg-purple-600', 'border-purple-600');
                    checkbox.classList.add('border-gray-300', 'dark:border-gray-600');
                    checkbox.querySelector('svg').classList.add('hidden');
                    card.classList.remove('ring-2', 'ring-purple-500', 'ring-opacity-50');
                });
                
                selectedParticipants = [];
                pesertaInput.value = JSON.stringify(selectedParticipants);
                updateSelectedCount();
            });

            function updateSelectedCount() {
                selectedCountSpan.textContent = selectedParticipants.length;
            }
        });
    </script>
</x-layouts.app> 