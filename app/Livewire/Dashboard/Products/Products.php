<?php

namespace App\Livewire\Dashboard\Products;

use Livewire\Component;

class Products extends Component
{
    public function render()
    {
        return view('livewire.dashboard.products.products')->layout('components.layouts.dashboards');
    }
}
