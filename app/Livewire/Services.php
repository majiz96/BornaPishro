<?php

namespace App\Livewire;

use App\Models\Article;
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
        $query = Article::query()->orderBy($this->sort,$this->direction);
        $query->paginate($this->perPage);

        return $query;
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
