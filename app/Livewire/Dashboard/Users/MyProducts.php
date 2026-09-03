<?php

namespace App\Livewire\Dashboard\Users;

use Livewire\Component;

class MyProducts extends Component
{
    public function render()
    {
        return view('livewire.dashboard.users.my-products')->layout('components.layouts.dashboards');;
    }
}
