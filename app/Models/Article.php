<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['writer_id','editor_id','filter_id','category_id', 'title', 'intro', 'content', 'cover', 'show'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class,'writer_id','id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id','id');
    }

    public function filter(): BelongsTo
    {
        return $this->belongsTo(Filter::class, 'filter_id', 'id');
    }

    public function comments():MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
