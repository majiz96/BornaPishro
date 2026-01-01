<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpecUnit extends Model
{
    protected $table = 'specs_units';
    protected $fillable = ['spec_group','title'];

    public function specGroup(): BelongsTo
    {
        return $this->belongsTo(SpecGroup::class, 'group_id');
    }

    public function values(): HasOne
    {
        return $this->hasOne(SpecValue::class, 'unit_id');
    }
}
