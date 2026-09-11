<?php

namespace App\Livewire\Auth;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;

use Livewire\Component;
use Livewire\Attributes\Validate;


use App\Models\User;
use App\Models\Position;

class Register extends Component
{

    public string $name;
    public string $lastname;
    public string $email;
    public int $position_id = 4;
    public $password;
    public $password_confirmation;


    public $showPassword = false;

    public function save()
    {
        $this->validate([
            'name' => ['required','min:3' ,'max:32'],
            'lastname' => ['required', 'min:3' ,'max:100'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ],[
            'name.required'=>'وارد کردن نام کوچک الزامیست',
            'name.max'=>'نام کوچک حداکثر ۳۲ حرف باید باشد',
            'name.min'=>'نام کوچک حداقل ۳ حرف باید باشد',

            'lastname.required'=>'وارد کردن نام خانوادگی الزامیست',
            'lastname.max'=>'نام خانوادگی حداکثر ۱۰۰ حرف باید باشد',
            'lastname.min'=>'نام خانوادگی حداقل ۳ حرف باید باشد',

            'email.required'=>'وارد کردن ایمیل الزامست',
            'email.string'=>'ایمیل وارد شده معتبر نیست',
            'email.email'=>'ایمیل وارد شده معتبر نیست',
            'email.unique'=>'ایمیل وارد شده ثبت شده است',

            'password.confirmed'=>'رمز عبور درست تکرار نشده است',
            'password.*'=>'رمز عبور باید حداقل ۸ کرکتر باشد و شامل نمادها،اعداد، حروف کوچک و بزرگ باشد.'
        ]);

        $data = $this->pull(['name','lastname','email','position_id','password','password_confirmation']);
        $user = User::create($data);

        Auth::login($user);
        event(new Registered($user));
        return redirect()->route('verification.notice');
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.dashboards');
    }
}
