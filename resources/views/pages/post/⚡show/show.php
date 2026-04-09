<?php

use Livewire\Component;
use App\Models\Question;

new class extends Component
{
    public $question;
    public $questionId;

    // public function mount(Question $question) {
    //     $this->question = $question;
    // }

    public function mount($id)
    {
        $this->questionId = $id;
        $this->question = Question::findOrFail($id);
    }

    public function answer()
    {
        
    }

    public function render()
        {
            return $this->view()
                ->layout('layouts::user'); 
        }
    };