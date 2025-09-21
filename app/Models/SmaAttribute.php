<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmaAttribute extends Model
{
    use HasFactory;

    protected $connection = 'products_db';
    protected $table = 'sma_attributes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'attribute_name',
        'attribute_slug', 
        'parent_id',
        'category_id',
        'status'
    ];

    /**
     * Get the parent attribute (for hierarchical structure)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(SmaAttribute::class, 'parent_id');
    }

    /**
     * Get child attributes
     */
    public function children(): HasMany
    {
        return $this->hasMany(SmaAttribute::class, 'parent_id');
    }

    /**
     * Scope for active attributes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope for parent attributes (main categories like MANUFACTURE, VRAM)
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for child attributes (specific values like MSI, 8GB)
     */
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
