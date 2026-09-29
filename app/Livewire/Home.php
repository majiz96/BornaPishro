<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Notice;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
//use Illuminate\Validation\ValidationException;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

use App\Models\User;
use App\Models\File;
use App\Models\Communication;
use Nette\Schema\ValidationException;

class
Home extends Component
{
    public $counter = 0;
    public int $NotificationLimit = 3;
    public int $ProductLimit = 12;
    public int $ArticleLimit = 6;

    public $panelShow;

    public function mount()
    {
        $this->panelShow = true;

        $this->dispatch('show-panel');
    }

    #[Computed]
    public function notificationSlider()
    {
        return Notice::where('display','اسلایدر')
            ->where('status',1)
            ->limit($this->NotificationLimit)
            ->orderBy('created_at','DESC')
            ->get();
    }
    #[Computed]
    public function notificationTile()
    {
        return Notice::where('display','کاشی ها')
            ->where('status',1)
            ->where('expired_at', '>', now())
            ->orderBy('created_at','DESC')
            ->get();
    }
    #[Computed]
    public function productSlider()
    {
         return Product::where('show',1)
            ->where('supply',1)
            ->where('price','!=',0)
            ->limit($this->ProductLimit)
            ->orderBy('created_at','DESC')->get();
    }
    #[Computed]
    public function serviceSlider()
    {
         return Service::where('show',1)->orderBy('created_at','DESC')->get();
    }
    #[Computed]
    public function articleSlider()
    {
         return Article::where('show',1)
             ->limit($this->ArticleLimit)
             ->orderBy('created_at','DESC')->get();
    }


    public function render()
    {
        return view('livewire.home');
    }
}
