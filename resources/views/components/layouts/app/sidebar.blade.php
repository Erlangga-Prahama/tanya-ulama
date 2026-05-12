<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-green-600 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo class="size-8" href="#"></x-app-logo>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group class="grid [&_.flux-navlist-group-heading]:text-white" heading="Platform">
                    <flux:navlist.item 
                        icon="home" 
                        :href="route('dashboard')" 
                        :current="request()->routeIs('dashboard')" 
                        wire:navigate
                        class="font-rubaith text-white! [&[aria-current]]:text-black! [&[data-current]]:text-black!"
                    >Dashboard</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.item 
                    icon="users" 
                    :href="route('admin.user-index')" 
                    :current="request()->routeIs('admin.user-index')" 
                    wire:navigate
                    class="text-white! [&[aria-current]]:text-black! [&[data-current]]:text-black!"
                >Pengguna</flux:navlist.item>
                
                <flux:sidebar.group 
                    expandable 
                    expanded="false" 
                    class="grid [&_.flux-sidebar-group-heading]:text-white!"
                    heading="Ustaz/Ustazah" 
                >
                    <flux:sidebar.item class="text-white! [&[aria-current]]:text-black! [&[data-current]]:text-black!" :href="route('admin.ustaz-index')">Daftar Ustaz dan Ustazah</flux:sidebar.item>
                    <flux:sidebar.item class="text-white! [&[aria-current]]:text-black! [&[data-current]]:text-black!" :href="route('admin.ustaz-verification')">Verifikasi</flux:sidebar.item>
                </flux:sidebar.group>

                <flux:navlist.item 
                    icon="flag" 
                    :href="route('admin.reports')" 
                    :current="request()->routeIs('admin.reports')" 
                    wire:navigate
                    class="text-white! [&[aria-current]]:text-black! [&[data-current]]:text-black!"
                >Laporan</flux:navlist.item>

                <flux:navlist.item 
                    icon="exclamation-triangle" 
                    :href="route('admin.offender')" 
                    :current="request()->routeIs('admin.offender')" 
                    wire:navigate
                    class="text-white! [&[aria-current]]:text-black! [&[data-current]]:text-black!"
                >Pelanggar</flux:navlist.item>
            </flux:navlist>

            <flux:spacer />

            {{-- <flux:navlist variant="outline" class="text-white!">
                <flux:navlist.item class="text-white!" icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    Repository
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                    Documentation
                </flux:navlist.item>
            </flux:navlist> --}}

            <!-- Desktop User Menu -->
            <flux:sidebar.nav>
                <flux:modal.trigger name="logout-modal">
                    <flux:sidebar.item as="button" icon="arrow-right-start-on-rectangle" class="w-full text-white!">
                        {{ __('Keluar') }}
                    </flux:sidebar.item>
                </flux:modal.trigger>
                <flux:sidebar.item icon="information-circle" href="#" class="text-white!">Bantuan</flux:sidebar.item>
            </flux:sidebar.nav>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
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

        <flux:modal name="logout-modal" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Keluar?</flux:heading>
                    <flux:text class="mt-2">
                        Anda yakin?<br>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:button type="submit" variant="danger">Keluar</flux:button>
                    </form>
                </div>
            </div>
        </flux:modal>

        {{ $slot }}

        @fluxScripts
        <flux:toast />
    </body>
</html>
