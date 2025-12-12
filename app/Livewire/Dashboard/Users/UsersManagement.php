<?php

namespace App\Livewire\Dashboard\Users;

use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\Attributes\Validate;

use App\Models\User;
use App\Models\Position;

class UsersManagement extends Component
{
    public string $title = 'مدیریت کاربران';
    public int $counter = 1;

    public string $name;
    public string $lastname;
    public string $email;
    public string $position_id;
    public string $password;
    public string $password_confirmation;
    public $editing = null;

    public $selected = [];
    public $selectAll = false;

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->position_id = $user->position_id;
        $this->editing = $user->id;
        $this->title = $user->name . ' ' . $user->lastname;
    }

    public function cancel()
    {
        $this->editing = null;
        $this->reset(['name', 'lastname', 'email', 'position_id', 'password', 'password_confirmation']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->title = 'مدیریت کاربران';
    }

    public function save()
    {
        if($this->editing) {
            $data = $this->pull(['position_id']);
            $update = User::findOrFail($this->editing)->update($data);
            $this->editing = null;
            $this->title = 'مدیریت کاربران';
        }
        else
        {
            $this->validate([
                'name' => ['required','min:3' ,'max:32'],
                'lastname' => ['required', 'min:3' ,'max:100'],
                'email' => ['required', 'string', 'email', 'unique:users'],
                'position_id' => ['required', 'integer'],
                'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            ],[
                'name.required'=>'وارد کردن نام کوچک الزامیست',
                'name.max'=>'نام کوچک حداکثر ۳۲ حرف باید باشد',
                'name.min'=>'نام کوچک حداقل ۳ حرف باید باشد',

                'lastname.required'=>'وارد کردن نام خانوادگی الزامیست',
                'lastname.max'=>'نام خانوادگی حداکثر ۱۰۰ حرف باید باشد',
                'lastname.min'=>'نام خانوادگی حداقل ۳ حرف باید باشد',

                'email.required'=>'وارد کردن ایمیل الزامیست',
                'email.string'=>'ایمیل وارد شده معتبر نیست',
                'email.email'=>'ایمیل وارد شده معتبر نیست',
                'email.unique'=>'ایمیل وارد شده ثبت شده است',

                'position_id.required' => 'سطح دسترسی باید انتخاب شود',
                'position_id.integer' => 'سطح دسترسی معتبر نیست',

                'password.confirmed'=>'رمز عبور درست تکرار نشده است',
                'password.*'=>'رمز عبور باید حداقل ۸ کرکتر باشد و شامل نمادها،اعداد، حروف کوچک و بزرگ باشد.'
            ]);

            $data = $this->pull();

            $create = User::create($data);

            $this->user = User::with('position')->get();
            $this->position = Position::all();

        }
    }

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selected = [];

            $users = User::with('position')->get();
            $maxLevel = Position::max('level');

            foreach ($users as $user) {
                if ($user->position->level < $maxLevel) {
                    $this->selected[] = $user->id;
                }
            }

        }
        else
        {
            $this->selected = [];
        }

    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
    }
    public function selectedDelete()
    {
        User::whereIn('id',$this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function render()
    {
        return view('livewire.dashboard.users.users-management',['user'=>User::with('position')->get(),
            'position'=>Position::orderBy('level','asc')->get(),
            'maxLevel'=>Position::max('level')])
            ->layout('components.layouts.dashboards');
    }
}
