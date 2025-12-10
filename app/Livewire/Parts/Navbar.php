<?php

namespace App\Livewire\Parts;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Navbar extends Component
{

    public $theme;

    public function mount()
    {
        $this->theme = session('theme', 'dark');
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


