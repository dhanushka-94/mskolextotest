<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmaProductStatus extends Model
{
    protected $connection = 'products_db';
    protected $table = 'sma_product_status';
    
    public $timestamps = false;
    
    protected $fillable = [
        'status_name',
        'status'
    ];

    protected $casts = [
        'status' => 'integer'
    ];

    /**
     * Get products with this status
     */
    public function products(): HasMany
    {
        return $this->hasMany(SmaProduct::class, 'product_status');
    }

    /**
     * Scope for active statuses
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope ordered by ID
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('id');
    }
}
