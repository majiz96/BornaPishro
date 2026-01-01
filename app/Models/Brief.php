<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Brief extends Model
{
    protected $table = 'briefs';
    protected $fillable = ['product_id'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function unit():HasOne
    {
        return $this->hasOne(briefUnit::class);
    }
}
