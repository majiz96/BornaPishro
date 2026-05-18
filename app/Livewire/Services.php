<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component

{
    use WithPagination;

    public array $activeCategory = [];

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
    public function articles()
    {
        $query = Article::query()->orderBy($this->sort,$this->direction);
        $query->paginate($this->perPage);

        return $query;
    }

    public function render()
    {
        return view('livewire.services');
    }
}
