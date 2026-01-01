<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends Model
{
protected $table = 'video';
protected $fillable = ['video', 'size', 'url' , 'status'];

public function videoable():MorphTo
{
    return $this->morphTo();
}

}
