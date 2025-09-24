<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip logging for certain conditions
        if ($this->shouldSkipLogging($request, $response)) {
            return $response;
        }

        // Log the activity
        try {
            $this->logActivity($request, $response);
        } catch (\Exception $e) {
            // Don't break the application if logging fails
            \Log::error('Activity logging failed: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Determine if we should skip logging this request
     */
    private function shouldSkipLogging(Request $request, Response $response): bool
    {
        // Skip if response is not successful
        if ($response->getStatusCode() >= 400) {
            return false; // We want to log errors too
        }

        // Skip for certain paths
        $skipPaths = [
            'activity-logs-feed', // Don't log the activity feed requests
            'heartbeat',
            'health-check',
            '_debugbar',
            'telescope',
        ];

        foreach ($skipPaths as $path) {
            if (str_contains($request->path(), $path)) {
                return true;
            }
        }

        // Skip for assets, images, etc.
        $skipExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2'];
        $extension = pathinfo($request->path(), PATHINFO_EXTENSION);
        
        if (in_array(strtolower($extension), $skipExtensions)) {
            return true;
        }

        // Skip for API requests (they should handle their own logging)
        if ($request->is('api/*')) {
            return true;
        }

        return false;
    }

    /**
     * Log the activity
     */
    private function logActivity(Request $request, Response $response): void
    {
        $user = Auth::user();
        $action = $this->determineAction($request);
        $description = $this->generateDescription($request, $action, $user);
        $type = $this->determineActivityType($request, $user);
        $severity = $this->determineSeverity($request, $response);
        $status = $this->determineStatus($response);

        // Prepare properties
        $properties = $this->gatherProperties($request, $response);

        // Create activity log
        ActivityLog::log([
            'type' => $type,
            'action' => $action,
            'description' => $description,
            'causer_type' => $user ? get_class($user) : null,
            'causer_id' => $user ? $user->id : null,
            'properties' => $properties,
            'severity' => $severity,
            'status' => $status,
            'request_data' => $this->getRequestData($request),
        ]);
    }

    /**
     * Determine the action based on the request
     */
    private function determineAction(Request $request): string
    {
        $method = $request->method();
        $path = $request->path();
        $routeName = $request->route()?->getName();

        // Check for specific actions first
        if ($routeName) {
            // Order related actions
            if (str_contains($routeName, 'orders')) {
                if (str_contains($routeName, 'create') || $method === 'POST') {
                    return ActivityLog::ACTION_ORDER_CREATED;
                }
                if (str_contains($routeName, 'show')) {
                    return 'order_viewed';
                }
                if ($method === 'PUT' || $method === 'PATCH') {
                    return ActivityLog::ACTION_ORDER_UPDATED;
                }
            }

            // Product related actions
            if (str_contains($routeName, 'products')) {
                if (str_contains($routeName, 'show')) {
                    return ActivityLog::ACTION_PRODUCT_VIEWED;
                }
            }

            // Category related actions
            if (str_contains($routeName, 'categories')) {
                if (str_contains($routeName, 'show')) {
                    return ActivityLog::ACTION_CATEGORY_VIEWED;
                }
            }

            // Cart related actions
            if (str_contains($routeName, 'cart')) {
                if ($method === 'POST') {
                    return ActivityLog::ACTION_PRODUCT_ADDED_TO_CART;
                }
                if ($method === 'DELETE') {
                    return ActivityLog::ACTION_PRODUCT_REMOVED_FROM_CART;
                }
            }

            // Search related actions
            if (str_contains($routeName, 'search')) {
                return ActivityLog::ACTION_SEARCH_PERFORMED;
            }

            // Auth related actions
            if (str_contains($routeName, 'login')) {
                return ActivityLog::ACTION_LOGIN;
            }
            if (str_contains($routeName, 'logout')) {
                return ActivityLog::ACTION_LOGOUT;
            }
            if (str_contains($routeName, 'register')) {
                return ActivityLog::ACTION_REGISTER;
            }
        }

        // Fallback based on method and path
        switch ($method) {
            case 'GET':
                if ($path === '/' || $path === 'home') {
                    return 'homepage_visited';
                }
                return 'page_viewed';
            case 'POST':
                return 'data_created';
            case 'PUT':
            case 'PATCH':
                return 'data_updated';
            case 'DELETE':
                return 'data_deleted';
            default:
                return 'unknown_action';
        }
    }

    /**
     * Generate description for the activity
     */
    private function generateDescription(Request $request, string $action, $user): string
    {
        $userName = $user ? $user->name : 'Guest';
        $path = $request->path();
        $method = $request->method();

        switch ($action) {
            case ActivityLog::ACTION_LOGIN:
                return "User {$userName} logged in";
            case ActivityLog::ACTION_LOGOUT:
                return "User {$userName} logged out";
            case ActivityLog::ACTION_REGISTER:
                return "New user {$userName} registered";
            case ActivityLog::ACTION_PRODUCT_VIEWED:
                return "User {$userName} viewed a product";
            case ActivityLog::ACTION_CATEGORY_VIEWED:
                return "User {$userName} browsed a category";
            case ActivityLog::ACTION_PRODUCT_ADDED_TO_CART:
                return "User {$userName} added item to cart";
            case ActivityLog::ACTION_PRODUCT_REMOVED_FROM_CART:
                return "User {$userName} removed item from cart";
            case ActivityLog::ACTION_SEARCH_PERFORMED:
                $query = $request->get('search') ?: $request->get('q');
                return "User {$userName} searched for: " . ($query ?: 'unknown');
            case 'homepage_visited':
                return "User {$userName} visited homepage";
            case 'page_viewed':
                return "User {$userName} viewed page: {$path}";
            default:
                return "User {$userName} performed {$action} on {$path}";
        }
    }

    /**
     * Determine activity type
     */
    private function determineActivityType(Request $request, $user): string
    {
        if (!$user) {
            return ActivityLog::TYPE_CUSTOMER; // Guest customer activity
        }

        if ($user->role === 'admin' && str_contains($request->path(), 'admin')) {
            return ActivityLog::TYPE_ADMIN;
        }

        return ActivityLog::TYPE_CUSTOMER;
    }

    /**
     * Determine severity level
     */
    private function determineSeverity(Request $request, Response $response): string
    {
        // High severity for admin actions
        if (str_contains($request->path(), 'admin')) {
            return ActivityLog::SEVERITY_HIGH;
        }

        // Medium severity for user actions like cart, orders
        $mediumActions = ['cart', 'order', 'checkout', 'payment'];
        foreach ($mediumActions as $action) {
            if (str_contains($request->path(), $action)) {
                return ActivityLog::SEVERITY_MEDIUM;
            }
        }

        // Low severity for viewing actions
        return ActivityLog::SEVERITY_LOW;
    }

    /**
     * Determine status from response
     */
    private function determineStatus(Response $response): string
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            return ActivityLog::STATUS_SUCCESS;
        }

        if ($statusCode >= 400 && $statusCode < 500) {
            return ActivityLog::STATUS_FAILED;
        }

        if ($statusCode >= 500) {
            return ActivityLog::STATUS_FAILED;
        }

        return ActivityLog::STATUS_PENDING;
    }

    /**
     * Gather additional properties
     */
    private function gatherProperties(Request $request, Response $response): array
    {
        $properties = [
            'route_name' => $request->route()?->getName(),
            'response_status' => $response->getStatusCode(),
        ];

        // Add search query if present
        if ($request->has('search') || $request->has('q')) {
            $properties['search_query'] = $request->get('search') ?: $request->get('q');
        }

        // Add pagination info if present
        if ($request->has('page')) {
            $properties['page'] = $request->get('page');
        }

        // Add filter info for category/product pages
        if ($request->has('filter') || $request->has('sort')) {
            $properties['filters'] = array_filter([
                'filter' => $request->get('filter'),
                'sort' => $request->get('sort'),
                'min_price' => $request->get('min_price'),
                'max_price' => $request->get('max_price'),
            ]);
        }

        return array_filter($properties);
    }

    /**
     * Get filtered request data
     */
    private function getRequestData(Request $request): array
    {
        $data = $request->all();

        // Remove sensitive data
        $sensitiveKeys = ['password', 'password_confirmation', 'token', '_token', 'csrf_token'];
        
        foreach ($sensitiveKeys as $key) {
            unset($data[$key]);
        }

        // Limit data size to prevent huge logs
        if (json_encode($data) && strlen(json_encode($data)) > 2048) {
            return ['_truncated' => 'Request data too large to log'];
        }

        return $data;
    }
}