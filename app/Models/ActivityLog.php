<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'action',
        'description',
        'properties',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'ip_address',
        'user_agent',
        'url',
        'method',
        'request_data',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'status',
        'severity',
    ];

    protected $casts = [
        'properties' => 'array',
        'request_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Activity Types
    const TYPE_SYSTEM = 'system';
    const TYPE_CUSTOMER = 'customer';
    const TYPE_ADMIN = 'admin';
    const TYPE_API = 'api';

    // Common Actions
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_REGISTER = 'register';
    const ACTION_ORDER_CREATED = 'order_created';
    const ACTION_ORDER_UPDATED = 'order_updated';
    const ACTION_ORDER_CANCELLED = 'order_cancelled';
    const ACTION_PRODUCT_VIEWED = 'product_viewed';
    const ACTION_PRODUCT_ADDED_TO_CART = 'product_added_to_cart';
    const ACTION_PRODUCT_REMOVED_FROM_CART = 'product_removed_from_cart';
    const ACTION_CART_CHECKOUT = 'cart_checkout';
    const ACTION_PAYMENT_ATTEMPTED = 'payment_attempted';
    const ACTION_PAYMENT_SUCCESS = 'payment_success';
    const ACTION_PAYMENT_FAILED = 'payment_failed';
    const ACTION_PROFILE_UPDATED = 'profile_updated';
    const ACTION_PASSWORD_CHANGED = 'password_changed';
    const ACTION_EMAIL_SENT = 'email_sent';
    const ACTION_FILE_UPLOADED = 'file_uploaded';
    const ACTION_SEARCH_PERFORMED = 'search_performed';
    const ACTION_CATEGORY_VIEWED = 'category_viewed';
    const ACTION_WISHLIST_ADDED = 'wishlist_added';
    const ACTION_REVIEW_SUBMITTED = 'review_submitted';

    // Status Types
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';
    const STATUS_CANCELLED = 'cancelled';

    // Severity Levels
    const SEVERITY_LOW = 'low';
    const SEVERITY_MEDIUM = 'medium';
    const SEVERITY_HIGH = 'high';
    const SEVERITY_CRITICAL = 'critical';

    /**
     * Get the subject (the model that was acted upon)
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the causer (the user who performed the action)
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who caused this activity (if causer is a user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id')->where('causer_type', User::class);
    }

    /**
     * Scope to filter by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by action
     */
    public function scopeOfAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by causer
     */
    public function scopeByCauser($query, $causer)
    {
        return $query->where('causer_type', get_class($causer))
                     ->where('causer_id', $causer->id);
    }

    /**
     * Scope to filter by subject
     */
    public function scopeForSubject($query, $subject)
    {
        return $query->where('subject_type', get_class($subject))
                     ->where('subject_id', $subject->id);
    }

    /**
     * Scope to filter by date range
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope to get recent activities
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Static method to log activity
     */
    public static function log(array $attributes = [])
    {
        $agent = new Agent();
        
        $defaults = [
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'device_type' => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'status' => self::STATUS_SUCCESS,
            'severity' => self::SEVERITY_MEDIUM,
        ];

        $attributes = array_merge($defaults, $attributes);

        return static::create($attributes);
    }

    /**
     * Log customer activity
     */
    public static function logCustomer($action, $description, $causer = null, $subject = null, array $properties = [])
    {
        return self::log([
            'type' => self::TYPE_CUSTOMER,
            'action' => $action,
            'description' => $description,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer ? $causer->id : null,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'properties' => $properties,
        ]);
    }

    /**
     * Log system activity
     */
    public static function logSystem($action, $description, $causer = null, $subject = null, array $properties = [])
    {
        return self::log([
            'type' => self::TYPE_SYSTEM,
            'action' => $action,
            'description' => $description,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer ? $causer->id : null,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'properties' => $properties,
        ]);
    }

    /**
     * Log admin activity
     */
    public static function logAdmin($action, $description, $causer = null, $subject = null, array $properties = [])
    {
        return self::log([
            'type' => self::TYPE_ADMIN,
            'action' => $action,
            'description' => $description,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer ? $causer->id : null,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'properties' => $properties,
            'severity' => self::SEVERITY_HIGH,
        ]);
    }

    /**
     * Get formatted time ago
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get formatted properties
     */
    public function getFormattedPropertiesAttribute()
    {
        if (!$this->properties) {
            return null;
        }

        return collect($this->properties)->map(function ($value, $key) {
            return ucfirst(str_replace('_', ' ', $key)) . ': ' . (is_array($value) ? json_encode($value) : $value);
        })->implode(', ');
    }

    /**
     * Get activity icon based on action
     */
    public function getIconAttribute()
    {
        $icons = [
            self::ACTION_LOGIN => '🔑',
            self::ACTION_LOGOUT => '🚪',
            self::ACTION_REGISTER => '📝',
            self::ACTION_ORDER_CREATED => '🛒',
            self::ACTION_ORDER_UPDATED => '📦',
            self::ACTION_ORDER_CANCELLED => '❌',
            self::ACTION_PRODUCT_VIEWED => '👀',
            self::ACTION_PRODUCT_ADDED_TO_CART => '➕',
            self::ACTION_PRODUCT_REMOVED_FROM_CART => '➖',
            self::ACTION_CART_CHECKOUT => '💳',
            self::ACTION_PAYMENT_SUCCESS => '✅',
            self::ACTION_PAYMENT_FAILED => '❌',
            self::ACTION_PROFILE_UPDATED => '👤',
            self::ACTION_SEARCH_PERFORMED => '🔍',
            self::ACTION_CATEGORY_VIEWED => '📂',
        ];

        return $icons[$this->action] ?? '📊';
    }

    /**
     * Get severity color class
     */
    public function getSeverityColorAttribute()
    {
        $colors = [
            self::SEVERITY_LOW => 'text-green-500',
            self::SEVERITY_MEDIUM => 'text-yellow-500',
            self::SEVERITY_HIGH => 'text-orange-500',
            self::SEVERITY_CRITICAL => 'text-red-500',
        ];

        return $colors[$this->severity] ?? 'text-gray-500';
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_SUCCESS => 'text-green-500',
            self::STATUS_FAILED => 'text-red-500',
            self::STATUS_PENDING => 'text-yellow-500',
            self::STATUS_CANCELLED => 'text-gray-500',
        ];

        return $colors[$this->status] ?? 'text-gray-500';
    }
}