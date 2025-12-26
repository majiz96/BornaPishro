<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;

use App\Models\Notice;
use App\Models\Position;

class Notices extends Component
{
    public string $title;
    public string $description;
    public string $display;
    public string $contact;
    public string $position_id;
    public string $style;
    public $expired_at;
    public function render()
    {
        return view('livewire.dashboard.website.notices',['positions'=>Position::OrderBy('level','DESC')->get()])
            ->layout('components.layouts.dashboards');
    }
}
