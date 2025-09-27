<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SearchController;

// Admin Routes (Must be FIRST to avoid conflicts with product routes)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [App\Http\Controllers\Admin\AdminDashboardController::class, 'analytics'])->name('analytics');
    
    // Order Management (Complete CRUD)
    Route::get('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [App\Http\Controllers\Admin\AdminOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [App\Http\Controllers\Admin\AdminOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\AdminOrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [App\Http\Controllers\Admin\AdminOrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/{order}/status', [App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::put('/orders/{order}/payment', [App\Http\Controllers\Admin\AdminOrderController::class, 'updatePaymentStatus'])->name('orders.update-payment');
    Route::post('/orders/bulk-action', [App\Http\Controllers\Admin\AdminOrderController::class, 'bulkAction'])->name('orders.bulk-action');
    Route::get('/orders-statistics', [App\Http\Controllers\Admin\AdminOrderController::class, 'statistics'])->name('orders.statistics');
    

    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/bulk-action', [App\Http\Controllers\Admin\AdminUserController::class, 'bulkAction'])->name('users.bulk-action');
    
    // Transaction Management
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/export', [App\Http\Controllers\Admin\TransactionController::class, 'export'])->name('transactions.export');
    Route::get('/transactions/{transaction}', [App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/retry', [App\Http\Controllers\Admin\TransactionController::class, 'retry'])->name('transactions.retry');
    Route::post('/transactions/{transaction}/refund', [App\Http\Controllers\Admin\TransactionController::class, 'refund'])->name('transactions.refund');
    
        // Activity Logs Management
        Route::get('/activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/activity-logs/{activityLog}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-logs.show');
        Route::get('/activity-logs-export', [App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('activity-logs.export');
        Route::get('/activity-logs-feed', [App\Http\Controllers\Admin\ActivityLogController::class, 'feed'])->name('activity-logs.feed');
        Route::post('/activity-logs-cleanup', [App\Http\Controllers\Admin\ActivityLogController::class, 'cleanup'])->name('activity-logs.cleanup');

        // Sitemap Management
        Route::get('/sitemap-management', [App\Http\Controllers\Admin\SitemapController::class, 'index'])->name('sitemap.index');
        Route::post('/sitemap-regenerate', [App\Http\Controllers\Admin\SitemapController::class, 'regenerate'])->name('sitemap.regenerate');
        Route::get('/sitemap-status', [App\Http\Controllers\Admin\SitemapController::class, 'status'])->name('sitemap.status');
        Route::get('/sitemap-download/{file}', [App\Http\Controllers\Admin\SitemapController::class, 'download'])->name('sitemap.download');
});

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
});

// Search Routes
Route::get('/api/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Promotions Route
Route::get('/promotions', [ProductController::class, 'promotions'])->name('promotions.index');

// Services page
Route::get('/services', function () {
    return view('services');
})->name('services.index');

// Bank Details page
Route::get('/bank-details', function () {
    return view('bank-details');
})->name('bank-details.index');

// About Us page
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us.index');

// Contact Us page
Route::get('/contact-us', function () {
    return view('contact-us');
})->name('contact-us.index');

// E-Services page
Route::get('/e-services', function () {
    return view('e-services');
})->name('e-services.index');

// SEO Routes
Route::get('/sitemap.xml', function() {
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Helper function to create URL entries
    $createUrlEntry = function($url, $priority, $changefreq, $lastmod = null) {
        $lastmod = $lastmod ?: now()->format('Y-m-d\TH:i:s\Z');
        $entry = "  <url>\n";
        $entry .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
        $entry .= "    <lastmod>{$lastmod}</lastmod>\n";
        $entry .= "    <changefreq>{$changefreq}</changefreq>\n";
        $entry .= "    <priority>{$priority}</priority>\n";
        $entry .= "  </url>\n";
        return $entry;
    };

    // 1. Main pages with high priority
    $mainPages = [
        ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
        ['url' => url('/categories'), 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['url' => url('/products'), 'priority' => '0.9', 'changefreq' => 'daily'],
        ['url' => url('/promotions'), 'priority' => '0.8', 'changefreq' => 'weekly'],
    ];

    foreach ($mainPages as $page) {
        $sitemap .= $createUrlEntry($page['url'], $page['priority'], $page['changefreq']);
    }

    // 2. Information pages
    $infoPages = [
        ['url' => url('/about-us'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => url('/contact-us'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => url('/services'), 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => url('/e-services'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ['url' => url('/bank-details'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ['url' => url('/warranty'), 'priority' => '0.6', 'changefreq' => 'monthly'],
        ['url' => url('/track-order'), 'priority' => '0.6', 'changefreq' => 'weekly'],
    ];

    foreach ($infoPages as $page) {
        $sitemap .= $createUrlEntry($page['url'], $page['priority'], $page['changefreq']);
    }

    // 3. User and legal pages
    $otherPages = [
        ['url' => url('/register'), 'priority' => '0.5', 'changefreq' => 'yearly'],
        ['url' => url('/login'), 'priority' => '0.5', 'changefreq' => 'yearly'],
        ['url' => url('/privacy-policy'), 'priority' => '0.4', 'changefreq' => 'yearly'],
        ['url' => url('/terms-of-service'), 'priority' => '0.4', 'changefreq' => 'yearly'],
    ];

    foreach ($otherPages as $page) {
        $sitemap .= $createUrlEntry($page['url'], $page['priority'], $page['changefreq']);
    }

    // 4. Categories (all categories)
    try {
        if (class_exists('\App\Models\SmaCategory')) {
            $categories = \App\Models\SmaCategory::select(['id', 'name', 'slug'])
                ->whereHas('products', function($query) {
                    $query->where('hide', 0);
                })
                ->orWhereHas('subcategoryProducts', function($query) {
                    $query->where('hide', 0);
                })
                ->get();

            foreach ($categories as $category) {
                $categoryUrl = url('/categories/' . ($category->slug ?: $category->id));
                $sitemap .= $createUrlEntry($categoryUrl, '0.8', 'weekly');
            }
        }
    } catch (\Exception $e) {
        // Handle gracefully if categories table doesn't exist
    }

    // 5. Featured products (limit to avoid huge sitemap)
    try {
        if (class_exists('\App\Models\SmaProduct')) {
            $products = \App\Models\SmaProduct::select(['id', 'name', 'slug', 'category_id'])
                ->where('hide', 0)
                ->where('promotion', 1) // Only promotional products for sitemap
                ->whereHas('category')
                ->with('category:id,name,slug')
                ->orderBy('id', 'desc')
                ->limit(200) // Limit to featured/promotional products
                ->get();

            foreach ($products as $product) {
                $productUrl = url('/' . ($product->category->slug ?: $product->category->id) . '/' . ($product->slug ?: $product->id));
                $sitemap .= $createUrlEntry($productUrl, '0.7', 'weekly');
            }
        }
    } catch (\Exception $e) {
        // Handle gracefully if products table doesn't exist
    }

    $sitemap .= '</urlset>';

    return response($sitemap, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::get('/robots.txt', function() {
    $robots = "User-agent: *\n";
    $robots .= "Allow: /\n";
    $robots .= "Disallow: /admin/\n";
    $robots .= "Disallow: /cart/\n";
    $robots .= "Disallow: /checkout/\n";
    $robots .= "Disallow: /login\n";
    $robots .= "Disallow: /register\n";
    $robots .= "Disallow: /password/\n";
    $robots .= "Disallow: /storage/\n";
    $robots .= "\n";
    $robots .= "Sitemap: " . url('/sitemap.xml') . "\n";

    return response($robots, 200, ['Content-Type' => 'text/plain']);
})->name('robots');

// Sitemap routes for serving individual sitemap files
Route::get('/sitemaps/{file}', function($file) {
    $path = public_path('sitemaps/' . $file);
    
    if (!File::exists($path) || !str_ends_with($file, '.xml')) {
        abort(404);
    }
    
    $content = File::get($path);
    return response($content, 200, ['Content-Type' => 'application/xml']);
})->where('file', '.*\.xml$');

// Category Routes
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
});

// User Dashboard Routes (Protected) - MUST BE BEFORE DYNAMIC PRODUCT ROUTES
Route::middleware('auth')->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [App\Http\Controllers\User\DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\Auth\AuthController::class, 'updateProfile'])->name('profile.update');
        Route::post('/avatar', [App\Http\Controllers\Auth\AuthController::class, 'updateAvatar'])->name('avatar.update');
        
        // Orders
        Route::get('/orders', [App\Http\Controllers\User\DashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{orderNumber}', [App\Http\Controllers\User\DashboardController::class, 'orderDetail'])->name('orders.detail');
        Route::post('/orders/{order}/cancel', [App\Http\Controllers\User\DashboardController::class, 'cancelOrder'])->name('orders.cancel');
        Route::post('/orders/{order}/reorder', [App\Http\Controllers\OrderController::class, 'reorder'])->name('orders.reorder');
        
        // Addresses
        Route::get('/addresses', [App\Http\Controllers\User\DashboardController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [App\Http\Controllers\User\DashboardController::class, 'storeAddress'])->name('addresses.store');
        Route::put('/addresses/{address}', [App\Http\Controllers\User\DashboardController::class, 'updateAddress'])->name('addresses.update');
        Route::delete('/addresses/{address}', [App\Http\Controllers\User\DashboardController::class, 'deleteAddress'])->name('addresses.delete');
        Route::post('/addresses/{address}/default', [App\Http\Controllers\User\DashboardController::class, 'setDefaultAddress'])->name('addresses.default');
        
        // Settings
        Route::get('/settings', [App\Http\Controllers\User\DashboardController::class, 'settings'])->name('settings');
        Route::put('/settings', [App\Http\Controllers\User\DashboardController::class, 'updateSettings'])->name('settings.update');
    });
});

// Clean URL structure for products: /category-slug/product-slug
Route::get('/uncategorized/{product}', function($product) {
    // Fallback for products without categories
    $productModel = App\Models\SmaProduct::where('id', $product)
        ->orWhere('slug', $product)
        ->firstOrFail();
    
    // If product has a category, redirect to proper URL
    if ($productModel->category) {
        return redirect()->route('products.show', [
            'category' => $productModel->category->slug ?: $productModel->category->id,
            'product' => $productModel->slug ?: $productModel->id
        ], 301);
    }
    
    // For truly uncategorized products, show them with a dummy category
    $dummyCategory = new \stdClass();
    $dummyCategory->id = 'uncategorized';
    $dummyCategory->name = 'Uncategorized';
    $dummyCategory->slug = 'uncategorized';
    
    return view('products.show', ['product' => $productModel, 'relatedProducts' => collect()]);
})->name('products.uncategorized');

Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{cart}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cart}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout Routes (guest checkout allowed)
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');


// Additional Checkout Routes (for backward compatibility)
Route::post('/checkout/save-address', [App\Http\Controllers\CheckoutController::class, 'saveAddress'])->name('checkout.save-address');

// Payment Routes
Route::post('/payment/payhere/{order}', [App\Http\Controllers\PaymentController::class, 'initiatePayment'])->name('payment.payhere');
Route::post('/payment/card/{order}', [App\Http\Controllers\PaymentController::class, 'processCardPayment'])->name('payment.card');
Route::post('/payment/mobile/{order}', [App\Http\Controllers\PaymentController::class, 'processMobilePayment'])->name('payment.mobile');
Route::get('/payment/status/{order}', [App\Http\Controllers\PaymentController::class, 'checkPaymentStatus'])->name('payment.status');

// PayHere Callback Routes
Route::get('/payment/return', [App\Http\Controllers\PaymentController::class, 'handleReturn'])->name('payment.return');
Route::get('/payment/cancel', [App\Http\Controllers\PaymentController::class, 'handleCancel'])->name('payment.cancel');
Route::post('/payment/notify', [App\Http\Controllers\PaymentController::class, 'handleNotify'])->name('payment.notify');

// WebXPay Payment Routes
Route::get('/payment/webxpay/test', [App\Http\Controllers\PaymentController::class, 'testWebXPay'])->name('payment.webxpay.test');
Route::get('/payment/webxpay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateWebXPayPayment'])->name('payment.webxpay');
Route::post('/payment/webxpay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateWebXPayPayment'])->name('payment.webxpay.post');
Route::get('/payment/webxpay/return', [App\Http\Controllers\PaymentController::class, 'handleWebXPayReturn'])->name('payment.webxpay.return');
Route::post('/payment/webxpay/return', [App\Http\Controllers\PaymentController::class, 'handleWebXPayReturn'])->name('payment.webxpay.return.post');
Route::get('/payment/webxpay/cancel', [App\Http\Controllers\PaymentController::class, 'handleWebXPayCancel'])->name('payment.webxpay.cancel');
Route::post('/payment/webxpay/notify', [App\Http\Controllers\PaymentController::class, 'handleWebXPayNotify'])->name('payment.webxpay.notify');
Route::get('/payment/webxpay/status/{order}', [App\Http\Controllers\PaymentController::class, 'checkWebXPayPaymentStatus'])->name('payment.webxpay.status');

// Koko Pay Payment Routes
Route::get('/payment/kokopay/test', [App\Http\Controllers\PaymentController::class, 'testKokoPay'])->name('payment.kokopay.test');
Route::get('/payment/kokopay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateKokoPayPayment'])->name('payment.kokopay');
Route::post('/payment/kokopay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateKokoPayPayment'])->name('payment.kokopay.post');
Route::get('/payment/kokopay/return', [App\Http\Controllers\PaymentController::class, 'handleKokoPayReturn'])->name('payment.kokopay.return');
Route::post('/payment/kokopay/return', [App\Http\Controllers\PaymentController::class, 'handleKokoPayReturn'])->name('payment.kokopay.return.post');
Route::get('/payment/kokopay/cancel', [App\Http\Controllers\PaymentController::class, 'handleKokoPayCancel'])->name('payment.kokopay.cancel');
Route::post('/payment/kokopay/notify', [App\Http\Controllers\PaymentController::class, 'handleKokoPayNotify'])->name('payment.kokopay.notify');
Route::get('/payment/kokopay/status/{order}', [App\Http\Controllers\PaymentController::class, 'checkKokoPayPaymentStatus'])->name('payment.kokopay.status');

// Legal Pages
Route::get('/terms-of-service', [App\Http\Controllers\LegalController::class, 'termsOfService'])->name('terms-of-service');
Route::get('/privacy-policy', [App\Http\Controllers\LegalController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/warranty', function () {
    return view('warranty');
})->name('warranty');

// Order Tracking Routes (Public)
Route::get('/track-order', [App\Http\Controllers\OrderController::class, 'track'])->name('orders.track');

// Profile Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [App\Http\Controllers\ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::patch('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
Route::post('/track-order', [App\Http\Controllers\OrderController::class, 'track']);
Route::get('/orders/{orderNumber}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{orderNumber}/invoice', [App\Http\Controllers\OrderController::class, 'invoice'])->name('orders.invoice');

// Fallback route for unknown category/product combinations (excluding admin routes)
Route::get('{any}/{any2}', [App\Http\Controllers\FallbackController::class, 'handleUnknownUrl'])
    ->where('any', '^(?!admin).*')
    ->where('any2', '.*');
