<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use App\Models\Specification;
use App\Models\SpecGroup;
use App\Models\SpecUnit;
use App\Models\SpecValue;


use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

use function Pest\Laravel\put;

class Products extends Component
{
    public $activeCategory = [];

    public $activeChild = [];
    public $activeFilter = [];

    public $valueSearch;

    public $priceCheck = false;
    public $priceMax;
    public $priceMin;

    public $priceLimits = [];

    public function mount()
    {

        $specs = Specification::query()
            ->whereNotNull('price')
            ->get();

        $this->priceLimits = [
            'min' => $specs->min('price'),
            'max' => $specs->max('price'),
        ];

        $this->priceMin = $this->priceLimits['min'];
        $this->priceMax = $this->priceLimits['max'];
    }
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

    public function togglePrice()
    {
        $this->priceCheck = !$this->priceCheck;
    }

    #[Computed]
    public function categories()
    {
        $categories = Category::with('children.products.specifications.group.units.values')
            ->where('field_id', 3)
            ->get();

        return $categories;
    }

    #[Computed]
    public function products()
    {
        $query = Product::query()->with('specifications.group.units.values');

        $allCategories = array_merge($this->activeCategory, $this->activeChild);

        if(!empty($this->activeCategory))
        {
            $query->whereIn('category_id', $allCategories);
        }

        if(!empty($this->activeFilter))
        {
            $query->whereHas('specifications.group.units.values', function($q){
                $q->whereIn('id', $this->activeFilter);
            });
        }

        return $query->get()->filter(function ($product) {

            // قیمت‌های محصول
            $prices = $product->specifications->pluck('price')->filter();

            // اگر priceCheck خاموش باشد → همه محصولات را نشان بده
            if (!$this->priceCheck) {
                return true;
            }

            // اگر محصول قیمت ندارد → وقتی priceCheck روشن است، نباید نمایش داده شود
            if ($prices->isEmpty()) {
                return false;
            }

            // فیلتر قیمت
            $min = $prices->min();
            $max = $prices->max();

            return $min >= $this->priceMin && $max <= $this->priceMax;
        });


    }

    #[On('updatePriceRange')]
    public function updatePriceRange($data)
    {
        $this->priceMin = $data['min'];
        $this->priceMax = $data['max'];
    }

    #[Computed]
    public function filters()
    {
        $allCategories = array_merge($this->activeCategory, $this->activeChild);

        $filters = Filter::with('category.products.specifications.group.units.values')->whereIn('category_id',$allCategories)->get();

        if(empty($this->activeCategory))
        {
            $filters = Filter::with('category.products.specifications.group.units.values')->where('field_id',3)->get();
        }

        return $filters;
    }

    public function render()
    {
        return view('livewire.products');
    }
}
