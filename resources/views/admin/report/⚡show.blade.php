<?php

use Livewire\Component;
use App\Models\Report;
use Flux\Flux;

new class extends Component
{
    public $reportable_type;
    public $reportable_id;
    public $reports;
    public $content;

    public function mount($id)
    {
        $firstReport = Report::where('reportable_id', $id)->firstOrFail();
        
        $this->reportable_type = $firstReport->reportable_type;
        $this->reportable_id   = $id;

        $this->reports = Report::where('reportable_type', $this->reportable_type)
            ->where('reportable_id', $id)
            ->with('reporter')
            ->latest()
            ->get();

        $this->content = $firstReport->reportable;
    }

    public function accept()
    {
        // Tandai semua laporan sebagai approved
        Report::where('reportable_type', urldecode($this->reportable_type))
            ->where('reportable_id', $this->reportable_id)
            ->update([
                'status'      => 'approved',
                'resolved_at' => now(),
                'resolved_by' => auth()->id(),
            ]);

        // Hapus konten yang dilaporkan
        $this->content?->delete();

        Flux::toast('Laporan diterima, konten telah dihapus.', variant: 'success');

        $this->redirect(route('admin.reports'));
    }

    public function reject()
    {
        Report::where('reportable_type', urldecode($this->reportable_type))
            ->where('reportable_id', $this->reportable_id)
            ->update([
                'status'      => 'rejected',
                'resolved_at' => now(),
                'resolved_by' => auth()->id(),
            ]);

        Flux::toast('Laporan ditolak.', variant: 'success');

        $this->redirect(route('admin.reports'));
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts.app');
    }
};
?>

<div class="relative min-h-screen mx-3 mt-2">

    {{-- Konten yang dilaporkan --}}
    <flux:text class="text-xs text-slate-400 mb-1">
        {{ class_basename(urldecode($reportable_type)) }}
    </flux:text>

    <div class="rounded border bg-white pt-4 pb-3 px-4 mb-4 shadow">
        <flux:text variant="strong" class="text-sm font-semibold text-slate-700 mb-2">Konten yang dilaporkan</flux:text>
        <div class="text-slate-700 text-sm mt-1">
            {!! $content?->content !!}
        </div>
    </div>

    {{-- Daftar laporan --}}
    <flux:text variant="strong" class="font-bold mb-2 block">
        {{ $reports->count() }} Laporan
    </flux:text>

    @foreach ($reports as $report)
        <div class="rounded border bg-white px-4 py-3 mb-2 shadow">
            <div class="flex justify-between items-start">
                <div>
                    <flux:text class="text-sm font-medium text-slate-800">{{ $report->reporter->name }}</flux:text>
                    <flux:text class="text-xs text-slate-500">{{ $report->created_at->diffForHumans() }}</flux:text>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $report->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                    {{ $report->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $report->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                ">
                    {{ ucfirst($report->status) }}
                </span>
            </div>
            <flux:text class="text-sm text-slate-700 mt-2"><strong>Alasan:</strong> {{ $report->reason }}</flux:text>
            @if($report->description)
                <flux:text class="text-sm text-slate-600 mt-1">{{ $report->description }}</flux:text>
            @endif
        </div>
    @endforeach

    {{-- Popover pojok kanan bawah --}}
    <div class="fixed bottom-3 right-3 z-50" x-data="{ open: false }">
        <button
            @click="open = !open"
            class="bg-slate-500 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-slate-700 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
            </svg>
        </button>

        <div
            x-show="open"
            x-transition
            @click.outside="open = false"
            class="absolute bottom-14 right-0 bg-white rounded-xl shadow-xl border border-slate-200 p-4 w-30"
        >
            <button
                wire:click="accept"
                class="w-full mb-2 py-2 px-4 rounded-lg border-2 hover:bg-green-500 border-green-400 text-black text-sm font-medium transition"
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
</div>