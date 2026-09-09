<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Models\Field;
use App\Models\Filter;
use App\Models\Option;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SelectFilter extends Component
{
    public $type,$id,$model,$field,$category;

    public $selected = [];

    public function mount($type,$id)
    {
        $this->type = $type;
        $this->id = $id;

        $allFields = Field::all();

        $modelClass = "App\\Models\\".ucfirst($type);

        if (!in_array($modelClass,$allFields->pluck('model')->toArray()))
            abort(404);

        $this->model = $modelClass::findOrFail($id);

        $this->field = Field::where('model',$modelClass)->first();

        $this->category = $this->model->category;

    }

    public function toggleOption($id)
    {
        $this->model->relatedOptions()->toggle($id);
    }


    #[Computed]
    public function Filters()
    {
        return Filter::with(['options'=>function($query){
            $query->where('show',1);
        }])
            ->where('category_id', $this->category->id)
            ->OrWhereNull('category_id')
            ->where('field_id', $this->field->id)
            ->where('show',1)
            ->get();
    }

    #[Computed]
    public function selectedOptions($id)
    {
      return $this->model->relatedOptions()
          ->where('option_id',$id)
          ->where('optionable_id',$this->id)
          ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.attachments.select-filter')
            ->layout('components.layouts.dashboards');
    }
}
