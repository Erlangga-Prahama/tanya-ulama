<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Question;
use App\Models\Answer;

new class extends Component
{
    public $question;
    public $questionId;

    #[Validate('required')]
    public $content = '';

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
        $this->validate();

        Answer::create([
            'question_id' => $this->questionId,
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        $this->question->markAsAnswered(auth()->user());

        $this->redirectRoute('post.show', ['id' => $this->questionId]);
    }

    public function render()
        {
            return $this->view()
                ->layout('layouts::user'); 
        }
    };