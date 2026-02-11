<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public array $activeCategory = [];
    public array $activeFilter = [];
    public bool $priceCheck = false;
    public int $priceMin = 0;
    public int $priceMax = 1000000000;

    public int $perPage = 3;
    public string $search = '';
    public string $sort = 'created_at';
    public string $direction = 'desc';

    public function updated($property)
    {
        if (in_array($property, ['search', 'activeCategory', 'activeFilter', 'priceCheck', 'priceMin', 'priceMax', 'sort', 'direction'])) {
            $this->resetPage();
        }
    }

    public function mount()
    {
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

        // سرچ
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('brand_name', 'like', '%' . $this->search . '%');
            });
        }

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

        // فیلتر قیمت
        if ($this->priceCheck) {
            $query->whereHas('specifications', function($q) {
                $q->whereNotNull('price')
                    ->whereBetween('price', [$this->priceMin, $this->priceMax]);
            });
        } else {
            $query->where(function($q) {
                $q->whereHas('specifications', function($q2) {
                    $q2->whereNotNull('price')
                        ->whereBetween('price', [$this->priceMin, $this->priceMax]);
                })->orWhereHas('specifications', function($q2) {
                    $q2->whereNull('price');
                });
            });
        }


        if ($this->sort !== 'price') {
            $query->orderBy($this->sort, $this->direction);
        }

        $paginated = $query->paginate($this->perPage);


        if ($this->sort === 'price') {

            $sorted = $this->direction === 'desc'

                ? $paginated->getCollection()->sortByDesc('max_price')
                : $paginated->getCollection()->sortBy('min_price');

            $paginated->setCollection($sorted);
        }

        return $paginated;
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
                ->where('show', 1)
                ->get();
        }

        return Filter::with('units.values')
            ->whereIn('category_id', $allCategories)
            ->where('show', 1)
            ->get();
    }

    public function updatePriceRange($min, $max)
    {
        $this->priceMin = (int) $min;
        $this->priceMax = (int) $max;
        $this->resetPage();
    }

    public function togglePrice()
    {
        $this->priceCheck = !$this->priceCheck;
        $this->resetPage();
    }

    public function categoryReset()
    {
        $this->activeCategory = [];
        $this->activeFilter = [];
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.products');
    }
}
