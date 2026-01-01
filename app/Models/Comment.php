<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['parent_id','text','votes'];

    public function commentable():MorphTo
    {
        return $this->morphTo();
    }
}
