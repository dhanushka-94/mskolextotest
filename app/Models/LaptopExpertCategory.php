<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaptopExpertCategory extends SmaCategory
{
    protected $connection = 'laptopexpert_products_db';
    protected $table = 'sma_categories';

    public function products(): HasMany
    {
        return $this->hasMany(LaptopExpertProduct::class, 'category_id')->where('hide', 0);
    }

    public function subcategoryProducts(): HasMany
    {
        return $this->hasMany(LaptopExpertProduct::class, 'subcategory_id')->where('hide', 0);
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function allProductsQuery()
    {
        return LaptopExpertProduct::where(function ($query) {
            $query->where('category_id', $this->id)
                ->orWhere('subcategory_id', $this->id);
        })->where('hide', 0);
    }
}
