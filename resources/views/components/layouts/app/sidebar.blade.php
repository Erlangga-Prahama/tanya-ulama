@php
    // Satu tempat untuk gaya item menu. Hapus "font-rubaith" di sini jika tidak ingin dipakai di semua item.
    $navItem = 'rounded-lg! text-emerald-50/85! transition-colors hover:bg-white/10! hover:text-white! '
        . '[&[aria-current]]:bg-white/15! [&[aria-current]]:text-white! '
        . '[&[data-current]]:bg-white/15! [&[data-current]]:text-white! '
        . '[&[data-current]]:shadow-[inset_3px_0_0_var(--color-amber-300)]';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar
            sticky
            stashable
            class="relative overflow-hidden border-r border-emerald-950/60 bg-linear-to-b from-emerald-800 via-emerald-900 to-emerald-950 dark:border-emerald-950/60 dark:bg-linear-to-b dark:from-emerald-800 dark:via-emerald-900 dark:to-emerald-950"
        >
            {{-- Ornamen bintang geometris (halus, di belakang konten) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0 -z-10 opacity-[0.07]"
                style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64' fill='none' stroke='%23fcd34d' stroke-width='1'%3E%3Cpath d='M32 6l7.4 14.6L56 22l-12 11.4L46.8 50 32 42.2 17.2 50 20 33.4 8 22l16.6-1.4z'/%3E%3Cpath d='M32 0v6M32 58v6M0 32h6M58 32h6'/%3E%3C/svg%3E&quot;);"
            ></div>
            <div
                aria-hidden="true"
                class="pointer-events-none absolute -top-24 left-1/2 -z-10 h-56 w-56 -translate-x-1/2 rounded-full bg-amber-300/10 blur-3xl"
            ></div>

            <flux:sidebar.toggle class="lg:hidden text-white" icon="x-mark" />

            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" class="mr-5 flex flex-col gap-1.5" wire:navigate>
                <x-app-logo class="size-8" href="#"></x-app-logo>
                <span class="text-[10px] font-medium uppercase tracking-[0.3em] text-amber-300/80">Panel Admin</span>
            </a>

            <div class="h-px bg-linear-to-r from-transparent via-amber-300/40 to-transparent"></div>

            <flux:navlist variant="outline">
                <flux:navlist.group class="grid [&_.flux-navlist-group-heading]:text-amber-200/70" heading="Platform">
                    <flux:navlist.item
                        icon="home"
                        :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')"
                        wire:navigate
                        class="{{ $navItem }}"
                    >Dashboard</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.item
                    icon="users"
                    :href="route('admin.user-index')"
                    :current="request()->routeIs('admin.user-index')"
                    wire:navigate
                    class="{{ $navItem }}"
                >Pengguna</flux:navlist.item>

                <flux:sidebar.group
                    expandable
                    expanded="false"
                    class="grid [&_.flux-sidebar-group-heading]:text-emerald-50/85!"
                    heading="Ustaz/Ustazah"
                >
                    <flux:sidebar.item
                        class="{{ $navItem }}"
                        :href="route('admin.ustaz-index')"
                        :current="request()->routeIs('admin.ustaz-index')"
                        wire:navigate
                    >Daftar Ustaz dan Ustazah</flux:sidebar.item>
                    <flux:sidebar.item
                        class="{{ $navItem }}"
                        :href="route('admin.ustaz-verification')"
                        :current="request()->routeIs('admin.ustaz-verification')"
                        wire:navigate
                    >Verifikasi</flux:sidebar.item>
                </flux:sidebar.group>

                <flux:navlist.item
                    icon="flag"
                    :href="route('admin.reports')"
                    :current="request()->routeIs('admin.reports')"
                    wire:navigate
                    class="{{ $navItem }}"
                >Laporan</flux:navlist.item>

                <flux:navlist.item
                    icon="exclamation-triangle"
                    :href="route('admin.offender')"
                    :current="request()->routeIs('admin.offender')"
                    wire:navigate
                    class="{{ $navItem }}"
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
                <flux:sidebar.item icon="information-circle" href="#" class="{{ $navItem }}">Bantuan</flux:sidebar.item>
                <flux:modal.trigger name="logout-modal">
                    <flux:sidebar.item as="button" icon="arrow-right-start-on-rectangle" class="w-full {{ $navItem }} hover:bg-red-500/20!">
                        {{ __('Keluar') }}
                    </flux:sidebar.item>
                </flux:modal.trigger>
            </flux:sidebar.nav>

            <div class="h-px bg-linear-to-r from-transparent via-amber-300/40 to-transparent"></div>

            <div class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 p-3 backdrop-blur-sm">
                <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-amber-300 text-sm font-semibold text-emerald-950">
                    {{ auth()->user()->initials() }}
                </span>
                <div class="grid min-w-0 flex-1 leading-tight">
                    <span class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</span>
                    <span class="truncate text-xs text-emerald-100/70">{{ auth()->user()->email }}</span>
                </div>
            </div>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="border-b border-emerald-950/60 bg-linear-to-r from-emerald-900 to-emerald-800 lg:hidden dark:border-emerald-950/60 dark:bg-linear-to-r dark:from-emerald-900 dark:to-emerald-800">
            <flux:sidebar.toggle class="lg:hidden text-white" icon="bars-2" inset="left" />

            <a href="{{ route('dashboard') }}" class="ml-2 flex items-center" wire:navigate>
                <x-app-logo class="size-7" href="#"></x-app-logo>
            </a>

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
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-amber-300 font-semibold text-emerald-950"
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
                <div class="flex items-start gap-4">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-red-500/15 text-red-400">
                        <flux:icon.arrow-right-start-on-rectangle class="size-5" />
                    </span>
                    <div>
                        <flux:heading size="lg">Keluar?</flux:heading>
                        <flux:text class="mt-2">
                            Anda yakin?<br>
                        </flux:text>
                    </div>
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