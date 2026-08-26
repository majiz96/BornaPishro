<?php

namespace App\Livewire\Dashboard\Website;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Social;

class Socials extends Component
{
    use WithFileUploads;

    public $name,$link,$icon;
    public $counter = 1;
    public $editing = null;

    public $selected = [];
    public $selectAll = false;

    public function edit($id)
    {
        $social = Social::findOrFail($id);
        $this->name = $social->name;
        $this->link = $social->link;
        $this->icon = $social->icon;

        $this->editing = $social->id;
    }

    public function cancel()
    {
        $this->reset(['name', 'link', 'icon']);
        $this->editing = null;
    }
    public function save()
    {

        $rules = [
            'name' => 'required|string',
            'link' => 'required|string',
        ];
        $messages = [
            'name.required' => 'شبکه مجازی باید نام داشت',
            'name.string' => 'نام شبکه مجازی باید متنی باشد',
            'link.required' => 'شبکه مجازی به یک لینک نیاز دارد',
            'link.string' => 'لینک شبکه مجازی باید به صورت متنی باشد',
            ];

        if ($this->editing)
        {

            $social = Social::findOrFail($this->editing);

            if (!is_string($this->icon)) {

                $rules['icon'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
                $messages['icon.mimes'] = 'نماد شبکه مجازی باید از فرمت jpg, jpeg, png باشد';
                $messages['icon.image'] = 'فایل شبکه مجازی باید از نوع تصویر باشد';
                $messages['icon.max']   = 'نماد شبکه مجازی باید حداکثر ۲ مگابایت باشد';

                Storage::disk('public')->delete('social_icons/'.$social->icon);

                $filename = uniqid('icon_') . '.' . $this->icon->getClientOriginalExtension();

                $this->icon->storeAs('social_icons', $filename, 'public');
            } else {
                $filename = $social->icon;
            }

            $this->validate($rules, $messages);

            $data = $this->pull(['name', 'link']);
            $data['icon'] = $filename ?? $this->icon;

            $social = Social::findOrFail($this->editing)->update($data);

            Cache::forget('website-socials');

            $this->editing = null;

            $this->reset(['name', 'link', 'icon']);

            session('success','شبکه مجازی مورد نظر ویرایش شد');

        }
        else
        {
            $this->validate([
                    'name' => 'required|unique:socials|string',
                    'link' => 'required|string|unique:socials',
                    'icon' => 'required|mimes:png,jpg,jpeg|image|max:2048',
                ]
                ,
                [
                    'name.required'=>'شبکه مجازی باید نام داشت',
                    'name.unique'=>'هر شبکه مجازی باید نام منحصر به فرد داشته باشد',
                    'name.string'=>'نام شبکه مجازی باید متنی باشد',
                    'link.required'=>'شبکه مجازی به یک لینک نیاز دارد',
                    'link.string'=>'لینک شبکه مجازی باید به صورت متنی باشد',
                    'link.unique'=>'هر شبکه مجازی باید آدرس منحصر به فرد داشته باشد',
                    'icon.required'=>'بارگذاری نماد لازم است',
                    'icon.mimes'=>'نماد شبکه مجازی باید از فرمت jpg, jpeg, png باشد',
                    'icon.image'=>'فایل شبکه مجازی باید از نوع تصویر باشد',
                    'icon.max'=>'نماد شبکه مجازی باید حداکثر ۲ مگابایت باشد',
                ]);

            $filename = uniqid('icon_') . '.' . $this->icon->getClientOriginalExtension();

            $this->icon->storeAs('social_icons', $filename, 'public');


            Social::create([
                'name'=>$this->name,
                'link'=>$this->link,
                'icon'=>$filename
            ]);

            Cache::forget('website-socials');

            $this->reset(['name', 'link', 'icon']);

            session()->flash('success','شبکه مجازی اضافه شد');
        }


    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Social::all()->pluck('id')->toArray();
        }
        else
        {
            $this->selected = [];
        }
    }

    public function delete($id)
    {
        $social=Social::findOrFail($id);
        $social->delete();
        Storage::disk('public')->delete('social_icons/'.$social->icon);

        Cache::forget('website-socials',function (){

        });
    }

    public function deleteSelected()
    {

        $icon = Social::whereIn('id', $this->selected)->pluck('icon')->toArray();

        Social::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;

        foreach ($icon as $icons)
        {
            Storage::disk('public')->delete('social_icons/'.$icons);

        }

        Cache::forget('all-socials');
    }

    #[Computed]
    public function Socials()
    {
        $social = Social::Cached();

        return $social;
    }

    public function render()
    {
        return view('livewire.dashboard.website.socials')
            ->layout('components.layouts.dashboards');
    }
}
