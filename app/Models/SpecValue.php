<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecValue extends Model
{
    protected $table = 'spec_values';
    protected $fillable = ['unit_id', 'value'];

    public function unit():BelongsTo
    {
        return $this->belongsTo(SpecUnit::class, 'unit_id');
    }
}
