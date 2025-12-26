<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    protected $table = 'positions';

    protected $fillable = ['title','description','level'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function notices(): HasMany
    {
        return $this->hasMany(Notice::class);
    }
}
