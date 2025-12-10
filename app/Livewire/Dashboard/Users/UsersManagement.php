<?php

namespace App\Livewire\Dashboard\Users;

use Livewire\Component;

class UsersManagement extends Component
{
    public function render()
    {
        return view('livewire.dashboard.users.users-management')->layout('components.layouts.dashboards');
    }
}
