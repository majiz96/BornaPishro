<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'field_id', 'parent_id'];

    public function products(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
