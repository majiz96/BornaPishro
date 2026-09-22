<?php

namespace App\Livewire\Dashboard\Products;

use App\Livewire\Products;
use App\Models\Category;
use App\Models\Field;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class Discounts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $product,$price,$categoryPrice;

    public $perPage = 5;
    public $sort = 'created_at';
    public $direction = 'desc';
    public $search = '';

    public $discount = 0;
    public string $tab = 'products';
    public $counter = 1;

    public $editing = null;

    public $multiple = false;
    public $grouped = [];
    public $selectedProducts = [];
    public $selectedCategories = [];

    public $field;

    public function mount()
    {
        Gate::authorize('isAdmin');

        $this->field = Field::where('model', Product::class)->first()?->id;

    }
    public function setDiscount($id)
    {
        $product = Product::findOrFail($id);
        $this->product = $product->name;
        $this->discount = $product->discount;
        $this->price = $product->price;
        $this->editing = $product->id;
    }

    public function removeDiscount($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['discount' => null]);
    }
    public function multipleRemove()
    {
        Product::whereIn('id', $this->selectedProducts)->update(['discount' => null]);
        $this->selectedProducts = [];
    }
    public function removeCategoryDiscount($id)
    {
        $group = Category::where('id', $id)
            ->orWhere('parent_id', $id)
            ->pluck('id')
            ->toArray();

        Product::whereIn('category_id',$group)->update(['discount' => null]);
        $this->tab = 'products';
    }
    public function removeSelectedCategoryDiscount()
    {
        $group = Category::whereIn('id', $this->selectedCategories)
            ->orWhereIn('parent_id', $this->selectedCategories)
            ->pluck('id')
            ->toArray();

        Product::whereIn('category_id',$group)->update(['discount' => null]);
        $this->tab = 'products';

        $this->selectedCategories = [];
    }
    public function cancel()
    {
       $this->reset(['price', 'product', 'discount', 'editing']);
    }
    public function cancelList()
    {
       $this->selectedProducts = [];
       $this->selectedCategories = [];
       $this->reset(['price', 'product', 'discount','multiple','grouped']);
    }

    public function save()
    {
        if($this->multiple)
        {
            Product::whereIn('id', $this->selectedProducts)->update(['discount' => $this->discount]);
            $this->reset(['price', 'product', 'discount', 'editing','multiple']);
            $this->selectedProducts = [];
        }
        elseif ($this->grouped)
        {
            Product::whereIn('category_id',$this->grouped)->update(['discount' => $this->discount]);
            $this->reset(['price', 'product', 'discount', 'editing','grouped']);
            $this->selectedCategories = [];
        }
        else
        {
            $product = Product::findOrFail($this->editing);
            $product->update(['discount' => $this->discount]);
            $this->reset(['price', 'product', 'discount', 'editing','grouped']);
        }

    }

    public function multipleDiscount()
    {
        $this->multiple = true;
        $this->grouped = [];
        $this->selectedProducts = [];
        $this->selectedCategories = [];

    }

    public function categoryDiscount($id)
    {
        $this->grouped = Category::where('id', $id)
            ->orWhere('parent_id', $id)
            ->pluck('id')
            ->toArray();

        $this->multiple = null;
        $this->selectedProducts = [];
        $this->selectedCategories = [];
    }

    public function SelectedCategoryDiscount()
    {
        $this->grouped = Category::whereIn('id', $this->selectedCategories)
            ->orWhereIn('parent_id', $this->selectedCategories)
            ->pluck('id')
            ->toArray();

        $this->multiple = null;
        $this->selectedProducts = [];
    }

    #[Computed]
    public function categories()
    {
        return Category::with('children','products')
            ->where('field_id', $this->field)
            ->get()
            ->filter->has_price
            ->values();
    }

    #[Computed]
    public function productList()
    {
        return Product::whereIn('id',$this->selectedProducts)->get();
    }

    #[Computed]
    public function groupedList()
    {
        return Product::whereIn('category_id',$this->grouped)->get();
    }

    #[Computed]
    public function Products()
    {
        return Product::with('category','brand')
            ->where('price','>',0)
            ->where('name','like','%'.$this->search.'%')
            ->orWhere('fullname','like','%'.$this->search.'%')
            ->orWhere('brand_name','like','%'.$this->search.'%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.dashboard.products.discounts')
            ->layout('components.layouts.dashboards');
    }
}
