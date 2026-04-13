
<div class="my-3 mx-2">
    <div class="rounded border bg-white py-3 px-2 shadow relative">
        
        <flux:modal.trigger name="edit-profile">
            <flux:button icon="exclamation-triangle" variant='ghost' icon:variant="outline" size="sm" square='true' class="absolute! right-0 top-0"></flux:button>
        </flux:modal.trigger>
        <div></div>
        <p class="text-slate-700 text-sm">{!! $question->content !!}</p>
        <p class="my-2 text-xs text-slate-600">{{ $question->created_at->diffForHumans() }}</p>
        @if (!$question->canBeAnswered())            
            <flux:separator/>
            <div>
                <div class="my-2 text-slate-800 font-semibold text-sm">Jawaban</div>
                <strong class="text-sm text-slate-800 font-semibold">Oleh {{$question->answered->user->roles->first()->name}} {{ $question->answered->user->name }}</strong>
                <div class="text-slate-700! text-sm">{!! $question->answered->content !!} </div> 
                <p class="mt-2 text-xs text-slate-600">{{ $question->answered_at->diffForHumans() }}</p>
            </div>
        @endif
    </div>

    <flux:modal name="edit-profile" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Update profile</flux:heading>
                <flux:text class="mt-2">Make changes to your personal details.</flux:text>
            </div>

            <flux:input label="Name" placeholder="Your name" />

            <flux:input label="Date of birth" type="date" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>
    

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


