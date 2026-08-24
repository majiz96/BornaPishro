<?php

namespace App\Livewire\Dashboard\Attachments\Details;

use Livewire\Component;

class Table extends Component
{
    public int $active;

    public function render()
    {
        return view('livewire.dashboard.attachments.details.table');
    }
}
