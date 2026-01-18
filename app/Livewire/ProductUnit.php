<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductUnit extends Component
{

    public $product,$text,$replyText,$parent_id,$vote;

    public $reply = null;

    public function makeReply($id)
    {
        $this->reply = $id;
    }
    public function cancel()
    {
        $this->reply = null;
        $this->reset('replyText');
    }

    public function toggleVote($id)
    {
        $comment = Comment::findOrFail($id);

        $this->vote = $this->vote == 1 ? 0 : 1;

        $comment->votes = $this->vote + $comment->votes;

        $comment->save();
    }

    public function save()
    {
        $this->validate([
            'text' => 'required|string|max:1000'
        ]
        ,
        [
            'text.required'=>'متنی برای نظر خود ننوشته اید',
            'text.string'=>'متن نظر معتبر نمی باشد',
            'text.max'=>'نظر نوشته شده طولانی تر از ۱۰۰۰ حرف است',
        ]);

        Comment::create([
            'user_id'=>Auth::id(),
            'text'=>$this->text,
            'commentable_id'=>$this->product->id,
            'commentable_type'=>Product::class
        ]);

        $this->reset('text');
    }

    public function saveReply()
    {
        $this->validate([
           'replyText'=>'required|string|max:1000'
        ]
        ,
        [
            'replyText.required'=>'متنی برای نظر خود ننوشته اید',
            'replyText.string'=>'متن نظر معتبر نمی باشد',
            'replyText.max'=>'نظر نوشته شده طولانی تر از ۱۰۰۰ حرف است'
        ]);

        Comment::create([
            'user_id'=>Auth::id(),
            'parent_id'=>$this->reply,
            'text'=>$this->replyText,
            'commentable_id'=>$this->product->id,
            'commentable_type'=>Product::class
        ]);

        $this->reset('replyText','reply');
    }


    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {


        $comments = Comment::with('parent','children')->where('commentable_id',$this->product->id)
            ->where('commentable_type',Product::class)->get();

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



        return view('livewire.product-unit',compact('comments','name','lastname'));
    }
}
