<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $connection = 'mysql'; // Use main website database
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
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

    public function product(): BelongsTo
    {
        return $this->belongsTo(SmaProduct::class, 'product_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}
