<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="lg">Daftar ustaz dan ustazah</flux:heading>
        <flux:modal.trigger name="add-ustaz-modal">
            <flux:button size="sm" icon="plus">Tambah</flux:button>
        </flux:modal.trigger>
    </div>
    
    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-3 py-2 shadow-sm mb-4">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
        </svg>
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Cari nama atau email..."
            class="text-sm text-slate-700 placeholder-slate-400 outline-none bg-transparent flex-1"
        />
        @if($search)
            <button wire:click="$set('search', '')" class="text-slate-300 hover:text-slate-500 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
    
    <flux:table>
        <flux:table.rows>
                @foreach ($ustaz as $u)
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex items-center gap-2 sm:gap-4">
                                <div class="flex flex-col">
                                    <flux:heading class="capitalize">{{ $u->roles->first()->name }} {{ $u->name }}</flux:heading>
                                    <flux:text class="max-sm:hidden">{{ $u->email }}</flux:text>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex justify-end items-center">
                                <flux:tooltip content="Dokumen pendidikan">
                                    <flux:button as="a" :href="route('admin.ustaz-verification-show', $u)" size="sm" variant="subtle" icon="document-text" class="shrink-0" />
                                </flux:tooltip>
                                <flux:modal.trigger name="delete-modal">
                                    <flux:tooltip content="Hapus">
                                        <flux:button wire:click="confirmDelete({{ $u->id }})" as="button" size="xs" variant="primary" color="rose" icon="trash" class="shrink-0" />
                                    </flux:tooltip>
                                </flux:modal.trigger>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
    </flux:table>
    <div class="mt-3">{{ $ustaz->links() }}</div>

    <flux:modal name="delete-modal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus ustaz?</flux:heading>
                <flux:text class="mt-2">
                    Anda yakin?<br>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>

                <flux:button wire:click="delete" variant="danger">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="add-ustaz-modal" class="md:w-106">
        <div class="space-y-6 p-4">
            <flux:heading size="lg">Tambah Ustaz/Ustazah</flux:heading>
            <form wire:submit="add" class="flex flex-col gap-6" enctype="multipart/form-data">

                <div class="grid gap-2">
                    <flux:input wire:model="name" id="name" label="{{ __('Nama Lengkap') }}" type="text" required autofocus placeholder="Nama lengkap sesuai ijazah" />
                </div>

                <div class="grid gap-2">
                    <flux:input wire:model="email" id="email" label="{{ __('Email') }}" type="email" required placeholder="email@example.com" />
                </div>

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
                    <flux:button type="submit" variant="primary" color="emerald" class="w-full">
                        {{ __('Tambah') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>