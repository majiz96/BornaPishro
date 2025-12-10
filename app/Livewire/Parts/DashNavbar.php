<?php

namespace App\Livewire\Parts;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashNavbar extends Component
{

    public $dashtheme = 'dark';

    public function toggleTheme()
    {
        $this->dashtheme = ($this->dashtheme == 'dark') ? 'light' : 'dark';
        session(['dashtheme' => $this->dashtheme]);
        $this->dispatch('DashthemeChanged',dashtheme: $this->dashtheme);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function render()
    {
        return view('livewire.parts.dash-navbar');
    }
}
