<?php

namespace App\Livewire\Dashboard\Website;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

use App\Models\Field;
use App\Models\Category;

class Categories extends Component
{

    use WithFileUploads;
    public $editingField,$editingCategory,$editingChild = null;

    public $field_name,$field_route,$field_logo,$field_show,$field_order;

    public string $category_name,$child_name;

    public int $field_id,$parent_id;

    public $fieldActive,$categoryActive,$firstField,$firstCategory;

    public $canActive = true;

    public $permission;

    public function mount()
    {
        Gate::authorize('isManager');


        $this->firstField = Field::orderBy('order','ASC')->first()?->id;

        $this->firstField ? $this->canActive == true : $this->canActive = false;

        if (!$this->firstField)
        {
            $this->canActive = false;
        }

        if($this->canActive)
        {
            $this->fieldActive = $this->firstField;
            $this->categoryActive = Category::where('field_id',$this->fieldActive)->first()?->id;
        }

    }

    public function editField(Field $field)
    {

        if($field->system)
        {
            $this->permission = false;
        }
        $this->field_name = $field->name;
        $this->field_route = $field->route;
        $this->editingField = $field->id;
        $this->field_logo = $field->image;
        $this->field_show = $field->show_menu;
        $this->field_order = $field->order;
    }

    public function cancelField()
    {
    $this->editingField = null;
    $this->reset(['field_name','field_route','field_logo','field_show','field_order','permission']);
    }

    protected $Field_Rules = [
        'field_name' => 'required|string|unique:fields,name',
        'field_route' => 'nullable|string|unique:fields,route',
        'field_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096|unique:fields,image',
    ];

    protected $Field_Messages = [
        'field_name.required' => 'هر زمینه به یک نام نیاز دارد',
        'field_name.string' => 'نام هر زمینه باید متنی باشد',
        'field_name.unique' => 'زمینه ای با این نام وجود دارد',
        'field_route.string' => 'مسیر هر زمینه باید متنی باشد',
        'field_route.unique' => 'زمینه ای با این مسیر وجود دارد',
        'field_logo.image' => 'فایل انتخاب شده تصویر نیست',
        'field_logo.mimes' => 'فایل انتخاب شده از فرمتهای مجاز(jpeg,png,jpg,gif,svg) نیست',
        'field_logo.max' => 'فایل انتخاب شده بزرگتر از ۲ مگابایت ۴ مگابایت است',
        'field_logo.unique' => 'این فایل قبلا انتخاب شده است',
    ];

    protected $Field_Update_Rules = [
        'field_name' => 'required|string',
        'field_route' => 'nullable|string',
    ];

    protected $Field_Update_Messages = [
        'field_name.required' => 'هر زمینه به یک نام نیاز دارد',
        'field_name.string' => 'نام هر زمینه باید متنی باشد',
        'field_route.string' => 'مسیر هر زمینه باید متنی باشد',
    ];


    public function saveField()
    {
        if($this->editingField)
        {
            $field = Field::findOrFail($this->editingField);

            $this->validate($this->Field_Update_Rules , $this->Field_Update_Messages);


            if(!is_string($this->field_logo))
            {
                $this->Field_Update_Rules['image'] ='nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096';
                $this->Field_Update_Messages['image.image'] = 'فایل انتخاب شده تصویر نیست';
                $this->Field_Update_Messages['image.mimes'] = 'فایل انتخاب شده از فرمتهای مجاز(jpeg,png,jpg,gif,svg) نیست';
                $this->Field_Update_Messages['image.max'] = 'فایل انتخاب شده بزرگتر از ۴ مگابایت است';

                Storage::disk('public')->delete('field_logos/'.$field->image);

                $logoname = uniqid('logo_').'.'.$this->field_logo->getClientOriginalExtension();
                $this->field_logo->storeAs('field_logos', $logoname , 'public');
            }
            else
            {
                $logoname = $this->field_logo;
            }


            Field::findOrFail($this->editingField)->update([

                'name' => $this->field_name,
                'route' => $this->field_route,
                'order' =>  $this->field_order,
                'image' => $logoname,
                'show_menu' => $this->field_show,
            ]);

            $this->reset('field_name','field_route','field_logo','field_order');
        }
        else
        {
            $this->validate($this->Field_Rules , $this->Field_Messages);

            if($this->field_logo && !is_string($this->field_logo))
            {
                $logoname = uniqid('logo_').'.'.$this->field_logo->getClientOriginalExtension();
                $this->field_logo->storeAs('field_logos', $logoname, 'public');
            }
            else
            {
                $this->field_logo = [];
            }


            Field::create([
                'name'=>$this->field_name,
                'route'=>$this->field_route,
                'image'=>$logoname ?? '',
                'order'=>$this->field_order,
                'show_menu'=>$this->field_show,
            ]);

            $this->reset('field_name','field_route','field_logo','field_order','image');
        }
    }

    public function deleteField($id)
    {
        $field = Field::findOrFail($id);

        if(!$field->system)
        {
            $field->delete();
            Storage::disk('public')->delete('field_logos/'.$field->image);

            if(Field::all())
            {
                $this->fieldActive = Field::first()->id ?? null;
            }
        }

    }

    public function selectField($id)
    {
        $this->fieldActive = $id;
        $this->editingField = null;
        $this->editingCategory = null;
        $this->reset(['field_name', 'category_name','categoryActive']);

        if ($this->canActive)
        {
            $this->categoryActive = Category::where('field_id',$this->fieldActive)->first()?->id;
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
                    Rule::unique('categories','name')
                        ->where('field_id',$this->fieldActive)
                ],
            ],
                [
                'category_name.required' => 'هر زمینه به یک نام نیاز دارد',
                'category_name.string' => 'نام هر زمینه باید متنی باشد',
               'category_name.unique' => 'نام زمینه قبلا انتخاب شده است',
                ]
            );



            $category = Category::findOrFail($this->editingCategory);
            $category->update(['name' => $this->category_name]);

            Cache::forget("menu-categories-{$category->field_id}");

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

            $category = Category::create(['name'=>$this->category_name,'field_id'=>$this->fieldActive]);

            Cache::forget("menu-categories-{$category->field_id}");
            $this->reset(['category_name']);


            if ($this->canActive && !$this->categoryActive)
            {
                $this->categoryActive = $this->firstCategory;
            }


        }
    }

    public function deleteCategory($id)
    {
        $delete = Category::findOrFail($id);

        $delete->delete();

        Cache::forget("menu-categories-{$delete->field_id}");

        if ($this->canActive && !$this->categoryActive)
        {
            $this->categoryActive = $this->firstCategory;
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
                        Rule::unique('categories','name')
                            ->where('parent_id',$this->categoryActive)
                    ]
                ]
                ,
                [
                    'child_name.required'=>'نامی برای این زیردسته انتخاب نکرده اید',
                    'child_name.string'=>'نام زیردسته ها باید به صورت متنی باشد',
                    'child_name.unique'=>'این نام قبلا در این دسته بندی انتخاب شده است',
                ]);

//        $data = $this->pull(['child_name'=>$this->child_name,'field_id'=>$this->fieldActive,'parent_id'=>$this->parent_id]);

            $child = Category::findOrFail($this->editingChild);
            $child->update(['name'=>$this->child_name]);
            Cache::forget("menu-categories-{$child->field_id}");
            $this->reset(['child_name']);
            $this->editingChild = null;

        }
        else
        {
            $this->validate([
                'child_name'=>[
                    'required',
                    'string',
                    Rule::unique('categories','name')
                        ->where('parent_id',$this->categoryActive)
                ]
            ]
            ,
            [
                'child_name.required'=>'نامی برای این زیردسته انتخاب نکرده اید',
                'child_name.string'=>'نام زیردسته ها باید به صورت متنی باشد',
                'child_name.unique'=>'این نام قبلا در این دسته بندی انتخاب شده است',
            ]);

            $child = Category::where('parent_id',$this->categoryActive)->create([
                'name' => $this->child_name,
                'field_id'=>$this->fieldActive,
                'parent_id'=>$this->categoryActive]);

            Cache::forget("menu-categories-{$child->field_id}");

            $this->reset(['child_name']);

        }
    }

    public function deleteChild($id)
    {
        $delete = Category::findOrFail($id);
        $delete->delete();
        Cache::forget("menu-categories-{$delete->field_id}");
    }


    #[Computed]
    public function Categories()
    {
        return Category::where('field_id', $this->fieldActive)
            ->where('parent_id',null)
            ->get();
    }

    #[Computed]
    public function Children()
    {
        return Category::where('field_id', $this->fieldActive)
            ->where('parent_id',$this->categoryActive)
            ->whereNotNull('parent_id')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.website.categories', ['fields'=>Field::Cached()])
            ->layout('components.layouts.dashboards');
    }
}
