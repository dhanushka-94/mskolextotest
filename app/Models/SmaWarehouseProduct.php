<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmaWarehouseProduct extends Model
{
    protected $connection = 'products_db';
    protected $table = 'sma_warehouses_products';
    
    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'rack',
        'avg_cost'
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'avg_cost' => 'decimal:4'
    ];

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(SmaProduct::class, 'product_id');
    }

    /**
     * Get the warehouse
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(SmaWarehouse::class, 'warehouse_id');
    }
}
