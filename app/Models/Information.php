<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Information extends Model
{
    protected $table = 'information';
    protected $primaryKey = 'id';
    protected $fillable = ['phone', 'mobile', 'email', 'address','activity','response','start_date', 'about_us'];

    public static function Cached()
    {
        return Cache::remember(
            'website-information',
            now()->addDays(3),
            fn()=>Information::first()
        );
    }

}
