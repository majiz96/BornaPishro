<?php

namespace App\Livewire\Dashboard\Website;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Category;
use App\Models\Field;
use App\Models\Filter;
use App\Models\SpecUnit;
use App\Models\SpecValue;
class Filters extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $field_id,$category_id,$title,$show,$activeField;

    public $counter = 1;
    public $counterModal = 1;
    public $editing = null;
    public $selected = [];
    public $selectAll = false;
    public $showed = [];
    public $filterModal = false;

    public $filterUnit,$filterTitle,$filterCat;

    public $perPage = 5;
    public $search = '';

    public $sort = 'created_at';
    public $direction = 'desc';

    public $rules = [
        'field_id' => 'required',
        'category_id' => 'nullable',
        'title' => 'required',
    ];
    public $messages = [
        'field_id.required' => 'انتخاب موضوع لازم است',
        'title.required'=>'عنوانی برای فیلتر ننوشتید',
    ];

    public function mount()
    {

        if(!$this->activeField)
        {
            $this->activeField = Field::all()->first()?->id;
        }

        $this->showed = Filter::where('field_id',$this->activeField)->where('show',1)->pluck('id')->toArray();
    }

    public function edit($id)
    {
        $filter = Filter::findOrFail($id);
        $this->editing = $id;
        $this->field_id = $filter->field_id;
        $this->category_id = $filter->category_id;
        $this->title = $filter->title;
    }
    public function cancel()
    {
        $this->reset(['field_id','category_id','title','editing']);
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
           ]);

           $this->reset(['field_id','category_id','title','editing']);
        }
        else
        {
            Filter::create([
                'field_id' => $this->field_id,
                'category_id' => $this->category_id,
                'title' => $this->title,
            ]);

            $this->reset(['field_id','category_id','title']);
        }
    }

    public function selectField($id)
    {
        $this->activeField = $id;
    }

    public function toggleShow($id)
    {
        $filter = Filter::findOrFail($id);
        $filter->show = $filter->show == true ? false : true;
        $filter->save();

        $this->showed = Filter::where('field_id',$this->activeField)->where('show',1)->pluck('id')->toArray();
    }

    public function showAll()
    {
        Filter::where('field_id', $this->activeField)->where('show', 0)->update(['show' => 1]);
        $this->showed = Filter::where('field_id',$this->activeField)->where('show',1)->pluck('id')->toArray();
    }

    public function showNone()
    {
        Filter::where('field_id', $this->activeField)->where('show', 1)->update(['show' => 0]);
        $this->showed = [];
        $this->showed = Filter::where('field_id',$this->activeField)->where('show',1)->pluck('id')->toArray();
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

        $this->filterUnit = $filter->units()
            ->with(['values','specGroup.specification.product'])
            ->get();

        $category = Category::findOrFail($filter->category_id);
        $this->filterCat = $category->name;
    }

    public function remove($id)
    {
        $unit = SpecUnit::findOrFail($id);
        $unit->update(['filter_id' => null]);
        $this->reset();
    }

    #[Computed]
    public function Fields()
    {
        return Field::all();
    }

    #[Computed]
    public function Categories()
    {
        if ($this->Fields())
        {
            return Category::with('children','parent')
                ->where('parent_id',null)
                ->where('field_id',$this->field_id)
                ->get();
        }
        else
        {
            return Category::where('parent_id',null)->get();
        }
    }

    #[Computed]
    public function Filters()
    {

        $query = Filter::with('category')
            ->where('field_id',$this->activeField)
            ->where('title','like','%'.$this->search.'%')
            ->orWhereNull('category_id')
            ->where('field_id',$this->activeField)
            ->orderBy($this->sort,$this->direction);

        return ($this->perPage == "") ? $query->get() : $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.dashboard.website.filters')
            ->layout('components.layouts.dashboards');
    }
}
