<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class Comments extends Component
{
    public $product,$show,$see;

    public $showed = [];
    public $seen = [];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function toggleShow($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->show = $comment->show == 1 ? 0 : 1;
        $comment->save();
    }

    public function showAll()
    {
        $this->showed = Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('show', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('show', 0)->update(['show' => 1]);
    }

    public function showNone()
    {
        $this->showed = Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('show', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('show', 1)->update(['show' => 0]);
    }

    public function toggleSee($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->see = $comment->see == 1 ? 0 : 1;
        $comment->save();
    }

    public function seeAll()
    {
        $this->seen = Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('see', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('see', 0)->update(['see' => 1]);
    }
    public function seeNone()
    {
        $this->seen = Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('see', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', Product::class)
            ->where('see', 1)->update(['see' => 0]);
    }
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->deleteWithChildren();
    }

    public function render()
    {
        $comments = Comment::where('commentable_id', $this->product->id)->where('commentable_type', Product::class)->with('Users')->get();

        $showed_comments = Comment::where('commentable_id', $this->product->id)->where('commentable_type', Product::class)->where('show', 1)->get();
        $seen_comments = Comment::where('commentable_id', $this->product->id)->where('commentable_type', Product::class)->where('see', 1)->get();


        return view('livewire.dashboard.attachments.comments', compact('comments','showed_comments','seen_comments'))
            ->layout('components.layouts.dashboards');
    }
}
