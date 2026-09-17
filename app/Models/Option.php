<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'filter_id',
        'name',
        'show'
    ];

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class, 'filter_id', 'id');
    }

    public function usedOptions(): BelongsToMany
    {
        return $this->belongsToMany(
            Option::class,
            'model_options',
            'option_id'
        );
    }

    public function optionables(): MorphToMany
    {
        return $this->morphedByMany(
            Product::class,
            'optionable',
            'model_options'
        );
    }
}
