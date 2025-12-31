<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Notice extends Model
{
    protected $table = 'notices';
    protected $fillable = ['title', 'description', 'display', 'contact','style','position_id','status','expired_at'];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function notices():BelongsToMany
    {
        return $this->belongsToMany(Notice::class,'user_notices');
    }

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_notice')->withPivot('read_at')->withTimestamps();
    }

}

