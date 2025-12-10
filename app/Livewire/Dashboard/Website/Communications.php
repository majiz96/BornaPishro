<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

class Communications extends Component
{
    public function render()
    {
        return view('livewire.dashboard.website.communications')->layout('components.layouts.dashboards');
    }
}
