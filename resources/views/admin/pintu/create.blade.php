<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Pintu') }}
            </h2>
            <x-button href="{{ route('admin.pintu.index') }}" variant="secondary">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                {{ __('Back to List') }}
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto">
            <x-card>
                <form action="{{ route('admin.pintu.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <flux:input 
                                name="code" 
                                :label="__('Code')" 
                                type="text" 
                                required 
                                autocomplete="off"
                                :placeholder="__('Enter pintu code')"
                                :value="old('code')" 
                            />
                        </div>
                        
                        <div class="col-span-2">
                            <flux:input 
                                name="nama_produk" 
                                :label="__('Nama Produk')" 
                                type="text" 
                                required
                                autocomplete="off"
                                :placeholder="__('Enter product name')"
                                :value="old('nama_produk')" 
                            />
                        </div>

                        <div class="grid grid-cols-12 gap-6" x-data="{ isAksesoris: false }" x-init="isAksesoris = $refs.statusAksesoris.checked">
                            <div class="col-span-4">
                                <flux:input 
                                    name="lebar" 
                                    :label="__('Lebar (cm)')" 
                                    type="number" 
                                    step="0.01"
                                    autocomplete="off"
                                    :placeholder="__('Enter width')"
                                    :value="old('lebar')"
                                    x-show="!isAksesoris"
                                />
                            </div>

                            <div class="col-span-4">
                                <flux:input 
                                    name="tebal" 
                                    :label="__('Tebal (cm)')" 
                                    type="number" 
                                    step="0.01"
                                    autocomplete="off"
                                    :placeholder="__('Enter thickness')"
                                    :value="old('tebal')" 
                                    x-show="!isAksesoris"
                                />
                            </div>

                            <div class="col-span-4">
                                <flux:input 
                                    name="tinggi" 
                                    :label="__('Tinggi (cm)')" 
                                    type="number" 
                                    step="0.01"
                                    autocomplete="off"
                                    :placeholder="__('Enter height')"
                                    :value="old('tinggi')" 
                                    x-show="!isAksesoris"
                                />
                            </div>
                        </div>

                        <div class="col-span-2">
                            <flux:input 
                                name="warna" 
                                :label="__('Warna')" 
                                type="text" 
                                autocomplete="off"
                                :placeholder="__('Enter color')"
                                :value="old('warna')" 
                                x-show="!isAksesoris"
                            />
                        </div>

                        <div class="col-span-2">
                            <flux:input 
                                name="harga_satuan" 
                                :label="__('Harga Satuan')" 
                                type="number" 
                                step="0.01"
                                required
                                autocomplete="off"
                                :placeholder="__('Enter unit price')"
                                :value="old('harga_satuan')"
                            />
                        </div>

                        <div class="col-span-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="status_aksesoris" id="status_aksesoris" value="1" {{ old('status_aksesoris') ? 'checked' : '' }} x-ref="statusAksesoris" @change="isAksesoris = $event.target.checked" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="status_aksesoris" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('Status Aksesoris') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <x-button type="submit" variant="secondary">
                            {{ __('Save Pintu') }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-layouts.app>
