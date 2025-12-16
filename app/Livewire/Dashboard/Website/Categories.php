<?php

namespace App\Livewire\Dashboard\Website;

use Livewire\Component;
use Livewire\Attributes\Validate;

use App\Models\Field;
use App\Models\Category;

class Categories extends Component
{

    public $editingField = null;
    public $editingCategory = null;

    #[validate('required',message: 'نام زمینه را باید وارد کنید')]
    #[validate('string',message: 'نام زمینه معتبر نیست')]
    public string $field_name;

    #[validate('required',message: 'نام دسته را باید وارد کنید')]
    #[validate('string',message: 'نام دسته معتبر نیست')]
    public string $category_name;
    public int $parent_id;

    public $fieldActive = 1;


    public function editField($id)
    {
        $field = Field::findOrFail($id);
        $this->editingField = $field->id;
        $this->field_name = $field->name;
    }

    public function cancelField()
    {
    $this->editingField = null;
    $this->reset();
    }

    public function saveField()
    {
        if($this->editingField)
        {
            $this->validate();
            Field::findOrFail($this->editingField)->update(['name' => $this->field_name]);
            $this->reset();
        }
        else
        {
            $this->validate();
            Field::create(['name'=>$this->field_name]);
            $this->reset();
        }
    }

    public function deleteField($id)
    {
        $field = Field::findOrFail($id);
        $field->delete();

        if ($this->fieldActive == $id)
        {
            $this->fieldActive = 1;
        }
    }

    public function selectField($id)
    {
        $this->fieldActive = $id;
    }

    // -------------------------------------------------- Category codes -----------------------------------------------------------


    public function editCategory($id)
    {

    }
    public function cancelCategory()
    {
        $this->editingCategory = null;
    }

    public function saveCategory()
    {
        if($this->editingCategory)
        {

        }
        else
        {
            $this->validate();

        }
    }

    public function deleteCategory($id)
    {

    }

    public function selectCategory($id)
    {

    }

    public function render()
    {
        return view('livewire.dashboard.website.categories',['fields'=>Field::all(),'categories'=>Category::all()])
            ->layout('components.layouts.dashboards');
    }
}
