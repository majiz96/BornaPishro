<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'brand_id', 'name', 'fullname', 'intro', 'price','discount','supply','image','show',
        'brand_name'
    ];

//    protected $guarded = [];
//    protected $casts = [];
//    protected $hidden = [];
//    protected $appends = [];
//    protected $with = [];
//


//    public function getRouteKeyName()
//    {
//        return 'fullname';
//    }


    public function brand(): BelongsTo
    {
    return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brief(): hasOne
    {
        return $this->hasOne(Brief::class);
    }

    protected $with = ['specifications'];
    public function specifications(): hasMany
    {
        return $this->hasMany(Specification::class);
    }

    public function getPriceRangeAttribute()
    {
        $prices = $this->specifications
            ->pluck('price')
            ->filter();

        return match (true) {
            $prices->isEmpty()      => 0,
            $prices->count() === 1  => number_format($prices->first()),
            default                 => number_format($prices->min()) . ' تا ' . number_format($prices->max()),
        };
    }

    public function getHasPriceAttribute()
    {
        return $this->specifications->whereNotNull('price')->isNotEmpty();
    }

    public function getMinPriceAttribute()
    {
        return $this->specifications->pluck('price')->filter()->min();
    }
    public function getMaxPriceAttribute()
    {
        return $this->specifications->pluck('price')->filter()->max();
    }

//    public function isInPriceRange($min, $max)
//    {
//        if(!$this->has_price)
//        {
//            return false;
//        }
//
//        return $this->specifications->pluck('price')->filter()->contains(fn($price) => $price >= $min && $price <= $max);
//    }

    public function getFinalPriceAttribute()
    {

        if(!$this->discount)
        {
            return $this->price;
        }

        return $this->price - ($this->price * ($this->discount/100));

    }

    public function UserProducts(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_product')->withTimestamps();
    }

    public function videos():MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function galleries():MorphMany
    {
        return $this->morphMany(Gallery::class, 'galleryable');
    }

    public function files():MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function sources():MorphMany
    {
        return $this->morphMany(Source::class, 'sourceable');
    }

    public function comments():MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function relatedOptions():MorphToMany
    {
        return $this->morphToMany(Option::class, 'optionable','model_options');
    }
}
