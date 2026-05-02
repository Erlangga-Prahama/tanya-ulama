<?php

use Livewire\Component;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;

new class extends Component
{
    public $query = '';

    public function render()
    {
        $questions = collect();
        $ustaz = collect();

        if (strlen($this->query) >= 2) {
            $questions = Question::where('content', 'like', '%' . $this->query . '%')
                ->where('is_answered', true)
                ->limit(5)
                ->get();

            $ustaz = User::where('name', 'like', '%' . $this->query . '%')
                ->whereHas('roles', fn($q) => $q->whereIn('name', ['ustaz', 'ustazah']))
                ->where('is_verified', true)
                ->limit(5)
                ->get();
        }

        return $this->view(compact('questions', 'ustaz'));
    }
};
?>

<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-2 py-1.5 shadow-sm">
        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
        </svg>
        <input
            type="text"
            wire:model.live.debounce.300ms="query"
            @focus="open = true"
            placeholder="Cari pertanyaan atau ustaz..."
            class="text-sm text-slate-700 placeholder-slate-400 outline-none bg-transparent w-52"
        />
        @if($query)
            <button wire:click="$set('query', '')" class="text-slate-300 hover:text-slate-500 transition">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    {{-- Dropdown hasil --}}
    @if($query && strlen($query) >= 2)
        <div
            x-show="open"
            class="absolute top-full mt-2 left-0 w-80 bg-white border border-slate-100 rounded-xl shadow-xl z-50 overflow-hidden"
        >
            {{-- Pertanyaan --}}
            @if($questions->count())
                <div class="px-3 pt-3 pb-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Pertanyaan</p>
                    @foreach($questions as $q)
                        <a href="{{ route('post.show', $q) }}" class="block px-2 py-2 rounded-lg hover:bg-slate-50 transition">
                            <p class="text-sm text-slate-700 line-clamp-1">{!! $q->short_content !!}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $q->created_at->diffForHumans() }}</p>
                        </a>
                    @endforeach
                </div>
                <div class="border-t border-slate-50"></div>
            @endif

            {{-- Ustaz --}}
            @if($ustaz->count())
                <div class="px-3 py-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2 mt-2">Ustaz / Ustazah</p>
                    @foreach($ustaz as $u)
                        <div class="flex items-center gap-2 px-2 py-2 rounded-lg hover:bg-slate-50 transition">
                            <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-semibold text-green-600">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm text-slate-700">{{ $u->name }}</p>
                                <p class="text-xs text-slate-400">{{ $u->roles->first()->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Tidak ada hasil --}}
            @if($questions->isEmpty() && $ustaz->isEmpty())
                <div class="px-4 py-6 text-center text-sm text-slate-400">
                    Tidak ada hasil untuk "{{ $query }}"
                </div>
            @endif
        </div>
    @endif
</div>