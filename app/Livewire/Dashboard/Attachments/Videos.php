<?php

namespace App\Livewire\Dashboard\Attachments;

use App\Models\Product;
use App\Models\Video;
use Livewire\Component;

class Videos extends Component
{

    public $product;

    public $title, $description, $aparat, $youtube , $show;

    public $priority = 'آپارات';

    public int $counter = 1;

    public $editing = null;
    public $selected = [];
    public $selectAll = false;

    public $showed = [];

    public $videoModal = false;

    public $modalVideo;
    public $modalAparat;
    public $modalYoutube;
    public $modalTitle;

    public $modalPriority;


    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $this->editing = $id;

        $this->title = $video->title;
        $this->description = $video->description;
        $this->aparat = $video->aparat;
        $this->youtube = $video->youtube;
        $this->priority = $video->priority;
    }

    public function cancel()
    {
        $this->editing = null;
        $this->reset(['title','description','aparat','youtube','priority']);
    }

    public function save()
    {
        if($this->editing)
        {
            $video = Video::findOrFail($this->editing);

            $this->validate([
                    'title' => 'required|string',
                    'description' => 'nullable|string',
                    'aparat' => 'nullable|string|required_without:youtube',
                    'youtube' => 'nullable|string|required_without:aparat',
                    'priority' => 'nullable|string',
                ]
                ,
                [
                    'title.required' => 'هر ویدیو باید عنوانی داشته باشد',
                    'description.string'=> 'توضیحات ویدیو باید متنی باشد',
                    'aparat.required_without'=>'حداقل آدرس لینک یک پلتفرم باید وارد شود',
                    'youtube.required_without'=>'حداقل آدرس لینک یک پلتفرم باید وارد شود',
                ]
            );

            $video->update([
                'title' => $this->title,
                'description' => $this->description,
                'aparat' => $this->aparat,
                'youtube' => $this->youtube,
                'priority' => $this->priority,
            ]);

            $this->reset(['title','description','aparat','youtube','priority']);
            $this->editing = null;
        }
        else
        {

            $this->validate([
                    'title' => 'required|string',
                    'description' => 'nullable|string',
                    'aparat' => 'nullable|string|required_without:youtube',
                    'youtube' => 'nullable|string|required_without:aparat',
                ]
                ,
                [
                    'title.required' => 'هر ویدیو باید عنوانی داشته باشد',
                    'description.string'=> 'توضیحات ویدیو باید متنی باشد',
                    'aparat.required_without'=>'حداقل آدرس لینک یک پلتفرم باید وارد شود',
                    'youtube.required_without'=>'حداقل آدرس لینک یک پلتفرم باید وارد شود',
                ]
            );

            Video::create([
                'title' => $this->title,
                'description' => $this->description,
                'aparat' => $this->aparat,
                'youtube' => $this->youtube,
                'priority' => $this->priority,
                'videoable_id' => $this->product->id,
                'videoable_type' => Product::class,
            ]);

            $this->reset(['title','description','aparat','youtube','priority']);
        }

    }


    public function toggleShow($id)
    {
        $video = Video::findOrFail($id);
        $video->show = $video->show == 1 ? 0 : 1;
        $video->save();
    }

    public function showAll()
    {
        $this->showed = Video::where('videoable_id',$this->product->id)->where('videoable_type',Product::class)->where('show',0)->pluck('id')->toArray();
        Video::where('videoable_id',$this->product->id)->where('videoable_type',Product::class)->where('show',0)->update(['show' => 1]);
    }


    public function showNone()
    {
        $this->showed = Video::where('videoable_id',$this->product->id)->where('videoable_type',Product::class)->where('show',1)->pluck('id')->toArray();
        Video::where('videoable_id',$this->product->id)->where('videoable_type',Product::class)->where('show',1)->update(['show' => 0]);
    }

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selected = Video::where('videoable_id', $this->product->id)->where(['videoable_type' => Product::class])->pluck('id')->toArray();
        }
        else
        {
            $this->selectAll = false;
            $this->selected = [];
        }
    }

    public function delete($id)
    {
        Video::findOrFail($id)->delete();
    }

    public function deleteSelected()
    {
        Video::whereIn('id', $this->selected)->delete();

        $this->selectAll = false;
        $this->selected = [];
    }

    public function see($id)
    {
        $video = Video::findOrFail($id);
        $this->modalVideo = $video->aparat ?? $video->youtube;
        $this->modalTitle = $video->title;
        $this->modalPriority = $video->priority;
        $this->modalYoutube = $video->youtube;
        $this->modalAparat = $video->aparat;

        $this->videoModal = true;
    }

    public function render()
    {
        $products = Product::findOrFail($this->product->id);
        $product_videos = $products->videos;
        $showed_videos = Video::where('videoable_id', $this->product->id)->where(['videoable_type' => Product::class])->where('show', 1)->pluck('id')->toArray();

        return view('livewire.dashboard.attachments.videos',['products'=>$products, 'product_videos'=>$product_videos,'showed_videos'=>$showed_videos])
            ->layout('components.layouts.dashboards');
    }
}
