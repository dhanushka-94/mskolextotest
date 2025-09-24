<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmaCategory extends Model
{
    protected $connection = 'products_db';
    protected $table = 'sma_categories';
    
    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'name',
        'image',
        'parent_id',
        'slug',
        'sort_order'
    ];

    protected $casts = [
        'parent_id' => 'integer'
    ];

    /**
     * Get products in this category
     */
    public function products(): HasMany
    {
        return $this->hasMany(SmaProduct::class, 'category_id')->where('hide', 0);
    }

    /**
     * Get products that belong to this subcategory (subcategory products)
     */
    public function subcategoryProducts(): HasMany
    {
        return $this->hasMany(SmaProduct::class, 'subcategory_id')->where('hide', 0);
    }

    /**
     * Get all products (both as main category and as subcategory)
     */
    public function allProductsQuery()
    {
        return SmaProduct::where(function($query) {
            $query->where('category_id', $this->id)
                  ->orWhere('subcategory_id', $this->id);
        })->where('hide', 0);
    }

    /**
     * Get subcategories (child categories)
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(SmaCategory::class, 'parent_id');
    }

    /**
     * Get parent category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(SmaCategory::class, 'parent_id');
    }

    /**
     * Scope for main categories (parent_id is null or empty) excluding Services
     */
    public function scopeMainCategories($query)
    {
        return $query->where(function($q) {
            $q->whereNull('parent_id')
              ->orWhere('parent_id', '')
              ->orWhere('parent_id', 0);
        })->where('name', 'NOT LIKE', '%Service%')
          ->where('name', 'NOT LIKE', '%service%');
    }

    /**
     * Get category image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return 'https://mskcomputers.lk/assets/uploads/' . $this->image;
        }
        
        return asset('images/placeholder-category.jpg');
    }

    /**
     * Get products count
     */
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    /**
     * Generate SEO-friendly slug from category name
     */
    public function getSlugAttribute($value)
    {
        return $value ?: \Str::slug($this->name);
    }

    /**
     * Get route key for model binding (use ID as primary, handle slug in resolution)
     */
    public function getRouteKeyName()
    {
        return 'id'; // Keep ID as primary for now
    }

    /**
     * Resolve route binding using both slug and ID
     */
    public function resolveRouteBinding($value, $field = null)
    {
        \Log::info("Category route binding - Value: $value, Field: " . ($field ?: 'null'));
        
        // If it's numeric, treat as ID
        if (is_numeric($value)) {
            $result = $this->where('id', $value)->first();
            \Log::info("Category ID lookup result: " . ($result ? $result->name : 'not found'));
            return $result;
        }
        
        // Otherwise, treat as slug - check actual slug field first, then name-based slug
        $result = $this->where('slug', $value)->first();
        if ($result) {
            \Log::info("Category slug lookup (stored) result: " . $result->name);
            return $result;
        }
        
        // Fallback: convert slug back to name and search
        $searchTerms = str_replace('-', ' ', $value);
        \Log::info("Category slug lookup - searching for: $searchTerms");
        
        $result = $this->where('name', 'like', '%' . $searchTerms . '%')->first();
        if (!$result) {
            $result = $this->whereRaw('REPLACE(LOWER(name), " ", "-") LIKE ?', ['%' . $value . '%'])->first();
        }
        
        // Try common category variations if still not found
        if (!$result) {
            $variations = [
                'cables' => ['cable', 'networking', 'accessories', 'wire'],
                'cable' => ['cables', 'networking', 'accessories'],
                'accessories' => ['cable', 'cables', 'misc', 'other'],
                'monitors' => ['monitor', 'display', 'screen'],
                'keyboard' => ['keyboards', 'input'],
                'mouse' => ['mice', 'input']
            ];
            
            if (isset($variations[$value])) {
                foreach ($variations[$value] as $variation) {
                    $result = $this->where('name', 'like', '%' . $variation . '%')->first();
                    if ($result) {
                        \Log::info("Category variation found: " . $result->name . " for input: $value");
                        break;
                    }
                }
            }
        }
        
        \Log::info("Category slug lookup result: " . ($result ? $result->name : 'not found'));
        return $result;
    }
}
