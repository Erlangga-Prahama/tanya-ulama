<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public $deleteId = null;

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        User::findOrFail($this->deleteId)->delete();
        $this->deleteId = null;
    }

    public function render()
    {
        return $this->view(['ustaz' => User::where('is_verified', true)->latest()->get()])
            ->layout('layouts.app'); 
    }
};