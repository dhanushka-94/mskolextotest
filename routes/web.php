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
    // Bulk order actions route disabled (bulk feature removed from UI)
    // Route::post('/orders/bulk-action', [App\Http\Controllers\Admin\AdminOrderController::class, 'bulkAction'])->name('orders.bulk-action');
    Route::get('/orders-statistics', [App\Http\Controllers\Admin\AdminOrderController::class, 'statistics'])->name('orders.statistics');
    
    // Quotation Management
    Route::get('/quotations', [App\Http\Controllers\Admin\AdminQuotationController::class, 'index'])->name('quotations.index');
    Route::get('/quotations/{quotation}', [App\Http\Controllers\Admin\AdminQuotationController::class, 'show'])->name('quotations.show');
    Route::put('/quotations/{quotation}/status', [App\Http\Controllers\Admin\AdminQuotationController::class, 'updateStatus'])->name('quotations.update-status');
    Route::post('/quotations/{quotation}/notes', [App\Http\Controllers\Admin\AdminQuotationController::class, 'addNotes'])->name('quotations.add-notes');
    Route::get('/quotations/{quotation}/download', [App\Http\Controllers\Admin\AdminQuotationController::class, 'downloadPdf'])->name('quotations.download');
    Route::delete('/quotations/{quotation}', [App\Http\Controllers\Admin\AdminQuotationController::class, 'destroy'])->name('quotations.destroy');
    Route::post('/quotations/bulk-action', [App\Http\Controllers\Admin\AdminQuotationController::class, 'bulkAction'])->name('quotations.bulk-action');
    Route::get('/quotations-statistics', [App\Http\Controllers\Admin\AdminQuotationController::class, 'statistics'])->name('quotations.statistics');

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

        // Cache Management
        Route::get('/cache', [App\Http\Controllers\Admin\CacheController::class, 'index'])->name('cache.index');
        Route::post('/cache/clear-all', [App\Http\Controllers\Admin\CacheController::class, 'clearAll'])->name('cache.clear-all');
        Route::post('/cache/clear-application', [App\Http\Controllers\Admin\CacheController::class, 'clearApplication'])->name('cache.clear-application');
        Route::post('/cache/clear-views', [App\Http\Controllers\Admin\CacheController::class, 'clearViews'])->name('cache.clear-views');
        Route::post('/cache/clear-products', [App\Http\Controllers\Admin\CacheController::class, 'clearProductCaches'])->name('cache.clear-products');
        Route::post('/cache/warm-up', [App\Http\Controllers\Admin\CacheController::class, 'warmUp'])->name('cache.warm-up');
        Route::post('/cache/increment-version', [App\Http\Controllers\Admin\CacheController::class, 'incrementAssetVersion'])->name('cache.increment-version');

        // Slider Management
        Route::resource('sliders', App\Http\Controllers\Admin\SliderController::class);
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

// SEO Routes — serve generated sitemap index (covers all ~3k+ product URLs)
Route::get('/sitemap.xml', function () {
    $indexPath = public_path('sitemap-index.xml');
    if (is_file($indexPath)) {
        return response(file_get_contents($indexPath), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    // Fallback: regenerate and serve index
    \Illuminate\Support\Facades\Artisan::call('sitemap:generate-all');
    if (is_file($indexPath)) {
        return response(file_get_contents($indexPath), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    return response('Sitemap not available', 503);
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

// Cart Routes (MUST be before catch-all routes)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{cart}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cart}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/summary', [CartController::class, 'summary'])->name('summary');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Checkout Routes (guest checkout allowed) - MUST be before catch-all routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'selectOption'])->name('index');
    Route::get('/quotation', [CheckoutController::class, 'quotation'])->name('quotation');
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('products.show');

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');


// Additional Checkout Routes (for backward compatibility)
Route::post('/checkout/save-address', [App\Http\Controllers\CheckoutController::class, 'saveAddress'])->name('checkout.save-address');

// Quotation Routes
Route::post('/quotation/generate', [App\Http\Controllers\QuotationController::class, 'generateQuotation'])->name('quotation.generate');

// Payment Routes (PayHere routes removed)
Route::post('/payment/card/{order}', [App\Http\Controllers\PaymentController::class, 'processCardPayment'])->name('payment.card');
Route::post('/payment/mobile/{order}', [App\Http\Controllers\PaymentController::class, 'processMobilePayment'])->name('payment.mobile');
Route::get('/payment/status/{order}', [App\Http\Controllers\PaymentController::class, 'checkPaymentStatus'])->name('payment.status');

// WebXPay Payment Routes (specific routes first, then parameterized routes)
Route::get('/payment/webxpay/test', [App\Http\Controllers\PaymentController::class, 'testWebXPay'])->name('payment.webxpay.test');
Route::get('/payment/webxpay/return', [App\Http\Controllers\PaymentController::class, 'handleWebXPayReturn'])->name('payment.webxpay.return');
Route::post('/payment/webxpay/return', [App\Http\Controllers\PaymentController::class, 'handleWebXPayReturn'])
    ->name('payment.webxpay.return.post')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/payment/webxpay/cancel', [App\Http\Controllers\PaymentController::class, 'handleWebXPayCancel'])->name('payment.webxpay.cancel');
Route::post('/payment/webxpay/notify', [App\Http\Controllers\PaymentController::class, 'handleWebXPayNotify'])
    ->name('payment.webxpay.notify')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/payment/webxpay/status/{order}', [App\Http\Controllers\PaymentController::class, 'checkWebXPayPaymentStatus'])->name('payment.webxpay.status');
Route::get('/payment/webxpay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateWebXPayPayment'])->name('payment.webxpay');
Route::post('/payment/webxpay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateWebXPayPayment'])->name('payment.webxpay.post');

// WebXPay Legacy/Alternative Routes (for compatibility)
// Test endpoint to verify return URL is accessible (must be defined BEFORE the general route)
Route::get('/pay/webxpayResponse/test', [App\Http\Controllers\PaymentController::class, 'testWebXPayReturnUrl'])->name('payment.webxpay.legacy.return.test');
Route::post('/pay/webxpayResponse', [App\Http\Controllers\PaymentController::class, 'handleWebXPayReturn'])
    ->name('payment.webxpay.legacy.return')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/pay/webxpayResponse', [App\Http\Controllers\PaymentController::class, 'handleWebXPayReturn'])->name('payment.webxpay.legacy.return.get');


// Koko Pay Payment Routes (specific routes first, then parameterized routes)
Route::get('/payment/kokopay/test', [App\Http\Controllers\PaymentController::class, 'testKokoPay'])->name('payment.kokopay.test');
Route::get('/payment/kokopay/return', [App\Http\Controllers\PaymentController::class, 'handleKokoPayReturn'])->name('payment.kokopay.return');
Route::post('/payment/kokopay/return', [App\Http\Controllers\PaymentController::class, 'handleKokoPayReturn'])
    ->name('payment.kokopay.return.post')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/payment/kokopay/cancel', [App\Http\Controllers\PaymentController::class, 'handleKokoPayCancel'])->name('payment.kokopay.cancel');
Route::post('/payment/kokopay/notify', [App\Http\Controllers\PaymentController::class, 'handleKokoPayNotify'])
    ->name('payment.kokopay.notify')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/payment/kokopay/status/{order}', [App\Http\Controllers\PaymentController::class, 'checkKokoPayPaymentStatus'])->name('payment.kokopay.status');
Route::get('/payment/kokopay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateKokoPayPayment'])->name('payment.kokopay');
Route::post('/payment/kokopay/{order}', [App\Http\Controllers\PaymentController::class, 'initiateKokoPayPayment'])->name('payment.kokopay.post');

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

// Fallback route for unknown category/product combinations (excluding admin and payment routes)
Route::get('{any}/{any2}', [App\Http\Controllers\FallbackController::class, 'handleUnknownUrl'])
    ->where('any', '^(?!admin|payment).*')
    ->where('any2', '.*');
