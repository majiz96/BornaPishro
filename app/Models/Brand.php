<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Attributes\Validate;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['name','description','logo','cover'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
