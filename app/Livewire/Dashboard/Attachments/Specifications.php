<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Livewire\Dashboard\Website\Filters;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use App\Models\Specification;
use App\Models\SpecGroup;
use App\Models\SpecUnit;
use App\Models\SpecValue;

use Livewire\Component;

class Specifications extends Component
{
    public $product,$category,$name,$price,$group,$title,$value,$suffix;

    public int $filter_id = 0;

    public $type = 'string';

    public $activeTable,$activeGroup,$first_group,$activeUnit;

    public $editingTable = null;
    public $editingGroup = null;
    public $editingUnit = null;
    public $editingValue = null;



    public function mount(Product $product)
    {
        $this->product = $product;

        $this->category = $product->category->id;
    }

    public function editTable($id)
    {
        $table = Specification::findOrFail($id);
        $this->editingTable = $id;
        $this->name = $table->name;
        $this->price = $table->price;
    }

    public function editGroup($id)
    {
        $groups = SpecGroup::findOrFail($id);
        $this->editingGroup = $id;
        $this->group = $groups->title;
    }

    public function editUnit($id)
    {
        $unit = SpecUnit::findOrFail($id);
        $this->editingUnit = $id;
        $this->title = $unit->title;
        $this->filter_id = $unit->filter_id;
    }

    public function editValue($id)
    {
        $value = SpecValue::findOrFail($id);
        $this->editingValue = $id;
        $this->type = $value->type;
        $this->value = $value->value;
        $this->suffix = $value->suffix;
    }

    public function cancelTable()
    {
        $this->editingTable = null;
        $this->reset(['name', 'price']);
    }

    public function cancelGroup()
    {
        $this->editingGroup = null;
        $this->reset(['group']);
    }

    public function cancelUnit()
    {
        $this->editingUnit = null;
        $this->reset(['filter_id', 'title']);
    }

    public function cancelValue()
    {
        $this->editingValue = null;
        $this->reset(['type','value','suffix']);
    }

    public function saveTable()
    {
        if ($this->editingTable)
        {
            $this->validate([
                'name' => 'required|string',
                'price' => 'nullable|numeric',
            ]
            ,
            [
                'name.required'=>'هر جدول باید یک نام داشته باشد',
                'price.numeric'=>'قیمت وارد شده باید عددی باشد',
            ]);

            $table = Specification::findOrFail($this->editingTable);

            $table->update(['name' => $this->name, 'price' => $this->price]);
            $this->reset(['name', 'price','editingTable']);
        }
        else
        {
            $this->validate([
                'name' => 'required|string',
                'price' => 'nullable|numeric',
            ]
            ,
            [
                'name.required'=>'هر گروه باید یک نام داشته باشد',
                'price.numeric'=>'قیمت وارد شده باید عددی باشد',
            ]);

            $this->product->specifications()->create([
                'spec_id'=>$this->activeTable,
                'name' => $this->name,
                'price' => $this->price,
            ]);

            $this->reset(['name','price']);
        }
    }

    public function saveGroup()
    {
        if ($this->editingGroup)
        {
            $this->validate([
                'group' => 'required|string',
            ]
            ,
            [
                'group.required'=>'هر گروه باید یک نام داشته باشد',
            ]);

            $group = SpecGroup::findOrFail($this->editingGroup);
            $group->update(['title' => $this->group]);
            $this->reset(['group','editingGroup']);
        }
        else
        {
            $this->validate([
                'group' => 'required|string',
            ]
            ,
            [
                'group.required'=>'هر گروه باید یک نام داشته باشد',
            ]);


            SpecGroup::create(['specification_id'=>$this->activeTable,'title'=>$this->group]);

            $this->reset(['group']);
        }
    }

    public function saveUnit()
    {


        if ($this->editingUnit)
        {
            $this->validate([
                    'title' => 'required|string',
                    'filter_id' => 'nullable|integer',
                ]
                ,
                [
                    'title.required'=>'هر گروه باید یک نام داشته باشد',
                ]);
            $unit = SpecUnit::findOrFail($this->editingUnit);
            $unit->update(['title' => $this->title,'filter_id'=>$this->filter_id]);
            $this->reset(['title','filter_id','editingUnit']);
        }
        else
        {
            $this->validate([
                    'title' => 'required|string',
                    'filter_id' => 'nullable|integer',
                ]
                ,
                [
                    'title.required'=>'هر گروه باید یک نام داشته باشد',
                ]);

            if(SpecGroup::where('specification_id',$this->activeTable)->exists())
            {
                $activate = SpecUnit::where('group_id',$this->activeGroup)->create([
                'group_id'=>$this->activeGroup,
                'title'=>$this->title,
                'filter_id'=>$this->filter_id
                ]);

                $this->activeUnit = $activate->id;

            }
            else
            {
                $new = SpecGroup::create(['specification_id'=>$this->activeTable,'title'=>'مشخصات']);

                $activate = $new->units()->create(['title'=>$this->title,'filter_id'=>$this->filter_id]);

                $this->activeGroup = $new->id;
                $this->activeUnit = $activate->id;

            }
            $this->reset(['title','filter_id','group']);


        }
    }

    public function saveValue()
    {
        if ($this->editingValue)
        {
            $value = SpecValue::findOrFail($this->editingValue);

            $this->validate([
                'type' => 'required|string',
                'value'=>'required|string',
                'suffix'=>'nullable|string',
            ],
                [
                    'type.required'=>'وارد کردن نوع مقدار ضروری است',
                    'value.required'=>'وارد کردن مقدار ضروری است',
                    'suffix.required'=>'پسوند مقادیر باید متنی باشد'
                ]);

            $value->update([
                'type'=>$this->type,
                'value'=>$this->value,
                'suffix'=>$this->suffix
            ]);

            $this->reset(['type','value','suffix','editingValue']);

        }
        else
        {

            $this->validate([
            'type' => 'required|string',
            'value'=>'required|string',
            'suffix'=>'nullable|string',
            ],
            [
                'type.required'=>'وارد کردن نوع مقدار ضروری است',
                'value.required'=>'وارد کردن مقدار ضروری است',
                'suffix.required'=>'پسوند مقادیر باید متنی باشد'
            ]);

            if(SpecUnit::where('group_id',$this->activeGroup)->exists())
            {
                SpecValue::where('unit_id',$this->activeUnit)->create([
                    'unit_id'=>$this->activeUnit,
                    'type'=>$this->type,
                    'value'=>$this->value,
                    'suffix'=>$this->suffix
                ]);
            }
            else
            {
                $unit = SpecUnit::where('group_id',$this->activeGroup)->create(['group_id'=>$this->activeGroup,'title'=>'عنوان مشخصه']);
                $unit->values()->create([
                    'unit_id'=>$this->activeUnit,
                    'type'=>$this->type,
                    'value'=>$this->value,
                    'suffix'=>$this->suffix
                ]);
            }


            $this->reset(['type','value','suffix','value']);
        }
    }

    public function selectTable($id)
    {
        $this->activeTable = $id;

        if(SpecGroup::where('specification_id',$id)->exists())
        {
            $this->first_group = SpecGroup::where('specification_id',$id)->first()->id;

            if(!$this->first_group)
            {
                $new = SpecGroup::where('specification_id',$id)->create(['specification_id'=>$id,'title'=>'مشخصات']);

                $this->activeGroup = $new->id;
            }
            else
            {
                $this->activeGroup = $this->first_group;
            }
        }
        else
        {
           SpecGroup::where('specification_id',$id)->create(['specification_id'=>$id,'title'=>'مشخصات']);

            $this->activeGroup = SpecGroup::where('specification_id',$id)->first()->id;
        }

        $this->reset(['activeUnit']);

    }

    public function selectGroup($id)
    {
        $this->activeGroup = $id;

        if(SpecUnit::where('group_id',$id)->exists())
        {
        $this->activeUnit = SpecUnit::where('group_id',$id)->first()->id;
        }
        else
        {
            $this->reset(['activeUnit']);
        }

    }

    public function selectUnit($id)
    {
        $this->activeUnit = $id;
        $unit = SpecUnit::findOrFail($id);

        $this->activeGroup = SpecGroup::where('id',$unit->group_id)->first()->id;
    }

    public function deleteTable($id)
    {
        Specification::findOrFail($id)->delete();

        if($this->activeTable == $id)
        {
        $this->reset(['activeTable','activeGroup','activeUnit']);
        }

    }
    public function deleteGroup($id)
    {
        SpecGroup::findOrFail($id)->delete();

        if($this->activeGroup == $id)
        {
            $this->reset(['activeGroup','activeUnit']);
        }
    }
    public function empty($id)
    {
        $group = SpecGroup::findOrFail($id);

        SpecUnit::where('group_id',$group->id)->delete();

        if($this->activeGroup == $id)
        {
            $this->reset(['activeUnit']);
        }
    }

    public function deleteUnit($id)
    {
        SpecUnit::findOrFail($id)->delete();

        if($this->activeUnit == $id)
        {
            $this->reset(['activeUnit']);
        }
    }
    public function deleteValue($id)
    {
        SpecValue::findOrFail($id)->delete();

    }

    public function render()
    {
        $products = $this->product;

        $specifications = Specification::with('groups')->where('product_id',$this->product->id)->get();

        if($specifications->isNotEmpty())
        {
            if (!$this->activeTable)
            {
                $this->activeTable = Specification::where('product_id',$this->product->id)->first()->id;
            }

            if (!$this->activeGroup)
            {

                if(SpecGroup::where('specification_id',$this->activeTable)->exists())
                {
                $this->activeGroup = SpecGroup::where('specification_id',$this->activeTable)->first()->id;
                }
                else
                {
                    $this->activeGroup = null;
                }

            }
        }

        if(SpecUnit::where('group_id',$this->activeGroup)->exists())
        {
            if(!$this->activeUnit)
            {
                $this->activeUnit = SpecUnit::where('group_id',$this->activeGroup)->first()->id;
            }
        }

        $table = Specification::where('id',$this->activeTable)->pluck('name')->first();

        $groups = SpecGroup::with('specification','units')->where('specification_id',$this->activeTable)->get();


        $filters = Filter::where('field_id',3)->where('category_id',$this->product->category->id)->get();


        return view('livewire.dashboard.attachments.specifications',
            compact('products', 'specifications', 'groups', 'table','filters'))
            ->layout('components.layouts.dashboards');
    }
}
