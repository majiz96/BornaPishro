<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'brand_id', 'name', 'fullname', 'intro', 'price', 'image',
        'brand_name'
    ];

//    protected $guarded = [];
//    protected $casts = [];
//    protected $hidden = [];
//    protected $appends = [];
//    protected $with = [];
//



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
            $prices->isEmpty()      => 'استعلام بگیرید',
            $prices->count() === 1  => number_format($prices->first()),
            default                 => number_format($prices->min()) . ' تا ' . number_format($prices->max()),
        };
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
}
