<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
//    protected $table = 'licenses';
    protected $fillable = ['name','link','icon','description','expire','active','show'];
}
