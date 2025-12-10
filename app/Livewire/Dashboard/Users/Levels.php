<?php

namespace App\Livewire\Dashboard\Users;

use Livewire\Component;

class Levels extends Component
{
    public function render()
    {
        return view('livewire.dashboard.users.levels')->layout('components.layouts.dashboards');
    }
}
