<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = ['filename','file' ,'size', 'fileable_id', 'fileable_type', 'name'];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
