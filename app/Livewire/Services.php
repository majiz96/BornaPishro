<?php

namespace App\Livewire;

use App\Models\Field;
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

    public $field_id,$field_class;
    public array $activeCategory = [];
    public array $activeOption = [];

    public $category;

    public  $title,$intro,$cover,$thumbnail,$date;
    public $search = '';
    public $perPage = 10;
    public $sort='created_at';
    public $direction = 'desc';

    public $showCategories = false;
    public $showFilters = false;
    public $showOrders = false;


    public function mount(Category $category)
    {
        $this->field_class = Service::class;
        $this->field_id = Field::where('model',$this->field_class)->first()?->id;

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
    public function Filters()
    {
//         get categories id from their general category for showing related filters
        $allCategories = array_merge(
            $this->activeCategory,
            Category::whereIn('parent_id', $this->activeCategory)->pluck('id')->toArray()
        );

        $query = Filter::with(['options'=>function($options){
            $options->whereHas('usedOptions',function($used){
                $used->where('optionable_type',$this->field_class);
            });
        }])->where('field_id', $this->field_id)
            ->where('show',1)
        ->whereHas('services',function($service){
            $service->where('show',1);
        });

        if(!empty($allCategories))
        {
            $query->where(function($option) use($allCategories){
                $option->whereIn('category_id', $allCategories);
                $option->orWhereNull('category_id');
            });
        }

        return $query->get();

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

        if (!empty($this->activeOption)) {
            $query->whereHas('relatedOptions', function($option) {
                $option->where('optionable_type', $this->field_class)
                ->whereIn('option_id', $this->activeOption);
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
        $this->activeOption = [];
        $this->resetPage();
    }
    public function openCategories()
    {
        $this->showCategories = true;
    }
    public function closeCategories()
    {
        $this->showCategories = false;
    }

    public function openFilters()
    {
        $this->showFilters = true;
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
