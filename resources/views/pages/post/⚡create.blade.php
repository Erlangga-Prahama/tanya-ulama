<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts::user')] class extends Component
{
    //
};
?>

<div class="mt-4 mx-2">
    <h1>Buat Pertanyaan</h1>
   <livewire:rich-text-editor />
</div>
