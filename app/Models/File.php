<?php

namespace App\Models;

use App\Traits\ToJalai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use ToJalai;

    protected $table = 'files';
    protected $fillable = ['filename','file' ,'size', 'fileable_id', 'fileable_type'];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
