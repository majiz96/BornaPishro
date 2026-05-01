<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Notice;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
//use Illuminate\Validation\ValidationException;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

use App\Models\User;
use App\Models\File;
use App\Models\Communication;
use Nette\Schema\ValidationException;

class
Home extends Component
{

    use WithFileUploads;

    public int $user_id;
    public string $subject;
    public string $text;

    public string $name;
    public string $email;
    public string $phone;

    public string $uploadTip='فقط فایلهای آفیس و یا pdf و rar و zip ';
    public  $files = [];
    public $uploadedFiles = [];

    public $size;

    public $counter = 0;
    public int $NotificationLimit = 3;
    public int $ProductLimit = 12;
    public int $ArticleLimit = 6;


    #[Computed]
    public function notificationSlider()
    {
        return Notice::where('display','اسلایدر')
            ->where('status',1)
            ->limit($this->NotificationLimit)
            ->orderBy('created_at','DESC')
            ->get();
    }
    #[Computed]
    public function notificationTile()
    {
        return Notice::where('display','کاشی ها')
            ->where('status',1)
            ->orderBy('created_at','DESC')
            ->get();
    }
    #[Computed]
    public function productSlider()
    {
         return Product::where('show',1)
            ->where('supply',1)
            ->where('price','!=',0)
            ->limit($this->ProductLimit)
            ->orderBy('created_at','DESC')->get();
    }
    #[Computed]
    public function serviceSlider()
    {
         return Service::where('show',1)->orderBy('created_at','DESC')->get();
    }
    #[Computed]
    public function articleSlider()
    {
         return Article::where('show',1)
             ->limit($this->ArticleLimit)
             ->orderBy('created_at','DESC')->get();
    }


//    validation of guest messages
    public function saveGuestMessage()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'nullable|min:10|max:13',
            'subject' => 'required|string|max:200',
            'text' => 'required|string|max:2000',
            'files' =>   'nullable|array|max:3',
            'files.*' => 'file|mimes:pdf,zip,rar,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ],
        [
            'name.required'=>'نام و نام خانوادگی خود را بنویسید',
            'name.min'=>'نام و نام خانوادگی نمی تواند کمتر از ۳ حرف باشد',
            'email.required'=>'ایمیل خود را وارد کنید ',
            'email.email'=>'ایمیل وارد شده معتبر نیست',
            'phone.min'=>'شماره همراه صحیح نمی باشد',
            'phone.max'=>'شماره همراه صحیح نمی باشد',
            'subject.required'=>'موضوع پیام را مشخص کنید',
            'subject.string'=>'نوع موضوع پیام معتبر نیست',
            'subject.max'=>'موضوع پیام حداکثر ۲۰۰ کرکتر می تواند باشد',
            'text.required'=>'متنی در پیام شما نیست',
            'text.string'=>'نوع پیام باید متنی باشد',
            'text.max'=>'حداکثر کرکتر مجاز برای پیام ۲۰۰۰ حرف است',
            'files.max'=>'حداکثر ۳ فایل قابل بارگذاری است',
            'files.*.mimes'=>'فایل انتخاب شده باید فرمت فایلهای آفیس ورد،اکسل و پاورپوینت یا rar و zip و یا pdf باشد',
            'files.*.max'=>'متن پیام حداکثر ۲۰۰۰ حرف می تواند باشد'
        ]);

//        save the message in database
        $comm = Communication::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->text,
            'user_id' => 0,
        ]);


        foreach ($this->files as $file) {
//            set semi-hashed name for file in storage
            $filestore = uniqid('guest_') . '.' . $file->getClientOriginalExtension();
//            save the file in storage by it's semi-hashed name
            $file->storeAs('attachments', $filestore, 'public');

            File::create([
                'filename' => $file->getClientOriginalName(),
                'file' => $filestore,
                'size' => ($file->getSize())/1024/1024,2 ,
                'fileable_id' => $comm->id,
                'fileable_type' => Communication::class,
            ]);

        }

        $this->reset(['name','email','phone','subject','text','files','uploadedFiles']);
    }

    // save messages of registered users
    public function saveMessage()
    {
        $this->validate([
            'subject' => 'required|string|max:200',
            'text' => 'required|string|max:2000',
            'files' =>   'nullable|array',
            'files.*' => 'file|mimes:pdf,zip,rar,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ],
        [
            'subject.required'=>'موضوع پیام را مشخص کنید',
            'subject.string'=>'نوع موضوع پیام معتبر نیست',
            'subject.max'=>'موضوع پیام حداکثر ۲۰۰ کرکتر می تواند باشد',
            'text.required'=>'متنی در پیام شما نیست',
            'text.string'=>'نوع پیام باید متنی باشد',
            'text.max'=>'حداکثر کرکتر مجاز برای پیام ۲۰۰۰ حرف است',
            'files.*.mimes'=>'فایل انتخاب شده باید فرمت فایلهای آفیس ورد،اکسل و پاورپوینت یا rar و zip و یا pdf باشد',
            'files.*.max'=>'هر فایل نهایت ۱۰ مگابایت باید باشد'
        ]);

//        find user by it's id
        $this->user_id = Auth::id();

        if (count($this->files) > 3) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'files.*' => 'حداکثر می‌توانید ۳ فایل ارسال کنید.',
            ]);
        }

        $comm= Communication::create([
            'subject'=>$this->subject,
            'message'=>$this->text,
            'user_id'=>$this->user_id,
        ]);

        foreach($this->files as $file){

            $filestore = uniqid('auth_'.Auth::user()->id.'_') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('attachments', $filestore, 'public');

            File::create([
                'filename'=>$file->getClientOriginalName(),
                'file'=>$filestore,
                'size'=>($file->getSize())/1024 / 1024, 2,
                'fileable_id'=>$comm->id,
                'fileable_type'=> Communication::class
            ]);

        }

//        $this->files = [];
        $this->reset('uploadedFiles', 'files','subject','text');
    }

//    get uploaded file's names and send it's names for showing in UI for messages attachments
    public function updatedFiles()
    {
        $this->uploadedFiles = [];

        foreach($this->files as $file)
        {
            $this->uploadedFiles[] = $file->getClientOriginalName();
        }

    }


    public function render()
    {
        return view('livewire.home');
    }
}
