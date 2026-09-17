<?php

namespace App\Traits;

use SweetAlert2\Laravel\Traits\WithSweetAlert;

trait HasToastAlert
{
    use WithSweetAlert;
    //

    public function toastSuccess($message)
    {
        $this->swalToastSuccess([
            'title' => $message,
            'position' => 'top-end',
            'timer' => 3000,
            'background' => 'green',
            'color'=> 'white',
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
            'position' => 'top-end',
            'timer' => 5000,
            'background' => 'red',
            'color'=> 'white',
            'showConfirmButton' => false,
            'timerProgressBar' => true,
            'closeButton' => true,
            'customClass' => [
                'popup' => 'swal2-rtl',
            ],
        ]);
    }
}
