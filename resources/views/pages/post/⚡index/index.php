<?php

use Livewire\Component;
use App\Models\Question;

new class extends Component
{
    public function mount()
    {
        // Tandai notif sudah ditampilkan setelah pertama kali muncul
        if (auth()->user()->is_verified && !session()->has('verified_notif_shown')) {
            session(['show_verified_notif' => true]);
        }
    }

    public function render()
    {
        return $this->view(['questions' => Question::latest()->get()])
            ->layout('layouts::user'); 
    }
};