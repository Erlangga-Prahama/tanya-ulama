<?php

use Livewire\Component;
use App\Models\Question;
use App\Models\Report;
use App\Models\User;

new class extends Component
{
    public function render()
    {
        return $this->view([
            'totalQuestions' => Question::count(),
            'totalUstaz'     => User::where('is_verified', true)->count(),
            'totalUsers'     => User::count(),
            'pendingReports' => Report::selectRaw('reportable_type, reportable_id, COUNT(*) as total')
                                ->where('status', 'pending')
                                ->groupBy('reportable_type', 'reportable_id')
                                ->with('reportable')
                                ->orderByDesc('total')
                                ->limit(5)
                                ->get(),
            'pendingUstaz'   => User::where('is_verified', false)
                                ->whereHas('roles', fn($q) => $q->whereIn('name', ['ustaz', 'ustazah']))
                                ->with('roles')
                                ->limit(5)
                                ->get(),
        ])->layout('layouts.app');
    }
};
?>

<div class="p-4 flex flex-col gap-4">

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-4">
            <p class="text-xs text-slate-500 mb-1">Total Pertanyaan</p>
            <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalQuestions }}</p>
        </div>
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-4">
            <p class="text-xs text-slate-500 mb-1">Total Ustaz</p>
            <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalUstaz }}</p>
        </div>
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-4">
            <p class="text-xs text-slate-500 mb-1">Total User</p>
            <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalUsers }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-4">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-4 bg-red-400 rounded-full"></div>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Laporan Pending</p>
                <a href="{{ route('admin.reports') }}" class="ml-auto text-xs text-green-600 hover:underline">Lihat semua</a>
            </div>
            @forelse($pendingReports as $report)
                <a href="{{ route('admin.reports.show', $report->reportable_id) }}" class="block py-2 border-b border-slate-50 dark:border-zinc-700 last:border-0 hover:bg-slate-50 dark:hover:bg-zinc-700 rounded px-2 transition">
                    <p class="text-sm text-slate-700 dark:text-slate-300 line-clamp-1">{!! strip_tags($report->reportable?->content) !!}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $report->total }} laporan · {{ class_basename($report->reportable_type) === 'Question' ? 'Pertanyaan' : 'Jawaban' }}</p>
                </a>
            @empty
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400">Tidak ada laporan pending.</p>
                </div>
            @endforelse
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-4">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-4 bg-amber-400 rounded-full"></div>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Menunggu Verifikasi</p>
                <a href="{{ route('admin.ustaz-verification') }}" class="ml-auto text-xs text-green-600 hover:underline">Lihat semua</a>
            </div>
            @forelse($pendingUstaz as $u)
                <a href="{{ route('admin.ustaz-verification-show', $u) }}" class="flex items-center gap-3 py-2 border-b border-slate-50 dark:border-zinc-700 last:border-0 hover:bg-slate-50 dark:hover:bg-zinc-700 rounded px-2 transition">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-semibold text-green-600">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-700 dark:text-slate-300 capitalize">{{ $u->roles->first()?->name }} {{ $u->name }}</p>
                        <p class="text-xs text-slate-400">{{ $u->email }}</p>
                    </div>
                </a>
            @empty
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400">Semua sudah terverifikasi.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>