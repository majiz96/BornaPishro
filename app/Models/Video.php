<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends Model
{
protected $table = 'videos';
protected $fillable = ['title', 'description','aparat', 'youtube', 'show', 'videoable_id', 'videoable_type',
    'priority',
];

public function videoable():MorphTo
{
    return $this->morphTo();
}

}
