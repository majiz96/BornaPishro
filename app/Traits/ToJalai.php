<?php

namespace App\Traits;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

trait ToJalai
{
    public function toJalaiDate(Carbon $date)
    {
        return Jalalian::fromCarbon(
            $date->timezone('Asia/Tehran')
        )->format('d/m/Y');
    }

    public function toJalaiDateByHours(Carbon $date)
    {
        return Jalalian::fromCarbon(
            $date->timezone('Asia/Tehran')
        )->format('d/m/Y H:i');
    }

    public function toJalaiNamedDate(Carbon $date)
    {
        return Jalalian::fromCarbon(
            $date->timezone('Asia/Tehran')
        )->format('d F Y');
    }

    public function toJalaiNameDateByHours(Carbon $date)
    {
        return Jalalian::fromCarbon(
            $date->timezone('Asia/Tehran')
        )->format('d F Y H:i');
    }
    public function fromJalaliDatePicker($date): string
    {
        return Jalalian::fromDateTime($date)->format('d F Y');
    }

}
