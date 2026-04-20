<div class="flex flex-col h-screen">
    
    {{-- Konten yang bisa discroll --}}
    <div class="flex-1 overflow-y-auto mt-1 mb-2 mx-3">
        <flux:breadcrumbs class="mb-3 text-xs!">
            <flux:breadcrumbs.item href="{{route('posts.index')}}" class="text-xs!" icon:variant="outline" icon="chat-bubble-bottom-center-text"></flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-xs!">Pertanyaan</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="rounded border bg-white pt-6 pb-3 px-5 mb-2 shadow relative">
            @if(auth()->user()->hasAnyRole(['ustaz', 'ustazah']) && auth()->user()->is_verified)   
                <flux:modal.trigger name="edit-profile">
                    <flux:button icon="exclamation-triangle" tooltip="Laporkan pertanyaan" variant='ghost' icon:variant="outline" size="sm" square='true' class="absolute! right-0 top-0"></flux:button>
                </flux:modal.trigger>
            @endif
            <p class="text-slate-700 text-sm">{!! $question->content !!}</p>
            <p class="my-2 text-xs text-slate-600">{{ $question->created_at->diffForHumans() }}</p>
        </div>

        @if (!$question->canBeAnswered())            
            <div class="rounded border bg-white pt-6 pb-3 px-5 mb-2 shadow relative">
                <flux:modal.trigger name="edit-profile">
                    <flux:button icon="exclamation-triangle" tooltip="Laporkan jawaban" variant='ghost' icon:variant="outline" size="sm" square='true' class="absolute! right-0 top-0"></flux:button>
                </flux:modal.trigger>
                <strong class="text-sm text-slate-800 font-semibold mb-1">Oleh {{$question->answered->user->roles->first()->name}} {{ $question->answered->user->name }}</strong>
                <div class="text-slate-700! text-sm">{!! $question->answered->content !!}</div> 
                <p class="mt-2 text-xs text-slate-600">{{ $question->answered_at->diffForHumans() }}</p>
            </div>
        @endif

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
    </div>

    {{-- Form jawaban tetap menempel di bawah --}}
    @if ($question->canBeAnswered() && auth()->user()->hasAnyRole(['ustaz', 'ustazah']) && auth()->user()->is_verified)        
        <div class="mx-3 mb-2 flex-shrink-0">
            <flux:heading size="sm" class="mb-1">Jawab pertanyaan</flux:heading>
            <form wire:submit="answer">
                <input type="hidden" wire:model="content" id="quill-content" />
                <div id="quill-editor" style="min-height: 80px;" class="bg-white rounded border"></div>
                <flux:error name="content" />
                <flux:button type="submit" variant="primary" color="green" class="mt-1">Kirim</flux:button>
            </form>
        </div>
    @endif

</div>