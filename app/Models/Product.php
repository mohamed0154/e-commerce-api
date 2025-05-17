<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded=[];



    public function brand(): BelongsTo

    {
        return $this->belongsTo(Brand::class);
    }


    public function subcategory(): BelongsTo

    {
        return $this->belongsTo(Subcategory::class);
    }


    
}
