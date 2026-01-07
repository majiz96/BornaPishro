<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Source extends Model
{
    protected $table = 'sources';
    protected $fillable = ['title', 'url', 'webname',
        'sourceable_id',
        'sourceable_type'
    ];

    public function sourceable():MorphTo
    {
        return $this->morphTo();
    }
}
