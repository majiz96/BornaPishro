<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Models\Product;
use App\Models\Source;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Sources extends Component
{
    public $product;
    public $title,$webname,$url;
    public $counter = 1;
    public $editing = null;
    public $selected = [];
    public $selectAll = false;
    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function edit($id)
    {
        $this->editing = $id;

        $source = Source::findOrFail($id);
        $this->title = $source->title;
        $this->webname = $source->webname;
        $this->url = $source->url;
    }

    public function cancel()
    {
        $this->editing = null;
        $this->reset(['title','webname','url']);
    }

    public function save()
    {
        if($this->editing){

            $source = Source::findOrFail($this->editing);

            $this->validate([
                'title' => 'required|string',
                'webname' => 'required|string',
                'url' => 'required|string',
            ],
                [
                    'title.required'=>'هر منبع باید عنوانی داشته باشد',
                    'webname.required'=>'نام منبع باید ذکر شود',
                    'url.required'=>'لینک منبع باید وارد شود'
                ]);
            $source->update([
                'title' => $this->title,
                'webname' => $this->webname,
                'url' => $this->url,
            ]);

            $this->reset(['title','webname','url']);
            $this->editing = null;
        }
        else
        {
            $this->validate([
                'title' => 'required|string',
                'webname' => 'required|string',
                'url' => 'required|string',
            ],
            [
                'title.required'=>'هر منبع باید عنوانی داشته باشد',
                'webname.required'=>'نام منبع باید ذکر شود',
                'url.required'=>'لینک منبع باید وارد شود'
            ]);

            Source::create([
            'title' => $this->title,
            'webname' => $this->webname,
            'url' => $this->url,
            'sourceable_id' => $this->product->id,
            'sourceable_type' => Product::class,
            ]);

            $this->reset(['title','webname','url']);
        }
    }

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selected = Source::where('sourceable_id', $this->product->id)->where('sourceable_type', Product::class)->pluck('id')->toArray();
        }
        else
        {
            $this->selectAll = false;
            $this->selected = [];
        }
    }

    public function delete($id)
    {
        Source::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        $sources = Source::whereIn('id', $this->selected)->delete();

        $this->selectAll = false;
        $this->selected = [];
    }

    #[Computed]
    public function Sources()
    {
        return Source::where('sourceable_id', $this->product->id)
            ->where('sourceable_type', Product::class)
            ->get();
    }


    public function render()
    {
        return view('livewire.dashboard.attachments.sources')
            ->layout('components.layouts.dashboards');
    }
}
