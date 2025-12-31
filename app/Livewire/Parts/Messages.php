<?php

namespace App\Livewire\Parts;

use App\Livewire\Dashboard\Website\Notices;
use Livewire\Component;

use App\Models\Notice;

class Messages extends Component
{

    public $notice;

    public function mount($notice)
    {
        $this->notice = $notice ? Notice::findOrFail($notice) : Notice::orderBy('id', 'desc')->first();

        auth()->user()->notices()->updateExistingPivot($this->notice->id, ['read_at' => now()]);
    }

    public function markAsRead()
    {
        auth()->user()->notices()->updateExistingPivot($this->notice->id, ['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.parts.messages',['messages'=>auth()->user()?->notices()->whereNull('user_notice.read_at')
            ->where('notices.status', 1)->latest()->get()
        ]);
    }
}
