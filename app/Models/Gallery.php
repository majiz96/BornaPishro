<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Gallery extends Model
{
    protected $table = 'galleries';
    protected $fillable = ['image', 'order', 'show',
        'galleryable_id',
        'galleryable_type'
    ];

    public function galleryable(): MorphTo
    {
        return $this->morphTo();
    }
}
