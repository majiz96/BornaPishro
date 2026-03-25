<?php

namespace App\Livewire\Parts;

use App\Models\Information;
use App\Models\License;
use App\Models\Social;
use Livewire\Component;

class Footer extends Component
{
    public $phone, $mobile, $email, $address, $activity ,$response, $start_date, $about_us;

    public $icon, $link;

    public function mount()
    {
        $info = Information::first();

        $this->fill($info->only([
            'phone', 'mobile', 'email', 'address', 'activity', 'response', 'location', 'start_date', 'about_us'
        ]));

    }

    public function render()
    {
        $socials = Social::all();

        $licenses = License::all();

        return view('livewire.parts.footer', compact('socials', 'licenses'));
    }
}
