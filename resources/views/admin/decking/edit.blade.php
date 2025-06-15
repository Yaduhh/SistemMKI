<x-layouts.app>
    <div class="w-full h-auto">
        <!-- Header Section -->
        <div class=" border-b border-gray-200 dark:border-zinc-700">
            <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center pb-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Decking</h1>
                            <p class="text-sm text-gray-600 dark:text-zinc-400">Perbarui informasi decking yang sudah ada</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <!-- Back Button -->
                        <a href="{{ route('admin.decking.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 rounded-lg text-sm font-medium text-gray-700 dark:text-zinc-300 hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
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


        <!-- Main Content -->
        <div class="w-full">
            <div class="w-full mx-auto">
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-sm border border-gray-200 dark:border-zinc-700">
                    <div class="p-6">
                        <form action="{{ route('admin.decking.update', $decking) }}" method="POST" class="space-y-6" x-data="deckingCalculator({{ old('lebar', $decking->lebar) }}, {{ old('panjang', $decking->panjang) }}, {{ old('luas_btg', $decking->luas_btg) }}, {{ old('luas_m2', $decking->luas_m2) }})" x-init="calculateLuas()">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Code -->
                                <div class="md:col-span-2">
                                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Code</label>
                                    <input type="text" name="code" id="code" value="{{ old('code', $decking->code) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           placeholder="Masukkan kode decking" required>
                                    @error('code')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Lebar -->
                                <div>
                                    <label for="lebar" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Lebar (mm)</label>
                                    <input type="number" step="0.01" name="lebar" id="lebar" x-model="lebar" @input="calculateLuas()" value="{{ old('lebar', $decking->lebar) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           placeholder="Masukkan lebar dalam mm" required>
                                    @error('lebar')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tebal -->
                                <div>
                                    <label for="tebal" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Tebal (mm)</label>
                                    <input type="number" step="0.01" name="tebal" id="tebal" value="{{ old('tebal', $decking->tebal) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           placeholder="Masukkan tebal dalam mm" required>
                                    @error('tebal')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Satuan -->
                                <div>
                                    <label for="satuan" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Satuan</label>
                                    <select name="satuan" id="satuan" disabled 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm bg-gray-100 dark:bg-zinc-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="mm" selected>mm</option>
                                    </select>
                                    <input type="hidden" name="satuan" value="mm">
                                </div>

                                <!-- Panjang -->
                                <div>
                                    <label for="panjang" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Panjang (Cm)</label>
                                    <input type="number" step="0.01" name="panjang" id="panjang" x-model="panjang" @input="calculateLuas()" value="{{ old('panjang', $decking->panjang) }}" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                           placeholder="Masukkan panjang dalam cm" required>
                                    @error('panjang')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Luas/btg -->
                                 <div>
                                     <label for="luas_btg" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Luas/btg</label>
                                     <input type="number" step="0.01" name="luas_btg" id="luas_btg" x-model="luas_btg" value="{{ old('luas_btg', $decking->luas_btg) }}" 
                                             class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm bg-white dark:bg-zinc-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                             placeholder="Luas per batang" required oninput="this.value = parseFloat(this.value).toFixed(2)">
                                     @error('luas_btg')
                                         <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                     @enderror
                                 </div>

                                 <!-- Area (m²) -->
                                 <div>
                                     <label for="luas_m2" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-2">Area (m²)</label>
                                     <input type="number" step="0.01" name="luas_m2" id="luas_m2" x-model="luas_m2" value="{{ old('luas_m2', $decking->luas_m2) }}" readonly 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm bg-gray-100 dark:bg-zinc-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="Area dalam m²">
                                     @error('luas_m2')
                                         <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                     @enderror
                                 </div>

                                 <!-- Is Accessory -->
                                 <div class="md:col-span-2">
                                     <div class="flex items-center">
                                         <input type="checkbox" name="status_aksesoris" id="status_aksesoris" value="1" {{ old('status_aksesoris', $decking->status_aksesoris) ? 'checked' : '' }} 
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-zinc-600 rounded dark:bg-zinc-700">
                                         <label for="status_aksesoris" class="ml-2 block text-sm text-gray-700 dark:text-zinc-300">
                                             Is Accessory
                                         </label>
                                     </div>
                                 </div>
                            </div>

                            <!-- Warning Box -->
                            <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Peringatan!</h3>
                                        <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">Area Luas/btg dihitung secara otomatis dengan rumus: (Lebar/1000) * (Panjang/100)</p>
                                        <p class="text-sm text-yellow-700 dark:text-yellow-300">Pastikan nilai lebar dan panjang sudah benar sebelum menyimpan data.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-end pt-6">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 border border-transparent rounded-lg font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Update Decking
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
        function deckingCalculator(initialLebar = 0, initialPanjang = 0, initialLuasBtg = 0, initialLuasM2 = 0) {
            return {
                lebar: initialLebar,
                panjang: initialPanjang,
                luas_btg: initialLuasBtg,
                luas_m2: initialLuasM2,
                
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
