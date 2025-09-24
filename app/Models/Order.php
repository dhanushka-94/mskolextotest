<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use App\Models\ActivityLog;

class Order extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'billing_address_line_1',
        'billing_address_line_2',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'shipping_address_line_1',
        'shipping_address_line_2',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'subtotal',
        'tax_amount',
        'shipping_cost',
        'discount_amount',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'notes',
        'admin_notes',
        'shipped_at',
        'delivered_at',
        'tracking_number',
        'courier_service',
        'admin_viewed_at',
        'viewed_by_admin_id',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
            'admin_viewed_at' => 'datetime',
        ];
    }

    /**
     * Boot method to generate order number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->order_number) {
                $model->order_number = 'MSK-' . date('Y') . '-' . strtoupper(Str::random(8));
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function viewedByAdmin()
    {
        return $this->belongsTo(User::class, 'viewed_by_admin_id');
    }

    /**
     * Helper methods for order viewing
     */
    public function isViewedByAdmin()
    {
        return !is_null($this->admin_viewed_at);
    }

    public function markAsViewedBy($adminId)
    {
        $this->update([
            'admin_viewed_at' => now(),
            'viewed_by_admin_id' => $adminId
        ]);
    }

    public function scopeUnviewed($query)
    {
        return $query->whereNull('admin_viewed_at');
    }

    public function scopeViewed($query)
    {
        return $query->whereNotNull('admin_viewed_at');
    }

    /**
     * Accessors
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-purple-100 text-purple-800',
            'shipped' => 'bg-indigo-100 text-indigo-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->payment_status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getFormattedTotalAttribute()
    {
        return 'LKR ' . number_format($this->total_amount, 2);
    }

    public function getShippingAddressAttribute()
    {
        return trim($this->shipping_address_line_1 . ' ' . $this->shipping_address_line_2) . ', ' . 
               $this->shipping_city . ', ' . $this->shipping_state . ' ' . $this->shipping_postal_code;
    }

    public function getBillingAddressAttribute()
    {
        return trim($this->billing_address_line_1 . ' ' . $this->billing_address_line_2) . ', ' . 
               $this->billing_city . ', ' . $this->billing_state . ' ' . $this->billing_postal_code;
    }

    /**
     * Scopes
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Methods
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function canBeShipped()
    {
        return $this->status === 'processing' && $this->payment_status === 'paid';
    }

    public function markAsShipped($trackingNumber = null, $courierService = null)
    {
        $this->update([
            'status' => 'shipped',
            'shipped_at' => now(),
            'tracking_number' => $trackingNumber,
            'courier_service' => $courierService,
        ]);
    }

    public function markAsDelivered()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Activity Logging Methods
     */
    protected function getActivityType()
    {
        return ActivityLog::TYPE_SYSTEM;
    }

    public function logOrderCreated()
    {
        return $this->logOrderActivity(ActivityLog::ACTION_ORDER_CREATED, "Order {$this->order_number} created for customer {$this->customer_name}", [
            'order_number' => $this->order_number,
            'customer_email' => $this->customer_email,
            'items_count' => $this->orderItems->count(),
        ]);
    }

    public function logStatusChange($oldStatus, $newStatus)
    {
        return $this->logOrderActivity(ActivityLog::ACTION_ORDER_UPDATED, "Order {$this->order_number} status changed from {$oldStatus} to {$newStatus}", [
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ], ActivityLog::SEVERITY_MEDIUM);
    }

    public function logPaymentUpdate($paymentStatus, $paymentMethod = null)
    {
        return $this->logOrderActivity(ActivityLog::ACTION_PAYMENT_ATTEMPTED, "Payment {$paymentStatus} for order {$this->order_number}", [
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentMethod,
            'order_total' => $this->total_amount,
        ], $paymentStatus === 'paid' ? ActivityLog::SEVERITY_LOW : ActivityLog::SEVERITY_HIGH);
    }

    public function logOrderCancelled($reason = null)
    {
        return $this->logOrderActivity(ActivityLog::ACTION_ORDER_CANCELLED, "Order {$this->order_number} cancelled", [
            'cancellation_reason' => $reason,
            'cancelled_amount' => $this->total_amount,
        ], ActivityLog::SEVERITY_HIGH);
    }
}