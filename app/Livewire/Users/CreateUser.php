<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends Component
{
    public $email;
    public $role;

    // Variables pour le modal de succès
    public $showSuccessModal = false;
    public $temporaryPassword = null;

    protected $rules = [
        'email' => 'required|email|unique:users',
        'role' => 'required|in:employee,manager,accounting'
    ];

    public function createUser()
    {
        $this->validate();

        $this->temporaryPassword = Str::random(10);

        // Utiliser l'email comme nom par défaut
        $user = User::create([
            'name' => $this->email, // Nom = email par défaut
            'email' => $this->email,
            'password' => Hash::make($this->temporaryPassword),
            'email_verified_at' => now(),
            'must_change_password' => true,
        ]);

        $user->assignRole($this->role);

        // Afficher le modal de succès
        $this->showSuccessModal = true;

        // Réinitialiser le formulaire
        $this->reset(['email', 'role']);
    }

    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
        $this->temporaryPassword = null;
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        $newPassword = Str::random(10);

        $user->update([
            'password' => Hash::make($newPassword),
            'must_change_password' => true,
        ]);

        $this->temporaryPassword = $newPassword;
        $this->showSuccessModal = true;

        session()->flash('message', "Mot de passe réinitialisé pour {$user->name}");
    }

    public function render()
    {
        return view('livewire.users.create-user', [
            'users' => User::with('roles')->latest()->get()
        ])->layout('layouts.app');
    }
}
