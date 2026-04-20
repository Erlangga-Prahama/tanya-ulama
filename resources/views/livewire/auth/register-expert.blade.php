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

<div class="flex flex-col gap-6">
    <x-auth-header 
        title="Daftar sebagai Ustaz / Ustazah" 
        description="Isi data diri dan unggah dokumen pendukung untuk verifikasi" 
    />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6" enctype="multipart/form-data">
        <!-- Name -->
        <div class="grid gap-2">
            <flux:input wire:model="name" id="name" label="{{ __('Nama Lengkap') }}" type="text" required autofocus placeholder="Nama lengkap sesuai ijazah" />
        </div>

        <!-- Email Address -->
        <div class="grid gap-2">
            <flux:input wire:model="email" id="email" label="{{ __('Email') }}" type="email" required placeholder="email@example.com" />
        </div>

        <!-- Gender Selection -->
        <div class="grid gap-2">
            <flux:label>{{ __('Jenis Kelamin') }}</flux:label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="radio" wire:model="gender" value="L" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Laki-laki</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" wire:model="gender" value="P" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span>Perempuan</span>
                </label>
            </div>
            @error('gender') 
                <span class="text-sm text-red-600">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Verification Document Upload -->
        <div class="grid gap-2">
            <flux:label>{{ __('Dokumen Verifikasi (Ijazah/Sertifikat)') }}</flux:label>
            <input 
                type="file" 
                wire:model="verification_document" 
                accept=".pdf,.jpg,.jpeg,.png"
                class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-zinc-50 file:text-zinc-700 hover:file:bg-zinc-100 dark:file:bg-zinc-800 dark:file:text-zinc-300"
            />
            @error('verification_document') 
                <span class="text-sm text-red-600">{{ $message }}</span> 
            @enderror
            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                Upload ijazah/sertifikat kompetensi (PDF/JPG/PNG, maks 2MB)
            </p>
        </div>

        <!-- Password -->
        <div class="grid gap-2">
            <flux:input wire:model="password" id="password" label="{{ __('Password') }}" type="password" required placeholder="Password" />
        </div>

        <!-- Confirm Password -->
        <div class="grid gap-2">
            <flux:input wire:model="password_confirmation" id="password_confirmation" label="{{ __('Konfirmasi Password') }}" type="password" required placeholder="Konfirmasi password" />
        </div>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Daftar & Ajukan Verifikasi') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Sudah punya akun?
        <x-text-link href="{{ route('login') }}">Masuk</x-text-link>
    </div>
    
    <div class="text-center text-sm">
        <x-text-link href="{{ route('register') }}">← Kembali</x-text-link>
    </div>
</div>