<?php

namespace App\Livewire\Parts;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;

use App\Models\User;

class Navbar extends Component
{

    public string $name;
    public string $lastname;

    public $theme;

    public function mount()
    {
        $this->theme = session('theme', 'dark');

        if(Auth::check())
        {
            $user_id = Auth::user()->id;

            $this->name = User::where('id', $user_id)->pluck('name')->first();
            $this->lastname = User::where('id', $user_id)->pluck('lastname')->first();
        }


    }
    public function toggleTheme()
    {
        $this->theme = ($this->theme == 'dark') ? 'light' : 'dark';
        session(['theme' => $this->theme]);
        $this->dispatch('themeChanged',theme: $this->theme);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.parts.navbar');
    }
}


