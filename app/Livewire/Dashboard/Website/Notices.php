<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

class Notices extends Component
{
    public function render()
    {
        return view('livewire.dashboard.website.notices')->layout('components.layouts.dashboards');
    }
}
