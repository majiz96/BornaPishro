<?php

namespace App\Livewire\Dashboard\Attachments\Details;

use App\Models\Filter;
use App\Models\SpecUnit;
use App\Models\SpecValue;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Record extends Component
{
    public $editing = false;

    public $group,$active,$product;

    public $title,$value,$type,$suffix,$filter_id;

    public function mount($product)
    {
        $this->product = $product;

        $first = SpecUnit::first()->id ?? null;
        $this->active = $this->active ? $first : null;
    }

    #[On('group-changed')]
    public function group($group)
    {
        $this->group = $group;
    }

    #[Computed]
    public function Units()
    {
        return SpecUnit::where('group_id', $this->group)->get();
    }

    #[Computed]
    public function Values()
    {
        return SpecValue::where('unit_id', $this->active)->get();
    }

    #[Computed]
    public function Filters()
    {
        return Filter::where('category_id', $this->product->category->id)->get();
    }

    public function render()
    {
        return view('livewire.dashboard.attachments.details.record');
    }
}
