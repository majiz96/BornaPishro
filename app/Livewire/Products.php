<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $field_id;

    public $category;
    public array $activeCategory = [];
    public array $activeFilter = [];
    public bool $supplyCheck = false;
    public bool $priceCheck = false;
    public int $priceMin = 0;
    public int $priceMax = 1000000000;

    public $priceless = 0 ?? null;

    public $perPage = 5;
    public string $search = '';
    public string $sort = 'created_at';
    public string $direction = 'desc';

//    reset products page if each of these variables change
    public function updated($property)
    {
        if (in_array($property, ['search', 'activeCategory', 'activeFilter', 'priceCheck', 'priceMin', 'priceMax', 'sort', 'direction'])) {
            $this->resetPage();
        }
    }

    public function mount(Category $category)
    {
        $this->field_id = Field::where('model',Product::class)->first()?->id;

        $this->category = $category->id;

        if($this->category)
        {
            $this->activeCategory = $category->where('id',$this->category)->pluck('id')->toArray();
        }
        else
        {
            $this->activeCategory = [];
        }

//      set chosen and default value of minimum and maximum price
        $this->priceMin = (int) Product::get()->min('final_price') ?? 0;
        $this->priceMax = (int) Product::get()->max('final_price') ?? 1000000000;
    }
    #[Computed]
    public function categories()
    {
        return Category::with('children')
            ->where('field_id', $this->field_id)
            ->where('id', '<', 99)
            ->get();
    }

    #[Computed]
    public function products()
    {
//        get price after get discount
        $finalPrice = DB::raw('price * (1 - IFNULL(discount,0) / 100)');

        $query = Product::query()
            ->where('products.show',1)
            ->select('products.*')
            ->with('specifications')
            ->addSelect(['final_price' => $finalPrice]);
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('brand_name', 'like', '%' . $this->search . '%');
            });
        }

//         get categories id from their general category for showing related products
        $allCategories = array_merge(
            $this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray()
        );
//        get categories themselves for showing related products
        if (!empty($allCategories)) {
            $query->whereIn('category_id', $allCategories);
        }

//        get filters id values for showing related products
        if (!empty($this->activeFilter)) {
            $query->whereHas('specifications.groups.units.values', function($q) {
                $q->whereIn('id', $this->activeFilter);
            });
        }

//        show only priced products
        if ($this->priceCheck)
        {
          $query->whereNotNull('price')
//              the discounted price that is between max and min price slider indicators
              ->WhereBetween($finalPrice, [$this->priceMin, $this->priceMax])
              ->where($finalPrice, '>', 0);
        }
//        show all products
        else
        {
            $query->whereBetween($finalPrice, [$this->priceMin, $this->priceMax]);
            $query->orWhereNull('price');
        }

//        show only products which have supply
        if($this->supplyCheck)
        {
            $query->where('supply',1);
        }

//        sorting the products from different ways and directions
        $query->orderBy($this->sort, $this->direction);

//       set numbers of products in each page
        if ($this->perPage == 'all')
        {
            return $query->get();
        }

        return $query->paginate($this->perPage);
    }

    #[Computed]
    public function filters()
    {
//         get categories id from their general category for showing related filters
        $allCategories = array_merge(
            $this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray()
        );

// show all filters
        if (empty($allCategories)) {
            return Filter::with('units.values')
                ->where('field_id', $this->field_id)
                ->where('show', 1)
                ->get();
        }

//        show filters in selected categories
        return Filter::with('units.values')
            ->whereIn('category_id', $allCategories)
            ->where('show', 1)
            ->get();
    }

//    reset products page when price indicators changed for updating the page
    public function updatePriceRange($min, $max)
    {
        $this->priceMin = (int) $min;
        $this->priceMax = (int) $max;
        $this->resetPage();
    }

//    get toggle value from showing price checkbox
    public function togglePrice()
    {
        $this->priceCheck = !$this->priceCheck;
        $this->resetPage();
    }

//   empty the categories
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
