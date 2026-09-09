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
    public $selectAll = false;
    public $showed = [];

    public int $selected_id = 0;

    public function mount(Filter $filter)
    {
        $this->filter = $filter;

        $this->model = $filter->field->model;

        $this->showed = Option::where('filter_id', $filter->id)
            ->where('show',1)
            ->pluck('id')
            ->toArray();
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

    public function toggleShow($id)
    {
        $option = Option::findOrFail($id);
        $option->show = $option->show == true ? false : true;
        $option->save();

        $this->showed = Option::where('filter_id', $this->filter->id)
            ->where('show',1)
            ->pluck('id')
            ->toArray();
    }

    public function showAll()
    {
        Option::where('filter_id', $this->filter->id)
            ->where('show',0)
            ->update(['show' => 1]);

        $this->showed = Option::where('filter_id', $this->filter->id)
            ->where('show',1)
            ->pluck('id')
            ->toArray();
    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
           $this->selected = Option::where('filter_id', $this->filter->id)
                ->pluck('id')
                ->toArray();
        }
        else
        {
            $this->selectAll = false;
            $this->selected = [];
        }
    }

    public function showNone()
    {
        Option::where('filter_id', $this->filter->id)
            ->where('show',1)
            ->update(['show' => 0]);

        $this->showed = Option::where('filter_id', $this->filter->id)
            ->where('show',1)
            ->pluck('id')
            ->toArray();

        $this->showed = [];
    }
    public function redirectItem($id)
    {
        $type = substr($this->model,11);

        return $this->redirect(route('select-filter',[
            'type'=>$type,
            'id'=>$id
        ]));
    }


    public function delete($id)
    {
        Option::findOrFail($id)->delete();
    }
    public function deleteAll()
    {
        Option::where('filter_id', $this->filter->id)
            ->whereIn('id',$this->selected)
            ->delete();
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
