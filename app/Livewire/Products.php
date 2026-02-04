<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use App\Models\SpecGroup;
use App\Models\SpecUnit;
use App\Models\SpecValue;

use Livewire\Component;
use Livewire\Attributes\Computed;

use function Pest\Laravel\put;

class Products extends Component
{
    public $activeCategory = [];

    public $activeChild = [];
    public $activeFilter = [];

    public $valueSearch;

    public $priceMax;
    public $priceMin;

    public function categoryReset()
    {
        $this->activeCategory = [];
    }

    public function updatedActiveCategory($value)
    {
        if($value)
        {
            if(!empty($this->activeCategory)) {
                $this->activeChild = Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray();
            }
        }
        else
        {
            $this->activeChild = [];
        }

    }

    #[Computed]
    public function categories()
    {
        $categories = Category::with('children.products.specification.group.units.values')
            ->where('field_id', 3)
            ->get();

        return $categories;
    }

    #[Computed]
    public function products()
    {
        $query = Product::query()->with('specification.group.units.values');

        $allCategories = array_merge($this->activeCategory, $this->activeChild);

        if(!empty($this->activeCategory))
        {
            $query->whereIn('category_id', $allCategories);
        }

        if(!empty($this->activeFilter))
        {
            $query->whereHas('specification.group.units.values', function($q){
                $q->whereIn('id', $this->activeFilter);
            });
        }

        return $query->get();
    }

    #[Computed]
    public function filters()
    {
        $allCategories = array_merge($this->activeCategory, $this->activeChild);

        $filters = Filter::with('category.products.specification.group.units.values')->whereIn('category_id',$allCategories)->get();

        if(empty($this->activeCategory))
        {
            $filters = Filter::with('category.products.specification.group.units.values')->where('field_id',3)->get();
        }

        return $filters;
    }

    public function render()
    {
        return view('livewire.products');
    }
}
