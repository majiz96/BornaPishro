<?php

namespace App\Livewire\Dashboard\Website;

use App\Mail\NoticeMail;
use App\Models\User;
use App\Models\Notice;
use App\Models\Position;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Notices extends Component
{

    public $row = 1;
    public string $title;
    public string $description;
    public string $display;
    public string $contact;
    public int $position_id = 4;
    public string $style;
    public $expired_at;

//    public $status;

    public $editing = null;
    public $seeModal = false;
    public string $modalTitle;
    public string $modalDescription;

    public $selected = [];
    public $selectAll = false;

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
        $this->expired_at = $notice->expired_at;
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
                'expired_at' => 'required|date_format:Y-m-d'
            ];

            $messages = [
                'title.required' => ' عنوان پیام لازم است ',
                'description.required'=>'پیام خالی نمی توان فرستاد',
                'display.required'=>'باید مشخص کنید که پیام چگونه نمایش داده شود',
                'contact.required'=>'باید مخاطب پیام را مشخص کنید',
                'expired_at.required'=>'تاریخ انقضاء پیام را باید مشخص کنید',
                'expired_at.date_format'=>'تاریخ انقضاء پیام را باید مشخص کنید'
            ];


            $this->validate($rules,$messages);


            $notice = Notice::findOrFail($this->editing);

            $data = $this->pull(['title','description','display','contact','position_id','style','expired_at']);

            $notice->update($data);

            $this->editing = null;
//            $this->reset(['title','description','display','contact','position_id','style','expired_at']);


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
                    'expired_at' => 'required|date_format:Y/m/d'
                ]
                ,
                [
                    'title.required' => ' عنوان پیام لازم است ',
                    'description.required'=>'پیام خالی نمی توان فرستاد',
                    'display.required'=>'باید مشخص کنید که پیام چگونه نمایش داده شود',
                    'contact.required'=>'باید مخاطب پیام را مشخص کنید',
                    'position_id.integer'=>'سطح کاربری انتخاب شده معتبر نیست',
                    'expired_at.required'=>'تاریخ انقضاء پیام را باید مشخص کنید',
                    'expired_at.date_format'=>'تاریخ انقضاء پیام را باید مشخص کنید'
                ]);

            $data = $this->pull(['title','description','display','position_id','contact','style','expired_at']);

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

        $recipients->each(fn($email) => Mail::to($email)->send(new NoticeMail($notice)));
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
        return view('livewire.dashboard.website.notices',[
            'positions'=>Position::OrderBy('level','DESC')->get()
            ,'notices'=>Notice::with('position')->orderBy('created_at','DESC')->get()])
            ->layout('components.layouts.dashboards');
    }
}
