<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecGroup extends Model
{
    protected $table = 'spec_groups';
    protected $fillable = ['specification_id', 'title'];

    public function specification():BelongsTo
    {
        return $this->belongsTo(Specification::class);

    }


    public function units():HasMany
    {
        return $this->hasMany(SpecUnit::class, 'group_id','id');

    }
}
