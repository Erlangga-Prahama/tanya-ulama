<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads, WithPagination;

    public $deleteId = null;

    public $name = '';
    public $email = '';
    public $gender = '';
    public $password = '';
    public $password_confirmation = '';
    public $verification_document = null;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function add()
    {
        $this->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'gender'                => ['required', 'in:L,P'],
            'password'              => ['required', 'confirmed', Password::defaults()],
            'verification_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $documentPath = $this->verification_document->store('verification-documents', 'public');
        $role = $this->gender === 'L' ? 'ustaz' : 'ustazah';

        $user = User::create([
            'name'                  => $this->name,
            'email'                 => $this->email,
            'gender'                => $this->gender,
            'password'              => Hash::make($this->password),
            'profession'            => $role,
            'verification_document' => $documentPath,
            'is_verified'           => true,
            'verified_at'           => now(),
        ]);

        $user->assignRole($role);

        $this->reset(['name', 'email', 'gender', 'password', 'password_confirmation', 'verification_document']);

        Flux::modal('tambah-ustaz')->close();
        Flux::toast('Ustaz/Ustazah berhasil ditambahkan.', variant: 'success');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        $user = User::findOrFail($this->deleteId);

        if ($user->verification_document) {
            Storage::disk('public')->delete($user->verification_document);
        }

        $user->delete();
        $this->deleteId = null;
    }

    public function render()
    {
        return $this->view([
            'ustaz' => User::where('is_verified', true)
                ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%'))
                ->latest()
                ->paginate(8)
        ])->layout('layouts.app'); 
    }
};