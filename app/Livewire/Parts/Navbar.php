<?php

namespace App\Livewire\Parts;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Navbar extends Component
{
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
