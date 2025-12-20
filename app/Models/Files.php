<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Files extends Model
{
    protected $table = 'files';
    protected $fillable = ['file', 'table'];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
