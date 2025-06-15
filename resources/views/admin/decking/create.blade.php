<x-layouts.app :title="__('Add New Decking')">
    <div class="h-auto bg-gray-50 dark:bg-zinc-900 transition-colors duration-300">
        <!-- Header Section -->
        <div class="bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700 mb-6">
            <div class="w-full lg:pb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Decking Baru</h1>
                            <p class="text-gray-600 dark:text-gray-400">Buat produk decking baru dengan detail lengkap</p>
                        </div>
                    </div>
                    <div class="flex justify-end max-sm:my-4 items-center space-x-4">
                        <!-- Dark Mode Toggle -->
                        <button id="theme-toggle" 
                            class="p-2 bg-gray-100 dark:bg-zinc-700 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-zinc-600 transition-colors duration-200"
                            title="Toggle Dark/Light Mode">
                            <!-- Sun Icon (Light Mode) -->
                            <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                            <!-- Moon Icon (Dark Mode) -->
                            <svg id="theme-toggle-dark-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </button>
                        <a href="{{ route('admin.decking.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-zinc-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-zinc-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    
    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

        <div class="w-full">
            <div class="w-full mx-auto">
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm">
                    <div class="px-6">
                        <form action="{{ route('admin.decking.store') }}" method="POST" x-data="deckingCalculator()" x-init="calculateLuas()">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Code</label>
                                    <input id="code" name="code" type="text" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" 
                                           value="{{ old('code') }}" required autofocus>
                                    @error('code')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="lebar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lebar</label>
                                    <input id="lebar" name="lebar" type="number" step="0.01" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" 
                                           value="{{ old('lebar') }}" x-model="lebar" @input="calculateLuas()" required>
                                    @error('lebar')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tebal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tebal</label>
                                    <input id="tebal" name="tebal" type="number" step="0.01" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" 
                                           value="{{ old('tebal') }}" required>
                                    @error('tebal')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="satuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satuan</label>
                                    <input id="satuan" name="satuan" type="text" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-gray-100 dark:bg-zinc-700 text-gray-900 dark:text-white" 
                                           value="mm" readonly>
                                </div>

                                <div>
                                    <label for="panjang" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Panjang (Cm)</label>
                                    <input id="panjang" name="panjang" type="number" step="0.01" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors duration-200" 
                                           value="{{ old('panjang') }}" x-model="panjang" @input="calculateLuas()" required>
                                    @error('panjang')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="luas_btg" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Luas/btg</label>
                                    <input id="luas_btg" name="luas_btg" type="number" step="0.01" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-gray-100 dark:bg-zinc-700 text-gray-900 dark:text-white" 
                                           value="{{ old('luas_btg') }}" x-model="luas_btg" readonly oninput="this.value = parseFloat(this.value).toFixed(2)">
                                    @error('luas_btg')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="luas_m2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Area (m²)</label>
                                    <input id="luas_m2" name="luas_m2" type="number" step="0.01" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-lg bg-gray-100 dark:bg-zinc-700 text-gray-900 dark:text-white" 
                                           value="{{ old('luas_m2') }}" x-model="luas_m2" readonly>
                                    @error('luas_m2')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <div class="flex items-center">
                                        <input id="is_accessory" name="is_accessory" type="checkbox" 
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800" 
                                               value="1" {{ old('is_accessory') ? 'checked' : '' }}>
                                        <label for="is_accessory" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            Is Accessory
                                        </label>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-500 dark:text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                                    Perhitungan Otomatis
                                                </h3>
                                                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                                    <p>Luas/btg akan dihitung otomatis berdasarkan nilai Lebar dan Panjang.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6 py-6 border-t border-gray-200 dark:border-zinc-700">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Decking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Dark Mode Toggle Script -->
    <script>
        // Check for saved theme preference or default to 'light' mode
        const theme = localStorage.getItem('theme') || 'light';
        
        // Apply theme on page load
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
            document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            document.getElementById('theme-toggle-light-icon').classList.add('hidden');
            document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
        }
        
        // Theme toggle functionality
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const isDark = document.documentElement.classList.contains('dark');
            
            if (isDark) {
                // Switch to light mode
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                document.getElementById('theme-toggle-light-icon').classList.add('hidden');
                document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            } else {
                // Switch to dark mode
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
                document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
            }
        });
        
        // Alpine.js calculator function
        function deckingCalculator() {
            return {
                lebar: {{ old('lebar', 0) }},
                panjang: {{ old('panjang', 0) }},
                luas_btg: {{ old('luas_btg', 0) }},
                luas_m2: {{ old('luas_m2', 0) }},
                
                calculateLuas() {
                    if (this.lebar > 0 && this.panjang > 0) {
                        // Calculate luas_btg: (lebar in mm / 1000) * (panjang in cm / 100)
                        this.luas_btg = parseFloat(((this.lebar / 1000) * (this.panjang / 100)).toFixed(2));
                        
                        // Calculate luas_m2: 1 / luas_btg (how many pieces per m²)
                        this.luas_m2 = this.luas_btg > 0 ? parseFloat((1 / this.luas_btg).toFixed(2)) : 0;
                    } else {
                        this.luas_btg = 0;
                        this.luas_m2 = 0;
                    }
                }
            }
        }
    </script>
    @endpush
</x-layouts.app>