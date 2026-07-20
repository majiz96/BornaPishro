<?php

namespace App\Livewire\Dashboard\Website;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Morilog\Jalali\Jalalian;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\License;

class Licenses extends Component
{
    use WithFileUploads;

   public $name, $link, $icon, $description, $expire;

   public int $active = 1;
   public int $show = 0;

   public $editing = null;
   public $rules = [
       'name' => 'required|string|unique:licenses,name',
       'link' => 'required|string|unique:licenses,link',
       'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       'description' => 'string|nullable|max:300',
       'expire' => 'required|date',
   ];

   public $messages = [
       'name.required' => 'هر مجوز باید نامگذاری شود',
       'name.string' => 'نام مجوز باید متنی باشد',
       'name.unique' => 'نام هر مجوز باید منحصر به فرد باشد',
       'link.required' => 'هر مجوز باید لینک داشته باشد',
       'link.string' => 'فرمت لینک معتبر نیست',
       'link.unique' => 'هر مجوز باید لینک منحصر به فرد داشته باشد',
       'icon.required' => 'هر مجوز باید یک تصویر به عنواد نماد داشته باشد',
       'icon.image' => 'نماد انتخاب شده تصویری نیست',
       'icon.mimes' => 'تصویر انتخاب شده از فرمتهای مجاز (jpeg,jpg,png,gif,svg) نیست',
       'icon.max' => 'تصویر انتخاب شده باید کوچکتر از ۲ مگابایت باشد',
       'description.string' => 'توضیحات باید متنی باشد',
       'description.max' => 'توضیحات حداکثر ۳۰۰ کرکتر می تواند باشد',
       'expire.required' => 'تاریخ انقضا باید وارد شود',
       'expire.date' => 'تاریخ انقضا وارد شده فرم صحیحی ندارد',
   ];

   public function edit($id)
   {
       $license = License::findOrFail($id);
       $this->editing = $id;
       $this->name = $license->name;
       $this->link = $license->link;
       $this->icon = $license->icon;
       $this->description = $license->description;
       $this->expire = $license->expire;
   }

   public function cancel()
   {
       $this->editing = null;
       $this->reset();
   }

   public function save()
   {


    if($this->editing){

        $update_rules = [
            'name' => 'required|string',
            'link' => 'required|string',
            'description' => 'string|nullable|max:300',
            'expire' => 'required|date',
        ];

        $update_messages = [
            'name.required' => 'هر مجوز باید نامگذاری شود',
            'name.string' => 'نام مجوز باید متنی باشد',
            'link.required' => 'هر مجوز باید لینک داشته باشد',
            'link.string' => 'فرمت لینک معتبر نیست',
            'description.string' => 'توضیحات باید متنی باشد',
            'description.max' => 'توضیحات حداکثر ۳۰۰ کرکتر می تواند باشد',
            'expire.required' => 'تاریخ انقضا باید وارد شود',
            'expire.date' => 'تاریخ انقضا وارد شده فرم صحیحی ندارد',
        ];

        $this->validate($update_rules, $update_messages);

        $license = License::findOrFail($this->editing);

        if(!is_string($this->icon)){

            $update_rules['icon'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $update_messages['icon.image'] = 'نماد انتخاب شده تصویری نیست';
            $update_messages['icon.mimes'] = 'تصویر انتخاب شده از فرمتهای مجاز (jpeg,jpg,png,gif,svg) نیست';
            $update_messages['icon.max'] = 'تصویر انتخاب شده باید کوچکتر از ۲ مگابایت باشد';


            Storage::disk('public')->delete('license_icons/'.$license->icon);


            $filename = uniqid('icon_') . '.' . $this->icon->getClientOriginalExtension();
            $this->icon->storeAs('license_icons', $filename, 'public');

        }
        else
        {
            $filename = $license->icon;
        }


        $data = $this->pull(['name', 'link','description','expire']);
        $data['icon'] = $filename ?? $this->icon;
        $data['active'] = $this->active;
        $data['show'] = $this->show;

        $license->update($data);

        Cache::forget('website-licenses');

        $this->reset(['name', 'link', 'icon']);
        $this->editing = null;

    }
    else
    {

        if($this->icon && !is_string($this->icon)){
            $filename = uniqid('icon_') . '.' . $this->icon->getClientOriginalExtension();
            $this->icon->storeAs('license_icons', $filename, 'public');
        }
        else
        {
            $filename = [];
        }

        $this->validate($this->rules, $this->messages);

        $data = $this->pull(['name', 'link','description','expire']);
        $data['icon'] = $filename;
        $data['active'] = $this->active;
        $data['show'] = $this->show;

        if(License::create($data))
        {

            Cache::forget('website-licenses');
            session()->flash('success','مجوز ثبت شد');

            $this->reset(['expire','icon']);
        }


    }

   }

   public function delete($id)
   {
    $licence = License::findOrFail($id);
    $licence->delete();

    Cache::forget('website-licenses');

    Storage::disk('public')->delete('license_icons/' . $licence->icon);
   }

   public function toggleActive($id)
   {
    $license = License::find($id);
    $license->active = $license->active == 1 ? 0 : 1;
    $license->save();

    Cache::forget('website-licenses');
   }
   public function toggleShow($id)
   {
       $license = License::find($id);
       $license->show = $license->show == 1 ? 0 : 1;
       $license->save();

       Cache::forget('website-licenses');
   }
   #[Computed]
   public function Licenses()
   {
       return License::Cached();
   }

    public function render()
    {
        return view('livewire.dashboard.website.licenses')
            ->layout('components.layouts.dashboards');
    }
}
