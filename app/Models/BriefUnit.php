<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class briefUnit extends Model
{
    protected $table = 'brief_units';
    protected $fillable = ['brief_id','title'];

    public function brief():BelongsTo
    {
        return $this->belongsTo(Brief::class);
    }
    public function briefValues():HasOne
    {
        return $this->hasOne(BriefValues::class);
    }
}
