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
        $this->priceMin = Specification::min('price') ?? 0;
        $this->priceMax = Specification::max('price') ?? 1000000000;
    }

    public function updatedActiveCategory()
    {
        // وقتی دسته تغییر کرد، محدوده اسلایدر رو به‌روز کن
        $this->updateSliderRange();
    }

    public function updatedActiveFilter()
    {
        $this->updateSliderRange();
    }

    protected function updateSliderRange()
    {
        $productsId = $this->getBaseProductIds();

        $min = Specification::whereIn('product_id', $productsId)->min('price') ?? 0;
        $max = Specification::whereIn('product_id', $productsId)->max('price') ?? 1000000000;

        $this->dispatch('updateSlider', [
            'min' => $min,
            'max' => $max,
            'currentMin' => $this->priceMin,
            'currentMax' => $this->priceMax
        ]);

    }

    protected function getBaseProductIds()
    {
        $query = Product::query();

        $allCategories = array_merge(
            $this->activeCategory,
        Category::whereIn('parent_id',$this->activeCategory)->pluck('id')->toArray()
        );

        if(!empty($allCategories)){
            $query->whereIn('category_id', $allCategories);
        }

        if(!empty($this->activeFilter)){
            $query->whereHas('specifications.group.units.values', function ($q) {
               $q->whereIn('id', $this->activeFilter);
            });
        }

        return $query->pluck('id');

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

        // قیمت
        if ($this->priceCheck) {
            // فقط محصولات با قیمت در محدوده
            $query->whereHas('specifications', function($q) {
                $q->whereNotNull('price')
                    ->whereBetween('price', [$this->priceMin, $this->priceMax]);
            });
        } else {
            // محصولات با قیمت در محدوده + بدون قیمت
            $query->where(function($q) {
                $q->whereHas('specifications', function($q2) {
                    $q2->whereNotNull('price')
                        ->whereBetween('price', [$this->priceMin, $this->priceMax]);
                })->orWhereDoesntHave('specifications', function($q2) {
                    $q2->whereNotNull('price');
                });
            });


        }

        return $query->get();
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
        $this->updateSliderRange();
    }

    public function render()
    {
        return view('livewire.products');
    }
}
