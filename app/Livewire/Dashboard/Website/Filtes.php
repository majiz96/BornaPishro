<?php

namespace App\Livewire\Dashboard\Website;

use App\Models\Category;
use App\Models\Field;
use App\Models\Filter;
use App\Models\SpecUnit;
use App\Models\SpecValue;
use Livewire\Component;

class Filtes extends Component
{
    public $field_id,$category_id,$title,$type,$show,$activeField;

    public $counter = 1;
    public $counterModal = 1;
    public $editing = null;
    public $selected = [];
    public $selectAll = false;
    public $showed = [];
    public $filterModal = false;

    public $filterUnit,$filterTitle;

    public $rules = [
        'field_id' => 'required',
        'category_id' => 'required',
        'title' => 'required',
        'type' => 'required',
    ];
    public $messages = [
        'field_id.required' => 'انتخاب موضوع لازم است',
        'category_id.required'=>'انتخاب دسته لازم است',
        'title.required'=>'عنوانی برای فیلتر ننوشتید',
        'type.required'=>'انتخاب نوع نمایش فیلتر لازم است',
    ];

    public function edit($id)
    {
        $filter = Filter::findOrFail($id);
        $this->editing = $id;
        $this->field_id = $filter->field_id;
        $this->category_id = $filter->category_id;
        $this->title = $filter->title;
        $this->type = $filter->type;
    }
    public function cancel()
    {
        $this->reset(['field_id','category_id','title','type','editing']);
    }

    public function save()
    {
        $this->validate($this->rules,$this->messages);

        if($this->editing)
        {
           $filter = Filter::findOrFail($this->editing);

           $filter->update([
               'field_id' => $this->field_id,
               'category_id' => $this->category_id,
               'title' => $this->title,
               'type' => $this->type,
           ]);

           $this->reset(['field_id','category_id','title','type','editing']);
        }
        else
        {
            Filter::create([
                'field_id' => $this->field_id,
                'category_id' => $this->category_id,
                'title' => $this->title,
                'type' => $this->type,
            ]);

            $this->reset(['field_id','category_id','title','type']);
        }
    }

    public function selectField($id)
    {
        $this->activeField = $id;
    }

    public function toggleShow($id)
    {
        $filter = Filter::findOrFail($id);
        $filter->show = $filter->show == 1 ? 0 : 1;
        $filter->save();
    }

    public function showAll()
    {
        Filter::where('field_id', $this->activeField)->where('show', 0)->update(['show' => 1]);
    }

    public function showNone()
    {
        Filter::where('field_id', $this->activeField)->where('show', 1)->update(['show' => 0]);
    }

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selected = Filter::where('field_id',$this->activeField)->pluck('id')->toArray();
        }
        else
        {
            $this->selected = [];
            $this->selectAll = false;
        }
    }

    public function delete($id)
    {
        Filter::findOrFail($id)->delete();
    }

    public function selectiveDelete()
    {
        Filter::whereIn('id',$this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function showModal($id)
    {
        $this->filterModal = true;
        $filter = Filter::findOrFail($id);
        $this->filterTitle = $filter->title;
        $this->filterCat = $filter->category_id;
        $this->filterUnit = $filter->units;

    }

    public function remove($id)
    {
        $unit = SpecUnit::findOrFail($id);
        $unit->update(['filter_id' => 0]);
        $this->reset();
    }

    public function render()
    {
        $fields = Field::all();
        $categories = Category::where('parent_id',0)->get();

        if(!$this->activeField)
        {
            $this->activeField = Field::all()->last()->id;
        }

        $filters = Filter::with('field','category','units')->where('field_id',$this->activeField)->get();

        $this->showed = Filter::where('field_id',$this->activeField)->where('show',1)->pluck('id')->toArray();

        return view('livewire.dashboard.website.filtes',compact('fields','categories','filters'))
            ->layout('components.layouts.dashboards');
    }
}
