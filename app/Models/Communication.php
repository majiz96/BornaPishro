<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Files;

class Communication extends Model
{
    protected $table = 'communications';
    protected $fillable = ['user_id', 'name', 'email', 'subject', 'message', 'phone'];

    public function user():belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function files():MorphMany
    {
        return $this->morphMany(Files::class, 'fileable');
    }

}

