<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts::user')] class extends Component
{
    public $questions = '';

    public function mount() 
    {
        $this->questions = Auth::user()->questions()->latest()->get();
    }
};
?>

<div class="mx-4 mt-6">
    @if ($questions->count() > 0)
        <div class="flex items-center gap-2 mb-4">
            <div class="w-1 h-4 bg-green-500 rounded-full"></div>
            <p class="text-sm font-semibold text-slate-700">Pertanyaan Anda</p>
            <span class="ml-auto text-xs font-medium text-green-600 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">
                {{ $questions->count() }}
            </span>
        </div>

        <div class="space-y-2">
            @foreach ($questions as $q)
                <a href="{{ route('post.show', $q) }}" class="block group">
                    <div class="bg-white border border-slate-100 rounded-xl px-4 py-3 shadow-sm group-hover:border-green-200 group-hover:shadow-md transition-all duration-200">
                        <p class="text-sm text-slate-700 line-clamp-2 leading-relaxed">{!! $q->content !!}</p>
                        <div class="flex items-center gap-1.5 mt-2">
                            @if($q->is_answered)
                                <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                                <p class="text-xs text-slate-400">Sudah dijawab · {{ $q->answered_at->diffForHumans() }}</p>
                            @else
                                <div class="w-1.5 h-1.5 rounded-full bg-amber-400"></div>
                                <p class="text-xs text-slate-400">Menunggu jawaban · {{ $q->created_at->diffForHumans() }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                </svg>
            </div>
            <p class="text-sm font-semibold text-slate-700 mb-1">Belum ada pertanyaan</p>
            <p class="text-xs text-slate-400 mb-6 max-w-xs">Jangan ragu untuk bertanya. Semua pertanyaan bersifat anonim dan akan dijawab oleh ustaz/ustazah terpercaya.</p>
            
            <a    href="{{ route('posts.create') }}"
                class="flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-xl transition"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Pertanyaan
            </a>
        </div>
    @endif
</div>