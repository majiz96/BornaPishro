<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Relations\Relation;
class Comments extends Component
{
    public $type,$id,$show,$see,$model;

    public $showed = [];
    public $seen = [];



    public function mount(string $type, int $id)
    {
        $modelClass = "App\\Models\\{$type}";

        abort_unless(
            class_exists($modelClass) &&
            is_subclass_of($modelClass, \Illuminate\Database\Eloquent\Model::class),
            404
        );

        $this->type = $modelClass;
        $this->id = $id;
        $this->model = $modelClass::findOrFail($id);
    }

    public function toggleShow($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->show = $comment->show == 1 ? 0 : 1;
        $comment->save();
    }

    public function showAll()
    {
        $this->showed = Comment::where('commentable_id', $this->id)
            ->where('commentable_type', $this->type)
            ->where('show', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', $this->type)
            ->where('show', 0)->update(['show' => 1]);
    }

    public function showNone()
    {
        $this->showed = Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', $this->type)
            ->where('show', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->product->id)
            ->where('commentable_type', $this->type)
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
        $this->seen = Comment::where('commentable_id', $this->id)
            ->where('commentable_type', $this->type)
            ->where('see', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->id)
            ->where('commentable_type', $this->type)
            ->where('see', 0)->update(['see' => 1]);
    }
    public function seeNone()
    {
        $this->seen = Comment::where('commentable_id', $this->id)
            ->where('commentable_type', $this->type)
            ->where('see', 1)->pluck('id')->toArray();

        Comment::where('commentable_id', $this->id)
            ->where('commentable_type', $this->type)
            ->where('see', 1)->update(['see' => 0]);
    }
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->deleteWithChildren();
    }

    public function render()
    {
        $comments = Comment::where('commentable_id', $this->id)->where('commentable_type', $this->type)->with('Users')->get();

        $showed_comments = Comment::where('commentable_id', $this->id)->where('commentable_type', $this->type)->where('show', 1)->get();
        $seen_comments = Comment::where('commentable_id', $this->id)->where('commentable_type', $this->type)->where('see', 1)->get();


        return view('livewire.dashboard.attachments.comments', compact('comments','showed_comments','seen_comments'))
            ->layout('components.layouts.dashboards');
    }
}
