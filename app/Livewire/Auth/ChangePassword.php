<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
        'new_password_confirmation' => 'required',
    ];

    protected $messages = [
        'current_password.required' => 'Le mot de passe actuel est requis.',
        'new_password.required' => 'Le nouveau mot de passe est requis.',
        'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
        'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
    ];

    public function changePassword()
    {
        $this->validate();

        // Vérifier le mot de passe actuel
        if (!Hash::check($this->current_password, auth()->user()->password)) {
            $this->addError('current_password', 'Le mot de passe actuel est incorrect.');
            return;
        }

        // Mettre à jour le mot de passe
        auth()->user()->update([
            'password' => Hash::make($this->new_password),
            'must_change_password' => false, // Plus besoin de changer
        ]);

        session()->flash('message', 'Mot de passe changé avec succès!');

        // Rediriger vers le dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.change-password')
            ->layout('layouts.guest'); // Layout pour les pages d'authentification
    }
}
