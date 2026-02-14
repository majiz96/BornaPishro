<?php

namespace App\Livewire\Dashboard\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Discounts extends Component
{
    public $discount;

    public function render()
    {
        $products = Product::with('category','brand')->where('price','>',0)->get();
        $categories = Category::where('field_id', 3)->get();
        return view('livewire.dashboard.products.discounts',compact('products','categories'))
            ->layout('components.layouts.dashboards');
    }
}
