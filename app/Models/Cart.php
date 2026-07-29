<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Cart extends Model
{
    protected $connection = 'mysql'; // Use main website database
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_type',
        'quantity',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Resolve product model class for a cart catalog key (MSK products DB only).
     */
    public static function productClassFromCatalog(?string $catalog): string
    {
        return SmaProduct::class;
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}
