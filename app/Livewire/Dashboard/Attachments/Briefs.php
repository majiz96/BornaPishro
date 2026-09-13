<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Models\Brief;
use App\Models\BriefUnit;
use App\Models\BriefValue;
use App\Models\Product;
use Livewire\Attributes\Lazy;
use Livewire\Component;

class Briefs extends Component
{
    public $product,$brief,$title,$value;

    public $editing = null;
    public $selected = [];
    public $selectAll = false;
    public $counter = 1;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->brief = $this->product->brief;
    }

    public function edit($id)
    {
        $brief = BriefUnit::findOrFail($id);
        $this->editing = $id;
        $this->title = $brief->title;
        $this->value = $brief->values->value;
    }
    public function cancel()
    {
        $this->editing = null;
        $this->reset(['title','value']);
    }

    public function save()
    {
        if ($this->editing)
        {
            $this->validate(['title'=>'required|string','value'=>'required|string'],[
                'title.required'=>'نوشتن عنوان الزامیست',
                'value.required'=>'نوشتن مقدار هر عنوان الزامیست',
            ]);

            $unit = BriefUnit::findOrFail($this->editing);

            $unit->update(['title' => $this->title]);

            $unit->values()->update(['value' => $this->value]);


            $this->reset(['title','value']);
            $this->editing = null;
        }
        else
        {
            $this->validate(['title'=>'required|string','value'=>'required|string'],[
                'title.required'=>'نوشتن عنوان الزامیست',
                'value.required'=>'نوشتن مقدار هر عنوان الزامیست',
            ]);

            $unit = BriefUnit::create(['brief_id'=>$this->product->brief->id,'title'=>$this->title]);
            $unit->value = BriefValue::create(['unit_id'=>$unit->id,'value'=>$this->value]);

            $this->reset(['title','value']);
        }
    }

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selected = BriefUnit::where('brief_id',$this->product->id)->pluck('id')->toArray();
        }
        else
        {
            $this->selectAll = false;
            $this->selected = [];
        }
    }

    public function delete($id)
    {
        BriefUnit::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        BriefUnit::whereIn('id',$this->selected)->delete();

        $this->selected = [];
        $this->selectAll = false;
    }

    #[Computed]
    public function Units()
    {
       return BriefUnit::with('values')->where('brief_id',$this->brief->id)->get();
    }


    public function render()
    {
        return view('livewire.dashboard.attachments.briefs')
            ->layout('components.layouts.dashboards');
    }
}
