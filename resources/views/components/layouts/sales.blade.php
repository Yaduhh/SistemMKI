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

        <flux:brand href="{{ route('sales.dashboard') }}" logo="{{ asset('storage/logo.png') }}" name="{{ config('app.name', 'Laravel') }}" class="max-lg:hidden dark:hidden" />
        <flux:brand href="{{ route('sales.dashboard') }}" logo="{{ asset('storage/logo-dark.png') }}" name="{{ config('app.name', 'Laravel') }}" class="max-lg:hidden! hidden dark:flex" />

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item icon="home" href="{{ route('sales.dashboard') }}" :current="request()->routeIs('sales.dashboard')">Dashboard</flux:navbar.item>
            <flux:navbar.item icon="document-text" href="#">Penawaran</flux:navbar.item>
            <flux:navbar.item icon="calendar" href="#">Jadwal</flux:navbar.item>
            <flux:navbar.item icon="chart-bar" href="#">Laporan</flux:navbar.item>

            <flux:separator vertical variant="subtle" class="my-2"/>

            <flux:dropdown class="max-lg:hidden">
                <flux:navbar.item icon:trailing="chevron-down">Menu</flux:navbar.item>
                <flux:navmenu>
                    <flux:navmenu.item href="#">Profil Klien</flux:navmenu.item>
                    <flux:navmenu.item href="#">Riwayat Penjualan</flux:navmenu.item>
                    <flux:navmenu.item href="#">Target Penjualan</flux:navmenu.item>
                </flux:navmenu>
            </flux:dropdown>
        </flux:navbar>

        <flux:spacer />

        <flux:navbar class="me-4">
            <flux:navbar.item icon="magnifying-glass" href="#" label="Cari" />
            <flux:navbar.item class="max-lg:hidden" icon="cog-6-tooth" href="{{ route('sales.setting.index') }}" label="Pengaturan" />
            <flux:navbar.item class="max-lg:hidden" icon="information-circle" href="#" label="Bantuan" />
        </flux:navbar>

        <flux:dropdown position="top" align="start">
            <flux:profile avatar="{{ auth()->user()->profile ? asset('storage/' . auth()->user()->profile) : null }}" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('sales.setting.index')" icon="cog" wire:navigate>{{ __('Pengaturan') }}</flux:menu.item>
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

    <flux:sidebar stashable sticky class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('sales.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>
        
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('sales.dashboard') }}" :current="request()->routeIs('sales.dashboard')">Dashboard</flux:navlist.item>
            <flux:navlist.item icon="document-text" href="#">Penawaran</flux:navlist.item>
            <flux:navlist.item icon="calendar" href="#">Jadwal</flux:navlist.item>
            <flux:navlist.item icon="chart-bar" href="#">Laporan</flux:navlist.item>

            <flux:navlist.group expandable heading="Menu" class="max-lg:hidden">
                <flux:navlist.item href="#">Profil Klien</flux:navlist.item>
                <flux:navlist.item href="#">Riwayat Penjualan</flux:navlist.item>
                <flux:navlist.item href="#">Target Penjualan</flux:navlist.item>
            </flux:navlist.group>

            <!-- Daily Activity -->
            <flux:navlist.group :heading="__('Aktivitas')" class="grid mt-10">
                <flux:navlist.item icon="calendar" :href="route('sales.daily-activity.index')" :current="request()->routeIs('sales.daily-activity.*')" wire:navigate>{{ __('Aktivitas Harian') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="{{ route('sales.setting.index') }}" :current="request()->routeIs('sales.setting.*')">Pengaturan</flux:navlist.item>
            <flux:navlist.item icon="information-circle" href="#">Bantuan</flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>

    <flux:main container>
        {{ $slot }}
    </flux:main>

    @fluxScripts
    @stack('scripts')
</body>
</html> 