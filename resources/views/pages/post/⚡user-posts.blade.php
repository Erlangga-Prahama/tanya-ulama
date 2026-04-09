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

<div class="my-3 mx-2">
    @if ($questions->count() > 0)
        <flux:text variant="strong" class="font-bold mb-3">Pertanyaan anda</flux:text>
        @foreach ($questions as $q)        
            <a href="{{ route('post.show', $q) }}" aria-label="Latest on our blog">
                <flux:card size="sm" class="mb-2 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                    <flux:text class="text-slate-700">{!! $q->content !!}</flux:text>
                </flux:card>
            </a>
        @endforeach
        
    @else
        <div class="mx-auto font-bold text-lg">Belum ada pertanyaan</div>
    @endif
</div>