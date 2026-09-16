<?php

namespace App\Traits;

trait HasToastAlert
{
    //

    public function toastSuccess($message)
    {
        $this->swalToastSuccess([
            'title' => $message,
            'position' => 'top-start',
            'timer' => 3000,
            'showConfirmButton' => false,
            'timerProgressBar' => true,
            'closeButton' => true,
            'customClass' => [
                'popup' => 'swal2-rtl',
            ],
        ]);
    }

    public function toastError($message)
    {
        $this->swalToastError([
            'title' => $message,
            'position' => 'top-start',
            'timer' => 5000,
            'showConfirmButton' => false,
            'timerProgressBar' => true,
            'closeButton' => true,
            'customClass' => [
                'popup' => 'swal2-rtl',
            ],
        ]);
    }
}
