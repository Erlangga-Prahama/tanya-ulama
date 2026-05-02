<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public $ustaz = '';
    public $pdfBase64 = null;

    public function mount($id)
    {
        $this->ustaz = User::findOrFail($id);

        if ($this->ustaz->verification_document) {
            $ext = pathinfo($this->ustaz->verification_document, PATHINFO_EXTENSION);
            if ($ext === 'pdf') {
                $path = storage_path('app/public/' . $this->ustaz->verification_document);
                if (file_exists($path)) {
                    $this->pdfBase64 = base64_encode(file_get_contents($path));
                }
            }
        }
    }

    public function accept()
    {
        $this->ustaz->update([
            'is_verified' => true,
            'verified_at' => now(),
            ]);
        $this->redirect(route('admin.ustaz-verification'));
    }

    public function reject()
    {
        $this->ustaz->update(['is_verified' => false]);
        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts.app');
    }
};
?>

<div class="relative min-h-screen">
    <flux:breadcrumbs class="mb-2 text-xs!">
        <flux:breadcrumbs.item href="{{route('admin.ustaz-verification')}}" class="text-xs!" icon:variant="outline" icon="check-badge"></flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-xs! capitalize">{{ $ustaz->roles->first()->name }} {{$ustaz->name}}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="rounded w-full shadow py-3 px-2 mb-2">
        @if($ustaz->verification_document)
            @php
                $ext = pathinfo($ustaz->verification_document, PATHINFO_EXTENSION);
            @endphp

            @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                <img src="{{ Storage::url($ustaz->verification_document) }}" alt="Dokumen Verifikasi" class="w-fit">
            @elseif($ext === 'pdf')
                <div id="pdf-container" class="w-full bg-gray-100 rounded space-y-2 p-2"></div>
                <script>
                    window.__PDF_BASE64__ = "{{ $pdfBase64 }}";
                </script>
            @endif
        @else
            <p class="text-slate-500 text-sm">Tidak ada dokumen verifikasi.</p>
        @endif
    </div>

    @if (!$ustaz->is_verified)        
        {{-- Popover pojok kanan bawah --}}
        <div class="fixed bottom-3 right-3 z-50" x-data="{ open: false }">

            {{-- Tombol toggle --}}
            <button
                @click="open = !open"
                class="bg-slate-500 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-slate-700 transition"
            >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
            </svg>

            </button>

            {{-- Popover box --}}
            <div
                x-show="open"
                x-transition
                @click.outside="open = false"
                class="absolute bottom-14 right-0 bg-white rounded-xl shadow-xl border border-slate-200 p-4 w-30"
            >


                <button
                    wire:click="accept"
                    class="w-full mb-2 py-2 px-4 rounded-lg border-2 hover:bg-green-500 border-green-400 hover:bg-green-600 text-black text-sm font-medium transition"
                >
                    Terima
                </button>

                <button
                    wire:click="reject"
                    class="w-full py-2 px-4 rounded-lg border-2 border-red-400 hover:bg-red-600 text-black text-sm font-medium transition"
                >
                    Tolak
                </button>
            </div>
        </div>
    @endif
</div>