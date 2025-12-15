<?php

namespace App\Livewire\Dashboard\Website;

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
       'expire.date' => 'باید ورودی از نوع تاریخ باشد'
   ];

   public function save()
   {

       if(!is_string($this->icon)){
           $filename = uniqid('icon_') . '.' . $this->icon->getClientOriginalExtension();
           $this->icon->storeAs('license_icons', $filename, 'public');
       }
       else
       {
           $filename = $this->icon;
       }


    if($this->editing){

    }
    else
    {

        $this->validate($this->rules, $this->messages);

        $expire = $this->faToEn($this->expire);
        $expire = Jalalian::fromFormat('Y/m/d', $expire)->toCarbon()->format('Y-m-d');

        $data = $this->pull(['name', 'link','description']);
        $data['expire'] = $expire;
        $data['icon'] = $filename;
        $data['active'] = $this->active;
        $data['show'] = $this->show;

        if(License::create($data))
        {
            session()->flash('success','مجوز ثبت شد');
        }


    }

   }

    // ⬅️ این تابع باید اینجا باشد، داخل کلاس
    public function faToEn($string)
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($persian, $english, $string);
    }


    public function render()
    {
        return view('livewire.dashboard.website.licenses',['licenses'=>License::all()])
            ->layout('components.layouts.dashboards');
    }
}
