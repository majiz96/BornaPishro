<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModelOption extends Model
{
    protected $table = 'model_options';

    protected $fillable = [
        'option_id',
        'optionable_type',
        'optionable_id',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(
            Option::class,
            'option_id',
            'id'
        );
    }

    public function optionable(): MorphTo
    {
        return $this->morphTo();
    }
}
