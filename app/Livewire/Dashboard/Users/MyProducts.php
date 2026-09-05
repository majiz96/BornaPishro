<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class MyProducts extends Component
{
    public int $count = 1;

    public function deMark($id)
    {
        auth()->user()->SavedProducts()->detach($id);
    }

    #[Computed]
    public function MyProducts()
    {
        $saved = auth()->user()->SavedProducts()->pluck('product_id')->toArray();

        return Product::whereIn('id', $saved)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.users.my-products')->layout('components.layouts.dashboards');;
    }
}
