<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use App\Models\Specification;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Products extends Component
{
    public array $activeCategory = [];
    public array $activeFilter = [];
    public bool $priceCheck = false;
    public int $priceMin = 0;
    public int $priceMax = 1000000000;

    public function mount()
    {
        // مقداردهی اولیه با محدوده کل محصولات
        $this->priceMin = (int) Product::get()->min('min_price') ?? 0;
        $this->priceMax = (int) Product::get()->max('max_price') ?? 1000000000;

    }

    #[Computed]
    public function categories()
    {
        return Category::with('children')
            ->where('field_id', 3)
            ->get();
    }

    #[Computed]
    public function products()
    {
        $query = Product::query()->with('specifications');

        // دسته‌بندی
        $allCategories = array_merge(
            $this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray()
        );

        if (!empty($allCategories)) {
            $query->whereIn('category_id', $allCategories);
        }

        // فیلترها
        if (!empty($this->activeFilter)) {
            $query->whereHas('specifications.group.units.values', function($q) {
                $q->whereIn('id', $this->activeFilter);
            });
        }

       $products = $query->get();

        return $products->filter(function ($product) {

            if(!$product->has_price){
                return !$this->priceCheck;
            }

            return $product->isInPriceRange($this->priceMin, $this->priceMax);
        });
    }

    #[Computed]
    public function filters()
    {
        $allCategories = array_merge(
            $this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray()
        );

        if (empty($allCategories)) {
            return Filter::with('units.values')
                ->where('field_id', 3)
                ->where('show',1)
                ->get();
        }

        return Filter::with('units.values')
            ->whereIn('category_id', $allCategories)
            ->where('show',1)
            ->get();
    }

    public function updatePriceRange($min, $max)
    {
        $this->priceMin = (int) $min;
        $this->priceMax = (int) $max;
    }

    public function togglePrice()
    {
        $this->priceCheck = !$this->priceCheck;
    }

    public function categoryReset()
    {
        $this->activeCategory = [];
        $this->activeFilter = [];
    }

    public function render()
    {
        return view('livewire.products');
    }
}
