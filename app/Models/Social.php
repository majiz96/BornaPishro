<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Social extends Model
{
    protected $fillable = ['name','link','icon'];

    public static function Cached()
    {
        return Cache::remember(
            'website-socials',
            now()->addDays(3),
            fn () => Social::all()
        );
    }

}
