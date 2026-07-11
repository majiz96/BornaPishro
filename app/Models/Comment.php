<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['user_id', 'parent_id', 'text', 'votes','show','see',
        'commentable_id',
        'commentable_type'
    ];

    public function commentable():MorphTo
    {
        return $this->morphTo();
    }
    public function parent():HasOne
    {
        return $this->hasOne(Comment::class, 'id', 'parent_id')->where('show', 1);
    }

    public function children():HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->where('show',1);
    }

    public function LikedByUsers():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comment_user')->withTimestamps();
    }

    public function Users():HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
