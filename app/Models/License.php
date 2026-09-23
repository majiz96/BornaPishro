<?php

namespace App\Models;

use App\Traits\ToJalai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class License extends Model
{
    use ToJalai;

//    protected $table = 'licenses';
    protected $fillable = ['name','link','icon','description','expire','active','show'];

    public static function Cached()
    {
        return Cache::remember(
            'website-licenses',
            now()->addDays(3)
            ,fn()=>License::where('show',true)->orderBy('created_at','desc')->get()
        );
    }

}
