<?php

namespace App\Livewire\Dashboard\Website;

use App\Models\Filter;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Options extends Component
{
    public $filter, $name, $show, $field, $model;

    public $editing = false;

    public $selected = [];
    public $showed = [];

    public int $selected_id = 0;

    public function mount(Filter $filter)
    {
        $this->filter = $filter;

        $this->model = $filter->field->model;
    }

    public function edit($id)
    {
        $this->editing = $id;

        $option = Option::findOrFail($id);
        $this->name = $option->name;
    }

    public function cancel()
    {
        $this->reset('name','editing');
    }

    public function save()
    {
        if ($this->editing)
        {
            $this->validate(['name' => 'required'],['name.required'=>'نام گزینه را وارد کنید']);

            Option::findOrFail($this->editing)->update(['name' => $this->name]);

            $this->reset(['name','editing']);

        }
        else
        {
            $this->validate(['name' => 'required'],['name.required'=>'نام گزینه را وارد کنید']);

            Option::create(['name' => $this->name, 'filter_id' => $this->filter->id]);

            $this->reset(['name']);

        }
    }

    public function delete($id)
    {
        Option::findOrFail($id)->delete();
    }
    public function redirectItem($id)
    {
        $type = substr($this->model,11);

        return $this->redirect(route('select-filter',[
            'type'=>$type,
            'id'=>$id
        ]));
    }



    #[Computed]
    public function Options()
    {

       return $this->filter->options;

    }

    #[Computed]
    public function Items($id)
    {
        return $this->model::with('relatedOptions')
            ->whereHas('relatedOptions', function ($query) use ($id) {
                $query->where('option_id', $id);
            })->get();
    }



    public function render()
    {
        return view('livewire.dashboard.website.options')
            ->layout('components.layouts.dashboards');
    }
}
