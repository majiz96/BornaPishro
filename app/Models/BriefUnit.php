<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BriefUnit extends Model
{
    protected $table = 'brief_units';
    protected $fillable = ['brief_id', 'title'];

    public function brief():BelongsTo
    {
        return $this->belongsTo(Brief::class, 'brief_id');
    }
    public function values():HasMany
    {
        return $this->hasMany(BriefValue::class,'unit_id','id');
    }
}
