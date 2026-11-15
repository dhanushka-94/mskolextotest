<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        'first_name',
        'last_name',
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
        'transfer_slip_path',
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
     * Use create/update auto-logging from trait, but skip generic delete
     * (deletion is logged manually with full order + item snapshot).
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created', "New {$model->getModelName()} created");
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            if (!empty($changes)) {
                $model->logActivity('updated', "Updated {$model->getModelName()}", [
                    'changes' => $changes,
                    'original' => $model->getOriginal(),
                ]);
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

    /**
     * Get the transactions for this order.
     */
    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
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
            'pending' => 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30',
            'paid' => 'bg-green-500/20 text-green-400 border border-green-500/30',
            'failed' => 'bg-red-500/20 text-red-400 border border-red-500/30',
            'refunded' => 'bg-gray-500/20 text-gray-400 border border-gray-500/30',
        ];

        return $badges[$this->payment_status] ?? 'bg-gray-500/20 text-gray-400 border border-gray-500/30';
    }

    public function getPaymentMethodBadgeAttribute()
    {
        $badges = [
            'webxpay' => 'bg-blue-900/50 text-blue-200 border border-blue-700',
            'kokopay' => 'bg-purple-900/50 text-purple-200 border border-purple-700',
            'bank_transfer' => 'bg-green-900/50 text-green-200 border border-green-700',
        ];

        return $badges[$this->payment_method] ?? 'bg-gray-900/50 text-gray-200 border border-gray-700';
    }

    public function getPaymentMethodDisplayAttribute()
    {
        $displays = [
            'webxpay' => '💳 WebXPay',
            'kokopay' => '⏰ Koko Pay (BNPL)',
            'bank_transfer' => '🏦 Bank Transfer',
        ];

        return $displays[$this->payment_method] ?? '❓ ' . ucfirst(str_replace('_', ' ', $this->payment_method ?? 'Unknown'));
    }

    public function getPaymentMethodIconAttribute()
    {
        $icons = [
            'webxpay' => '💳',
            'kokopay' => '⏰',
            'bank_transfer' => '🏦',
        ];

        return $icons[$this->payment_method] ?? '❓';
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

    /**
     * Full order snapshot for activity logs (must be called before items are deleted).
     */
    public function getDeletionActivitySnapshot(): array
    {
        if (!$this->relationLoaded('orderItems')) {
            $this->load('orderItems');
        }

        $items = $this->orderItems->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'product_type' => $item->product_type,
                'product_name' => $item->product_name,
                'product_code' => $item->product_code,
                'quantity' => (float) $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'unit_price_formatted' => 'LKR ' . number_format((float) $item->unit_price, 2),
                'total_price' => (float) $item->total_price,
                'total_price_formatted' => 'LKR ' . number_format((float) $item->total_price, 2),
                'product_attributes' => $item->product_attributes,
            ];
        })->values()->all();

        $itemsTotal = collect($items)->sum('total_price');

        return [
            'order_id' => $this->id,
            'order_number' => $this->order_number,
            'customer' => [
                'user_id' => $this->user_id,
                'name' => $this->customer_name,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->customer_email,
                'phone' => $this->customer_phone,
            ],
            'billing_address' => [
                'line_1' => $this->billing_address_line_1,
                'line_2' => $this->billing_address_line_2,
                'city' => $this->billing_city,
                'state' => $this->billing_state,
                'postal_code' => $this->billing_postal_code,
                'country' => $this->billing_country,
            ],
            'shipping_address' => [
                'line_1' => $this->shipping_address_line_1,
                'line_2' => $this->shipping_address_line_2,
                'city' => $this->shipping_city,
                'state' => $this->shipping_state,
                'postal_code' => $this->shipping_postal_code,
                'country' => $this->shipping_country,
            ],
            'pricing' => [
                'subtotal' => (float) $this->subtotal,
                'subtotal_formatted' => 'LKR ' . number_format((float) $this->subtotal, 2),
                'tax_amount' => (float) $this->tax_amount,
                'tax_amount_formatted' => 'LKR ' . number_format((float) $this->tax_amount, 2),
                'shipping_cost' => (float) $this->shipping_cost,
                'shipping_cost_formatted' => 'LKR ' . number_format((float) $this->shipping_cost, 2),
                'discount_amount' => (float) $this->discount_amount,
                'discount_amount_formatted' => 'LKR ' . number_format((float) $this->discount_amount, 2),
                'total_amount' => (float) $this->total_amount,
                'total_amount_formatted' => 'LKR ' . number_format((float) $this->total_amount, 2),
                'items_line_total' => (float) $itemsTotal,
                'items_line_total_formatted' => 'LKR ' . number_format((float) $itemsTotal, 2),
            ],
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'payment_reference' => $this->payment_reference,
            'notes' => $this->notes,
            'admin_notes' => $this->admin_notes,
            'items_count' => count($items),
            'items' => $items,
            'ordered_at' => optional($this->created_at)?->toDateTimeString(),
            'deleted_at' => now()->toDateTimeString(),
            'deleted_by' => Auth::user() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ] : null,
        ];
    }

    /**
     * Log full order deletion details (items + prices) before the order is removed.
     */
    public function logOrderDeleted(?string $reason = null)
    {
        $snapshot = $this->getDeletionActivitySnapshot();
        $itemSummary = collect($snapshot['items'])
            ->map(fn ($item) => "{$item['quantity']} x {$item['product_name']} @ {$item['unit_price_formatted']} = {$item['total_price_formatted']}")
            ->implode('; ');

        $description = "Order {$this->order_number} deleted"
            . " — customer: {$this->customer_name}"
            . " — total: {$snapshot['pricing']['total_amount_formatted']}"
            . " — {$snapshot['items_count']} item(s)"
            . ($itemSummary !== '' ? " [{$itemSummary}]" : '');

        if ($reason) {
            $description .= " — reason: {$reason}";
            $snapshot['deletion_reason'] = $reason;
        }

        $causer = Auth::user();

        return ActivityLog::log([
            'type' => $causer ? ActivityLog::TYPE_ADMIN : ActivityLog::TYPE_SYSTEM,
            'action' => ActivityLog::ACTION_ORDER_DELETED,
            'description' => $description,
            'subject_type' => static::class,
            'subject_id' => $this->id,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer?->id,
            'properties' => $snapshot,
            'severity' => ActivityLog::SEVERITY_HIGH,
            'status' => ActivityLog::STATUS_SUCCESS,
        ]);
    }
}