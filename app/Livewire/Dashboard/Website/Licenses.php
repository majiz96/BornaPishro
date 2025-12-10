<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

class Licenses extends Component
{
    public function render()
    {
        return view('livewire.dashboard.website.licenses')->layout('components.layouts.dashboards');
    }
}
