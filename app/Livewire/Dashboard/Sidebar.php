<?php

namespace App\Livewire\Dashboard;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Article;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Sidebar extends Component
{

    public $showMenu = false;

    public function menuToggle()
    {
        $this->showMenu = $this->showMenu == true ? false : true;
    }
    public function closeMenu()
    {
        $this->showMenu = false;
    }

    #[Computed]
    public function commentAlert(string $type): int
    {
        return Comment::where('see', 0)
            ->where('commentable_type', $type)
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.sidebar')
        ->layout('components.layouts.dashboards');
    }
}
