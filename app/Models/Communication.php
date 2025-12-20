<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Communication extends Model
{
    protected $table = 'communications';
    protected $fillable = ['user_id','email','subject', 'message'];

    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function file():MorphOne
    {
        return $this->morphOne(Files::class, 'fileable');
    }

}

