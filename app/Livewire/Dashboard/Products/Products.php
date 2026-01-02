<?php

namespace App\Livewire\Dashboard\Products;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;


class Products extends Component
{
    use WithFileUploads;

    public $category_id,$name,$fullname,$brand_id,$brand_name,$intro,$image;

    public $editing = null;

    public int $counter = 1;

    public $selected = [];
    public $selectAll = false;

    protected $rules = [
        'name'=>'required',
        'category_id'=>'required',
        'image'=>'required|image|mimes:jpeg,png,jpg|max:4096'
        ];
    protected $messages = [
            'name.required'=>'هر محصول به یک نام نیاز دارد!',
            'category_id.required' => 'باید دسته محصول را مشخص کنید',
            'image.required'=>'هر محصول به یک عکس نیاز دارد',
            'image.image'=>'فایل انتخاب شده یک تصویر نیست',
            'image.mimes'=>'فقط فرمتهای jpeg, png, jpg قابل بارگذاری است',
            'image.max'=>' عکس محصول نهایت ۴ مگابایت می تواند باشد ',
        ];

    protected $update_rules = [
            'name'=>'required',
            'category_id'=>'required',
        ];
    protected $update_messages = [
            'name.required'=>'هر محصول به یک نام نیاز دارد!',
            'category_id.required' => 'باید دسته محصول را مشخص کنید',
        ];

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->editing = $id;
        $this->name = $product->name;
        $this->fullname = $product->fullname;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->brand_name = $product->brand_name;
        $this->intro = $product->intro;
        $this->image = $product->image;
    }
    public function cancel()
    {
        $this->editing = null;
        $this->reset();
    }

    public function saveProduct()
    {
        if($this->editing)
        {
            $product = Product::findOrFail($this->editing);

            $this->validate($this->update_rules,$this->update_messages);

            if(!is_string($this->image))
            {
                $this->update_rules['image'] = 'nullable|image|mimes:jpeg,png,jpg|max:4096';
                $this->update_messages['image.image'] = 'فایل انتخاب شده یک تصویر نیست';
                $this->update_messages['image.mimes'] = 'فقط فرمتهای jpeg, png, jpg قابل بارگذاری است';
                $this->update_messages['image.max'] = 'عکس محصول نهایت ۴ مگابایت می تواند باشد';

                Storage::disk('public')->delete('products/'.$product->image);

                $imagename = uniqid('product_').'.'.$this->image->getClientOriginalName();
                $this->image->storeAs('products',$imagename,'public');


            }
            else
            {
                $imagename = $this->image;
            }

            $product->update([
                'name' => $this->name,
                'fullname' => $this->fullname,
                'category_id' => $this->category_id,
                'brand_id' => $this->brand_id,
                'brand_name' => $this->brand_name,
                'intro' => $this->intro,
                'image' => $imagename,
            ]);

            $this->editing = null;
            $this->reset();

        }
        else
        {
            $this->validate($this->rules,$this->messages);

//            $data = $this->pull(['name','fullname','category_id','brand_id','brand_name','intro','image']);

            if($this->image && !is_string($this->image))
            {
                $imagename = uniqid('product_').'.'.$this->image->getClientOriginalName();
                $this->image->storeAs('products',$imagename,'public');
            }

            Product::create([
                'name'=>$this->name,
                'fullname'=>$this->fullname,
                'category_id'=>$this->category_id,
                'brand_id'=>$this->brand_id,
                'brand_name'=>$this->brand_name,
                'intro'=>$this->intro,
                'image'=>$imagename,
            ]);

            $this->reset(['name','fullname','category_id','brand_id','brand_name','intro','image']);

        }
    }

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selected = Product::all()->pluck('id')->toArray();
        }
        else
        {
            $this->selected = [];
            $this->selectAll = false;
        }
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Storage::disk('public')->delete('products/'.$product->image);
        $product->delete();
    }

    public function deleteSelected()
    {
        $images = Product::whereIn('id', $this->selected)->pluck('image')->toArray();

        foreach ($images as $image)
        {
            Storage::disk('public')->delete('products/'.$image);
        }

        Product::whereIn('id', $this->selected)->delete();

        $this->selectAll = false;
        $this->selected = [];
    }

    public function render()
    {
     $categories = Category::where('field_id',3)->get();
     $brands = Brand::all();
     $products = Product::with('category','brand')->get();

        return view('livewire.dashboard.products.products',[
            'categories'=>$categories,
            'brands'=>$brands,
            'products'=>$products
        ])
            ->layout('components.layouts.dashboards');
    }
}
