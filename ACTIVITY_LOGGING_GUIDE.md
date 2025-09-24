# MSK Computers - Activity Logging System Documentation

## Overview

A comprehensive activity logging system has been implemented for MSK Computers to track all system and customer activities. This system provides detailed insights into user behavior, system operations, and admin actions.

## Features

### ✅ Complete Activity Tracking
- **Customer Activities**: Login, logout, product views, cart actions, searches, orders
- **System Activities**: Order processing, email notifications, automated tasks
- **Admin Activities**: User management, order updates, system configuration

### ✅ Advanced Filtering & Search
- Filter by activity type, action, severity, status, date range
- Search across descriptions, actions, and IP addresses
- Real-time activity feed with auto-refresh
- Detailed activity views with full context

### ✅ Real-time Monitoring
- Live activity feed updates every 10 seconds
- Auto-refresh toggle for continuous monitoring
- Visual indicators for different activity types and severities
- Instant notifications for critical activities

### ✅ Comprehensive Data Collection
- IP address, user agent, device type, browser, platform
- Request data (sanitized), response status, timestamps
- Geographic information (when available)
- Custom properties for each activity type

## Database Structure

### Activity Logs Table
```sql
- id: Primary key
- type: 'system', 'customer', 'admin', 'api'
- action: Specific action performed
- description: Human-readable description
- properties: JSON data with additional context
- subject_type/subject_id: What was acted upon
- causer_type/causer_id: Who performed the action
- ip_address, user_agent, url, method: Request details
- device_type, browser, platform: Device information
- country, city: Geographic information
- status: 'success', 'failed', 'pending', 'cancelled'
- severity: 'low', 'medium', 'high', 'critical'
- created_at, updated_at: Timestamps
```

## Usage Examples

### Manual Logging
```php
use App\Models\ActivityLog;

// Log customer activity
ActivityLog::logCustomer(
    ActivityLog::ACTION_PRODUCT_VIEWED,
    'Customer viewed gaming laptop',
    $user,
    $product,
    ['product_name' => $product->name, 'price' => $product->price]
);

// Log system activity
ActivityLog::logSystem(
    ActivityLog::ACTION_ORDER_CREATED,
    'New order placed',
    $user,
    $order,
    ['order_total' => $order->total, 'items_count' => $order->items->count()]
);

// Log admin activity
ActivityLog::logAdmin(
    'user_updated',
    'Admin updated user profile',
    $admin,
    $user,
    ['updated_fields' => ['name', 'email']]
);
```

### Using Model Traits
```php
// Add to your models
use App\Traits\LogsActivity;

class Order extends Model
{
    use LogsActivity;
    
    // Automatic logging on create/update/delete
    // Custom logging methods available
    public function logStatusChange($oldStatus, $newStatus)
    {
        return $this->logOrderActivity(
            ActivityLog::ACTION_ORDER_UPDATED,
            "Order status changed from {$oldStatus} to {$newStatus}",
            ['old_status' => $oldStatus, 'new_status' => $newStatus]
        );
    }
}
```

### Controller Integration
```php
// In AuthController
public function login(Request $request)
{
    if (Auth::attempt($credentials)) {
        // Log successful login
        Auth::user()->logLoginActivity();
        return redirect()->intended();
    }
    
    // Log failed login
    ActivityLog::log([
        'type' => ActivityLog::TYPE_CUSTOMER,
        'action' => ActivityLog::ACTION_LOGIN,
        'description' => "Failed login attempt for {$request->email}",
        'status' => ActivityLog::STATUS_FAILED,
        'severity' => ActivityLog::SEVERITY_MEDIUM,
    ]);
    
    return back()->withErrors(['email' => 'Invalid credentials']);
}
```

## Admin Dashboard Features

### Activity Logs Interface
- **URL**: `/admin/activity-logs`
- **Features**:
  - Comprehensive activity table with sorting and pagination
  - Advanced filtering by type, action, severity, status, date range
  - Real-time feed with auto-refresh
  - Detailed activity views
  - Export functionality
  - Cleanup tools for old logs

### Statistics Dashboard
- Total activities count
- Activities by type (Customer, System, Admin)
- Activities by severity level
- High priority activities count
- Activity trends and patterns

### Management Tools
- **Export**: Download activity logs as JSON/CSV
- **Cleanup**: Remove old logs (configurable retention period)
- **Real-time Feed**: Live updates without page refresh
- **Search**: Full-text search across all activity data

## Available Activity Types

### Customer Activities
- `login`: User authentication
- `logout`: User logout
- `register`: New user registration
- `product_viewed`: Product page access
- `category_viewed`: Category browsing
- `search_performed`: Search queries
- `product_added_to_cart`: Cart additions
- `product_removed_from_cart`: Cart removals
- `cart_checkout`: Checkout process
- `profile_updated`: Profile changes
- `password_changed`: Security updates

### System Activities
- `order_created`: New orders
- `order_updated`: Order modifications
- `order_cancelled`: Order cancellations
- `payment_attempted`: Payment processing
- `payment_success`: Successful payments
- `payment_failed`: Failed payments
- `email_sent`: Email notifications
- `file_uploaded`: File operations

### Admin Activities
- All customer and system activities when performed by admins
- `user_updated`: User management
- `bulk_action_performed`: Bulk operations
- `cleanup`: System maintenance

## Security & Privacy

### Data Protection
- Sensitive data (passwords, tokens) automatically filtered
- Large request payloads truncated to prevent bloat
- IP address logging for security tracking
- Configurable data retention policies

### Performance Optimization
- Indexed database fields for fast queries
- Automatic cleanup commands
- Background processing for heavy operations
- Optimized queries with selective loading

## Commands

### Create Sample Data
```bash
php artisan logs:create-samples --count=50
```

### Cleanup Old Logs
```bash
php artisan logs:cleanup --days=90
```

## Configuration

### Environment Variables
```env
ACTIVITY_LOG_ENABLED=true
ACTIVITY_LOG_RETENTION_DAYS=90
ACTIVITY_LOG_MAX_REQUEST_SIZE=2048
```

### Middleware Integration
The `ActivityLogMiddleware` automatically captures web requests:
- Skips assets, API routes, and internal requests
- Determines activity type based on route patterns
- Captures device and browser information
- Handles errors gracefully without breaking application

## Best Practices

### When to Log
- ✅ Important user actions (login, purchase, profile changes)
- ✅ System events (order processing, payments)
- ✅ Admin operations (user management, configuration)
- ✅ Security events (failed logins, suspicious activity)
- ❌ Routine page views (unless specifically needed)
- ❌ Asset requests (images, CSS, JS)
- ❌ Health checks and monitoring pings

### Performance Considerations
- Use background jobs for bulk logging
- Implement regular cleanup schedules
- Monitor database size and performance
- Use appropriate log levels (severity)

### Security Guidelines
- Never log sensitive data (passwords, credit cards)
- Sanitize user input before logging
- Implement log access controls
- Regular security audits of logged data

## Troubleshooting

### Common Issues
1. **Large Database**: Implement regular cleanup
2. **Performance Impact**: Use background processing
3. **Missing Logs**: Check middleware registration
4. **Permission Errors**: Verify database permissions

### Debug Mode
Enable detailed logging in development:
```php
// In AppServiceProvider
if (app()->environment('local')) {
    ActivityLog::$debugMode = true;
}
```

## Integration Examples

### E-commerce Events
```php
// Product view tracking
ActivityLog::logCustomer(
    ActivityLog::ACTION_PRODUCT_VIEWED,
    "Viewed {$product->name}",
    $user,
    $product,
    [
        'category' => $product->category->name,
        'price' => $product->price,
        'referrer' => request()->header('referer')
    ]
);

// Cart abandonment tracking
ActivityLog::logCustomer(
    'cart_abandoned',
    'User left items in cart',
    $user,
    null,
    [
        'cart_value' => $cart->total(),
        'items_count' => $cart->items->count(),
        'time_on_site' => session('session_start_time')
    ]
);
```

### Admin Monitoring
```php
// Bulk operations
ActivityLog::logAdmin(
    'bulk_order_update',
    "Updated {$count} orders to shipped status",
    $admin,
    null,
    [
        'affected_orders' => $orderIds,
        'operation' => 'status_update',
        'new_status' => 'shipped'
    ]
);
```

## Future Enhancements

### Planned Features
- [ ] Advanced analytics and reporting
- [ ] Alert system for critical activities
- [ ] Integration with external monitoring tools
- [ ] Machine learning for anomaly detection
- [ ] API endpoints for external systems

### Performance Improvements
- [ ] Elasticsearch integration for large datasets
- [ ] Redis caching for frequent queries
- [ ] Async logging with queues
- [ ] Data archiving system

## Support

For questions or issues regarding the activity logging system:
- Check the logs: `storage/logs/laravel.log`
- Review database performance
- Monitor system resources
- Contact development team for advanced troubleshooting

---

**MSK Computers Activity Logging System**  
*Comprehensive tracking for enhanced security and analytics*
