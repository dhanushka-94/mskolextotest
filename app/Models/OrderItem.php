<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_type',
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
     * Live product relation (MSK products DB). Snapshot fields are stored on the row.
     */
    public function product(): MorphTo
    {
        return $this->morphTo();
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