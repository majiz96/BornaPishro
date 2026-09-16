<?php

namespace App\Livewire\Dashboard\Users;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\Position;

class UsersManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $title = 'مدیریت کاربران';
    public int $counter = 1;

    public string $name,$lastname,$email,$position_id,$password;
    public string $password_confirmation;
    public $editing = null;

    public $selected = [];
    public $selectAll = false;

    public $perPage = 5;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';

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

            Gate::authorize('update', User::class);

            $data = $this->pull(['position_id']);
            $update = User::findOrFail($this->editing)->update($data);
            $this->editing = null;
            $this->title = 'مدیریت کاربران';
        }
        else
        {
            Gate::authorize('create', User::class);

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
        Gate::authorize('delete', User::class);

        User::findOrFail($id)->delete();
    }
    public function selectedDelete()
    {
        User::whereIn('id',$this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
    }

    #[Computed]
    public function Users()
    {
        $maxLevel = Position::max('level');

        $user = User::query();

        $user->whereHas('position', function($q) use($maxLevel) {
            $q->where('level','<' ,$maxLevel);
        });

        $user->whereLike('name', '%'.$this->search.'%')
        ->orWhereLike('lastname','%'.$this->search.'%')
        ->orWhereLike('email', '%'.$this->search.'%')
        ->orWhereLike('position_id', '%'.$this->search.'%')
        ->orWhereLike('created_at', '%'.$this->search.'%')
       ->orWhereLike('email_verified_at', '%'.$this->search.'%');

        $user->orderBy($this->sort, $this->direction);


        return ($this->perPage == "") ? $user->get() : $user->paginate($this->perPage);
    }

    #[Computed]
    public function Positions()
    {
        $maxLevel = Position::max('level');

        return Position::with('users')
            ->where('level', '<', $maxLevel)
            ->orderBy('level', 'DESC')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.users.users-management')
            ->layout('components.layouts.dashboards');
    }
}
