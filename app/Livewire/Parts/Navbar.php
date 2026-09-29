<?php

namespace App\Livewire\Parts;

use App\Livewire\Dashboard\Website\Notices;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Field;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;


class Navbar extends Component
{

    public string $name, $lastname;

    public $theme;

    public $unreadNotice = [];
    public $lastUnreadNotice = [];
    public $noticeTitle;

    public int $searchShow = 0;
    public int $modalSearchShow = 0;

    public $submenu = '';
    public string $menuTab;

    public int $children = 0;

    public function mount()
    {
        $this->theme = session('theme', 'dark');

        if(Auth::check())
        {
            $user_id = Auth::user()->id;

            $user = auth()->user();

            $this->name = $user->name;
            $this->lastname = $user->lastname;

            $this->unreadNotice = collect();

            $this->unreadNotice = auth()->user()
                ->notices()->whereNull('user_notice.read_at')
                ->where('notices.status', 1)
                ->where('expired_at', '>', now())
                ->latest()->get();

            $this->lastUnreadNotice = auth()->user()
                ->notices()->whereNull('user_notice.read_at')
                ->where('notices.status', 1)
                ->where('expired_at', '>', now())
                ->latest()->limit(1)->get();
        }

    }


    public function toggleTheme()
    {
        $this->theme = ($this->theme == 'dark') ? 'light' : 'dark';
        session(['theme' => $this->theme]);
        $this->dispatch('themeChanged',theme: $this->theme);
    }

    public function showMenu($tab)
    {
        if(!empty($tab))
        {
            $this->submenu = $tab;
            $this->menuTab = $tab;
        }
        else
        {
            $this->submenu = $this->menuTab;
        }

    }
    public function hideMenu()
    {
        $this->submenu = '';
    }

    public function hideFooter()
    {
        $this->dispatch('hide-footer');
    }
    public function showFooter()
    {
        $this->dispatch('show-footer');
    }

    #[Computed]
    public function getField()
    {
        return Field::Menu();
    }
    #[Computed]
    public function getCategory()
    {
         return Cache::remember(
                "menu-categories-{$this->submenu}",
                now()->addMonth(),
                fn()=>Category::where('field_id',$this->submenu)
                    ->where('parent_id',null)
                    ->with('children','field')
                    ->get()
            );


    }

    #[Computed]
    public function currentField()
    {
        return Cache::remember(
            "current-field-{$this->submenu}",
            now()->addMonth(),
            fn()=>Field::find($this->submenu)
        );
    }

    public function showChildren($id)
    {
        $this->children = $id;
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

    #[Computed]
    public function commentAlert()
    {
        return Comment::where('see',0)->count();
    }

    #[On('user-updated')]
    public function userUpdate()
    {
        $this->name = Auth::user()->name;
        $this->lastname = Auth::user()->lastname;
    }

    public function render()
    {
        return view('livewire.parts.navbar');
    }
}


