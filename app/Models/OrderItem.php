<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_code',
        'product_image',
        'quantity',
        'unit_price',
        'total_price',
        'product_attributes',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'product_attributes' => 'array',
        ];
    }

    /**
     * Boot method to calculate total price
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_price = $model->quantity * $model->unit_price;
        });
    }

    /**
     * Relationships
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get product from products database
     * Note: This connects to the read-only products database
     */
    public function getProductAttribute()
    {
        return SmaProduct::find($this->product_id);
    }

    /**
     * Eloquent relationship to product
     * This allows using ->with('product') in queries
     */
    public function product()
    {
        return $this->belongsTo(SmaProduct::class, 'product_id');
    }

    /**
     * Accessors
     */
    public function getFormattedUnitPriceAttribute()
    {
        return 'LKR ' . number_format($this->unit_price, 2);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'LKR ' . number_format($this->total_price, 2);
    }

    public function getProductImageUrlAttribute()
    {
        return $this->product_image ?: asset('images/no-product-image.png');
    }
}