<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use Livewire\Component;
use function Pest\Laravel\put;

class Products extends Component
{
    public $activeCategory = [];

    public $activeChild = [];
    public $activeFilter = [];

    public function categoryReset()
    {
        $this->activeCategory = [];
    }

    public function render()
    {
        $categories = Category::with('products','parent','children','filters')->where('field_id',3)->get();

        $maincat = Category::with('products','parent','children','filters')
            ->where('field_id',3)
            ->whereIn('id',$this->activeCategory)
            ->orWhereIn('parent_id',$this->activeCategory)
            ->get();

        if ($this->activeCategory)
        {
            $parent = $categories->whereIn('parent_id',$this->activeCategory);

            $products = Product::with('specification')->whereIn('category_id',$this->activeCategory)->get();

            $this->activeChild = Category::with('products','parent','children','filters')
                ->where('parent_id',$this->activeCategory)->pluck('id')->toArray();
        }
        else
        {
            $products = Product::with('specification')->get();

            $this->activeChild = [];
        }

        $filters = Filter::with('field','category','units')
            ->whereIn('category_id',$this->activeCategory)
            ->orWhereIn('category_id',$this->activeChild)
            ->get();

        return view('livewire.products', compact('products', 'categories', 'maincat','filters'));
    }
}
