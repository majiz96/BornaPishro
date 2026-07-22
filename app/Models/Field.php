<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Field extends Model
{
    protected $table = 'fields';
    protected $fillable = ['name','route','image','show_menu'];

    public function filters(): HasMany
    {
        return $this->hasMany(Filter::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public static function Cached()
    {
        return Cache::remember(
            'website-fields',
            now()->addMonth(),
            fn () => Field::all(),
        );
    }
    public static function Menu()
    {
        return Cache::remember(
            'menu-fields',
            now()->addMonth(),
            fn()=>Field::where('show_menu', 1)
                ->orderBy('name')
                ->get()
        );
    }

    public static function booted():void
    {
        $flush =function ()
        {
            Cache::forget('website-fields');
            Cache::forget('menu-fields');
        };

        static::saved($flush);
        static::deleted($flush);

    }

}
