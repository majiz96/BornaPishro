<?php

namespace App\Livewire\Dashboard\Website;

//use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;

use App\Models\Communication;
use App\Models\Files;
use App\Models\User;

class Communications extends Component
{

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
        $file = Files::findOrFail($id);

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

    public function render()
    {
        return view('livewire.dashboard.website.communications',['comm'=>Communication::with('user','files')->orderBy('created_at','DESC')->get(),
        ])
            ->layout('components.layouts.dashboards');
    }
}
