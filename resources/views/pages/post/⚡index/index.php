<?php

use Livewire\Component;
use App\Models\Question;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage('answered_page');
        $this->resetPage('unanswered_page');
    }

    public function render()
    {
        $query = Question::latest();

        if ($this->search) {
            $query->where('content', 'like', '%' . $this->search . '%');
        }

        return $this->view([
            'questions' => (clone $query)->where('is_answered', true)->paginate(8, ['*'], 'answered_page'),
            'questionsCanBeAnswered' => (clone $query)->where('is_answered', false)->paginate(8, ['*'], 'unanswered_page'),
        ])->layout('layouts::user'); 
    }
};