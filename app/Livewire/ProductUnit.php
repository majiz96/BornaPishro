<?php

namespace App\Livewire;

use App\Models\Brief;
use App\Models\Comment;
use App\Models\File;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Source;
use App\Models\SpecGroup;
use App\Models\Specification;
use App\Models\User;

use App\Models\Video;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductUnit extends Component
{

    public $product,$text,$replyText,$parent_id,$vote,$activeTable,$activePrice;

    public $modalTitle,$modalImage;

    public $gallery_id = null;
    public $galleryModal = false;

    public $gallery_limit = 3;
    public string $tab = 'specifications';

    public $showed = [];

    public $reply = null;

    public $showed_reply = [];
    public $reply_text = 'نمایش پاسخ ها';

    public function mount(Product $product)
    {
        $this->product = $product;

        if (!$this->activeTable)
        {
            $this->activeTable = Specification::where('product_id',$this->product->id)->first()->id;
        }

        $this->activePrice = Specification::where('id',$this->activeTable)->pluck('price')->first();
    }

    public function showGallery($id)
    {
        $this->galleryModal = true;
        $this->gallery_id = $id;
        $this->modalTitle = $this->product->name;
        $this->gallery_limit = null;

        if($id == 0)
        {
            $this->modalImage = $this->product->image;
        }
        else
        {
            $this->modalImage = Gallery::where('id',$id)->pluck('image')->first();
        }
    }

    public function closeGallery()
    {
        $this->galleryModal = false;

        if($this->gallery_id == 0)
        {
            $this->gallery_limit = 3;
        }
        else
        {
            $this->gallery_limit = 2;
        }
    }

    public function selectPic($id)
    {
        $this->gallery_id = $id;

        if($this->galleryModal)
        {
            $this->gallery_limit = null;
        }
        else
        {
            $this->gallery_limit = 2;
        }

    }
    #[Computed]
    public function gallery()
    {
        return Gallery::where('galleryable_id',$this->product->id)
            ->where('galleryable_type',Product::class)
            ->where('galleryable_id',$this->product->id)
            ->whereNot('id',$this->gallery_id)
            ->where('show',1)
            ->limit($this->gallery_limit)
            ->orderBy('order','asc')
            ->get();
    }
    public function resetGallery()
    {
        $this->gallery_id = null;

        if($this->galleryModal)
        {
            $this->gallery_limit = null;
        }
        else
        {
            $this->gallery_limit = 3;
        }

    }

    #[Computed]
    public function chosenPic()
    {
        return Gallery::where('id',$this->gallery_id)->get();
    }

    #[Computed]
    public function briefs()
    {
        return Brief::with('units.values')
            ->where('product_id',$this->product->id)
            ->get();
    }
    #[Computed]
    public function specifications()
    {
        return Specification::with('group.units.values')
            ->where('product_id',$this->product->id)
            ->get();
    }

    #[Computed]
    public function selectedSpecification()
    {
        return Specification::with('group.units.values')
            ->where('product_id',$this->product->id)
            ->where('id',$this->activeTable)
            ->get();
    }

    #[Computed]
    public function files()
    {
        return File::where('fileable_type',Product::class)
            ->where('fileable_id',$this->product->id)
            ->get();
    }

    public function download($id)
    {
        $file = File::findOrFail($id);

        return Storage::disk('public')->download('files/'.$file->filename);
    }

    #[Computed]
    public function sources()
    {
        return Source::where('sourceable_type',Product::class)
            ->where('sourceable_id',$this->product->id)
            ->get();
    }

    #[Computed]
    public function videos()
    {
        return Video::where('videoable_type',Product::class)
            ->where('videoable_id',$this->product->id)
            ->get();
    }


    public function selectTable($id)
    {
        $this->activeTable = $id;

        $this->activePrice = Specification::where('id',$id)->pluck('price')->first();
    }

    public function makeReply($id)
    {
        $this->reply = $id;
    }
    public function cancel()
    {
        $this->reply = null;
        $this->reset('replyText');
    }

    public function toggleLike(Comment $comment)
    {

        if(!auth()->check())
            {
                return redirect()->route('login');
            }

        $comment->LikedByUsers()->toggle(auth()->id());

    }

    public function toggleReplies($id)
    {
        if (in_array($id, $this->showed_reply))
        {
            $this->showed_reply = array_values(array_diff($this->showed_reply, [$id]));
        }
        else
        {
            $this->showed_reply[] = $id;
        }

        return $this->showed_reply;
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
            'commentable_type'=>Product::class,
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

    #[Computed]
    public function Comments()
    {
        return Comment::with('Users','parent','children')
            ->where('commentable_id',$this->product->id)
            ->where('commentable_type',Product::class)
            ->where('show',1)
            ->where('parent_id',0)
            ->get();
    }

    public function render()
    {
        return view('livewire.product-unit');
    }
}
