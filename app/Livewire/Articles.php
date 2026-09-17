<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use App\Models\Field;
use App\Models\Filter;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class Articles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $field_id;

    public array $activeCategory = [];
    public array $activeOption = [];

    public $category;

    public  $title,$intro,$cover,$date;
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
        $this->field_id = Field::where('model',Article::class)->first()?->id;

        $this->category = $category->id;

        if($this->category)
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
    public function Filters()
    {
//         get categories id from their general category for showing related filters
        $allCategories = array_merge(
            $this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray()
        );

        $query = Filter::with(['options'=>function($option){
            $option->whereHas('usedOptions',function($relation){
                $relation->where('optionable_type',Article::class);
            });
        }])->where('field_id', $this->field_id)
            ->where('show', 1)
        ->whereHas('articles',function($article){
            $article->where('show', 1);
        });

// show all filters
        if (!empty($allCategories)) {
           $query->where(function($option) use ($allCategories) {
               $option->whereIn('category_id', $allCategories)
               ->orWhereNull('category_id');

           });
        }

//        show filters in selected categories
        return $query->get();
    }

    #[Computed]
    public function articles()
    {
        $query = Article::where('show', 1);

        $allCategories = array_merge($this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray());


        if (!empty($allCategories))
        {
            $query->whereIn('category_id', $allCategories);
        }

        if (!empty($this->activeOption)) {
            $query->whereHas('relatedOptions', function($q) {
                $q->where('optionable_type', Article::class)
                    ->whereIn('option_id', $this->activeOption);
            });
        }

        if(!empty($this->search))
        {
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
        $this->activeOptions = [];
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
        return view('livewire.articles');
    }
}
