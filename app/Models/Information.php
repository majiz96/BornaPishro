<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'information';
    protected $primaryKey = 'id';
    protected $fillable = ['phone', 'mobile', 'email', 'address','activity','response','start_date', 'about_us'];
}
