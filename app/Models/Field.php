<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

}
