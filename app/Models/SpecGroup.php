<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecGroup extends Model
{
    protected $table = 'specs_groups';
    protected $fillable = ['spec_id', 'title'];

    public function spec():BelongsTo
    {
        return $this->belongsTo(Specification::class, 'spec_id');
    }

    public function units():HasMany
    {
        return $this->hasMany(SpecUnit::class, 'group_id');
    }
}
