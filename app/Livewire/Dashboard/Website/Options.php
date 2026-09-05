<?php

namespace App\Livewire\Dashboard\Website;

use App\Models\Filter;
use App\Models\Option;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Options extends Component
{
    public $filter, $name, $show;

    public bool $editing = false;

    public $selected = [];
    public $showed = [];



    public function mount(Filter $filter)
    {
        $this->filter = $filter;
    }

    public function edit(Options $option)
    {

    }

    public function cancel()
    {

    }

    public function save()
    {
        if ($this->editing)
        {
            $this->validate(['name' => 'required'],['name.required'=>'نام گزینه را وارد کنید']);

        }
        else
        {
            $this->validate(['name' => 'required'],['name.required'=>'نام گزینه را وارد کنید']);

            Option::create(['name' => $this->name, 'filter_id' => $this->filter->id]);

            $this->reset(['name']);

        }
    }

    public function delete(Options $option)
    {

    }

    #[Computed]
    public function Options()
    {
        return $this->filter->options;
    }



    public function render()
    {
        return view('livewire.dashboard.website.options')
            ->layout('components.layouts.dashboards');;
    }
}
