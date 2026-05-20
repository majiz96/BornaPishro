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

    public array $activeCategory = [];
    public array $activeFilter = [];

    public  $title,$intro,$cover,$thumbnail,$date;
    public $search = '';
    public $perPage = 10;
    public $sort='created_at';
    public $direction = 'desc';

    #[Computed]
    public function categories()
    {
        return Category::with('children')
            ->where('field_id', 2)
            ->where('id', '<', 99)
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
            return Filter::where('field_id', 2)
                ->orWhere('category_id', 200)
                ->where('show', 1)
                ->get();
        }

//        show filters in selected categories
        return Filter::where('field_id', 2)
            ->whereIn('category_id', $allCategories)
            ->orWhere('category_id', 200)
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


//        if(!empty($activeFilter)){
//            $query->whereIn('filter_id', $activeFilter);
//        }

        if (!empty($this->activeFilter)) {
            $query->whereHas('filter', function($q) {
                $q->whereIn('id', $this->activeFilter);
            });
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

    public function render()
    {
        return view('livewire.services');
    }
}
