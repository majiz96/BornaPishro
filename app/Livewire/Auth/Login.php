<?php

namespace App\Livewire\Auth;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\Attributes\Validate;

class Login extends Component
{
    #[Validate("required",message : "ایمیل الزامی است")]
    #[Validate("email",message: "ایمیل معتبر نیست")]
    public string $email;

    #[Validate("required",message : "گذرواژه الزامی است")]
    public string $password;

    public $remember;

    public $message = '';

    public $showPassword = false;

    public function login()
    {

        $this->validate();


        if(Auth::attempt(['email' => $this->email, 'password' => $this->password],$this->remember))
        {
            request()->session()->regenerate();

            $user = Auth::user();

            if ($user->hasVerifiedEmail()) {

                return redirect()->intended(config('fortify.home'));
            }
            else
            {
                auth()->user()->sendEmailVerificationNotification();
                return redirect()->route('verification.notice');
            }



        }
        else
        {
            $this->addError('password', __('ایمیل یا گذرواژه اشتباه است'));
        }

    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.dashboards');;
    }
}
