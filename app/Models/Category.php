<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }


    protected static function booted()
    {
        static::deleting(function ($category) {
            // Set category_id to null for all related products
            $category->subcategories()->update(['category_id' => null]);
        });
    }
}
