<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-bind:class="$flux.appearance">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @fluxAppearance
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <a href="{{ route('supervisi.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>
        <flux:spacer />

        <flux:navbar class="-mb-px max-lg:hidden space-x-4">
            <flux:navbar.item icon="home" href="{{ route('supervisi.dashboard') }}" :current="request()->routeIs('supervisi.dashboard')">Dashboard</flux:navbar.item>
            <flux:navbar.item icon="calculator" href="{{ route('supervisi.rab.index') }}" :current="request()->routeIs('supervisi.rab.*')">RAB</flux:navbar.item>
            <flux:navbar.item icon="clipboard-document-list" href="{{ route('supervisi.logs') }}" :current="request()->routeIs('supervisi.logs')">Log</flux:navbar.item>

            <flux:separator vertical variant="subtle" class="my-2"/>
        </flux:navbar>

        <flux:spacer />

        <flux:dropdown position="top" align="start">
            <flux:profile avatar:name="{{ auth()->user()->name }}" />
            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                                {{ auth()->user()->initials() }}
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">Supervisi</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('supervisi.setting.index')" icon="cog" wire:navigate>{{ __('Pengaturan') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Keluar') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:sidebar stashable sticky class="hidden-scrollbar lg:hidden bg-zinc-50 dark:bg-zinc-900 border rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('supervisi.dashboard') }}" class="me-5 lg:hidden flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>
        
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('supervisi.dashboard') }}" :current="request()->routeIs('supervisi.dashboard')">Dashboard</flux:navlist.item>
            
            <flux:navlist.group :heading="__('Rancangan Anggaran Biaya')" class="grid mt-10">
                <flux:navlist.item icon="calculator" href="{{ route('supervisi.rab.index') }}" :current="request()->routeIs('supervisi.rab.*')">Daftar RAB</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Sistem')" class="grid mt-10">
                <flux:navlist.item icon="clipboard-document-list" href="{{ route('supervisi.logs') }}" :current="request()->routeIs('supervisi.logs')">Log Aktivitas</flux:navlist.item>
                <flux:navlist.item icon="cog-6-tooth" href="{{ route('supervisi.setting.index') }}" :current="request()->routeIs('supervisi.setting.*')">Pengaturan</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>
    </flux:sidebar>

    <flux:main container>
        {{ $slot }}
    </flux:main>

    @stack('scripts')
    @fluxScripts
</body>
</html>
