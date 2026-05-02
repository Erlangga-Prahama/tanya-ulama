<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Question;
use App\Models\Answer;
use Flux\Flux;

new class extends Component
{
    public $question;
    public $questionId;
    public $description = '';
    public $reason = '';

    public $alreadyReportedQuestion = false;
    public $alreadyReportedAnswer = false;

    #[Validate('required')]
    public $content = '';


    // public function mount(Question $question) {
    //     $this->question = $question;
    // }

    public function mount($id)
    {
        $this->questionId = $id;
        $this->question = Question::findOrFail($id);

        $this->alreadyReportedQuestion = $this->question->reports()
        ->where('reporter_id', auth()->id())
        ->exists();

        

        if (!$this->question->canBeAnswered()) {
            $this->alreadyReportedAnswer = $this->question->answered->reports()
                ->where('reporter_id', auth()->id())
                ->exists();
        }
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

    public function reportQuestion()
    {
        $this->validate([
            'reason' => 'required',
            'description' => 'nullable|string',
        ]);

        $this->question->reports()->create([
            'reporter_id'      => auth()->id(),
            'reported_user_id' => $this->question->user_id, // tambah ini
            'reason'           => $this->reason,
            'description'      => $this->description,
        ]);

        $this->reason = '';
        $this->description = '';

        Flux::modal('report-question')->close();
        Flux::toast('Laporan berhasil dikirim', variant: 'success');
    }

    public function reportAnswer()
    {
        $this->validate([
            'reason' => 'required',
            'description' => 'nullable|string',
        ]);

        $answer = $this->question->answered;

        $answer->reports()->create([
            'reporter_id'      => auth()->id(),
            'reported_user_id' => $answer->user_id,
            'reason'           => $this->reason,
            'description'      => $this->description,
        ]);

        $this->reason = '';
        $this->description = '';

        Flux::modal('report-answer')->close();
        Flux::toast('Laporan berhasil dikirim', variant: 'success');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::user'); 
    }
};