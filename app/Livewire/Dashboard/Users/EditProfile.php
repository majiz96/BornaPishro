<?php

namespace App\Livewire\Dashboard\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

use App\Models\User;
class EditProfile extends Component
{

    public string $name;
    public string $lastname;
    public string $email;
    public string $position_id;
    public string $password;
    public string $password_confirmation;


    public string $message = '';
    public function mount()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $this->name = $user->name;
        $this->lastname = $user->lastname;
        $this->email = $user->email;
        $this->position_id = $user->position_id;
    }
    public function save()
    {
        $this->validate([
            'name' => ['required','min:3' ,'max:32'],
            'lastname' => ['required', 'min:3' ,'max:100'],
            'email' => ['required', 'string', 'email'],
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

        $data = $this->pull(['name','lastname','email','password','password_confirmation']);

        $id = Auth::user()->id;

        $user = User::findOrFail($id)->update($data);

        $this->name = $data['name'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];

        $this->dispatch('user-updated',userUpdat: $user);
    }
    public function render()
    {
        return view('livewire.dashboard.users.edit-profile')->layout('components.layouts.dashboards');
    }
}
