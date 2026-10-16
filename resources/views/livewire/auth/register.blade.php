<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $user->assignRole('user');

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-xl shadow-green-950/10 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/40">

    {{-- Header hijau dengan pola bintang islami --}}
    <div class="relative overflow-hidden bg-linear-to-br from-green-800 to-green-900 px-6 pb-8 pt-8 text-center">
        <svg class="absolute inset-0 h-full w-full text-white/10" aria-hidden="true">
            <defs>
                <pattern id="register-star-pattern" width="48" height="48" patternUnits="userSpaceOnUse">
                    <g fill="none" stroke="currentColor" stroke-width="1">
                        <rect x="10" y="10" width="28" height="28" />
                        <rect x="10" y="10" width="28" height="28" transform="rotate(45 24 24)" />
                    </g>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#register-star-pattern)" />
        </svg>

        <div class="relative">
            {{-- Emblem bulan sabit & bintang --}}
            <div class="relative mx-auto flex size-14 items-center justify-center rounded-full bg-white/10 ring-1 ring-white/25">
                <svg class="size-7 text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                </svg>
                <svg class="absolute -right-1 -top-1 size-4 text-amber-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 16.8l-6.2 4.5 2.4-7.4L2 9.4h7.6z" />
                </svg>
            </div>

            <p class="mt-4 font-alhambra text-3xl tracking-wide text-white">Tanya Ulama.</p>
            <p class="mt-1 text-lg text-green-100/90" dir="rtl" lang="ar">أهلاً وسهلاً</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="flex flex-col gap-5 px-6 py-7">
        <div class="text-center">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Buat akun</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Masukkan detail anda untuk membuat akun</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="register" class="flex flex-col gap-5">
            <!-- Name -->
            <flux:input
                wire:model="name"
                id="name"
                label="{{ __('Nama') }}"
                type="text"
                name="name"
                required
                autofocus
                autocomplete="name"
                placeholder="Nama lengkap"
                icon="user"
            />

            <!-- Email Address -->
            <flux:input
                wire:model="email"
                id="email"
                label="{{ __('Email') }}"
                type="email"
                name="email"
                required
                autocomplete="email"
                placeholder="email@contoh.com"
                icon="envelope"
            />

            <!-- Password -->
            <flux:input
                wire:model="password"
                id="password"
                label="{{ __('Kata sandi') }}"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Kata sandi"
                description="Minimal 8 karakter"
                icon="lock-closed"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                wire:model="password_confirmation"
                id="password_confirmation"
                label="{{ __('Konfirmasi kata sandi') }}"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Ulangi kata sandi"
                icon="lock-closed"
                viewable
            />

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="register"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-white disabled:cursor-not-allowed disabled:opacity-70 dark:focus:ring-offset-zinc-900"
            >
                <span wire:loading.remove wire:target="register">{{ __('Buat akun') }}</span>
                <span wire:loading wire:target="register" class="inline-flex items-center gap-2">
                    <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                    </svg>
                    Memproses...
                </span>
            </button>
        </form>

        {{-- Pemisah --}}
        <div class="flex items-center gap-3">
            <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-800"></div>
            <span class="text-xs uppercase tracking-wide text-zinc-400 dark:text-zinc-500">atau</span>
            <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-800"></div>
        </div>

        {{-- Daftar sebagai ustaz / ustazah --}}
        <a
            href="{{ route('register.expert') }}"
            wire:navigate
            class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-3 transition hover:border-green-300 hover:bg-green-100 dark:border-green-900/60 dark:bg-green-950/40 dark:hover:bg-green-950/70"
        >
            <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-green-700 text-white">
                <flux:icon.academic-cap class="size-5" />
            </span>
            <span class="flex-1 text-left">
                <span class="block text-sm font-semibold text-green-900 dark:text-green-200">Daftar sebagai ustaz / ustazah</span>
                <span class="block text-xs text-green-700/80 dark:text-green-300/70">Menjawab pertanyaan setelah akun terverifikasi</span>
            </span>
            <flux:icon.chevron-right class="size-4 text-green-700 dark:text-green-400" />
        </a>
    </div>

    {{-- Footer masuk --}}
    <div class="border-t border-zinc-200 bg-zinc-50 px-6 py-4 text-center text-sm text-zinc-600 dark:border-zinc-800 dark:bg-zinc-950/40 dark:text-zinc-400">
        Sudah punya akun?
        <a
            href="{{ route('login') }}"
            wire:navigate
            class="font-semibold text-green-700 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300"
        >
            Masuk
        </a>
    </div>
</div>