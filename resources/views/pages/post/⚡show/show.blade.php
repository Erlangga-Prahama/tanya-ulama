<div class="flex flex-col" style="height: calc(100vh - 56px);">
    
    {{-- Konten yang bisa discroll --}}
    <div class="flex-1 overflow-y-auto mt-1 mb-2 mx-3">
        <flux:breadcrumbs class="mb-3 text-xs!">
            <flux:breadcrumbs.item href="{{route('posts.index')}}" class="text-xs!" icon:variant="outline" icon="chat-bubble-bottom-center-text"></flux:breadcrumbs.item>
            <flux:breadcrumbs.item class="text-xs!">Pertanyaan</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="rounded border bg-white pt-6 pb-3 px-5 mb-2 shadow relative">
            @if(auth()->user()->isExpert())   
                <flux:modal.trigger name="report-question">
                    <flux:button icon="exclamation-triangle" :disabled="$alreadyReportedQuestion" tooltip="Laporkan pertanyaan" variant='ghost' icon:variant="outline" size="sm" square='true' class="absolute! right-0 top-0"></flux:button>
                </flux:modal.trigger>
            @endif
            <p class="text-slate-700 text-sm">{!! $question->content !!}</p>
            <p class="my-2 text-xs text-slate-600">{{ $question->created_at->diffForHumans() }}</p>
        </div>

        @if (!$question->canBeAnswered())            
            <div class="rounded border bg-white pt-6 pb-3 px-5 mb-2 shadow relative">
                @if(auth()->user()->isExpert())
                    <flux:modal.trigger name="report-answer">
                        <flux:button icon="exclamation-triangle" :disabled="$alreadyReportedAnswer" tooltip="Laporkan jawaban" variant='ghost' icon:variant="outline" size="sm" square='true' class="absolute! right-0 top-0"></flux:button>
                    </flux:modal.trigger>
                @endif
                <strong class="text-sm text-slate-800 font-semibold mb-1">Oleh {{$question->answered->user->roles->first()->name}} {{ $question->answered->user->name }}</strong>
                <div class="text-slate-700! text-sm">{!! $question->answered->content !!}</div> 
                <p class="mt-2 text-xs text-slate-600">{{ $question->answered_at->diffForHumans() }}</p>
            </div>
        @endif
        
        <flux:modal name="report-question" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Laporkan pertanyaan</flux:heading>
                </div>
                <form wire:submit="reportQuestion">
                    <flux:input label="Alasan" placeholder="" wire:model="reason" />
                    <flux:textarea
                        label="Deskripsi"
                        placeholder=""
                        wire:model="description"
                    />
                    <div class="flex">
                        <flux:spacer />
                        <flux:button type="submit" variant="primary">Laporkan</flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>

        <flux:modal name="report-answer" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Laporkan jawaban</flux:heading>
                </div>
                <form wire:submit="reportAnswer">
                    <flux:input label="Alasan" placeholder="" wire:model="reason" />
                    <flux:textarea label="Deskripsi" placeholder="" wire:model="description" />
                    <div class="flex">
                        <flux:spacer />
                        <flux:button type="submit" variant="primary">Laporkan</flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>
    </div>

    {{-- Form jawaban tetap menempel di bawah --}}
    @if ($question->canBeAnswered() && auth()->user()->isExpert())        
        <div class="mx-3 mb-2 flex-shrink-0">
            <form wire:submit="answer">
                <input type="hidden" wire:model="content" id="quill-content" />
                <div class="rounded-xl border border-slate-300 bg-white shadow-sm overflow-hidden">
                    <div id="quill-editor" class="bg-white px-1" style="min-height: 80px;"></div>
                    <flux:error name="content" class="px-3" />
                    <div class="flex justify-between items-center px-3 py-2 border-t border-slate-100">
                        <span class="text-xs text-slate-400">Jawab dengan bijak</span>
                        <flux:button icon="paper-airplane" variant="primary" size="xs" type="submit" color="emerald"></flux:button>
                    </div>
                </div>
            </form>
        </div>
    @endif


</div>