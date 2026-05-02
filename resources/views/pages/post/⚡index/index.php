<?php

use Livewire\Component;
use App\Models\Question;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function render()
    {
        return $this->view([
            'questions' => Question::where('is_answered', true)->latest()->paginate(10, ['*'], 'answered_page'),
            'questionsCanBeAnswered' => Question::where('is_answered', false)->latest()->paginate(10, ['*'], 'unanswered_page'),
        ])->layout('layouts::user'); 
    }
}