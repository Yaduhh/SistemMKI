<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Rotan Sintetis') }}
            </h2>
            <x-button href="{{ route('admin.rotan-sintetis.index') }}" variant="secondary">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                {{ __('Back to List') }}
            </x-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="w-full mx-auto">
            <x-card>
                <form action="{{ route('admin.rotan-sintetis.update', $rotanSintetis) }}" method="POST" class="space-y-6">
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
                                :placeholder="__('Enter rotan sintetis code')"
                                :value="old('code', $rotanSintetis->code)" 
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
                                :value="old('nama_produk', $rotanSintetis->nama_produk)" 
                            />
                        </div>

                        <div>
                            <flux:input 
                                name="satuan" 
                                :label="__('Satuan')" 
                                type="text" 
                                required 
                                autocomplete="off"
                                :placeholder="__('Enter unit, e.g: pcs, m, kg')"
                                :value="old('satuan', $rotanSintetis->satuan)"
                            />
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
                                :value="old('harga', $rotanSintetis->harga)"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <x-button type="submit" variant="secondary">
                            {{ __('Update Rotan Sintetis') }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-layouts.app>
