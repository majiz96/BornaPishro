<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Articles extends Component
{
    public function render()
    {
        return view('livewire.dashboard.articles')->layout('components.layouts.dashboards');
    }
}
