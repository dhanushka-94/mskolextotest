<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaptopExpertProductPhoto extends Model
{
    protected $connection = 'laptopexpert_products_db';
    protected $table = 'sma_product_photos';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'photo',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(LaptopExpertProduct::class, 'product_id');
    }

    /**
     * Full photo URL — uses LaptopExpert extras base from config/env.
     */
    public function getPhotoUrlAttribute(): string
    {
        if (str_starts_with((string) $this->photo, 'http')) {
            return $this->photo;
        }

        $base = config('laptopexpert.extra_photos_base_url')
            ?: config('laptopexpert.image_base_url')
            ?: config('laptopexpert.main_image_base_url');

        if ($base !== null && trim((string) $base) !== '') {
            return rtrim(trim((string) $base), '/') . '/' . ltrim((string) $this->photo, '/');
        }

        return 'https://billing.mskcomputers.lk/assets/uploads/' . ltrim((string) $this->photo, '/');
    }
}
