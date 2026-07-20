<?php

namespace App\Livewire\Dashboard\Website;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

use App\Models\Information;

class Info extends Component
{
    public $phone, $mobile, $email, $address, $activity ,$response, $start_date, $about_us;


    public function mount()
    {
        $data = Information::Cached();

        $this->fill($data->only([
            'phone', 'mobile', 'email', 'address', 'activity', 'response', 'location', 'start_date', 'about_us'
        ]));
    }
    public function save()
    {
        $this->validate([
            'phone' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'activity' => 'required|string',
            'response' => 'required|string',
            'start_date' => 'required|date',
            'about_us' => 'required|string|max:1000'
        ]
        ,
        [
            'phone.required'=>'شماره تلفن باید وارد شود',
            'phone.string'=>'تلفن وارد شده معتبر نیست',
            'mobile.required'=>'شماره موبایل باید وارد شود',
            'mobile.string'=>'شماره موبایل وارد شده معتبر نیست',
            'email.required'=>'ایمیل باید وارد شود',
            'email.email'=>'ایمیل وارد شده معتبر نیست',
            'address.required'=>'آدرس باید وارد شود',
            'address.string'=>'آدرس وارد شده معتبر نیست',
            'activity.required'=>'زمان فعالیت حضوری باید وارد شود',
            'activity.string'=>'زمان فعالیت وارد شده معتبر نیست',
            'response.required'=>'زمان پاسخگویی باید وارد شود',
            'response.string'=>'زمان پاسخگویی وارد شده معتبر نیست',
            'start_date.required'=>'تاریخ آغاز فعالیت باید وارد شود',
            'start_date.date'=>'تاریخ وارد شده معتبر نیست',
            'about_us.required'=>'بخش درباره ما باید پر شود',
            'about_us.string'=>'بخش درباره ما باید به صورت متنی باشد'
        ]);



        Information::first()->update([
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'address' => $this->address,
            'activity' => $this->activity,
            'response' => $this->response,
            'start_date' => $this->start_date,
            'about_us' => $this->about_us
        ]);

        Cache::forget('website-information');
        session()->flash('success', 'اطلاعات بروز شدند.');
    }

    public function render()
    {
        return view('livewire.dashboard.website.info')
            ->layout('components.layouts.dashboards');
    }
}
