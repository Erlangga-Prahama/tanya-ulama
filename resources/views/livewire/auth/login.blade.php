<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('posts.index', absolute: false), navigate: true);
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-xl shadow-green-950/10 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/40">

    {{-- Header hijau dengan pola bintang islami --}}
    <div class="relative overflow-hidden bg-linear-to-br from-green-800 to-green-900 px-6 pb-8 pt-8 text-center">
        <svg class="absolute inset-0 h-full w-full text-white/10" aria-hidden="true">
            <defs>
                <pattern id="login-star-pattern" width="48" height="48" patternUnits="userSpaceOnUse">
                    <g fill="none" stroke="currentColor" stroke-width="1">
                        <rect x="10" y="10" width="28" height="28" />
                        <rect x="10" y="10" width="28" height="28" transform="rotate(45 24 24)" />
                    </g>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#login-star-pattern)" />
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
            <p class="mt-1 text-lg text-green-100/90" dir="rtl" lang="ar">السلام عليكم</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="flex flex-col gap-5 px-6 py-7">
        <div class="text-center">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Masuk ke akun anda</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Masukkan email dan kata sandi anda untuk masuk</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="login" class="flex flex-col gap-5">
            <!-- Email Address -->
            <flux:input
                wire:model="email"
                label="{{ __('Email') }}"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@contoh.com"
                icon="envelope"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    wire:model="password"
                    label="{{ __('Kata sandi') }}"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Kata sandi"
                    icon="lock-closed"
                    viewable
                />

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        wire:navigate
                        class="absolute right-0 top-0 text-xs font-medium text-green-700 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300"
                    >
                        {{ __('Lupa kata sandi?') }}
                    </a>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox wire:model="remember" label="{{ __('Ingat saya') }}" />

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="login"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-white disabled:cursor-not-allowed disabled:opacity-70 dark:focus:ring-offset-zinc-900"
            >
                <span wire:loading.remove wire:target="login">{{ __('Masuk') }}</span>
                <span wire:loading wire:target="login" class="inline-flex items-center gap-2">
                    <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                    </svg>
                    Memproses...
                </span>
            </button>
        </form>

        {{-- Akun demo untuk pengunjung --}}
        @php
            $demoAccounts = [
                [
                    'role' => 'Admin',
                    'desc' => 'Kelola pengguna, verifikasi ustaz, dan laporan',
                    'email' => 'admin@gmail.com',
                    'password' => 'admin1234',
                    'badge' => 'bg-rose-100 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300',
                ],
                [
                    'role' => 'User',
                    'desc' => 'Mengajukan pertanyaan dan melihat jawaban',
                    'email' => 'ahmad.rizki@example.com',
                    'password' => 'password',
                    'badge' => 'bg-sky-100 text-sky-700 dark:bg-sky-950/50 dark:text-sky-300',
                ],
                [
                    'role' => 'Ustaz',
                    'desc' => 'Menjawab pertanyaan dari pengguna',
                    'email' => 'yusuf@example.com',
                    'password' => 'password',
                    'badge' => 'bg-green-100 text-green-700 dark:bg-green-950/50 dark:text-green-300',
                ],
            ];
        @endphp

        <div class="flex items-center gap-3">
            <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-800"></div>
            <span class="text-xs uppercase tracking-wide text-zinc-400 dark:text-zinc-500">Coba akun demo</span>
            <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-800"></div>
        </div>

        <div class="flex flex-col gap-2">
            @foreach ($demoAccounts as $account)
                <div class="flex items-center gap-3 rounded-xl border border-zinc-200 p-3 dark:border-zinc-800">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-semibold {{ $account['badge'] }}">{{ $account['role'] }}</span>
                            <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ $account['desc'] }}</span>
                        </div>
                        <p class="mt-1.5 truncate font-mono text-xs text-zinc-700 dark:text-zinc-300">{{ $account['email'] }}</p>
                        <p class="font-mono text-xs text-zinc-500 dark:text-zinc-400">{{ $account['password'] }}</p>
                    </div>
                    <button
                        type="button"
                        x-on:click="$wire.email = @js($account['email']); $wire.password = @js($account['password'])"
                        class="shrink-0 rounded-lg border border-green-600 px-3 py-1.5 text-xs font-semibold text-green-700 transition hover:bg-green-50 dark:border-green-500 dark:text-green-400 dark:hover:bg-green-950/40"
                    >
                        Isi otomatis
                    </button>
                </div>
            @endforeach

            <p class="text-center text-xs text-zinc-400 dark:text-zinc-500">
                Klik "Isi otomatis", lalu tekan Masuk. Akun demo bersifat publik, mohon tidak mengubah kata sandinya.
            </p>
        </div>
    </div>

    {{-- Footer daftar --}}
    <div class="border-t border-zinc-200 bg-zinc-50 px-6 py-4 text-center text-sm text-zinc-600 dark:border-zinc-800 dark:bg-zinc-950/40 dark:text-zinc-400">
        Belum punya akun?
        <a
            href="{{ route('register') }}"
            wire:navigate
            class="font-semibold text-green-700 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300"
        >
            Daftar
        </a>
    </div>
</div>