<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Models\Product;
use App\Models\File;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Files extends Component
{
    use WithFileUploads;

    public $product;

    public $files = [];
    public $uploadedFiles = [];
    public string $uploadTip='فقط فایلهای آفیس و یا pdf و rar و zip ';

    public int $counter = 1;

    public string $name;

    public $editing = null;

    public $selected = [];
    public $selectAll = false;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function updatedFiles()
    {
        $this->uploadedFiles = [];

        foreach ($this->files as $file)
        {
            $this->uploadedFiles[] = $file->getClientOriginalName();
        }
    }

    public function save()
    {

       $this->validate([
       'files' => 'required|array|',
       'files.*' => 'file|mimes:pdf,zip,rar,doc,docx,xls,xlsx,ppt,pptx|max:20480',
       ]);

       foreach ($this->files as $file)
       {
       $filestore = uniqid('product_'.$this->product->id.'_') . '.' . $file->getClientOriginalExtension();
       $file->storeAs('files', $filestore, 'public');

       File::create([
            'file'=>$file->getClientOriginalName(),
            'filename'=>$filestore,
            'size'=>($file->getSize() )/ 1024/ 1024 ,2 ,
            'fileable_id'=>$this->product->id,
            'fileable_type'=>Product::class
          ]);
       }


        $this->files = [];
       $this->uploadedFiles = [];
    }

    public function edit($id)
    {
        $this->editing = $id;
        $this->name = File::where('id',$id)->first()->file;
    }

    public function rename()
    {
        File::where('id',$this->editing)->update(['file'=>$this->name]);
        $this->editing = null;
    }

    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->selected = File::where('fileable_id',$this->product->id)->pluck('id')->toArray();
        }
        else
        {
            $this->selectAll = false;
            $this->selected = [];
        }
    }

    public function delete($id)
    {
        $file = File::findOrFail($id);
        Storage::disk('public')->delete('files/'.$file->filename);
        $file->delete();
    }

    public function deleteSelected()
    {
        $files = File::whereIn('id', $this->selected)->pluck('filename')->toArray();

        foreach ($files as $file)
        {
            Storage::disk('public')->delete('files/'.$file);
        }

        File::whereIn('id', $this->selected)->delete();

    }

    public function render()
    {
        $products = Product::findOrFail($this->product->id);

        $pf = File::where('fileable_id', $this->product->id)->where('fileable_type', Product::class)->get();

        return view('livewire.dashboard.attachments.files',['products'=>$products, 'product_files'=>$pf]);
    }
}
