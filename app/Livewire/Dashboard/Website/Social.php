<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

class Social extends Component
{
    public function render()
    {
        return view('livewire.dashboard.website.social')->layout('components.layouts.dashboards');
    }
}
