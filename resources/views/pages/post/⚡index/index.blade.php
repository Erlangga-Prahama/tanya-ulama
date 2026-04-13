
<div class="mt-4 mx-2">
    @if ($questions->count() > 0)
    <flux:text variant="strong" class="font-bold mb-3">Pertanyaan yang sudah dijawab</flux:text>
        @foreach ($questions as $q)        
            <a href="{{ route('post.show', $q) }}" aria-label="Latest on our blog">
                <flux:card size="sm" class="mb-2 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                    <flux:text class="text-slate-700">{!! $q->short_content !!}</flux:text>
                </flux:card>
            </a>
        @endforeach
        
    @else
        <div class="mx-auto font-bold text-lg">Belum ada pertanyaan</div>
    @endif
</div>