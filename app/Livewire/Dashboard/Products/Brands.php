<?php

namespace App\Livewire\Dashboard\Products;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Brands extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name,$description,$logo,$cover;
    public int $counter = 1;
    public $editing = null;

    public $selected = [];
    public $selectAll = false;

    public $perPage = 5;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';

    protected $rules = [
        'name'=>'required|string',
        'description'=>'nullable|string',
        'logo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'cover'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
    ];

    protected $messages = [
        'name.required'=>'هر برند باید یک نام داشته باشد',
        'name.string'=>'نام برند باید به صورت متن باشد',
        'description.string'=>'توضیحات باید به صورت متن باشد',
        'logo.image'=>'نماد برند باید یک عکس باشد',
        'logo.mimes'=>'تصویر انتخاب شده از فرمتهای مجاز (jpeg,jpg,png,gif,svg) نیست',
        'cover.image'=>'نماد برند عریض باید یک عکس باشد',
        'cover.mimes'=>'تصویر انتخاب شده از فرمتهای مجاز (jpeg,jpg,png,gif,svg) نیست'
    ];

    protected $update_rules = [
        'name'=>'required|string',
        'description'=>'nullable|string',
    ];

    protected $update_messages = [
        'name.required'=>'هر برند باید یک نام داشته باشد',
        'name.string'=>'نام برند باید به صورت متن باشد',
        'description.string'=>'توضیحات باید به صورت متن باشد',
    ];

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $this->editing = $id;
        $this->name = $brand->name;
        $this->description = $brand->description;
        $this->logo = $brand->logo;
        $this->cover = $brand->cover;
    }

    public function cancel()
    {
        $this->editing = null;
        $this->reset();
    }

    public function save()
    {
        if ($this->editing)
        {
            $brand = Brand::findOrFail($this->editing);

            $this->validate($this->update_rules, $this->update_messages);

                if(!is_string($this->logo))
                {
                    $update_rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                    $this->update_messages['logo.image'] = 'نماد برند باید یک عکس باشد';
                    $this->update_messages['logo.mimes'] = 'تصویر انتخاب شده از فرمتهای مجاز (jpeg,jpg,png,gif,svg) نیست';
                    $this->update_messages['logo.size'] = 'نماد برند حداکثر ۲ مگابایت باید باشد';

                    Storage::disk('public')->delete('brand_logos/'.$brand->logo);

                    $logoname = uniqid('logo_').'.'.$this->logo->getClientOriginalExtension();
                    $this->logo->storeAs('brand_logos', $logoname, 'public');
                }
                else
                {
                    $logoname = $this->logo;
                }

                if(!is_string($this->cover))
                {
                    $update_rules['cover'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096';
                    $this->update_messages['cover.image'] = 'نماد برند باید یک عکس باشد';
                    $this->update_messages['cover.mimes'] = 'تصویر انتخاب شده از فرمتهای مجاز (jpeg,jpg,png,gif,svg) نیست';
                    $this->update_messages['cover.size'] = 'نماد عریض برند حداکثر ۴ مگابایت باید باشد';

                    Storage::disk('public')->delete('brand_covers/'.$brand->cover);

                    $covername = uniqid('cover_').'.'.$this->cover->getClientOriginalExtension();
                    $this->cover->storeAs('brand_covers', $covername, 'public');
                }
                else
                {
                    $covername = $this->cover;
                }

                $data = $this->pull(['name', 'description']);
                $data['logo'] = $logoname;
                $data['cover'] = $covername;

                $brand->update($data);
                $this->reset(['name', 'description', 'logo', 'cover']);
                $this->editing = null;
        }
        else
        {
        $this->validate($this->rules,$this->messages);

        if ($this->logo && !is_string($this->logo))
        {
            $logoname = uniqid('logo_').'.'.$this->logo->getClientOriginalExtension();
            $this->logo->storeAs('brand_logos', $logoname, 'public');
        }
        else
        {
            $logoname = [];
        }

        if ($this->cover && !is_string($this->cover))
        {
            $covername = uniqid('cover_').'.'.$this->cover->getClientOriginalExtension();
            $this->cover->storeAs('brand_covers', $covername, 'public');
        }
        else
        {
            $covername = [];
        }

        Brand::create(['name'=>$this->name,'description'=>$this->description,'logo'=>$logoname,'cover'=>$covername]);

        $this->reset(['name','description','logo','cover']);

        }

    }

    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->selected = Brand::all()->pluck('id')->toArray();
        }
        else
        {
            $this->selectAll = false;
            $this->selected= [] ;
        }
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        Storage::disk('public')->delete('brand_logos/'.$brand->logo);
        Storage::disk('public')->delete('brand_covers/'.$brand->cover);
    }

    public function deleteSelected()
    {
        $logo  = Brand::whereIn('id',$this->selected)->pluck('logo')->toArray();
        $cover = Brand::whereIn('id',$this->selected)->pluck('cover')->toArray();

        foreach ($logo as $logos)
        {
            Storage::disk('public')->delete('brand_logos/'.$logos);
        }

        foreach ($cover as $covers)
        {
            Storage::disk('public')->delete('brand_covers/'.$covers);
        }

        Brand::whereIn('id',$this->selected)->delete();

        $this->selectAll = false;
        $this->selected = [];
    }



    public function render()
    {
        $brands = Brand::orderBy($this->sort,$this->direction)
            ->where('name','LIKE','%'.$this->search.'%')
            ->paginate($this->perPage);

        return view('livewire.dashboard.products.brands', compact('brands'))
            ->layout('components.layouts.dashboards');
    }
}
