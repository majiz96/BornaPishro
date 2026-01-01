<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['category_id', 'brand_id', 'name', 'fullname', 'intro', 'price', 'image'];

//    protected $guarded = [];
//    protected $casts = [];
//    protected $hidden = [];
//    protected $appends = [];
//    protected $with = [];
//


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
