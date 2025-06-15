<x-layouts.app.sidebarFinance :title="$title ?? null">
    <flux:main>
        @if (isset($header))
            <div class="">
                <div class="mx-auto w-full px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </div>
        @endif
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebarFinance>
