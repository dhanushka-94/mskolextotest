<?php

namespace App\Models;

use App\Models\Concerns\UsesConfiguredProductsConnection;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SmaProductAttribute extends Pivot
{
    use UsesConfiguredProductsConnection;

    protected $connection = 'products_db';
    protected $table = 'sma_product_attributes';
    public $timestamps = true;
    
    protected $fillable = [
        'product_id',
        'attribute_id',
        'status'
    ];
    
    protected $casts = [
        'status' => 'integer'
    ];
}
