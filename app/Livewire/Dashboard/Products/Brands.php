<?php

namespace App\Livewire\Dashboard\Products;

use Livewire\Component;

class Brands extends Component
{
    public function render()
    {
        return view('livewire.dashboard.products.brands')->layout('components.layouts.dashboards');
    }
}
