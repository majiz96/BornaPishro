<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

class Info extends Component
{
    public function render()
    {
        return view('livewire.dashboard.website.info')->layout('components.layouts.dashboards');
    }
}
