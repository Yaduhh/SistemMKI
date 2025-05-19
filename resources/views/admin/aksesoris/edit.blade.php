<x-layouts.app :title="__('Edit Aksesoris')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Edit Aksesoris')" :description="__('Perbarui detail aksesoris di bawah ini')" />

        <form action="{{ route('admin.aksesoris.update', $aksesoris->id) }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @method('PUT')

            <!-- Type -->
            <flux:input
                name="type"
                :label="__('Type')"
                type="text"
                required
                autocomplete="off"
                value="{{ $aksesoris->type }}"
            />

            <!-- Satuan -->
            <flux:input
                name="satuan"
                :label="__('Satuan')"
                type="text"
                required
                autocomplete="off"
                value="{{ $aksesoris->satuan }}"
            />

            <!-- Harga -->
            <flux:input
                name="harga"
                :label="__('Harga')"
                type="number"
                required
                value="{{ $aksesoris->harga }}"
            />

           <!-- Status -->
            <flux:select name="status" :label="__('Status')" required>
                <option value="1" {{ $aksesoris->status ? 'selected' : '' }}>{{ __('Tersedia') }}</option>
                <option value="0" {{ !$aksesoris->status ? 'selected' : '' }}>{{ __('Tidak Tersedia') }}</option>
            </flux:select>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Perbarui') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
