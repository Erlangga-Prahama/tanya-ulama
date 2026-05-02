<?php

use Livewire\Component;
use App\Models\Report;

new class extends Component
{

    public function render()
    {
        return $this->view([
            'reports' => Report::selectRaw('reportable_type, reportable_id, COUNT(*) as total')
            ->where('status', 'pending')
            ->groupBy('reportable_type', 'reportable_id')
            ->orderByDesc('total')
            ->with('reportable')
            ->get()
        ])->layout('layouts.app');
    }
};
?>

<div class="mx-3 mt-2">
    <flux:text variant="strong" class="font-bold mb-3">Laporan.</flux:text>

    @if($reports->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-700">Semua bersih!</p>
            <p class="text-xs text-slate-400 mt-1">Tidak ada laporan yang perlu ditinjau.</p>
        </div>
    @else
        @foreach ($reports as $report)
            <a href="{{ route('admin.reports.show', $report->reportable_id) }}">
                <flux:card size="sm" class="mb-2">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <flux:text class="text-xs text-slate-400 mb-1">
                                @if (class_basename($report->reportable_type) == 'Question')
                                    Pertanyaan
                                @else
                                    Jawaban
                                @endif
                            </flux:text>
                            <flux:text class="text-slate-700 text-sm line-clamp-2">
                                {!! $report->reportable?->content !!}
                            </flux:text>
                        </div>
                        <div class="ml-3 flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 text-sm font-bold">
                            {{ $report->total }}
                        </div>
                    </div>
                </flux:card>
            </a>
        @endforeach
    @endif
</div>