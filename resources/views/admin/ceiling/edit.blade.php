<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Ceiling') }}
            </h2>
            <x-button href="{{ route('admin.ceiling.index') }}" variant="secondary">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                {{ __('Back to List') }}
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto">
            <x-card>
                <form action="{{ route('admin.ceiling.update', $ceiling) }}" method="POST" class="space-y-6"
                    x-data="ceilingForm({{ old('lebar', $ceiling->lebar) }}, {{ old('panjang', $ceiling->panjang) }})"
                    x-init="calculateArea()"
                >
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <flux:input 
                                name="code" 
                                :label="__('Code')" 
                                type="text" 
                                required 
                                autocomplete="off"
                                :placeholder="__('Enter ceiling code')"
                                :value="old('code', $ceiling->code)" 
                            />
                        </div>
                        
                        <div class="col-span-2">
                            <flux:input 
                                name="nama_produk" 
                                :label="__('Nama Produk')" 
                                type="text" 
                                autocomplete="off"
                                :placeholder="__('Enter product name')"
                                :value="old('nama_produk', $ceiling->nama_produk)" 
                            />
                        </div>

                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-5">
                                <flux:input 
                                    name="lebar" 
                                    :label="__('Lebar')" 
                                    type="number" 
                                    step="0.01"
                                    required 
                                    autocomplete="off"
                                    :placeholder="__('Enter width')"
                                    :value="old('lebar', $ceiling->lebar)"
                                    x-model.number="lebar"
                                    @input="calculateArea"
                                />
                            </div>

                            <div class="col-span-5">
                                <flux:input 
                                    name="tebal" 
                                    :label="__('Tebal')" 
                                    type="number" 
                                    step="0.01"
                                    required 
                                    autocomplete="off"
                                    :placeholder="__('Enter thickness')"
                                    :value="old('tebal', $ceiling->tebal)" 
                                />
                            </div>

                            <div class="col-span-2">
                                <flux:select 
                                    name="satuan" 
                                    :label="__('Unit Satuan')" 
                                    required
                                >
                                    <option value="mm" {{ old('satuan', $ceiling->satuan) == 'mm' ? 'selected' : '' }}>mm</option>
                                    <option value="cm" {{ old('satuan', $ceiling->satuan) == 'cm' ? 'selected' : '' }}>cm</option>
                                    <option value="m" {{ old('satuan', $ceiling->satuan) == 'm' ? 'selected' : '' }}>m</option>
                                </flux:select>
                            </div>
                        </div>

                        <flux:input 
                            name="panjang" 
                            :label="__('Panjang')" 
                            type="number" 
                            step="0.01"
                            required 
                            autocomplete="off"
                            :placeholder="__('Enter length')"
                            :value="old('panjang', $ceiling->panjang)"
                            x-model.number="panjang"
                            @input="calculateArea"
                        />

                        <div>
                            <flux:input
                                name="luas_btg"
                                :label="__('Luas/btg')"
                                type="number"
                                step="0.01"
                                required
                                autocomplete="off"
                                :placeholder="__('Enter area per piece')"
                                :value="old('luas_btg', $ceiling->luas_btg)"
                                x-model.number="luas_btg"
                            />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-show="lebar > 0 && panjang > 0">
                                Luas per batang: <span x-text="luas_btg.toFixed(2)"></span> m²
                            </p>
                        </div>

                        <div>
                            <flux:input 
                                name="luas_m2" 
                                :label="__('Area (m²)')" 
                                type="number" 
                                step="0.01"
                                required 
                                autocomplete="off"
                                :placeholder="__('Enter area in m²')"
                                :value="old('luas_m2', $ceiling->luas_m2)"
                                x-model.number="luas_m2"
                                readonly
                            />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-show="luas_btg > 0">
                                Jumlah batang per m²: <span x-text="luas_m2.toFixed(2)"></span> btg
                            </p>
                        </div>

                        <div>
                            <flux:input 
                                name="harga" 
                                :label="__('Harga')" 
                                type="number" 
                                step="0.01"
                                required 
                                autocomplete="off"
                                :placeholder="__('Enter price')"
                                :value="old('harga', $ceiling->harga)"
                            />
                        </div>

                        <div class="col-span-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="status_aksesoris" id="status_aksesoris" value="1" {{ old('status_aksesoris', $ceiling->status_aksesoris) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="status_aksesoris" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('Status Aksesoris') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="my-6 p-4 bg-yellow-50 dark:bg-accent-foreground border-l-4 border-red-400 text-zinc-400">
                        <p class="font-bold">WARNING!!!</p>
                        <p>Area Luas/btg dihitung secara otomatis dengan rumus: (Lebar/1000) * (Panjang/100)</p>
                        <p>Pastikan nilai lebar dan panjang sudah benar sebelum menyimpan data.</p>
                    </div>

                    <div class="flex items-center justify-end">
                        <x-button type="submit" variant="secondary">
                            {{ __('Update Ceiling') }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('ceilingForm', (initialLebar = 0, initialPanjang = 0) => ({
                lebar: initialLebar,
                panjang: initialPanjang,
                luas_btg: 0,
                luas_m2: 0,

                calculateArea() {
                    if (this.lebar > 0 && this.panjang > 0) {
                        this.luas_btg = Number(((this.lebar / 1000) * (this.panjang/100)).toFixed(2));
                        this.luas_m2 = Number((1 / this.luas_btg).toFixed(2));
                    } else {
                        this.luas_btg = 0;
                        this.luas_m2 = 0;
                    }
                }
            }));
        });
    </script>
    @endpush
</x-layouts.app> 