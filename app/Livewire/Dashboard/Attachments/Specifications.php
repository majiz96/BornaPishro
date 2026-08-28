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

use Livewire\Attributes\Computed;
use Livewire\Component;

class Specifications extends Component
{
    public $product,$category,$name,$price,$group,$title,$value,$suffix,$filter_id;

    public $type = 'string';

    public $activeTable,$activeGroup,$activeUnit,$first_table,$first_group,$first_unit;

    public $editingTable = null;
    public $editingGroup = null;
    public $editingUnit = null;
    public $editingValue = null;
    public $canActive = true;

    public $cloneList = false;

    public $cloneCategory,$cloneProduct,$cloneTable;
    public $cloneCategoryName,$cloneProductName,$cloneTableName;

    public string $cloneCategorySearch = '';
    public string $cloneProductSearch = '';

    public $showCategoryList = false;
    public $showProductList = false;
    public $showTableList = false;

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->category = $product->category->id;


        $this->first_table = Specification::where('product_id',$this->product->id)->first()?->id;

        if(!$this->first_table)
        {
            $this->canActive = false;
        }


        if($this->canActive)
        {

            if(!$this->activeTable)
            {
                $this->activeTable = $this->first_table;
                $firstGroup = SpecGroup::where('specification_id',$this->activeTable)->first()->id;
            }

            if($firstGroup && !$this->activeGroup)
            {
                $this->activeGroup = $firstGroup;
                $this->first_unit = SpecUnit::where('group_id',$this->activeGroup)->first()?->id;
            }

            if($this->first_unit && !$this->activeUnit)
            {
                $this->activeUnit = $this->first_unit;
            }
        }


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
            $unit->update(['title' => $this->title,'filter_id' => $this->filter_id]);
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
                    'filter_id'=>$this->filter_id,
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

        $this->activeTable = $this->first_table;


    }
    public function deleteGroup($id)
    {
        SpecGroup::findOrFail($id)->delete();

        if($this->activeGroup == $id)
        {
            $this->reset(['activeGroup','activeUnit']);
        }

        $this->activeGroup = $this->first_group;
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
        $this->activeUnit = $this->first_unit;
    }
    public function deleteValue($id)
    {
       SpecValue::findOrFail($id)->delete();
    }

    public function duplicate(Specification $table)
    {
        $newTable = Specification::create([
            'product_id' => $table->product_id,
            'name' => $table->name . '(جدید)',
            'price' => $table->price,
        ]);

        foreach ($table->groups as $group)
        {
            $newGroup = SpecGroup::create([
                'specification_id' => $newTable->id,
                'title' => $group->title,
            ]);

            foreach($group->units as $unit)
            {
                $newUnit = SpecUnit::create([
                    'group_id' => $newGroup->id,
                    'filter_id' => $unit->filter_id,
                    'title' => $unit->title,
                ]);

                foreach($unit->values as $value)
                {
                    SpecValue::create([
                        'unit_id' => $newUnit->id,
                        'value' => $value->value,
                        'suffix' => $value->suffix,
                    ]);
                }
            }
        }


    }

    public function openCloneList()
    {
        $this->cloneList = true;
    }
    public function closeCloneList()
    {
        $this->cloneList = false;
    }

    public function chooseCategory(Category $category)
    {
        $this->cloneCategoryName = $category->name;
        $this->cloneCategory = $category->id;
        $this->showCategoryList = false;
    }
    public function chooseProduct(Product $product)
    {
        $this->cloneProductName = $product->name;
        $this->cloneProduct = $product->id;
        $this->showProductList = false;
    }

    public function cloneProductTable(Specification $table)
    {
        $cloneTable = Specification::create([
            'product_id' => $this->product->id,
            'name' => $table->name.' (جدید) ',
            'price' => $table->price,
        ]);

        foreach ($table->groups as $group)
        {
            $cloneGroup = SpecGroup::create([
                'specification_id' => $cloneTable->id,
                'title' => $group->title,
            ]);

            foreach($group->units as $unit)
            {
                $cloneUnit = SpecUnit::create([
                    'group_id' => $cloneGroup->id,
                    'filter_id' => $unit->filter_id,
                    'title' => $unit->title,
                ]);

                foreach($unit->values as $value)
                {
                    SpecValue::create([
                        'unit_id' => $cloneUnit->id,
                        'value' => $value->value,
                        'suffix' => $value->suffix,
                    ]);
                }
            }
        }

        $this->first_table = Specification::where('product_id',$this->product->id)->first()?->id;

        if(!$this->first_table)
        {
            $this->canActive = false;
        }

        $this->activeTable = $this->first_table;

        $this->reset([
            'cloneTable','cloneProduct','cloneTable',
            'cloneCategoryName','cloneProductName',
            'showCategoryList','showProductList',
            'cloneList']);

    }


    #[Computed]
    public function Categories()
    {
        $query = Category::query()->where('field_id',3);

        if($this->cloneCategorySearch)
        {
            $query->where('name','like','%'.$this->cloneCategorySearch.'%');
        }

        return $query->get();
    }
    #[Computed]
    public function Products()
    {
        $query = Product::query();

        if ($this->cloneProductSearch)
        {
            $query->where('name','like','%'.$this->cloneProductSearch.'%');
        }

        if($this->cloneCategoryName)
        {
            $query->where('category_id',$this->cloneCategory);
        }

        return $query->get();

    }

    #[Computed]
    public function CloneTable()
    {
        return Specification::where('product_id',$this->cloneProduct)->get();
    }

    #[Computed]
    public function Tables()
    {

        return Specification::where('product_id',$this->product->id)->get();

    }

    #[Computed]
    public function Groups()
    {
        return SpecGroup::where('specification_id',$this->activeTable)->get();
    }

    #[Computed]
    public function Filters()
    {
        return Filter::where('category_id',$this->product->category->id)
            ->where('show',true)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.attachments.specifications')
            ->layout('components.layouts.dashboards');
    }
}
