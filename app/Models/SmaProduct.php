<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmaProduct extends Model
{
    protected $connection = 'products_db';
    protected $table = 'sma_products';
    
    public $timestamps = false; // SMA doesn't use created_at/updated_at
    
    protected $fillable = [
        'name',
        'code',
        'barcode_symbology',
        'category_id',
        'subcategory_id',
        'unit',
        'cost',
        'price',
        'quantity',
        'alert_quantity',
        'track_quantity',
        'type',
        'supplier1',
        'supplier1price',
        'details',
        'image',
        'cf1',
        'cf2',
        'cf3',
        'cf4',
        'cf5',
        'cf6',
        'product_details',
        'product_status'
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'price' => 'decimal:2',
        'supplier1price' => 'decimal:2',
        'quantity' => 'decimal:4',
        'alert_quantity' => 'decimal:4',
        'track_quantity' => 'integer',
        'hide' => 'boolean',
        'second_name' => 'string',
        'promotion' => 'integer',
        'promo_price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'supplier1qty' => 'decimal:4',
        'sale_unit' => 'integer',
        'purchase_unit' => 'integer',
        'product_status' => 'integer'
    ];

    /**
     * Get the category for this product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(SmaCategory::class, 'category_id');
    }

    /**
     * Get the subcategory for this product
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SmaCategory::class, 'subcategory_id');
    }

    /**
     * Get the product status
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(SmaProductStatus::class, 'product_status');
    }


    /**
     * Get warehouse products (stock levels)
     */
    public function warehouseProducts(): HasMany
    {
        return $this->hasMany(SmaWarehouseProduct::class, 'product_id');
    }

    /**
     * Get product photos
     */
    public function photos(): HasMany
    {
        return $this->hasMany(SmaProductPhoto::class, 'product_id');
    }

    /**
     * Get product attributes (for display purposes)
     */
    public function attributes()
    {
        return $this->belongsToMany(SmaAttribute::class, 'sma_product_attributes', 'product_id', 'attribute_id')
            ->wherePivot('status', 1)
            ->with('parent');
    }


    /**
     * Get the final selling price (considering promotions)
     */
    public function getFinalPriceAttribute()
    {
        // Handle promotion pricing
        if ($this->promotion && $this->promo_price > 0) {
            // Check if dates are valid (allow promotions without date restrictions)
            if (!$this->start_date || !$this->end_date || 
                ($this->start_date <= now() && $this->end_date >= now())) {
                return $this->promo_price;
            }
        }
        
        // Return regular price (allow 0.00 prices)
        return $this->price ?? 0.00;
    }

    /**
     * Check if product is on sale
     */
    public function getIsOnSaleAttribute()
    {
        // Product is on sale if it has promotion flag and promo_price is lower than regular price
        if (!$this->promotion || !$this->promo_price || $this->promo_price >= $this->price) {
            return false;
        }
        
        // Check date restrictions if they exist
        if ($this->start_date && $this->end_date) {
            return $this->start_date <= now() && $this->end_date >= now();
        }
        
        // If no date restrictions, it's on sale
        return true;
    }

    /**
     * Get the main product image
     */
    public function getMainImageAttribute()
    {
        if ($this->image) {
            // Check if it's already a full URL
            if (str_starts_with($this->image, 'http')) {
                return $this->image;
            }
            return 'https://mskcomputers.lk/assets/uploads/' . $this->image;
        }
        
        // Get first photo if no main image
        $firstPhoto = $this->photos()->first();
        if ($firstPhoto) {
            if (str_starts_with($firstPhoto->photo, 'http')) {
                return $firstPhoto->photo;
            }
            return 'https://mskcomputers.lk/assets/uploads/' . $firstPhoto->photo;
        }
        
        // Fallback to placeholder
        return 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=300&fit=crop&crop=center';
    }

    /**
     * Get product images array
     */
    public function getImagesAttribute()
    {
        $images = [];
        
        // Add main image
        if ($this->image) {
            if (str_starts_with($this->image, 'http')) {
                $images[] = $this->image;
            } else {
                $images[] = 'https://mskcomputers.lk/assets/uploads/' . $this->image;
            }
        }
        
        // Add additional photos
        foreach ($this->photos as $photo) {
            if (str_starts_with($photo->photo, 'http')) {
                $images[] = $photo->photo;
            } else {
                $images[] = 'https://mskcomputers.lk/assets/uploads/' . $photo->photo;
            }
        }
        
        // If no images, add placeholder
        if (empty($images)) {
            $images[] = 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=300&fit=crop&crop=center';
        }
        
        return $images;
    }

    /**
     * Get formatted specifications
     */
    public function getSpecificationsAttribute()
    {
        // If product_details contains JSON, parse it
        if ($this->product_details) {
            $details = json_decode($this->product_details, true);
            if (is_array($details)) {
                return $details;
            }
        }
        
        // Fallback to details field
        return $this->details ? ['description' => $this->details] : [];
    }

    /**
     * Scope for active products (not hidden)
     */
    public function scopeActive($query)
    {
        return $query->where('hide', 0);
    }

    /**
     * Scope for products in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope for featured products (on promotion)
     */
    public function scopeFeatured($query)
    {
        return $query->where('promotion', 1)
                    ->where('promo_price', '>', 0)
                    ->where(function($q) {
                        $q->whereNull('start_date')
                          ->orWhereNull('end_date')
                          ->orWhere(function($dateQuery) {
                              $dateQuery->where('start_date', '<=', now())
                                       ->where('end_date', '>=', now());
                          });
                    });
    }

    /**
     * Scope for products by status
     */
    public function scopeByStatus($query, $statusId)
    {
        return $query->where('product_status', $statusId);
    }

    /**
     * Scope for products by status name
     */
    public function scopeByStatusName($query, $statusName)
    {
        return $query->whereHas('status', function($q) use ($statusName) {
            $q->where('status_name', $statusName);
        });
    }

    /**
     * Check if product can be added to cart
     */
    public function getCanAddToCartAttribute()
    {
        // Check if product has restricted status
        if ($this->status) {
            $restrictedStatuses = [
                'Coming Soon',
                'Pre Order', 
                'In Stock (for PC Build)',
                'Reserved'
            ];
            
            if (in_array($this->status->status_name, $restrictedStatuses)) {
                return false;
            }
        }
        
        // Additional checks: must be active and have stock
        return $this->hide == 0 && $this->quantity > 0;
    }

    /**
     * Get cart restriction reason
     */
    public function getCartRestrictionReasonAttribute()
    {
        if ($this->status) {
            $restrictedStatuses = [
                'Coming Soon' => 'This product is coming soon',
                'Pre Order' => 'This product is available for pre-order only',
                'In Stock (for PC Build)' => 'This product is reserved for PC builds',
                'Reserved' => 'This product is currently reserved'
            ];
            
            $statusName = $this->status->status_name;
            if (isset($restrictedStatuses[$statusName])) {
                return $restrictedStatuses[$statusName];
            }
        }
        
        if ($this->quantity <= 0) {
            return 'Out of stock';
        }
        
        return null;
    }

    /**
     * Get stock quantity (alias for quantity field)
     * Templates use stock_quantity but database field is quantity
     */
    public function getStockQuantityAttribute()
    {
        return (int) ($this->quantity ?: 0);
    }

    /**
     * Generate SEO-friendly slug from product name
     */
    public function getSlugAttribute()
    {
        return \Str::slug($this->name);
    }

    /**
     * Get route key for model binding (use slug instead of ID for new URLs, but support both)
     */
    public function getRouteKeyName()
    {
        return 'id'; // Keep ID as primary for now, we'll handle slug in resolveRouteBinding
    }

    /**
     * Resolve route binding using both slug and ID
     */
    public function resolveRouteBinding($value, $field = null)
    {
        \Log::info("Product route binding - Value: $value, Field: " . ($field ?: 'null'));
        
        // If it's numeric, treat as ID
        if (is_numeric($value)) {
            $result = $this->where('id', $value)->first();
            \Log::info("Product ID lookup result: " . ($result ? $result->name : 'not found'));
            return $result;
        }
        
        // Otherwise, treat as slug - find by name converted to slug
        $searchTerms = str_replace('-', ' ', $value);
        \Log::info("Product slug lookup - searching for: $searchTerms");
        
        $result = $this->where('name', 'like', '%' . $searchTerms . '%')->first();
        if (!$result) {
            $result = $this->whereRaw('REPLACE(LOWER(name), " ", "-") LIKE ?', ['%' . $value . '%'])->first();
        }
        
        // Try more flexible search if still not found
        if (!$result) {
            // Split search terms and try individual words
            $words = explode(' ', $searchTerms);
            if (count($words) > 1) {
                $query = $this->newQuery();
                foreach ($words as $word) {
                    if (strlen($word) > 2) { // Skip very short words
                        $query->where('name', 'like', '%' . $word . '%');
                    }
                }
                $result = $query->first();
            }
        }
        
        // Try common product variations
        if (!$result) {
            $variations = [
                'network cable' => ['ethernet cable', 'lan cable', 'cat5', 'cat6', 'rj45', 'network'],
                'hdmi cable' => ['hdmi', 'video cable'],
                'usb cable' => ['usb', 'charging cable'],
                'power cable' => ['power cord', 'ac cable', 'power supply']
            ];
            
            foreach ($variations as $pattern => $alternatives) {
                if (stripos($searchTerms, str_replace(' ', '', $pattern)) !== false) {
                    foreach (array_merge([$pattern], $alternatives) as $alt) {
                        $result = $this->where('name', 'like', '%' . $alt . '%')->first();
                        if ($result) {
                            \Log::info("Product variation found: " . $result->name . " for input: $value");
                            break 2;
                        }
                    }
                }
            }
        }
        
        \Log::info("Product slug lookup result: " . ($result ? $result->name : 'not found'));
        return $result;
    }

    /**
     * Get product attributes grouped by parent for display
     */
    public function getGroupedAttributesAttribute()
    {
        try {
            // Force fresh load of attributes with parent relationship
            $attributes = $this->attributes()->with('parent')->get();
            $grouped = [];
            
            foreach ($attributes as $attribute) {
                // Ensure we have a proper SmaAttribute model instance
                if ($attribute instanceof \App\Models\SmaAttribute && 
                    $attribute->parent && 
                    $attribute->parent->attribute_name) {
                    
                    $parentName = $attribute->parent->attribute_name;
                    if (!isset($grouped[$parentName])) {
                        $grouped[$parentName] = [];
                    }
                    $grouped[$parentName][] = $attribute->attribute_name;
                }
            }
            
            return $grouped;
        } catch (\Exception $e) {
            // Log error and return empty array to prevent page crash
            \Log::error('Error in getGroupedAttributesAttribute: ' . $e->getMessage());
            return [];
        }
    }
}
