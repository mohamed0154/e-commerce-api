<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Subcategory extends Model
{
    protected $guarded = [];



    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    protected static function booted()
    {
        static::deleting(function ($subcategory) {
            // Set subcategory_id to null for all related products
            $subcategory->products()->update(['subcategory_id' => null]);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
