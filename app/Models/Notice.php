<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notice extends Model
{
    protected $table = 'notices';
    protected $fillable = ['title', 'description', 'display', 'contact','style','status','expired_at'];

    public function Position():BelongsTo
    {
        $this->belongsTo(Position::class);
    }
}

