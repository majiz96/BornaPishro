<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Option extends Model
{
    //
    protected $table = 'options';
    protected $fillable = ['filter_id', 'name', 'show'];

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class,'filter_id','id');
    }
}
