
<div class="my-3 mx-2">
    <div class="rounded border bg-white py-3 px-2 shadow">
        <p class="text-slate-700 text-sm">{!! $question->content !!}</p>
        <p class="mt-2 text-xs text-slate-600">Dibuat: {{ $question->created_at->diffForHumans() }}</p> 
    </div>

    @if ($question->canBeAnswered() && auth()->user()->hasAnyRole(['ustaz', 'ustazah']) && auth()->user()->is_verified)        
        <div class="absolute inset-x-2 bottom-2">
            <flux:heading size="">Jawab pertanyaan</flux:heading>
            <form wire:submit="answer">
                <input type="hidden" wire:model="content" id="quill-content" />
                <div id="quill-editor" style="min-height: 80px;" class="bg-white"></div>
                <flux:error name="content" />

                <flux:button wire:click="answer" variant="primary" color="green" class="mt-0.5">Kirim</flux:button>
            </form>
        </div>
    @endif
</div>
