<?php

namespace App\Livewire\Dashboard\Attachments;


use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Product;
use App\Models\Gallery;
class Galleries extends Component
{
    use WithFileUploads;

    public $product;
    public $images = [];
    public $uplaods = [];
    public $order = 0;
    public $show;
    public $uploadTip = 'فقط عکسهای jpg, jpeg, png';

    public $counter = 1;

    public $selected = [];
    public $showed = [];
    public $selectAll = false;


    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function updatedImages()
    {
        $this->uplaods = [];

        foreach ($this->images as $image) {
            $this->uplaods[] = $image->temporaryUrl();
        }
    }

    public function save()
    {
        $this->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:4096',
        ]
        ,
        [
            'images.required'=>'عکسی بارگذاری نشده است',
            'images.*.image'=>'فایل بارگذاری شده تصویری نیست',
            'images.*.mimes'=>'فقط فایلهای jpg, jpeg, png قابل بارگذاری هستند',
            'images.*.max'=>'فایل بارگذاری شده سنگینتر از ۴ مگابایت است',
        ]);

        foreach ($this->images as $image) {

            $imagename = uniqid('product_'.$this->product->id.'_').'.'.$image->getClientOriginalExtension();
            $image->storeAs('gallery', $imagename, 'public');

            Gallery::create([
                'image'=>$imagename,
                'galleryable_id'=>$this->product->id,
                'galleryable_type'=>Product::class
            ]);

        }

            $this->images = [];
            $this->uplaods = [];
    }

    public function orderUp($id)
    {
        $image = Gallery::findOrFail($id);
        $image->update(['order'=>$image->order+1]);
    }

    public function orderDown($id)
    {
        $image = Gallery::findOrFail($id);
        $image->update(['order'=>$image->order-1]);
    }

    public function toggleShow($id)
    {
        $image = Gallery::find($id);
        $image->show = $image->show == 1 ? 0 : 1;
        $image->save();
    }

    public function showAll()
    {
        $this->showed = Gallery::where('galleryable_id', $this->product->id)->where('galleryable_type', Product::class)->pluck('id')->toArray();

        Gallery::where('galleryable_id', $this->product->id)->where('galleryable_type', Product::class)->update(['show' => 1]);
    }

    public function showNone()
    {
        $this->showed = Gallery::where('galleryable_id', $this->product->id)->where('galleryable_type', Product::class)->pluck('id')->toArray();

        Gallery::where('galleryable_id', $this->product->id)->where('galleryable_type', Product::class)->update(['show' => 0]);
    }


    public function updatedSelectAll($value)
    {
        if($value){

            $this->selected = Gallery::where('galleryable_id',$this->product->id)->pluck('id')->toArray();
        }
        else
        {
            $this->selected = [];
            $this->selectAll = false;
        }
    }
    public function delete($id)
    {
        $image =Gallery::findOrFail($id);
        Storage::disk('public')->delete('gallery/'.$image->image);
        $image->delete();
    }

    public function deleteSelected()
    {
        $images = Gallery::whereIn('id', $this->selected)->pluck('image')->toArray();

        foreach ($images as $image) {
            Storage::disk('public')->delete('gallery/'.$image);
        }
        Gallery::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function render()
    {
        $products = Product::findOrFail($this->product->id);
        $pg = Gallery::where('galleryable_id', $this->product->id)->where('galleryable_type', Product::class)->orderBy('order')->get();

        $imagesShow = Gallery::where('galleryable_id', $this->product->id)->where('galleryable_type', Product::class)->where('show',1)->pluck('id')->toArray();

        return view('livewire.dashboard.attachments.galleries',['products'=>$products,'galleries'=>$pg,'imagesShow'=>$imagesShow]);
    }
}
