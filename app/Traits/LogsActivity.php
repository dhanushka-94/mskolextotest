<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot the trait
     */
    protected static function bootLogsActivity()
    {
        // Log when a model is created
        static::created(function ($model) {
            $model->logActivity('created', "New {$model->getModelName()} created");
        });

        // Log when a model is updated
        static::updated(function ($model) {
            $changes = $model->getChanges();
            if (!empty($changes)) {
                $model->logActivity('updated', "Updated {$model->getModelName()}", [
                    'changes' => $changes,
                    'original' => $model->getOriginal()
                ]);
            }
        });

        // Log when a model is deleted
        static::deleted(function ($model) {
            $model->logActivity('deleted', "Deleted {$model->getModelName()}");
        });
    }

    /**
     * Log activity for this model
     */
    public function logActivity($action, $description, array $properties = [], $causer = null)
    {
        $causer = $causer ?: Auth::user();
        
        return ActivityLog::log([
            'type' => $this->getActivityType(),
            'action' => $action,
            'description' => $description,
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer ? $causer->id : null,
            'properties' => array_merge($this->getDefaultProperties(), $properties),
            'severity' => $this->getActivitySeverity($action),
        ]);
    }

    /**
     * Log custom activity
     */
    public function logCustomActivity($action, $description, array $properties = [], $severity = ActivityLog::SEVERITY_MEDIUM)
    {
        return ActivityLog::log([
            'type' => $this->getActivityType(),
            'action' => $action,
            'description' => $description,
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'causer_type' => Auth::user() ? get_class(Auth::user()) : null,
            'causer_id' => Auth::id(),
            'properties' => array_merge($this->getDefaultProperties(), $properties),
            'severity' => $severity,
        ]);
    }

    /**
     * Get all activities for this model
     */
    public function activities()
    {
        return ActivityLog::forSubject($this)->orderBy('created_at', 'desc');
    }

    /**
     * Get recent activities for this model
     */
    public function recentActivities($days = 30)
    {
        return $this->activities()->recent($days);
    }

    /**
     * Get activity type based on model
     */
    protected function getActivityType()
    {
        // Override in models for custom types
        return ActivityLog::TYPE_SYSTEM;
    }

    /**
     * Get model name for logging
     */
    protected function getModelName()
    {
        return class_basename(get_class($this));
    }

    /**
     * Get default properties to include in logs
     */
    protected function getDefaultProperties()
    {
        $properties = [];
        
        // Include key attributes
        if (isset($this->attributes['name'])) {
            $properties['name'] = $this->attributes['name'];
        }
        
        if (isset($this->attributes['title'])) {
            $properties['title'] = $this->attributes['title'];
        }
        
        if (isset($this->attributes['email'])) {
            $properties['email'] = $this->attributes['email'];
        }
        
        if (isset($this->attributes['status'])) {
            $properties['status'] = $this->attributes['status'];
        }

        return $properties;
    }

    /**
     * Determine activity severity based on action
     */
    protected function getActivitySeverity($action)
    {
        $highSeverityActions = ['deleted', 'cancelled', 'failed'];
        $mediumSeverityActions = ['updated', 'status_changed'];
        
        if (in_array($action, $highSeverityActions)) {
            return ActivityLog::SEVERITY_HIGH;
        }
        
        if (in_array($action, $mediumSeverityActions)) {
            return ActivityLog::SEVERITY_MEDIUM;
        }
        
        return ActivityLog::SEVERITY_LOW;
    }

    /**
     * Log order-specific activities
     */
    public function logOrderActivity($action, $description, array $properties = [])
    {
        $defaultProperties = [
            'order_total' => $this->total ?? null,
            'order_status' => $this->status ?? null,
            'customer_id' => $this->customer_id ?? null,
        ];

        return $this->logCustomActivity($action, $description, array_merge($defaultProperties, $properties));
    }

    /**
     * Log user-specific activities
     */
    public function logUserActivity($action, $description, array $properties = [])
    {
        $defaultProperties = [
            'user_email' => $this->email ?? null,
            'user_role' => $this->role ?? null,
        ];

        return $this->logCustomActivity($action, $description, array_merge($defaultProperties, $properties));
    }

    /**
     * Log product-specific activities
     */
    public function logProductActivity($action, $description, array $properties = [])
    {
        $defaultProperties = [
            'product_name' => $this->name ?? null,
            'product_price' => $this->price ?? null,
            'product_stock' => $this->stock_quantity ?? null,
        ];

        return $this->logCustomActivity($action, $description, array_merge($defaultProperties, $properties));
    }
}
