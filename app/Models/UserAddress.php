<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'name',
        'contact_name',
        'contact_phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    /**
     * Boot method to ensure only one default address per type
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->is_default) {
                // Remove default status from other addresses of the same type
                static::where('user_id', $model->user_id)
                    ->where('type', $model->type)
                    ->where('id', '!=', $model->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessors
     */
    public function getFullAddressAttribute()
    {
        return trim($this->address_line_1 . ' ' . $this->address_line_2) . ', ' . 
               $this->city . ', ' . $this->state . ' ' . $this->postal_code . ', ' . $this->country;
    }

    public function getFormattedAddressAttribute()
    {
        $address = $this->address_line_1;
        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }
        $address .= '<br>' . $this->city . ', ' . $this->state . ' ' . $this->postal_code;
        if ($this->country !== 'Sri Lanka') {
            $address .= '<br>' . $this->country;
        }
        return $address;
    }

    /**
     * Scopes
     */
    public function scopeShipping($query)
    {
        return $query->where('type', 'shipping');
    }

    public function scopeBilling($query)
    {
        return $query->where('type', 'billing');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}