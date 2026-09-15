<?php

namespace App\Livewire\Parts;

use App\Models\Communication;
use App\Models\File;
use App\Models\Information;
use App\Models\License;
use App\Models\Social;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Footer extends Component
{
    use WithFileUploads;

    public $panelShow = false;
    public $user_id,$subject,$text,$name,$guest_email,$guest_phone;

    public string $uploadTip='فقط فایلهای آفیس و یا pdf و rar و zip ';
    public  $files = [];
    public $uploadedFiles = [];

    public $size;

    public $phone, $mobile, $email, $address, $activity ,$response, $start_date, $about_us;

    public $icon, $link;

    public function mount()
    {
        $info = Information::Cached();

        if(!empty($info)){
            $this->fill($info->only([
                'phone', 'mobile', 'email', 'address', 'activity', 'response', 'location', 'start_date', 'about_us'
            ]));
        }
    }

    #[On('show-panel')]
    public function showPanel()
    {
        $this->panelShow = true;
    }

    //    validation of guest messages
    public function saveGuestMessage()
    {
        $this->validate([
            'name' => 'required|min:3',
            'guest_email' => 'required|email',
            'phone' => 'nullable|min:10|max:13',
            'subject' => 'required|string|max:200',
            'text' => 'required|string|max:2000',
            'files' =>   'nullable|array|max:3',
            'files.*' => 'file|mimes:pdf,zip,rar,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ],
            [
                'name.required'=>'نام و نام خانوادگی خود را بنویسید',
                'name.min'=>'نام و نام خانوادگی نمی تواند کمتر از ۳ حرف باشد',
                'guest_email.required'=>'ایمیل خود را وارد کنید ',
                'guest_email.email'=>'ایمیل وارد شده معتبر نیست',
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
            'email' => $this->guest_email,
            'phone' => $this->guest_phone,
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

        $this->reset(['name','guest_email','guest_phone','subject','text','files','uploadedFiles']);
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
        $socials = Social::Cached();

        $licenses = License::Cached();

        return view('livewire.parts.footer', compact('socials', 'licenses'));
    }
}
