<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="hidden-scrollbar-webkit border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')"
                    :current="request()->routeIs('admin.dashboard')" wire:navigate>{{ __('Dashboard') }}
                </flux:navlist.item>
                <flux:navlist.item icon="document-text" :href="route('admin.arsip-file.index')"
                    :current="request()->routeIs('admin.arsip-file.*')" wire:navigate>{{ __('File Purchase Order') }}
                </flux:navlist.item>
                <flux:navlist.item icon="cloud-arrow-up" :href="route('admin.file-manager.index')"
                    :current="request()->routeIs('admin.file-manager.*')" wire:navigate>{{ __('File Manager') }}
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Manajemen Proyek')" class="mt-10">
                <flux:navlist.item icon="calendar" :href="route('admin.daily-activity.index')"
                    :current="request()->routeIs('admin.daily-activity.*')" wire:navigate>{{ __('Kunjungan Harian') }}
                </flux:navlist.item>
                <flux:navlist.item icon="check-circle" :href="route('admin.absensi.index')"
                    :current="request()->routeIs('admin.absensi.*')" wire:navigate>{{ __('Absensi') }}
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Pelanggan & Distributor')" class="mt-10">
                <flux:navlist.item icon="truck" :href="route('admin.distributor.index')"
                    :current="request()->routeIs('admin.distributor.index')" wire:navigate>{{ __('Distributor') }}
                </flux:navlist.item>
                <flux:navlist.item icon="users" :href="route('admin.client.index')"
                    :current="request()->routeIs('admin.client.index')" wire:navigate>{{ __('Pelanggan') }}
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Penawaran & Pemasangan')" class="mt-10">
                <flux:navlist.item icon="document-chart-bar" :href="route('admin.penawaran.index')"
                    :current="request()->routeIs('admin.penawaran.*')" wire:navigate>{{ __('Penawaran') }}
                </flux:navlist.item>
                <flux:navlist.item icon="home-modern" :href="route('admin.penawaran-pintu.index')"
                    :current="request()->routeIs('admin.penawaran-pintu.*')" wire:navigate>{{ __('Penawaran Pintu') }}
                </flux:navlist.item>
                <flux:navlist.item icon="square-3-stack-3d" :href="route('admin.pemasangan.index')"
                    :current="request()->routeIs('admin.pemasangan.index')" wire:navigate>{{ __('Pemasangan') }}
                </flux:navlist.item>
                <flux:navlist.item icon="calculator" :href="route('admin.rancangan-anggaran-biaya.index')"
                    :current="request()->routeIs('admin.rancangan-anggaran-biaya.*')" wire:navigate>
                    {{ __('RAB') }}</flux:navlist.item>
            </flux:navlist.group>

            @if (auth()->user()->master === true)
                <flux:navlist.group :heading="__('Pengeluaran RAB')" class="mt-10">
                    <flux:navlist.item icon="sparkles" :href="route('admin.entertainment.index')"
                        :current="request()->routeIs('admin.entertainment.*')" wire:navigate>{{ __('Non Material') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="cube" :href="route('admin.material-tambahan.index')"
                        :current="request()->routeIs('admin.material-tambahan.*')" wire:navigate>{{ __('Material Tambahan') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('admin.tukang.index')"
                        :current="request()->routeIs('admin.tukang.*')" wire:navigate>{{ __('Tukang') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="wrench" :href="route('admin.kerja-tambah.index')"
                        :current="request()->routeIs('admin.kerja-tambah.*')" wire:navigate>{{ __('Kerja Tambah') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endif
            
            <flux:navlist.group :heading="__('Syarat & Kondisi')" class="mt-10">
                <flux:navlist.item icon="document-text" :href="route('admin.syarat_ketentuan.index')"
                    :current="request()->routeIs('admin.syarat_ketentuan.index')" wire:navigate>
                    {{ __('Syarat & Ketentuan') }}</flux:navlist.item>
                <flux:navlist.item icon="document-text" :href="route('admin.syarat-pemasangan.index')"
                    :current="request()->routeIs('admin.syarat-pemasangan.*')" wire:navigate>
                    {{ __('Syarat Pemasangan') }}</flux:navlist.item>
                <flux:navlist.item icon="home-modern" :href="route('admin.syarat-pintu.index')"
                    :current="request()->routeIs('admin.syarat-pintu.*')" wire:navigate>{{ __('Syarat Pintu') }}
                </flux:navlist.item>

            </flux:navlist.group>
            <flux:navlist.group :heading="__('Produk & Aksesoris')" class="mt-10">
                {{-- <flux:navlist.item icon="cube" :href="route('admin.produk.index')" :current="request()->routeIs('admin.produk.index')" wire:navigate>{{ __('Produk') }}</flux:navlist.item>
                    <flux:navlist.item icon="wrench-screwdriver" :href="route('admin.aksesoris.index')" :current="request()->routeIs('admin.aksesoris.*')" wire:navigate>{{ __('Aksesoris') }}</flux:navlist.item>
                    --}}
                <flux:navlist.group heading="Semua Produk WPC" expandable :expanded="true">
                    <flux:navlist.item icon="square-3-stack-3d" :href="route('admin.decking.index')"
                        :current="request()->routeIs('admin.decking.*')" wire:navigate>{{ __('Decking') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="square-3-stack-3d" :href="route('admin.facade.index')"
                        :current="request()->routeIs('admin.facade.*')" wire:navigate>{{ __('Facade') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="square-3-stack-3d" :href="route('admin.flooring.index')"
                        :current="request()->routeIs('admin.flooring.*')" wire:navigate>{{ __('Flooring') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="square-3-stack-3d" :href="route('admin.wallpanel.index')"
                        :current="request()->routeIs('admin.wallpanel.*')" wire:navigate>{{ __('Wallpanel') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="square-3-stack-3d" :href="route('admin.ceiling.index')"
                        :current="request()->routeIs('admin.ceiling.*')" wire:navigate>{{ __('Ceiling') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="home-modern" :href="route('admin.pintu.index')"
                        :current="request()->routeIs('admin.pintu.*')" wire:navigate>{{ __('Pintu') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist.group>
            {{--<flux:navlist.group :heading="__('Data Surat Jalan')" class="mt-10">
                <flux:navlist.item icon="document" :href="route('admin.surat_jalan.index')"
                    :current="request()->routeIs('admin.surat_jalan.index')" wire:navigate>{{ __('Surat Jalan') }}
                </flux:navlist.item>
            </flux:navlist.group>--}}

            <!-- Event Management -->
            @if (auth()->user()->role === 1)
                <flux:navlist.group :heading="__('Manajemen Event')" class="mt-10">
                    <flux:navlist.item icon="calendar-days" :href="route('admin.events.index')"
                        :current="request()->routeIs('admin.events.index')" wire:navigate>{{ __('Semua Event') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="clock" :href="route('admin.events.upcoming')"
                        :current="request()->routeIs('admin.events.upcoming')" wire:navigate>
                        {{ __('Event Mendatang') }}</flux:navlist.item>
                    <flux:navlist.item icon="check-circle" :href="route('admin.events.past')"
                        :current="request()->routeIs('admin.events.past')" wire:navigate>{{ __('Event Selesai') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endif

            <flux:navlist.group :heading="__('Akun')" class="mt-10">
                <flux:navlist.item icon="user-circle" :href="route('admin.akun.index')"
                    :current="request()->routeIs('admin.akun.index')" wire:navigate>{{ __('Akun') }}
                </flux:navlist.item>
                @if (auth()->user()->role === 1)
                    <flux:navlist.item icon="user-plus" :href="route('admin.akun.create')"
                        :current="request()->routeIs('admin.akun.create')" wire:navigate>{{ __('Tambah User') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="document-duplicate" :href="route('admin.tanda-tangan.index')"
                        :current="request()->routeIs('admin.tanda-tangan.*')" wire:navigate>{{ __('Tanda Tangan') }}
                    </flux:navlist.item>
                @endif
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    @if (auth()->user()->role === 1)
                        <flux:menu.item :href="route('admin.setting.index')" icon="cog" wire:navigate>
                            {{ __('Settings') }}</flux:menu.item>
                    @else
                        <flux:menu.item :href="route('sales.setting.index')" icon="cog" wire:navigate>
                            {{ __('Settings') }}</flux:menu.item>
                    @endif
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="flex text-start text-sm leading-tight flex-col">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    @if (auth()->user()->role === 1)
                        <flux:menu.item :href="route('admin.setting.index')" icon="cog" wire:navigate>
                            {{ __('Settings') }}</flux:menu.item>
                    @else
                        <flux:menu.item :href="route('sales.setting.index')" icon="cog" wire:navigate>
                            {{ __('Settings') }}</flux:menu.item>
                    @endif
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @stack('scripts')
    @fluxScripts
</body>

</html>
