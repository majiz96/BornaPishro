<?php

namespace App\Livewire\Errors;

use Livewire\Attributes\Computed;
use Livewire\Component;

class PageErrors extends Component
{
    public int $status;
    public string $message = '';
    public string $sign = '';

    public function mount($status)
    {
        $this->status = $status;

        if($status)
        {
            switch ($status) {
                case 403:
                    $this->message = 'شما دسترسی لازم به این صفحه را ندارید';
                    $this->sign = "lock";
                    break;

                case 404:
                    $this->message = 'صفحه مورد نظر پیدا نشد';
                    $this->sign = "exclamation-circle";
                    break;

                case 500:
                    $this->message = 'خطایی در سرور رخ داده است';
                    $this->sign = "database-exclamation";
                    break;

                case 503:
                    $this->message = 'وبسایت در حال توسعه/تعمیر است، صبور باشید';
                    $this->sign = "tools";
                    break;
            }
        }
    }

    public function render()
    {
        return view('livewire.errors.page-errors');
    }
}
