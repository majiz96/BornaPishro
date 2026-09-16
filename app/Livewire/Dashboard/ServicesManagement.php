<?php

namespace App\Livewire\Dashboard;

use App\Models\Category;
use App\Models\Field;
use App\Models\Filter;
use App\Models\Service;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class ServicesManagement extends Component
{
    use WithFileUploads;

    public $field_id;
    public string $err = '';

    public $category_id,$filter_id,$title,$intro,$content,$cover,$thumbnail,$show;

    public $activeParent,$activeChild,$firstParent,$firstChild,$canActive;

    public $editing = null;

    public $modal = false;

    public $search = '';

    public $direction = 'DESC';

    public $sort = 'created_at';

    public $perPage = 10;

    public $modalTitle,$modalDescription;

    public $summernoteImage;

    public $rules = [
        'category_id' => 'required',
        'filter_id' => 'nullable',
        'title'=>'required',
        'intro'=>'required',
        'content'=>'required|string',
        'cover'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'thumbnail'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];

    public $messages = [
        'category_id.required'=>'هر مورد باید دسته مشخصی داشته باشد',
        'title.required'=>'هر مورد باید عنوانی داشته باشد',
        'intro.required'=>'هر مورد به یک مقدمه نیاز دارد',
        'content.required'=>'متن را وارد نکرده اید',
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
        'content'=>'required',
    ];

    public $editMessages = [
        'category_id.required'=>'هر مورد باید دسته مشخصی داشته باشد',
        'title.required'=>'هر مورد باید عنوانی داشته باشد',
        'intro.required'=>'هر مورد به یک مقدمه نیاز دارد',
        'content.required'=>'متن را وارد نکرده اید',
    ];

    public function mount()
    {
        Gate::authorize('isAdmin');

        $this->field_id = Field::where('model',Service::class)->first()?->id;

        $this->canActive = Category::exists();

        if ($this->canActive)
        {
            $this->firstParent = Category::where('field_id',$this->field_id)->first()?->id;
            $this->activeParent = $this->firstParent;

            if($this->activeParent)
            {
                $this->firstChild = Category::where('parent_id', $this->activeParent)->first()?->id;
                $this->activeChild = $this->firstChild;
            }
        }
        else
        {
            $this->err = 'Ahhhhoooooy';
        }
    }

    #[On('summernote-updated')]
    public function updateContent($content)
    {
        $this->content = $content;
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->editing = $id;

        $this->category_id = $service->category_id;
        $this->filter_id = $service->filter_id;
        $this->title = $service->title;
        $this->intro = $service->intro;
        $this->content = $service->description;
        $this->cover = $service->cover;
        $this->thumbnail = $service->thumbnail;
        $this->show = $service->show;

        $this->dispatch('summernote-fill',content: $this->content);
    }

    public function cancel()
    {
        $this->editing = null;
        $this->reset(['cover','thumbnail','category_id','title','intro','content','filter_id']);
        $this->dispatch('summernote-fill',content: $this->content);
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
                'description' => $this->content,
                'cover' => $covername,
                'thumbnail' => $thumbnailname,
            ]);
            $this->reset(['cover','thumbnail','editing','category_id','title','intro','content','filter_id']);

            $this->dispatch('summernote-fill',content: $this->content);
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
                    'description' => $this->content,
                    'cover' => $covername,
                    'thumbnail' => $thumbnailname,
                    'show'=> 0
                ]
            );
            $this->reset(['cover','thumbnail','category_id','title','intro','content','filter_id']);

            $this->dispatch('summernote-fill',content: $this->content);
        }
    }

    public function selectParent($id)
    {
        $this->activeParent = $id;

        $count = Category::where('field_id',$this->field_id)->where('parent_id',$id)->count();

        if ($count > 0)
        {
            $this->activeChild = Category::where('field_id',$this->field_id)->where('parent_id',$this->activeParent)->first()->id;
        }
        else
        {
            $this->activeChild = Category::where('field_id',$this->field_id)->where('parent_id',null)->first()->id;
        }

    }

    public function selectChildren($id)
    {
        $this->activeChild = $id;
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
        $this->summernoteImage->storeAs('summernote_service_images', $filename, 'public');

        $url = Storage::disk('public')->url("summernote_service_images/{$filename}");

        $this->dispatch('summernote-image-uploaded', url: $url);

        $this->reset('summernoteImage');
    }

    #[Computed]
    public function Categories()
    {
        return Category::with('children','parent')
            ->where('field_id',$this->field_id)
            ->where('parent_id',null)
            ->get();
    }

    #[Computed]
    public function Children()
    {
        return Category::with('children','parent')
            ->where('field_id',$this->field_id)
            ->where('parent_id',$this->activeParent)
            ->get();
    }

    #[Computed]
    public function Services()
    {
        $query = Service::where('category_id',$this->activeChild)
            ->where('title','LIKE','%'.$this->search.'%')
            ->orderBy($this->sort,$this->direction);

        return ($this->perPage == "") ? $query->get() : $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.dashboard.services-management')
            ->layout('components.layouts.dashboards');
    }
}
