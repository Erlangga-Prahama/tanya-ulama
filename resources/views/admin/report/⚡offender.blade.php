<?php

use Livewire\Component;
use App\Models\Report;

new class extends Component
{
    public function render()
    {
        return $this->view([
            'reports' => Report::selectRaw('reported_user_id, COUNT(*) as total')
                ->where('status', 'approved')
                ->whereNotNull('reported_user_id')
                ->groupBy('reported_user_id')
                ->orderByDesc('total')
                ->with('reportedUser')
                ->get()
        ])->layout('layouts.app');
    }
};
?>

<div class="mx-3 mt-2">
    <flux:text variant="strong" class="font-bold mb-3">Pengguna Bermasalah.</flux:text>
    @foreach ($reports as $report)
        @php $user = $report->reportedUser @endphp
        @if ($user)
            <flux:card size="sm" class="mb-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <flux:text class="text-sm font-medium text-slate-800">{{ $user->name }}</flux:text>
                        <flux:text class="text-xs text-slate-500">{{ $user->email }}</flux:text>
                    </div>
                    <div class="ml-3 flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 text-sm font-bold">
                        {{ $report->total }}
                    </div>
                </div>
            </flux:card>
        @endif
    @endforeach
</div>