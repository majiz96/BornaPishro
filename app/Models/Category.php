<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'field_id', 'parent_id'];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function Independent(): HasMany
    {
        return $this->hasMany(Product::class)->whereNull('parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Category::class,'id','parent_id');
    }

   public function getHasPriceAttribute(): bool
   {
       if($this->products()->whereNotNull('price')->where('price', '!=', 0)->exists()){
           return true;
       }

       foreach ($this->children as $child) {
           if($child->has_price){
               return true;
           }
       }

       return false;
   }

    public function filters(): HasMany
    {
        return $this->hasMany(Filter::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }

    public function sevices(): HasMany
    {
        return $this->hasMany(Service::class, 'category_id', 'id');
    }

}
