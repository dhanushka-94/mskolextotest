<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Product statuses for LaptopExpert catalog (laptopexpert_products_db).
 * MSK SmaProductStatus must not be used for LaptopExpertProduct rows — IDs differ per database.
 */
class LaptopExpertProductStatus extends Model
{
    protected $connection = 'laptopexpert_products_db';
    protected $table = 'sma_product_status';

    public $timestamps = false;

    protected $fillable = [
        'status_name',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(LaptopExpertProduct::class, 'product_status');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('id');
    }
}
