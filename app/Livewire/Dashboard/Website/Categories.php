<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

class Categories extends Component
{
    public function render()
    {
        return view('livewire.dashboard.website.categories')->layout('components.layouts.dashboards');
    }
}
