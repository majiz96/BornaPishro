<?php

namespace App\Livewire\Dashboard\Attachments\Details;

use App\Models\SpecGroup;
use App\Models\Specification;

use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Group extends Component
{
    public $active;
    public $table;

    public $editing = false;

    public $name;

    public function mount()
    {
        $first = SpecGroup::first()->id;
        $this->active = $this->active ?? $first;

        if ($this->active) {
            $this->dispatch('group-changed',group:$this->active);
        }
    }

    public function edit($id)
    {
        $table = SpecGroup::findOrFail($id);
        $this->editing = $id;
        $this->name = $table->name;
        $this->price = $table->price;
    }

    public function cancel()
    {
        $this->reset('name', 'price', 'editing');
    }

    public function save()
    {
        if ($this->editing)
        {
            $this->validate([
                    'name' => 'required|string',
                ]
                ,
                [
                    'name.required'=>'هر گروه باید یک نام داشته باشد',
                ]);

            $group = SpecGroup::findOrFail($this->editing);
            $group->update(['title' => $this->name]);
            $this->reset(['name','editing']);
        }
        else
        {
            $this->validate([
                    'name' => 'required|string',
                ]
                ,
                [
                    'name.required'=>'هر گروه باید یک نام داشته باشد',
                ]);


            SpecGroup::create(['specification_id'=>$this->table,'title'=>$this->name]);

            $this->reset(['name']);
        }
    }

    public function delete($id)
    {
        SpecGroup::findOrFail($id)->delete();
    }

    public function select($id)
    {
        $this->active = $id;

        $this->dispatch('group-changed',group:$id);
    }

    #[On('table-changed')]
    public function table($table)
    {
        $this->table = $table;
    }

    #[Computed]
    public function groups()
    {
        return SpecGroup::where('specification_id', $this->table)->get();

    }
    public function render()
    {
        return view('livewire.dashboard.attachments.details.group');
    }
}
