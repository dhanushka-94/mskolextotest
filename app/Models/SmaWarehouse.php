<?php

namespace App\Models;

use App\Models\Concerns\UsesConfiguredProductsConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmaWarehouse extends Model
{
    use UsesConfiguredProductsConnection;

    protected $connection = 'products_db';
    protected $table = 'sma_warehouses';
    
    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'name',
        'address',
        'map',
        'phone',
        'email',
        'price_group_id'
    ];

    /**
     * Get warehouse products
     */
    public function warehouseProducts(): HasMany
    {
        return $this->hasMany(SmaWarehouseProduct::class, 'warehouse_id');
    }
}
