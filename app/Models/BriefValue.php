<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BriefValue extends Model
{
    protected $table = 'brief_values';
    protected $fillable = ['unit_id', 'value'];

    public function unit():BelongsTo
    {
        return $this->belongsTo(BriefUnit::class, 'unit_id');
    }
}
