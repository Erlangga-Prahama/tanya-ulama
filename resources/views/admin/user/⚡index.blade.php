<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithPagination;

    public $deleteId = null;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $user = User::findOrFail($this->deleteId);
        $user->delete();
        $this->deleteId = null;
    }

    public function render()
    {
        return $this->view([
            'users' => User::role('user')
                ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%'))
                ->latest()
                ->paginate(8)
        ])->layout('layouts.app'); 
    }
};
?>

<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="lg">Daftar Pengguna</flux:heading>
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

    @if($users->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-700">Tidak ada pengguna</p>
            <p class="text-xs text-slate-400 mt-1">Belum ada pengguna yang terdaftar.</p>
        </div>
    @else
        <flux:table>
            <flux:table.rows>
                @foreach ($users as $u)
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex flex-col">
                                <flux:heading>{{ $u->name }}</flux:heading>
                                <flux:text class="max-sm:hidden">{{ $u->email }}</flux:text>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="flex justify-end items-center">
                                <flux:modal.trigger name="delete-user-modal">
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
        <div class="mt-3">{{ $users->links() }}</div>
    @endif

    <flux:modal name="delete-user-modal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus pengguna?</flux:heading>
                <flux:text class="mt-2">Anda yakin ingin menghapus pengguna ini?</flux:text>
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
</div>