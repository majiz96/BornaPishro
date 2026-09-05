<?php

namespace App\Models;

use App\Observers\FieldObserver;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

#[ObservedBy([FieldObserver::class])]
class Field extends Model
{
    protected $table = 'fields';
    protected $fillable = ['name','model','route','image','show_menu','order','system'];

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
            fn () => Field::orderBy('order','ASC')->get(),
        );
    }
    public static function Menu()
    {
        return Cache::remember(
            'menu-fields',
            now()->addMonth(),
            fn()=>Field::where('show_menu', true)
                ->orderBy('order','asc')
                ->get()
        );

//        return Field::where('show_menu',true)->orderBy('name','desc')->get();
    }

    public static function booted():void
    {
//        $flush =function ()
//        {
//            Cache::forget('website-fields');
//            Cache::forget('menu-fields');
//        };
//
//        static::saved($flush);
//        static::deleted($flush);

    }

}
