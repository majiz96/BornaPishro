<?php

namespace App\Livewire\Dashboard;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Article;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Sidebar extends Component
{

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
