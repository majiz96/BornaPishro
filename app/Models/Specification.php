<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specification extends Model
{
    protected $table = 'specifications';
    protected $fillable = ['product_id','name','price'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function group():HasMany
    {
        return $this->hasMany(SpecGroup::class, 'specification_id', 'id');

    }

}
