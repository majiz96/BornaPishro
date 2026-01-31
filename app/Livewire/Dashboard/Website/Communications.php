<?php

namespace App\Livewire\Dashboard\Website;

//use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Communication;
use App\Models\File;
use App\Models\User;

class Communications extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public int $row = 1;
    public $messageModal = false;
    public $filesModal = false;

    public int $modalId;
    public string $modalSubject;
    public string $modalMessage;
    public string $modalName;

    public $modalFiles;
    public $modalFileId;
    public string $modalErr;

    public $selected = [];
    public $selectAll = false;

    public $perPage = 5;
    public $search = '';
    public $sort = 'created_at';
    public $direction = 'desc';

    public function seeMessage($id)
    {
        $this->messageModal = true;

        $message = Communication::with('user')->findOrFail($id);
        $this->modalId = $id;
        $this->modalSubject = $message->subject;
        $this->modalMessage = $message->message;
        $this->modalName    = $message->name ?? $message->user->name ." ". $message->user->lastname;

    }

    public function seeFiles($id)
    {
        $this->filesModal = true;

        $message = Communication::with('user','files')->findOrFail($id);

        $this->modalId = $id;
        $this->modalName = $message->name ?? $message->user->name ." ". $message->user->lastname;

        $this->modalFiles = $message->files->pluck('filename','id')->toArray();
//        $this->modalFileId = $message->files->pluck('id')->toArray();

    }

    public function download($id)
    {
        $file = File::findOrFail($id);

        return Storage::disk('public')->download('attachments/'.$file->file);
    }

    public function closeMessage()
    {
        $this->messageModal = false;
    }

    public function closeFiles()
    {
        $this->filesModal = false;
    }

    public function updatedSelectAll($value)
    {

        if($value){

            $this->selected = [];

            $comm = Communication::all();
            foreach($comm as $com){
                $this->selected[] = $com->id;
            }

        }
        else
        {
            $this->selected = [];
        }
    }

    public function delete($id)
    {
        $com = Communication::with('files')->findOrFail($id);

      foreach ($com->files()->get() as $file)
      {
          $path = 'attachments/'.$file->file;
          if (Storage::disk('public')->exists($path))
          {
              Storage::disk('public')->delete($path);
          }

          $file->delete();
      }

      $com->delete();

    }

    public function selectedDelete()
    {
        $com = Communication::whereIn('id',$this->selected)->with('files')->get();

        foreach ($com as $coms)
        {
            foreach ($coms->files as $file)
            {
                $path = 'attachments/'.$file->file;
                if (Storage::disk('public')->exists($path))
                {
                    Storage::disk('public')->delete($path);
                }

                $file->delete();
            }

            $coms->delete();

            $this->selected = [];
        }


    }

    public function render()
    {
        $comm = Communication::with('user','files')
            ->where('name','LIKE','%'.$this->search.'%')
            ->orWhere('subject','LIKE','%'.$this->search.'%')
            ->orWhere('email','LIKE','%'.$this->search.'%')
            ->orWhere('phone','LIKE','%'.$this->search.'%')
            ->orderBy($this->sort,$this->direction)
            ->paginate($this->perPage);

        return view('livewire.dashboard.website.communications',compact('comm'))
            ->layout('components.layouts.dashboards');
    }
}
