<?php

namespace App\Livewire\Dashboard\Attachments\Details;

use App\Models\Product;
use App\Models\Specification;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Table extends Component
{
    public $active;
    public $product;

    public $editing = false;

    public $name,$price;

    public function mount($product)
    {
        $this->product = $product;

        $first = Specification::first()->id;
        $this->active = $this->active ?? $first;

        if($this->active){
            $this->dispatch('table-changed',table:$this->active);
        }
    }

    public function edit($id)
    {
        $table = Specification::findOrFail($id);
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
                    'price' => 'nullable|numeric',
                ]
                ,
                [
                    'name.required'=>'هر جدول باید یک نام داشته باشد',
                    'price.numeric'=>'قیمت وارد شده باید عددی باشد',
                ]);

            $table = Specification::findOrFail($this->editing);

            $table->update(['name' => $this->name, 'price' => $this->price]);
            $this->reset(['name', 'price','editing']);
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
                'spec_id'=>$this->active,
                'name' => $this->name,
                'price' => $this->price,
            ]);

            $this->reset(['name','price']);
        }
    }

    public function delete($id)
    {
        Specification::findOrFail($id)->delete();
    }

    public function select($id)
    {
        $this->active = $id;

        $this->dispatch('table-changed',table:$id);
    }


    #[Computed]
    public function specifications()
    {
        return Specification::where('product_id', $this->product->id)->get();
    }
    public function render()
    {
        return view('livewire.dashboard.attachments.details.table');
    }
}
