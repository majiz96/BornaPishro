<?php

namespace App\Models;

use App\Traits\ToJalai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Service extends Model
{
    use ToJalai;

    protected $table = 'services';
    protected $fillable = ['category_id', 'title', 'intro', 'description', 'cover', 'thumbnail', 'show', 'filter_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class);
    }
    public function relatedOptions():MorphToMany
    {
        return $this->morphToMany(Option::class, 'optionable','model_options');
    }

    public static function booted()
    {
        static::deleting(function($service){
            $service->relatedOptions()->detach();
        });
    }
}
