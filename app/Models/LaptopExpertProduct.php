<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LaptopExpertProduct extends SmaProduct
{
    protected $connection = 'laptopexpert_products_db';
    protected $table = 'sma_products';

    /**
     * Read `quantity` from stored attributes only (avoids cast / relation edge cases).
     * LE billing often keeps a separate product_status label (e.g. "In Stock") while quantity is 0 or null.
     */
    protected function rawSaleQuantity(): float
    {
        if (! array_key_exists('quantity', $this->getAttributes())) {
            return 0.0;
        }

        return self::listingQuantityFromRaw($this->getAttributes()['quantity']);
    }

    /**
     * Stock for templates / JSON — always follows `quantity`, never the status name.
     */
    public function getStockQuantityAttribute(): float
    {
        return $this->rawSaleQuantity();
    }

    public function getCanAddToCartAttribute(): bool
    {
        if ($this->status) {
            $restrictedStatuses = [
                'Coming Soon',
                'Pre Order',
                'In Stock (for PC Build)',
                'Reserved',
            ];

            if (in_array($this->status->status_name, $restrictedStatuses, true)) {
                return false;
            }
        }

        return (int) $this->hide === 0 && $this->rawSaleQuantity() > 0;
    }

    public function getCartRestrictionReasonAttribute()
    {
        if ($this->status) {
            $restrictedStatuses = [
                'Coming Soon' => 'This product is coming soon',
                'Pre Order' => 'This product is available for pre-order only',
                'In Stock (for PC Build)' => 'This product is reserved for PC builds',
                'Reserved' => 'This product is currently reserved',
            ];

            $statusName = $this->status->status_name;
            if (isset($restrictedStatuses[$statusName])) {
                return $restrictedStatuses[$statusName];
            }
        }

        if ($this->rawSaleQuantity() <= 0) {
            return 'Out of stock';
        }

        return null;
    }

    /**
     * Base URL for main `image` field (trailing slash normalized).
     */
    protected static function laptopExpertMainImageBaseUrl(): string
    {
        $url = config('laptopexpert.main_image_base_url')
            ?: config('laptopexpert.image_base_url');

        return self::normalizeImageBaseUrl($url) ?? 'https://billing.mskcomputers.lk/assets/uploads/';
    }

    /**
     * Base URL for extra gallery photos (trailing slash normalized).
     */
    protected static function laptopExpertExtraPhotosBaseUrl(): string
    {
        $url = config('laptopexpert.extra_photos_base_url')
            ?: config('laptopexpert.image_base_url')
            ?: config('laptopexpert.main_image_base_url');

        return self::normalizeImageBaseUrl($url) ?? 'https://billing.mskcomputers.lk/assets/uploads/';
    }

    protected static function normalizeImageBaseUrl(?string $url): ?string
    {
        if ($url === null || trim($url) === '') {
            return null;
        }

        return rtrim(trim($url), '/') . '/';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LaptopExpertCategory::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(LaptopExpertCategory::class, 'subcategory_id');
    }

    /**
     * Status rows live on laptopexpert_products_db — never use MSK sma_product_status for these products.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(LaptopExpertProductStatus::class, 'product_status');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(LaptopExpertProductPhoto::class, 'product_id');
    }

    /**
     * Main image URL — uses env-driven base (LaptopExpert only).
     */
    public function getMainImageAttribute()
    {
        $base = self::laptopExpertMainImageBaseUrl();

        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }

            return $base . ltrim($this->image, '/');
        }

        $firstPhoto = $this->photos()->first();
        if ($firstPhoto) {
            if (str_starts_with($firstPhoto->photo, 'http')) {
                return $firstPhoto->photo;
            }

            return self::laptopExpertExtraPhotosBaseUrl() . ltrim($firstPhoto->photo, '/');
        }

        return 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=300&fit=crop&crop=center';
    }

    /**
     * All image URLs — main uses main base, gallery uses extras base (LaptopExpert only).
     */
    public function getImagesAttribute()
    {
        $images = [];
        $mainBase = self::laptopExpertMainImageBaseUrl();
        $photosBase = self::laptopExpertExtraPhotosBaseUrl();

        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                $images[] = $this->image;
            } else {
                $images[] = $mainBase . ltrim($this->image, '/');
            }
        }

        foreach ($this->photos as $photo) {
            if (str_starts_with($photo->photo, 'http')) {
                $images[] = $photo->photo;
            } else {
                $images[] = $photosBase . ltrim($photo->photo, '/');
            }
        }

        if (empty($images)) {
            $images[] = 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=300&fit=crop&crop=center';
        }

        return $images;
    }
}
