<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SmaProductAttribute extends Pivot
{
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
