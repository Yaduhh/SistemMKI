<x-layouts.app :title="__('Edit Syarat Pintu')">
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Syarat Pintu</h1>
            <x-button as="a" href="{{ route('admin.syarat-pintu.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Kembali ke Daftar
            </x-button>
        </div>
    </x-slot>

    <x-flash-message type="success" :message="session('success')" />
    <x-flash-message type="error" :message="session('error')" />

    <div class="py-4 mx-auto w-full">
        <div class="w-full mx-auto">
            <form action="{{ route('admin.syarat-pintu.update', $syaratPintu->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <flux:textarea name="syarat" label="Syarat Pintu" placeholder="Masukkan syarat pintu" rows="4" required
                        class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">{{ $syaratPintu->syarat }}</flux:textarea>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3">
                        <x-icon name="save" class="w-4 h-4 mr-2" />
                        Update Syarat Pintu
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
