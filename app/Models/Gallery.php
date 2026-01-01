<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Gallery extends Model
{
    protected $table = 'galleries';
    protected $fillable = ['image', 'size', 'order', 'status'];

    public function galleryable(): MorphTo
    {
        return $this->morphTo();
    }
}
