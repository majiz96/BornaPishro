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
    ##[Validate(['required','email'=>'email'])]

    #[Validate("required",message : "ایمیل الزامی است")]
    #[Validate("email",message: "ایمیل معتبر نیست")]
    public string $email;
    public string $password;

    public $remember;

    public function login()
    {
        Auth::attempt(['email' => $this->email, 'password' => $this->password],$this->remember);

        $user = Auth::user();
        if (!$user||!$user->hasVerifiedEmail()) {
            return redirect(route('verification.notice'));
        }
        return redirect()->intended('/');
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
