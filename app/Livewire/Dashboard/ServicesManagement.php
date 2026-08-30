<?php

namespace App\Livewire\Dashboard;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Service;

use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class ServicesManagement extends Component
{
    use WithFileUploads;

    public string $message = '';

    public $category_id,$filter_id,$title,$intro,$description,$cover,$thumbnail,$show;

    public $activeParent,$activeChild;

    public $editing = null;

    public $modal = false;

    public $modalTitle,$modalDescription;

    public $rules = [
        'category_id' => 'required',
        'filter_id' => 'nullable',
        'title'=>'required',
        'intro'=>'required',
        'description'=>'required',
        'cover'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'thumbnail'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    public $messages = [
        'category_id.required'=>'هر مورد باید دسته مشخصی داشته باشد',
        'title.required'=>'هر مورد باید عنوانی داشته باشد',
        'intro.required'=>'هر مورد به یک مقدمه نیاز دارد',
        'description.required'=>'متن را وارد نکرده اید',
        'cover.required'=>'تصویر را انتخاب نکرده اید',
        'cover.image'=>'فایل انتخاب شده یک تصویر نیست',
        'cover.mimes'=>'تصویر انتخاب شده از فرمتهای رایج (jpeg,jpg,png,gif,svg) نیست',
        'cover.max'=>'تصویر انتخاب شده بزرگتر از ۲ مگابایت است',
        'thumbnail.required'=>'تصویر کوچک را انتخاب نکرده اید',
        'thumbnail.image'=>'فایل انتخاب شده یک تصویر نیست',
        'thumbnail.mimes'=>'تصویر انتخاب شده از فرمتهای رایج (jpeg,jpg,png,gif,svg) نیست',
        'thumbnail.max'=>'تصویر انتخاب شده بزرگتر از ۲ مگابایت است',
    ];

    public $editRules = [
        'category_id' => 'required',
        'filter_id' => 'nullable',
        'title'=>'required',
        'intro'=>'required',
        'description'=>'required',
    ];

    public $editMessages = [
        'category_id.required'=>'هر مورد باید دسته مشخصی داشته باشد',
        'title.required'=>'هر مورد باید عنوانی داشته باشد',
        'intro.required'=>'هر مورد به یک مقدمه نیاز دارد',
        'description.required'=>'متن را وارد نکرده اید',
    ];

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->editing = $id;

        $this->category_id = $service->category_id;
        $this->filter_id = $service->filter_id;
        $this->title = $service->title;
        $this->intro = $service->intro;
        $this->description = $service->description;
        $this->cover = $service->cover;
        $this->thumbnail = $service->thumbnail;
    }

    public function cancel()
    {
        $this->reset();
        $this->editing = null;
    }

    public function save()
    {
        if($this->editing)
        {
            $service = Service::findOrFail($this->editing);

            if(!is_string($this->cover))
            {
                $this->editRules['cover'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                $this->editMessages['cover.image'] = 'فایل انتخاب شده یک تصویر نیست';
                $this->editMessages['cover.mimes'] = 'تصویر انتخاب شده از فرمتهای رایج (jpeg,jpg,png,gif,svg) نیست';
                $this->editMessages['cover.max'] = 'تصویر انتخاب شده بزرگتر از ۲ مگابایت است';

                Storage::disk('public')->delete('service_covers/'.$service->cover);

                $covername = uniqid('cover_') . '.' . $this->cover->getClientOriginalExtension();
                $this->cover->storeAs('service_covers', $covername, 'public');
            }
            else
            {
                $covername = $this->cover;
            }

            if(!is_string($this->thumbnail))
            {
                $this->editRules['thumbnail'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                $this->editMessages['thumbnail.image'] = 'فایل انتخاب شده یک تصویر نیست';
                $this->editMessages['thumbnail.mimes'] = 'تصویر انتخاب شده از فرمتهای رایج (jpeg,jpg,png,gif,svg) نیست';
                $this->editMessages['thumbnail.max'] = 'تصویر انتخاب شده بزرگتر از ۲ مگابایت است';

                Storage::disk('public')->delete('service_thumbnails/'.$service->thumbnail);

                $thumbnailname = uniqid('thumbnail_') . '.' . $this->thumbnail->getClientOriginalExtension();
                $this->thumbnail->storeAs('service_thumbnails', $thumbnailname, 'public');
            }
            else
            {
                $thumbnailname = $this->thumbnail;
            }

            $this->validate($this->editRules,$this->editMessages);

            $service->update([
                'category_id' => $this->category_id,
                'filter_id' => $this->filter_id,
                'title' => $this->title,
                'intro' => $this->intro,
                'description' => $this->description,
                'cover' => $covername,
                'thumbnail' => $thumbnailname,
                'show'=>0
            ]);
            $this->reset(['cover','thumbnail','editing','category_id','title','intro','description','filter_id']);
        }
        else
        {
            if($this->cover && !is_string($this->cover) && $this->thumbnail && !is_string($this->thumbnail))
            {
                $covername = uniqid('cover_') . '.' . $this->cover->getClientOriginalExtension();
                $this->cover->storeAs('service_covers', $covername, 'public');

                $thumbnailname = uniqid('thumbnails_').'.'.$this->thumbnail->getClientOriginalExtension();
                $this->thumbnail->storeAs('service_thumbnails', $thumbnailname, 'public');
            }
            else
            {
                $covername = [];
                $thumbnailname = [];
            }

            $this->validate($this->rules,$this->messages);


            Service::create(
                [
                    'category_id' => $this->category_id,
                    'filter_id' => $this->filter_id,
                    'title' => $this->title,
                    'intro' => $this->intro,
                    'description' => $this->description,
                    'cover' => $covername,
                    'thumbnail' => $thumbnailname,
                    'show'=> 0
                ]
            );
            $this->reset(['cover','thumbnail','category_id','title','intro','description','filter_id']);
        }
    }

    public function selectParent($id)
    {
        $this->activeParent = $id;

        $count = Category::where('field_id',2)->where('parent_id',$id)->count();

        if ($count > 0)
        {
            $this->activeChild = Category::where('field_id',2)->where('parent_id',$this->activeParent)->first()->id;
        }
        else
        {
            $this->activeChild = Category::where('field_id',2)->where('parent_id',null)->first()->id;
        }

    }

    public function toggleShow($id)
    {
        $service = Service::findOrFail($id);
        $service->show = $service->show == 1 ? 0 : 1;
        $service->save();
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);
        Storage::disk('public')->delete('service_covers/'.$service->cover);
        Storage::disk('public')->delete('service_thumbnails/'.$service->thumbnail);
        $service->delete();
    }

    public function see($id)
    {
        $this->modal = true;

        $service = Service::findOrFail($id);
        $this->modalTitle = $service->title;
        $this->modalDescription = $service->description;
    }

    public function uploadSummernoteImage()
    {
        $filename = uniqid('SIMG_') . '.' . $this->summernoteImage->getClientOriginalExtension();
        $this->summernoteImage->storeAs('summernote_images', $filename, 'public');

        $url = Storage::disk('public')->url("summernote_service_images/{$filename}");

        $this->dispatch('summernote-image-uploaded', url: $url);

        $this->reset('summernoteImage');
    }

    #[Computed]
    public function filters()
    {
        return Filter::where('field_id',2)
            ->where('category_id',$this->activeChild)
            ->orWhere('category_id',$this->activeParent)
            ->orWhere('category_id',200)
            ->where('show',1)
            ->get();
    }

    public function render()
    {
        $categories = Category::with('children','parent')->where('field_id',2)->where('parent_id',null)->get();

        if(!$this->activeParent)
        {
            $this->activeParent = Category::where('field_id',2)->where('parent_id',null)->first()->id;
        }

        if(!$this->activeChild)
        {
            if (!$this->activeParent)
            {
                $this->activeChild = Category::where('field_id',1)->where('parent_id',$this->activeParent)->first()->id;
            }
            else
            {
                $this->activeChild = Category::where('field_id',1)->where('parent_id',null)->first()->id;
            }

        }

        $children = Category::with('children','parent')->where('field_id',2)->where('parent_id',$this->activeParent)->get();

        $services = Service::where('category_id',$this->activeChild)->get();

        return view('livewire.dashboard.services-management',compact('categories','children','services'))
            ->layout('components.layouts.dashboards');
    }
}
