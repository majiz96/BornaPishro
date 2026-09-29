<?php

namespace App\Models;

use App\Traits\ToJalai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Article extends Model
{
    use ToJalai;

    protected $table = 'articles';
    protected $fillable = ['writer_id','editor_id','filter_id','category_id', 'title', 'intro', 'content', 'cover', 'show'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'writer_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class);
    }

    public function comments():MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function relatedOptions():MorphToMany
    {
        return $this->morphToMany(Option::class, 'optionable','model_options');
    }


    public static function booted()
    {
        static::deleting(function ($article) {
            $article->relatedOptions()->detach();
        });
    }
}
