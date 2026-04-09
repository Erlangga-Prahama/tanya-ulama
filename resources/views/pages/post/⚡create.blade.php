<?php

use Livewire\Component;
use Livewire\Attributes\Validate; 
use Livewire\Attributes\Layout;
use App\Models\Question;

new #[Layout('layouts::user')] class extends Component
{

    #[Validate('required')]
    public $content = '';

    public function save()
    {
        $this->validate();

        Question::create([
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        return  $this->redirect('/posts/index', navigate: true);
    }
};
?>

<div class="my-3 mx-2">
    <h1 class="font-bold text-xl">Buat pertanyaan</h1>
    <form wire:submit="save">
        <flux:field class="mt-3">
            <flux:label>Pertanyaan</flux:label>
            <flux:textarea wire:model="content" class="" />
            {{-- <input type="hidden" wire:model="content" id="quill-content" />
            <div id="quill-editor" style="min-height: 200px;" class="bg-white rounded border"></div>
            <flux:error name="content" /> --}}
        </flux:field>

        <flux:button wire:click="save" variant="primary" color="blue" class="mt-3">Buat</flux:button>
    </form>
</div>
