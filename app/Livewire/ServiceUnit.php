<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

use App\Models\Service;
use App\Models\Category;

class ServiceUnit extends Component
{

    public $default = 'عنوان پست';

    public $service;

    public function mount(Service $service)
    {
        $this->service = $service;
    }

    #[Computed]
    public function Category()
    {
        $service = $this->service->category_id;

        return Category::with('field','parent')
            ->where('id',$service)
            ->get();

    }

    #[Computed]
    public function Comments()
    {
        $comments = Comment::with('parent','children')
            ->where('commentable_id',$this->service->id)
            ->where('commentable_type',Service::class)
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
        return view('livewire.service-unit');
    }
}
