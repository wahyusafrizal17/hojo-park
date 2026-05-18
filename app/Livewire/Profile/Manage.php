<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.hotel')]
#[Title('Profil')]
class Manage extends Component
{
    public function render()
    {
        return view('livewire.profile.manage');
    }
}
