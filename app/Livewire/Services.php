<?php

namespace App\Livewire;

use App\Models\Service;
use App\Models\Category;
use App\Models\Filter;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component

{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $field_id;
    public array $activeCategory = [];
    public array $activeFilter = [];

    public $category;

    public  $title,$intro,$cover,$thumbnail,$date;
    public $search = '';
    public $perPage = 10;
    public $sort='created_at';
    public $direction = 'desc';

    public $showCategories = false;
    public $showFilters = false;
    public $showOrders = false;

    public $modalCategories,$modalFilters,$modalOrders;


    public function mount(Category $category)
    {
        $this->field_id = where('model',Service::class)->first()?->id;

        $this->category = $category->id;

        if ($this->category)
        {
            $this->activeCategory = $category->where('id', $this->category)->pluck('id')->toArray();
        }
        else
        {
            $this->activeCategory = [];
        }
    }
    #[Computed]
    public function categories()
    {
        return Category::with('children')
            ->where('field_id', $this->field_id)
            ->get();
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
            return Filter::where('field_id', $this->field_id)
                ->where('show', 1)
                ->get();
        }

//        show filters in selected categories
        return Filter::where('field_id', $this->field_id)
            ->whereIn('category_id', $allCategories)
            ->where('show', 1)
            ->get();
    }

    #[Computed]
    public function services()
    {
        $query = Service::where('show', 1);

        $allCategories = array_merge($this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray());

        if (!empty($allCategories)) {
            $query->whereIn('category_id', $allCategories);
        }

        if (!empty($this->activeFilter)) {
            $query->whereHas('filter', function($q) {
                $q->whereIn('id', $this->activeFilter);
            });
        }

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $query->orderBy($this->sort, $this->direction);

        if($this->perPage == 'all'){
            return $query->get();
        }

        return $query->paginate($this->perPage);

    }

    public function categoryReset()
    {
        $this->activeCategory = [];
        $this->activeFilter = [];
        $this->resetPage();
    }

    public function openCategories()
    {
        $this->showCategories = true;
        $this->modalCategories = $this->categories;
    }
    public function closeCategories()
    {
        $this->showCategories = false;
    }

    public function openFilters()
    {
        $this->showFilters = true;
        $this->modalFilters = $this->filters;
    }
    public function closeFilters()
    {
        $this->showFilters = false;
    }

    public function openOrders()
    {
        $this->showOrders = true;
    }
    public function closeOrders()
    {
        $this->showOrders = false;
    }

    public function render()
    {
        return view('livewire.services');
    }
}
