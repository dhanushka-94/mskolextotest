<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'order_id',
        'payment_method',
        'status',
        'amount',
        'currency',
        'gateway_transaction_id',
        'gateway_reference',
        'gateway_response',
        'customer_name',
        'customer_email',
        'customer_phone',
        'transaction_fee',
        'description',
        'failure_reason',
        'initiated_at',
        'completed_at',
        'failed_at',
        'metadata',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'metadata' => 'array',
        'amount' => 'decimal:2',
        'transaction_fee' => 'decimal:2',
        'initiated_at' => 'datetime',
        'completed_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Status check methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    // Payment method check methods
    public function isWebXPay(): bool
    {
        return $this->payment_method === 'webxpay';
    }

    public function isKokoPay(): bool
    {
        return $this->payment_method === 'kokopay';
    }

    public function isBankTransfer(): bool
    {
        return $this->payment_method === 'bank_transfer';
    }

    // Helper methods
    public function getPaymentMethodNameAttribute(): string
    {
        return match($this->payment_method) {
            'webxpay' => 'Credit/Debit Card',
            'kokopay' => 'Koko Pay (BNPL)',
            'bank_transfer' => 'Bank Transfer',
            default => ucfirst(str_replace('_', ' ', $this->payment_method))
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'completed' => 'green',
            'failed' => 'red',
            'cancelled' => 'gray',
            'refunded' => 'purple',
            default => 'gray'
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match($this->status) {
            'pending' => 'clock',
            'processing' => 'refresh',
            'completed' => 'check-circle',
            'failed' => 'x-circle',
            'cancelled' => 'x',
            'refunded' => 'arrow-left',
            default => 'question'
        };
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->amount + $this->transaction_fee;
    }

    // Scopes
    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
