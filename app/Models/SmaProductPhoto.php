<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmaProductPhoto extends Model
{
    protected $connection = 'products_db';
    protected $table = 'sma_product_photos';
    
    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'photo'
    ];

    /**
     * Get the product this photo belongs to
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(SmaProduct::class, 'product_id');
    }

    /**
     * Get the photo URL
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://mskcomputers.lk/assets/uploads/' . $this->photo;
    }
}
