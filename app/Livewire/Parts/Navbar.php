<?php

namespace App\Livewire\Parts;

use App\Livewire\Dashboard\Website\Notices;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

use App\Models\User;
use App\Models\Notice;

class Navbar extends Component
{

    public string $name, $lastname;

    public $theme;

    public $unreadNotice = [];
    public $lastUnreadNotice = [];
    public $noticeTitle;

    public int $searchShow = 0;
    public int $modalSearchShow = 0;

    public int $submenu = 0;

    public function mount()
    {
        $this->theme = session('theme', 'dark');

        if(Auth::check())
        {
            $user_id = Auth::user()->id;

            $this->name = User::where('id', $user_id)->pluck('name')->first();
            $this->lastname = User::where('id', $user_id)->pluck('lastname')->first();

            $this->unreadNotice = collect();

            $this->unreadNotice = auth()->user()
                ->notices()->whereNull('user_notice.read_at')
                ->where('notices.status', 1)->latest()->get();

            $this->lastUnreadNotice = auth()->user()
                ->notices()->whereNull('user_notice.read_at')
                ->where('notices.status', 1)->latest()->limit(1)->get();


        }


    }


//    public function getUnreadMessagesTitle()
//    {
//        return auth()->user()->notices()->whereNull('user_notice.read_at')->pluck('user_notice.title')->get();
//    }

    public function toggleTheme()
    {
        $this->theme = ($this->theme == 'dark') ? 'light' : 'dark';
        session(['theme' => $this->theme]);
        $this->dispatch('themeChanged',theme: $this->theme);
    }

    public function toggleMenu()
    {
        $this->submenu = $this->submenu == 0 ? 1 : 0;
    }

    public function toggleSearch()
    {
        $this->searchShow = $this->searchShow == 0 ? 1 : 0;

        $this->dispatch('searchToggled',show: $this->modalSearchShow);
    }
    public function toggleModalSearch()
    {
        $this->modalSearchShow = $this->modalSearchShow == 0 ? 1 : 0;

        $this->dispatch('modalSearchToggled',show: $this->modalSearchShow);
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


