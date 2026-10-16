<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.auth')] class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $gender = '';        // L atau P
    public $verification_document = null;

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'in:L,P'],
            'verification_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:1048'],
        ]);

        // Upload file
        $documentPath = $this->verification_document->store('verification-documents', 'public');

        // Tentukan role berdasarkan gender
        $role = $this->gender === 'L' ? 'ustaz' : 'ustazah';

        $validated['password'] = Hash::make($validated['password']);
        $validated['verification_document'] = $documentPath;
        $validated['is_verified'] = false;
        $validated['profession'] = $role; // Simpan role sebagai profession

        $user = User::create($validated);

        // Assign role sesuai gender
        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        // Redirect ke halaman informasi bahwa akun perlu verifikasi
        $this->redirect(route('posts.index', absolute: false), navigate: true);
    }
}; ?>

<div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-xl shadow-green-950/10 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/40">

    {{-- Header hijau dengan pola bintang islami --}}
    <div class="relative overflow-hidden bg-linear-to-br from-green-800 to-green-900 px-6 pb-8 pt-8 text-center">
        <svg class="absolute inset-0 h-full w-full text-white/10" aria-hidden="true">
            <defs>
                <pattern id="expert-star-pattern" width="48" height="48" patternUnits="userSpaceOnUse">
                    <g fill="none" stroke="currentColor" stroke-width="1">
                        <rect x="10" y="10" width="28" height="28" />
                        <rect x="10" y="10" width="28" height="28" transform="rotate(45 24 24)" />
                    </g>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#expert-star-pattern)" />
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
            <p class="mt-1 text-lg text-green-100/90" dir="rtl" lang="ar">جزاكم الله خيرًا</p>
        </div>
    </div>

    {{-- Form --}}
    <div class="flex flex-col gap-5 px-6 py-7">
        <div class="text-center">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">Daftar sebagai Ustaz / Ustazah</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Isi data diri dan unggah dokumen pendukung untuk verifikasi</p>
        </div>

        {{-- Info proses verifikasi --}}
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2.5 text-xs text-amber-800 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-300">
            Akun Anda akan ditinjau oleh admin terlebih dahulu. Setelah terverifikasi, Anda dapat mulai menjawab pertanyaan.
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="register" class="flex flex-col gap-5" enctype="multipart/form-data">
            {{-- Nama --}}
            <flux:input
                wire:model="name"
                id="name"
                label="{{ __('Nama Lengkap') }}"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Nama lengkap sesuai ijazah"
                icon="user"
            />

            {{-- Email --}}
            <flux:input
                wire:model="email"
                id="email"
                label="{{ __('Email') }}"
                type="email"
                required
                autocomplete="email"
                placeholder="email@contoh.com"
                icon="envelope"
            />

            {{-- Jenis kelamin --}}
            <div class="grid gap-2">
                <flux:label>{{ __('Jenis Kelamin') }}</flux:label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="block cursor-pointer">
                        <input type="radio" wire:model="gender" value="L" class="peer sr-only">
                        <div class="flex flex-col items-center rounded-xl border border-zinc-300 px-3 py-2.5 text-sm font-medium text-zinc-700 transition hover:border-green-500 peer-checked:border-green-600 peer-checked:bg-green-50 peer-checked:text-green-800 peer-focus-visible:ring-2 peer-focus-visible:ring-green-500 dark:border-zinc-700 dark:text-zinc-300 dark:peer-checked:border-green-500 dark:peer-checked:bg-green-950/40 dark:peer-checked:text-green-300">
                            <span>Laki-laki</span>
                            <span class="text-xs font-normal opacity-70">Ustaz</span>
                        </div>
                    </label>
                    <label class="block cursor-pointer">
                        <input type="radio" wire:model="gender" value="P" class="peer sr-only">
                        <div class="flex flex-col items-center rounded-xl border border-zinc-300 px-3 py-2.5 text-sm font-medium text-zinc-700 transition hover:border-green-500 peer-checked:border-green-600 peer-checked:bg-green-50 peer-checked:text-green-800 peer-focus-visible:ring-2 peer-focus-visible:ring-green-500 dark:border-zinc-700 dark:text-zinc-300 dark:peer-checked:border-green-500 dark:peer-checked:bg-green-950/40 dark:peer-checked:text-green-300">
                            <span>Perempuan</span>
                            <span class="text-xs font-normal opacity-70">Ustazah</span>
                        </div>
                    </label>
                </div>
                @error('gender')
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dokumen verifikasi --}}
            <div class="grid gap-2">
                <flux:label>{{ __('Dokumen Verifikasi (Ijazah/Sertifikat)') }}</flux:label>

                <label class="block cursor-pointer">
                    <input
                        type="file"
                        wire:model="verification_document"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="peer sr-only"
                    />
                    <div class="flex flex-col items-center justify-center gap-1.5 rounded-xl border-2 border-dashed border-zinc-300 px-4 py-5 text-center transition hover:border-green-500 hover:bg-green-50/50 peer-focus-visible:ring-2 peer-focus-visible:ring-green-500 dark:border-zinc-700 dark:hover:border-green-600 dark:hover:bg-green-950/20">

                        {{-- Sedang mengunggah --}}
                        <div wire:loading wire:target="verification_document" class="flex flex-col items-center gap-1.5">
                            <svg class="size-6 animate-spin text-green-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                            </svg>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Mengunggah...</span>
                        </div>

                        <div wire:loading.remove wire:target="verification_document" class="flex flex-col items-center gap-1.5">
                            @if ($verification_document)
                                <svg class="size-6 text-green-600 dark:text-green-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                                <span class="max-w-full truncate text-sm font-medium text-zinc-800 dark:text-zinc-100">{{ $verification_document->getClientOriginalName() }}</span>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">Klik untuk mengganti file</span>
                            @else
                                <svg class="size-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Klik untuk memilih file</span>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">PDF, JPG, atau PNG, maks 1 MB</span>
                            @endif
                        </div>
                    </div>
                </label>

                @error('verification_document')
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    Unggah ijazah atau sertifikat kompetensi Anda.
                </p>
            </div>

            {{-- Password --}}
            <flux:input
                wire:model="password"
                id="password"
                label="{{ __('Kata sandi') }}"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Kata sandi"
                description="Minimal 8 karakter"
                icon="lock-closed"
                viewable
            />

            <flux:input
                wire:model="password_confirmation"
                id="password_confirmation"
                label="{{ __('Konfirmasi kata sandi') }}"
                type="password"
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
                <span wire:loading.remove wire:target="register">{{ __('Daftar & Ajukan Verifikasi') }}</span>
                <span wire:loading wire:target="register" class="inline-flex items-center gap-2">
                    <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                    </svg>
                    Memproses...
                </span>
            </button>
        </form>
    </div>

    {{-- Footer --}}
    <div class="flex flex-col gap-2 border-t border-zinc-200 bg-zinc-50 px-6 py-4 text-center text-sm text-zinc-600 dark:border-zinc-800 dark:bg-zinc-950/40 dark:text-zinc-400">
        <p>
            Sudah punya akun?
            <a
                href="{{ route('login') }}"
                wire:navigate
                class="font-semibold text-green-700 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300"
            >
                Masuk
            </a>
        </p>
        <a
            href="{{ route('register') }}"
            wire:navigate
            class="text-xs font-medium text-zinc-500 hover:text-green-700 dark:text-zinc-400 dark:hover:text-green-400"
        >
            &larr; Kembali
        </a>
    </div>
</div>