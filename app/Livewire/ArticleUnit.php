<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Comment;
use App\Models\User;
use Livewire\Attributes\Computed;

use App\Models\Article;
use App\Models\Category;

class ArticleUnit extends Component
{
    public $default = 'عنوان پست';

    public $article;

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    #[Computed]
    public function Category()
    {
        $service = $this->article->category_id;

        return Category::with('field','parent')
            ->where('id',$service)
            ->get();

    }

    public function render()
    {
        return view('livewire.article-unit');
    }
}
