
<div class="mt-4 mx-2">
    <flux:text variant="strong" class="font-bold mb-3">Pertanyaa yang sudah dijawab</flux:text>
    @foreach ($questions as $q)        
        <a href="{{ route('post.show', $q) }}" aria-label="Latest on our blog">
            <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                <flux:heading class="flex items-center gap-2">{!! $q->title !!} <flux:icon name="arrow-up-right" class="ml-auto text-zinc-400" variant="micro" /></flux:heading>
                <flux:text class="mt-2">{!! $q->content !!}</flux:text>
            </flux:card>
        </a>
    @endforeach
</div>