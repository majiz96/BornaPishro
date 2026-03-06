<?php

namespace App\Livewire\Dashboard\Products;


use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Brief;
use App\Models\Specification;


class ProductsManagement extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $category_id,$name,$fullname,$brand_id,$brand_name,$price,$discount,$supply,$intro,$show,$image;

    public $editing = null;

    public int $counter = 1;

    public $selected = [];
    public $selectAll = false;

    public $perPage = 5;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';

    protected $rules = [
        'name'=>'required',
        'category_id'=>'required',
        'image'=>'required|image|mimes:jpeg,png,jpg|max:4096',
        'price'=>'nullable|numeric',
        ];
    protected $messages = [
            'name.required'=>'هر محصول به یک نام نیاز دارد!',
            'category_id.required' => 'باید دسته محصول را مشخص کنید',
            'price.numeric'=>'قیمت باید به عدد وارد شود',
            'image.required'=>'هر محصول به یک عکس نیاز دارد',
            'image.image'=>'فایل انتخاب شده یک تصویر نیست',
            'image.mimes'=>'فقط فرمتهای jpeg, png, jpg قابل بارگذاری است',
            'image.max'=>' عکس محصول نهایت ۴ مگابایت می تواند باشد ',
        ];

    protected $update_rules = [
            'name'=>'required',
            'category_id'=>'required',
            'price'=>'nullable',
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
        $this->price = $product->price ?? 0;
        $this->image = $product->image;
        $this->discount = $product->discount;
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

            if($this->price == 0)
            {
                $discount = null;
            }
            else
            {
                $discount = $this->discount;
            }

            $product->update([
                'name' => $this->name,
                'fullname' => $this->fullname,
                'category_id' => $this->category_id,
                'brand_id' => $this->brand_id,
                'brand_name' => $this->brand_name,
                'intro' => $this->intro,
                'price' => $this->price,
                'image' => $imagename,
                'discount' => $discount
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

           $product = Product::create([
                'name'=>$this->name,
                'fullname'=>$this->fullname,
                'category_id'=>$this->category_id,
                'brand_id'=>$this->brand_id,
                'brand_name'=>$this->brand_name,
                'intro'=>$this->intro,
                'price'=>$this->price,
                'image'=>$imagename,
            ]);

            $product->brief()->create([]);
            $product->specifications()->create(['name'=>'جدول اصلی']);

            $this->reset(['name','fullname','category_id','brand_id','brand_name','intro','price','image']);

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

    public function toggleShow($id)
    {
        $product = Product::findOrFail($id);
        $product->show = $product->show == 1 ? 0 : 1;
        $product->save();
    }
    public function toggleSupply($id)
    {
        $product = Product::findOrFail($id);
        $product->supply = $product->supply == 1 ? 0 : 1;
        $product->save();
    }

    public function render()
    {
     $categories = Category::with('children','parent')->where('field_id',3)->where('parent_id',0)->get();
     $brands = Brand::all();
     $query = Product::with('category','brand','brief','specifications','comments')
         ->where('name','LIKE','%'.$this->search.'%')
         ->orWhere('fullname','LIKE','%'.$this->search.'%')
         ->orWhere('brand_name','LIKE','%'.$this->search.'%')
         ->orderBy($this->sort,$this->direction);

        $products = ($this->perPage == "") ? $query->get() : $query->paginate($this->perPage);

        return view('livewire.dashboard.products.products-management',compact('products','categories','brands'))
            ->layout('components.layouts.dashboards');
    }
}
