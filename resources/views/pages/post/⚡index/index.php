<?php

use Livewire\Component;
use App\Models\Question;

new class extends Component
{
    public function render()
    {
        return $this->view(['questions' => Question::latest()->get()])
            ->layout('layouts::user'); 
    }
};