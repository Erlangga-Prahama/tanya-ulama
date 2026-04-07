<?php

use Livewire\Component;

new class extends Component
{
    public string $content = '';

    public function save()
    {
        $this->validate([
            'content' => 'required|string',
        ]);

    }

};
?>

<div>
    <input type="hidden" wire:model="content" id="quill-content" />

    <div id="quill-editor" class="min-h-24 bg-white"></div>

    <button wire:click="save" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
        simpan
    </button>
</div>