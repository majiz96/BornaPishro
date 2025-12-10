<?php

namespace App\Livewire\Dashboard\Users;

use Livewire\Component;

class EditProfile extends Component
{
    public function render()
    {
        return view('livewire.dashboard.users.edit-profile')->layout('components.layouts.dashboards');
    }
}
