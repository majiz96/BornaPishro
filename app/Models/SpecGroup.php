<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpecGroup extends Model
{
    protected $table = 'spec_groups';
    protected $fillable = ['specification_id', 'title',
        'group'
    ];

    public function specification():BelongsTo
    {
        return $this->belongsTo(Specification::class, 'specification_id', 'id');

    }


    public function units():HasMany
    {
        return $this->hasMany(SpecUnit::class, 'group_id');

    }
}
