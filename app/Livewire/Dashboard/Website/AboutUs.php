<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

class AboutUs extends Component
{
    public function render()
    {
        return view('livewire.dashboard.website.about-us')->layout('components.layouts.dashboards');
    }
}
