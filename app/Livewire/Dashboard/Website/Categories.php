<?php

namespace App\Livewire\Dashboard\Website;

use Illuminate\Validation\Rule;

use Livewire\Component;
use Livewire\Attributes\Validate;

use App\Models\Field;
use App\Models\Category;

class Categories extends Component
{

    public $editingField = null;
    public $editingCategory = null;
    public $editingChild = null;


    public string $field_name;

    public string $category_name;

    public string $child_name;

    public int $field_id;
    public int $parent_id;

    public $fieldActive;
    public $categoryActive;

    public function editField($id)
    {
        $field = Field::findOrFail($id);
        $this->editingField = $field->id;
        $this->field_name = $field->name;
    }

    public function cancelField()
    {
    $this->editingField = null;
    $this->reset(['field_name']);
    }

    public function saveField()
    {
        if($this->editingField)
        {
            $this->validate([
                'field_name' => 'required|string'
            ],
                [
                    'field_name.required' => 'هر زمینه به یک نام نیاز دارد',
                    'field_name.string' => 'نام هر زمینه باید متنی باشد',
                ]);
            Field::findOrFail($this->editingField)->update(['name' => $this->field_name]);
            $this->reset();
        }
        else
        {
            $this->validate([
                'field_name' => 'required|string|unique:categories,name'
            ],
            [
                'field_name.required' => 'هر زمینه به یک نام نیاز دارد',
                'field_name.string' => 'نام هر زمینه باید متنی باشد',
                'field_name.unique' => 'نام زمینه قبلا انتخاب شده است',
            ]);
            Field::create(['name'=>$this->field_name]);
            $this->reset();
        }
    }

    public function deleteField($id)
    {
        Field::findOrFail($id)->delete();

        Category::where('field_id', $id)->delete();

        if(Field::all())
        {
        $this->fieldActive = Field::first()->id;
        }

    }

    public function selectField($id)
    {
        $this->fieldActive = $id;
        $this->editingField = null;
        $this->editingCategory = null;
        $this->reset(['field_name', 'category_name','categoryActive']);

        if(Category::where('field_id', $id)->exists())
        {
            $this->categoryActive = Category::where('field_id', $id)->first()->id;
        }
    }

    // -------------------------------------------------- Category codes -----------------------------------------------------------


    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->category_name = $category->name;
        $this->editingCategory = $category->id;
    }
    public function cancelCategory()
    {
        $this->editingCategory = null;
        $this->reset(['category_name']);
    }

    public function saveCategory()
    {
        if($this->editingCategory)
        {
            $this->validate([
                'category_name'=>[
                    'required',
                    'string',
                    Rule::unique('categories','name')->where('field_id',$this->fieldActive)
                ],
            ],
                [
                'category_name.required' => 'هر زمینه به یک نام نیاز دارد',
                'category_name.string' => 'نام هر زمینه باید متنی باشد',
               'category_name.unique' => 'نام زمینه قبلا انتخاب شده است',
                ]
            );



            Category::findOrFail($this->editingCategory)->update(['name' => $this->category_name]);
            $this->reset(['category_name']);
            $this->editingCategory = null;
        }
        else
        {

            $this->validate([
                'category_name'=>[
                    'required',
                    'string',
                    Rule::unique('categories','name')->where('field_id',$this->fieldActive)
                ],
            ],
                [
                'category_name.required' => 'هر زمینه به یک نام نیاز دارد',
                'category_name.string' => 'نام هر زمینه باید متنی باشد',
                'category_name.unique' => 'نام زمینه قبلا انتخاب شده است',
                ]
            );

            Category::create(['name'=>$this->category_name,'field_id'=>$this->fieldActive]);
            $this->reset(['category_name']);


            if(Category::where('field_id',$this->fieldActive)->exists())
            {
                if(!$this->categoryActive)
                {
                    $this->categoryActive = Category::where('field_id',$this->fieldActive)->first()->id;
                }
            }


        }
    }

    public function deleteCategory($id)
    {
        $delete = Category::findOrFail($id)->delete();

        if(Category::where('field_id',$this->fieldActive)->exists())
        {
            if($this->categoryActive == $id)
            {
                $this->categoryActive = Category::where('field_id',$this->fieldActive)->first()->id;
            }
        }

    }

    public function selectCategory($id)
    {
        $this->categoryActive = $id;
        $this->reset(['category_name','child_name','editingCategory','editingChild']);
    }


    //------------------------------------------------------- sub-categories / branches / childs -------------------------------------------------------------

    public function editChild($id)
    {

        $child=Category::findOrFail($id);

        $this->editingChild = $id;
        $this->child_name = $child->name;
    }
    public function cancelChild()
    {
        $this->reset(['child_name','editingChild']);
    }

    public function saveChild()
    {
        if($this->editingChild)
        {

            $this->validate([
                    'child_name'=>[
                        'required',
                        'string',
                        Rule::unique('categories','name')->where('parent_id',$this->categoryActive)
                    ]
                ]
                ,
                [
                    'child_name.required'=>'نامی برای این زیردسته انتخاب نکرده اید',
                    'child_name.string'=>'نام زیردسته ها باید به صورت متنی باشد',
                    'child_name.unique'=>'این نام قبلا در این دسته بندی انتخاب شده است',
                ]);

//        $data = $this->pull(['child_name'=>$this->child_name,'field_id'=>$this->fieldActive,'parent_id'=>$this->parent_id]);

            Category::findOrFail($this->editingChild)->update(['name'=>$this->child_name]);
            $this->reset(['child_name']);
            $this->editingChild = null;

        }
        else
        {
            $this->validate([
                'child_name'=>[
                    'required',
                    'string',
                    Rule::unique('categories','name')->where('parent_id',$this->categoryActive)
                ]
            ]
            ,
            [
                'child_name.required'=>'نامی برای این زیردسته انتخاب نکرده اید',
                'child_name.string'=>'نام زیردسته ها باید به صورت متنی باشد',
                'child_name.unique'=>'این نام قبلا در این دسته بندی انتخاب شده است',
            ]);

            Category::where('parent_id',$this->categoryActive)->create([
                'name' => $this->child_name,
                'field_id'=>$this->fieldActive,
                'parent_id'=>$this->categoryActive]);

            $this->reset(['child_name']);

        }
    }

    public function deleteChild($id)
    {
        Category::findOrFail($id)->delete();
    }


    public function render()
    {

        if(count(Field::all())>0)
        {
            if(!$this->fieldActive)
            {
                $this->fieldActive = Field::first()->id;
            }
        }

        if(Category::where('field_id',$this->fieldActive)->exists())
        {
            if(!$this->categoryActive)
            {
                $this->categoryActive = Category::where('field_id',$this->fieldActive)->first()->id;
            }
        }


        return view('livewire.dashboard.website.categories',
            ['fields'=>Field::all(),
                'categories'=>Category::where('field_id', $this->fieldActive)->where('parent_id',0)->get(),
                'childs'=>Category::where('parent_id', $this->categoryActive)->get(),
            ])->layout('components.layouts.dashboards');
    }
}
