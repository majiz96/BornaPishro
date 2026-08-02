<?php

namespace App\Livewire\Dashboard;

use App\Models\Article;
use App\Models\Category;
use App\Models\Filter;
use App\Models\User;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class ArticlesManagement extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public string $message = '';

    public $writer_id,$editor_id,$category_id,$filter_id,$title,$intro,$content,$cover,$show;

    public $editing = null;

    public $activeParent;
    public $activeChild;

    public $modal = false;

    public $perPage = 6;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';

    public $modalContent,$modalTitle,$modalWriter,$modalEditor;

    public $rules = [
        'category_id' => 'required|integer',
        'filter_id' => 'nullable|integer',
        'title' => 'required|string',
        'intro' => 'required|string',
        'content' => 'required|string',
        'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];
    public $messages = [
      'category_id.required' => 'دسته مورد نظر را برای مقاله انتخاب کنید',
      'title.required'=>'هر مقاله به یک عنوان نیاز دارد',
      'intro.required'=>'هر مقاله باید یک مقدمه کوتاه داشته باشد',
      'content.required'=>'ثبت مقاله بدون داشتن متن ممکن نیست',
      'cover.required'=>'هر مقاله باید یک تصویر برای نمایش داشته باشد',
      'cover.image'=>'فایل انتخاب شده یک تصویر نیست',
      'cover.mimes'=>'فایل انتخاب شده از فرمتهای تصویری رایج نیست',
      'cover.max'=>'تصویر انتخاب شده حجیم تر از ۲ مگابایت است'
    ];

    public $editRules = [
        'category_id' => 'required',
        'filter_id' => 'nullable',
        'editor_id' => 'required',
        'title' => 'required',
        'intro' => 'required',
        'content' => 'required',
    ];
    public $editMessages = [
        'category_id.required' => 'دسته مورد نظر را برای مقاله انتخاب کنید',
        'title.required'=>'هر مقاله به یک عنوان نیاز دارد',
        'intro.required'=>'هر مقاله باید یک مقدمه کوتاه داشته باشد',
        'content.required'=>'ثبت مقاله بدون داشتن متن ممکن نیست',
    ];

    public function edit($id)
    {
        $this->editing = $id;
        $article = Article::findOrFail($id);
        $this->editor_id = Auth::id();
        $this->category_id = $article->category_id;
        $this->filter_id = $article->filter_id;
        $this->title = $article->title;
        $this->intro = $article->intro;
        $this->content = $article->content;
        $this->cover = $article->cover;
        $this->show = $article->show;
    }

    public function cancel()
    {
        $this->editing = null;
        $this->reset();
    }

    public function save()
    {

       if($this->editing)
       {
            $article = Article::findOrFail($this->editing);

            $this->validate($this->editRules,$this->editMessages);

            if(!is_string($this->cover))
            {
                $this->editRules['cover'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                $this->editMessages['cover.image'] = 'فایل انتخاب شده یک تصویر نیست';
                $this->editMessages['cover.mimes'] = 'فایل انتخاب شده از فرمتهای تصویری رایج نیست';
                $this->editMessages['cover.max'] = 'تصویر انتخاب شده حجیم تر از ۲ مگابایت است';

                Storage::disk('public')->delete('article_covers/'.$article->cover);

                $filename = uniqid('cover_') . '.' . $this->cover->getClientOriginalExtension();
                $this->cover->storeAs('article_covers', $filename, 'public');
            }
            else
            {
                $filename = $this->cover;
            }

            $data = $this->pull(['title', 'intro', 'content','category_id','filter_id']);
            $data['cover'] = $filename ?? $article->cover;
            $data['editor_id'] = Auth::id();

           $article->update($data);

            $this->reset(['editing','title','intro','content','cover','category_id','filter_id']);
       }
       else
       {
            if($this->cover && !is_string($this->cover))
            {
                $filename = uniqid('cover_') . '.' . $this->cover->getClientOriginalExtension();
                $this->cover->storeAs('article_covers', $filename, 'public');
            }
            else
            {
                $filename = [];
            }

            $this->validate($this->rules,$this->messages);

           $data = $this->pull(['category_id','filter_id','title','intro','content']);
           $data['writer_id'] = Auth::id();
           $data['cover'] = $filename ?? $this->cover;

           if(Article::create($data))
           {
               $this->message = 'مقاله اضافه شد';

               $this->reset(['title', 'intro', 'content', 'cover']);
           }
           else
           {
               $this->message = 'خطا در ثبت مقاله';
           }
       }
    }

    public function toggleShow($id)
    {
        $article = Article::findOrFail($id);
        $article->show = $article->show == 1 ? 0 : 1;
        $article->save();
    }

    public function selectParent($id)
    {
        $this->activeParent = $id;

        $count = Category::where('field_id',1)->where('parent_id',$this->activeParent)->count();

        if($count > 0)
        {
            $this->activeChild = Category::where('field_id',1)->where('parent_id',$this->activeParent)->first()->id;
        }
        else
        {
            $this->activeChild = Category::where('field_id',1)->where('parent_id',null)->first()->id;
        }

    }

    public function selectChildren($id)
    {
        $this->activeChild = $id;
    }

    public function delete($id)
    {
    $delete = Article::findOrFail($id);

        if($delete)
        {
        Storage::disk('public')->delete('article_covers/'.$delete->cover);
        }

        $delete->delete();
    }

    public function see($id)
    {
        $this->modal = true;

        $article = Article::findOrFail($id);
        $this->modalContent = $article->content;
        $this->modalTitle = $article->title;

        $writerName = User::where('id',$article->writer_id)->first()->name;
        $writerLastname = User::where('id',$article->writer_id)->first()->lastname;
        $this->modalWriter = $writerName . $writerLastname;


        if ($article->editor_id)
        {
            $editorName = User::where('id',$article->editor_id)->first()->name;
            $editorLastname = User::where('id',$article->editor_id)->first()->lastname;
            $this->modalEditor = $editorName . $writerLastname;
        }
        else
        {
            $this->modalEditor = 'ویرایش نشده است';
        }


    }

    #[Computed]
    public function filters()
    {
        return Filter::where('field_id',1)
            ->where('category_id',$this->activeChild)
            ->orWhere('category_id',$this->activeParent)
            ->orWhere('category_id',100)
            ->where('show',1)
            ->get();
    }

    public function render()
    {
        $categories = Category::with('children','parent')
            ->where('field_id',1)
            ->where('parent_id',null)
            ->where('id','!=',100)
            ->get();

        if(!$this->activeParent)
        {
            $this->activeParent = Category::where('field_id', 1)->where('parent_id', null)->first()->id;
        }

        if(!$this->activeChild)
        {
            if ($this->activeParent)
            {
                $this->activeChild = Category::where('field_id',1)->where('parent_id',$this->activeParent)->first()->id;
            }
            else
            {
                $this->activeChild = Category::where('field_id',1)->where('parent_id',null)->first()->id;
            }

        }

        $children = Category::with('children','parent')->where('field_id',1)->where('parent_id',$this->activeParent)->get();

        $query = Article::with('writer','editor')
            ->where('category_id',$this->activeChild)
            ->where('title','LIKE','%'.$this->search.'%')
            ->orderBy($this->sort,$this->direction);

        $articles = ($this->perPage == "") ? $query->get() : $query->paginate($this->perPage);

        return view('livewire.dashboard.articles-management',compact('categories','children','articles'))
            ->layout('components.layouts.dashboards');


    }
}
