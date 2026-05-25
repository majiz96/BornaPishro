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

    #[Computed]
    public function Comments()
    {
        $comments = Comment::with('parent','children')
            ->where('commentable_id',$this->article->id)
            ->where('commentable_type',Article::class)
            ->where('show',1)->get();

        if($comments->isNotEmpty())
        {
            foreach ($comments as $comment)
            {

                $name = User::where('id',$comment->user_id)->pluck('name')->first();
                $lastname = User::where('id',$comment->user_id)->pluck('lastname')->first();

            }
        }
        else
        {
            $name = null;
            $lastname = null;
        }

        return $comments;
    }

    public function render()
    {
        return view('livewire.article-unit');
    }
}
