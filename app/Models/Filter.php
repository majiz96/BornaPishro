<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filter extends Model
{
    protected $table = 'filters';
    protected $fillable = ['field_id','category_id','title','show'];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class,'filter_id','id');
    }

    public function articles():HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function services():HasMany
    {
        return $this->hasMany(Service::class);
    }
}
