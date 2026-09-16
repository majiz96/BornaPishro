<?php

namespace App\Livewire\Dashboard\Website;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

use App\Models\Information;
use Morilog\Jalali\Jalalian;

class Info extends Component
{
    public $phone, $mobile, $email, $address, $activity ,$response, $about_us,$date_picker;

    public $model = Information::class;

    public function mount()
    {
        Gate::authorize('isManager');

        $data = Information::Cached();

        $this->fill($data->only([
            'phone', 'mobile', 'email', 'address', 'activity', 'response', 'location', 'about_us'
        ]));

        $this->date_picker = $data->start_date;

        $this->dispatch('date-picker-set', value: $this->date_picker);
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
            'date_picker' => 'required|date',
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
            'date_picker.required'=>'تاریخ آغاز فعالیت باید وارد شود',
            'date_picker.date'=>'تاریخ وارد شده معتبر نیست',
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
            'start_date' => $this->date_picker,
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
