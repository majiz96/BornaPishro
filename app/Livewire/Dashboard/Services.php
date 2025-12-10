<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Services extends Component
{
    public function render()
    {
        return view('livewire.dashboard.services')->layout('components.layouts.dashboards');
    }
}
