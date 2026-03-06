<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brief extends Model
{
    protected $table = 'briefs';
    protected $fillable = ['product_id'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function units():HasMany
    {
        return $this->hasMany(BriefUnit::class);
    }
}
