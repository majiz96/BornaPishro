<?php

namespace App\Livewire\Dashboard\Website;

use App\Jobs\NoticeMailJob;
use App\Mail\NoticeMail;
use App\Models\User;
use App\Models\Notice;
use App\Models\Position;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

use Livewire\Component;
use Livewire\WithPagination;

class Notices extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $row = 1;
    public string $title,$description,$display,$contact,$style;
    public int $position_id = 4;
    public $date_picker;

//    public $status;

    public $editing = null;
    public $seeModal = false;
    public string $modalTitle,$modalDescription;

    public $selected = [];
    public $selectAll = false;

    public $perPage = 5;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';

    public function mount()
    {
        Gate::authorize('isManager');
    }

    public function edit($id)
    {
        $this->editing = $id;

        $notice = Notice::findOrFail($id);
        $this->title = $notice->title;
        $this->description = $notice->description;
        $this->display = $notice->display;
        $this->contact = $notice->contact;
        $this->position_id = $notice->position_id;
        $this->style = $notice->style;

        $this->date_picker = $notice->expired_at;
        $this->dispatch('date-picker-set', value: $this->date_picker);
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

            $rules = [
                'title' => 'required|string',
                'description' => 'required|string',
                'display' => 'required|string',
                'contact' => 'required|string',
                'date_picker' => 'required'
            ];

            $messages = [
                'title.required' => ' عنوان پیام لازم است ',
                'description.required'=>'پیام خالی نمی توان فرستاد',
                'display.required'=>'باید مشخص کنید که پیام چگونه نمایش داده شود',
                'contact.required'=>'باید مخاطب پیام را مشخص کنید',
                'date_picker.required'=>'تاریخ انقضاء پیام را باید مشخص کنید',
            ];


            $this->validate($rules,$messages);


            $notice = Notice::findOrFail($this->editing);

            $data = $this->pull(['title','description','display','contact','position_id','style']);
            $data['expired_at'] = $this->date_picker;

            $notice->update($data);

            $this->editing = null;
//            $this->reset(['title','description','display','contact','position_id','style','date_picker']);


        }
        else
        {
            $this->validate(
                [
                    'title' => 'required|string',
                    'description' => 'required|string',
                    'display' => 'required|string',
                    'contact' => 'required|string',
                    'position_id' => 'nullable|integer',
                    'style' => 'nullable|string',
                    'date_picker' => 'required'
                ]
                ,
                [
                    'title.required' => ' عنوان پیام لازم است ',
                    'description.required'=>'پیام خالی نمی توان فرستاد',
                    'display.required'=>'باید مشخص کنید که پیام چگونه نمایش داده شود',
                    'contact.required'=>'باید مخاطب پیام را مشخص کنید',
                    'position_id.integer'=>'سطح کاربری انتخاب شده معتبر نیست',
                    'date_picker.required'=>'تاریخ انقضاء پیام را باید مشخص کنید',
                ]);

            $data = $this->pull(['title','description','display','position_id','contact','style']);
            $data['expired_at'] = $this->date_picker;

            $notice = Notice::create($data);

            if($notice->display === 'ایمیل')
            {
                $this->sendEmail($notice);
            }

            if($notice->display === 'نماد')
            {
                $this->sendNotice($notice);
            }

        }

    }

    protected function sendEmail(Notice $notice)
    {
        $recipients = match ($notice->contact)
        {
            'همه'   =>  User::pluck('email'),
            default =>  User::where('position_id',$notice->position_id)->pluck('email')
        };

        $recipients->each(fn($email) => NoticeMailJob::dispatch($notice, $email));
    }

    protected function sendNotice(Notice $notice)
    {
        $users = match ($notice->contact)
        {
            'همه'   =>  User::pluck('id'),
            default =>  User::where('position_id',$notice->position_id)->pluck('id')
        };

        $notice->users()->attach($users);
    }


    public function see($id)
    {
        $this->seeModal = true;

        $modal = Notice::findOrFail($id);

        $this->modalTitle = $modal->title;
        $this->modalDescription = $modal->description;
    }

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selected = [];

            $notice = Notice::all();
            foreach ($notice as $notices) {
                $this->selected[] = $notices->id;
            }
        }
        else
        {
            $this->selected = [];
        }
    }

    public function delete($id)
    {
        Notice::findOrFail($id)->delete();
    }
    public function selectedDelete()
    {
        Notice::whereIn('id',$this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function toggleStatus($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->status = $notice->status == 1 ? 0 : 1;
        $notice->save();
    }

    public function render()
    {
        $positions =Position::OrderBy('level','DESC')->get();

        $query = Notice::with('position')
            ->where('title','like','%'.$this->search.'%')
            ->orWhere('contact','like','%'.$this->search.'%')
            ->orWhere('display','like','%'.$this->search.'%')
            ->orWhere('style','like','%'.$this->search.'%')
            ->orderBy($this->sort,$this->direction);

        $notices =
            ($this->perPage == "")
            ? $query->get()
                : $query->paginate($this->perPage);

        return view('livewire.dashboard.website.notices',compact('positions','notices'))
            ->layout('components.layouts.dashboards');
    }
}
