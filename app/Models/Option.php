<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(
            Filter::class,
            'filter_id',
            'id'
        );
    }

    public function modelOptions(): HasMany
    {
        return $this->hasMany(
            ModelOption::class,
            'option_id',
            'id'
        );
    }

    public function scopeVisible($query)
    {
        return $query->where('show', true)
            ->whereHas('modelOptions',function($q){
                $q->whereHasMorph('optionable','*',function($q){
                    $q->where('show', true);
                });
            });
    }
}
