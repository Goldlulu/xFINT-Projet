<?php

namespace App\Livewire\Users;

use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.users.user-profile')
            ->layout('layouts.app');
    }
}
