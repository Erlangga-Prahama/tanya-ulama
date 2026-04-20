<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public function render()
    {
        return $this->view(['ustaz' => User::where('is_verified', 0)->role(['ustaz', 'ustazah'])->latest()->get()])
            ->layout('layouts.app'); 
    }
};