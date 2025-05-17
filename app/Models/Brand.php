<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }



    protected static function booted()
    {
        static::deleting(function ($brand) {
            // Set brand_id to null for all related products
            $brand->products()->update(['brand_id' => null]);
        });
    }
}
