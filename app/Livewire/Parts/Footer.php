<?php

namespace App\Livewire\Parts;

use App\Models\Information;
use App\Models\License;
use App\Models\Social;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Footer extends Component
{
    public $phone, $mobile, $email, $address, $activity ,$response, $start_date, $about_us;

    public $icon, $link;

    public function mount()
    {
        $info = Information::Cached();

        $this->fill($info->only([
            'phone', 'mobile', 'email', 'address', 'activity', 'response', 'location', 'start_date', 'about_us'
        ]));

    }

    public function render()
    {
        $socials = Social::Cached();

        $licenses = License::Cached();

        return view('livewire.parts.footer', compact('socials', 'licenses'));
    }
}
