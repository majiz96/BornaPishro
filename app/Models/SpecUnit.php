<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpecUnit extends Model
{
    protected $table = 'spec_units';
    protected $fillable = ['group_id','title','filter_id'];

    public function specGroup(): BelongsTo
    {
        return $this->belongsTo(SpecGroup::class);
    }

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(SpecValue::class);
    }
}
