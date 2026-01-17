<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['user_id','parent_id','text','votes'];

    public function commentable():MorphTo
    {
        return $this->morphTo();
    }
    public function parent():HasOne
    {
        return $this->hasOne(Comment::class, 'id', 'parent_id');
    }
}
