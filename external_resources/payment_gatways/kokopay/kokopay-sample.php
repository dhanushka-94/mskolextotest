<?php
/*
 * 🔴 KOKO PAY PRODUCTION INTEGRATION
 * ================================
 * WARNING: This system processes REAL payments
 * Environment: LIVE PRODUCTION
 * Service: Koko Buy Now Pay Later (3 interest-free instalments)
 * Last Updated: 2025-09-19
 */

session_start();

// Koko Pay Configuration - PRODUCTION ENVIRONMENT
$merchant_id = '7d3f30056c643b23b9fef10aac9d6425'; // PRODUCTION Merchant ID
$api_key = 'YDMw4sWQb65XB8tJL1FvAIbJn5FxFpQP'; // PRODUCTION API Key
$plugin_name = "customapi";
$plugin_version = "1.0.1";
$currency = 'LKR';

// Environment URLs - PRODUCTION
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/');
$koko_api_url = 'https://prodapi.paykoko.com/api/merchants/orderCreate'; // PRODUCTION environment

// RSA Private Key for signing - PRODUCTION
$private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgHH+6EMtaNy6Y486eoxNRrUQlHgQiohdFWd0cHeHk/JocrJvX80P
V9AVAaVdWKH0UfYYgUaY363H7/owDQFWf1iAjT8JwZveoOuJsYyfbaXiQwBYTtY1
koPoFCeMr625Jc90mH0gHbyw91J7gMd+5T8YBLah5DVq0pWLKjTqzpSJAgMBAAEC
gYAYUuv8aZQWhS75QOElTtfnisIjXGQy9Km8iXv2BVfsQZ03tcwbVUrHe7P+NQzU
ge17NX9gMP6JdkAegmJEBtDlJxogiHSf5/jDxvwZppkfQyjGP1FrDHgbODv1+G+b
QQxiio+0/8xQMYa3AacZ5cAabqi6LLURoTFNlWATVO+QAQJBANGYy8Bhiqx0j17k
e9K9aVNeI6xBMvnlJEAMOfw9Rx4EP6P2Ud9UXaeC1bjQP9vFBaJPJMuYXNbdBTHt
rvCO6nECQQCLO8eYqI4JTPNPtZ8aQf8dr2GA2xFnji9SE/hSP6kVbRDcBAH2XUn8
u8zdFfTy5/ut46/oLWoJp2FcgFF0oWeZAkEAw4tRNKgML78Db52tZDywwkXG9FNT
0s8UVejSRGGLMxb1pOwPEFPumHS5HpazrT8QdZBvHL+GhjNoQF+m4eoEEQJAc8qw
cNXk4fk79FNgUO8H4sEjPo1xiQSneAQhpQ1KagY9Wix/EUt+J5BrjIYhIw4osfHE
Ljvujr7D6rDQjUVaKQJBAIgcM8ymdcI+uHdcCbPGTN0u4VFX2TIDzzG44YOMzlYb
Ce/OaXghaCUALu7lmZgvpwntUFvRvafyao/X3AUU5Nk=
-----END RSA PRIVATE KEY-----';

// Koko Pay Public Key - PRODUCTION (for reference/verification)
$koko_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDwDt4Q9B+MEAcxP8pPeTYGh22
lvCOxxKEwDuJPAvTtYpfiqU1Ip//njnMgWIpFcpIcqabALPrkHW8eD37SBzQ6R5l
fr01xf7lBG3bGqNXZkdXb0txnoXSmPya+B4oGqZc+KWNrKTntY3sNKD6k4tdOeoX
83rxb/gnZR5v7WP7WQIDAQAB
-----END PUBLIC KEY-----';

// Sample Product Data
$products = [
    1 => [
        'name' => 'Sony WH-1000XM4 Wireless Headphones',
        'price' => 85.00,
        'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop&crop=center',
        'description' => 'Industry-leading noise canceling with Dual Noise Sensor technology. Premium sound quality with Hi-Res Audio.',
        'features' => ['30-hour battery life', 'Quick Charge (10min = 5hrs)', 'Touch Sensor controls', 'Speak-to-chat technology']
    ],
    2 => [
        'name' => 'Apple Watch Series 9',
        'price' => 95.00,
        'image' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=400&h=300&fit=crop&crop=center',
        'description' => 'The most advanced Apple Watch yet with S9 chip and Double Tap gesture control.',
        'features' => ['S9 SiP chip', 'Double Tap gesture', 'Precision Finding', 'All-day 18-hour battery']
    ],
    3 => [
        'name' => 'Anker PowerCore 26800mAh',
        'price' => 75.00,
        'image' => 'https://images.unsplash.com/photo-1609592842906-1dfedbd5b43b?w=400&h=300&fit=crop&crop=center',
        'description' => 'Ultra-high capacity portable charger with PowerIQ technology for optimized charging.',
        'features' => ['26800mAh capacity', 'PowerIQ 2.0 technology', '3 USB ports', 'MultiProtect safety system']
    ]
];

// Handle different actions
$action = $_GET['action'] ?? 'product_list';
$product_id = $_GET['product_id'] ?? null;
$message = $_GET['message'] ?? '';
$status = $_GET['status'] ?? '';

// Callback Handlers
if ($action == 'payment_response') {
    // This handles the backend webhook from Koko
    $order_id = $_POST['orderId'] ?? '';
    $trn_id = $_POST['trnId'] ?? '';
    $payment_status = $_POST['status'] ?? '';
    $signature = $_POST['signature'] ?? '';
    
    // Here you would verify the signature and update your database
    // For demo purposes, we'll just log it
    error_log("Payment Response: OrderID: $order_id, TrnID: $trn_id, Status: $payment_status");
    
    http_response_code(200);
    echo "OK";
    exit;
}

// Helper function to generate signature
function generateSignature($dataString, $privateKey) {
    $pkeyid = openssl_get_privatekey($privateKey);
    if (!$pkeyid) {
        error_log("Failed to load private key: " . openssl_error_string());
        return false;
    }
    
    if (!openssl_sign($dataString, $signature, $pkeyid, OPENSSL_ALGO_SHA256)) {
        error_log("Failed to generate signature: " . openssl_error_string());
        openssl_free_key($pkeyid);
        return false;
    }
    
    openssl_free_key($pkeyid);
    return base64_encode($signature);
}

// Initialize variables
$payment_data = null;
$show_payment_redirect = false;

// Process checkout
if ($_POST && $action == 'checkout') {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    
    if (!isset($products[$product_id])) {
        $message = "Invalid product selected.";
        $status = "error";
    } elseif ($quantity < 1) {
        $message = "Please select a valid quantity.";
        $status = "error";
    } elseif (empty($first_name) || empty($last_name) || empty($email)) {
        $message = "Please fill in all required fields.";
        $status = "error";
    } else {
        $product = $products[$product_id];
        $subtotal = $product['price'] * $quantity;
        $transaction_fee = $subtotal * 0.10; // 10% transaction fee
        $total_amount = number_format($subtotal + $transaction_fee, 2, '.', '');
        $order_id = time() . rand(100, 999);
        $reference = $merchant_id . rand(111, 999) . '-' . $order_id;
        $description = $quantity . " x " . $product['name'];
        
        // Callback URLs
        $return_url = $base_url . "/product_checkout.php?action=payment_success&order_id=" . $order_id;
        $cancel_url = $base_url . "/product_checkout.php?action=payment_cancelled&order_id=" . $order_id;
        $response_url = $base_url . "/product_checkout.php?action=payment_response";
        
        // Create data string in the exact order required by Koko Pay API
        $dataString = $merchant_id . $total_amount . $currency . $plugin_name . $plugin_version . 
                     $return_url . $cancel_url . $order_id . $reference . $first_name . 
                     $last_name . $email . $description . $api_key . $response_url;
        
        // Generate signature
        $signature = generateSignature($dataString, $private_key);
        
        // Check if signature generation failed
        if ($signature === false) {
            $message = "Payment processing error. Please try again or contact support.";
            $status = "error";
            error_log("Signature generation failed for order: $order_id");
        } else {
            // Prepare form data for Koko Pay
            $payment_data = [
                '_mId' => $merchant_id,
                'api_key' => $api_key,
                '_returnUrl' => $return_url,
                '_cancelUrl' => $cancel_url,
                '_responseUrl' => $response_url,
                '_amount' => $total_amount,
                '_currency' => $currency,
                '_reference' => $reference,
                '_orderId' => $order_id,
                '_pluginName' => $plugin_name,
                '_pluginVersion' => $plugin_version,
                '_firstName' => $first_name,
                '_lastName' => $last_name,
                '_email' => $email,
                '_description' => $description,
                'dataString' => $dataString,
                'signature' => $signature,
                '_mobileNo' => $mobile
            ];
            
            // Store order details in session for reference
            $_SESSION['current_order'] = [
                'order_id' => $order_id,
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'transaction_fee' => $transaction_fee,
                'total_amount' => $total_amount,
                'customer' => [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'mobile' => $mobile
                ]
            ];
            
            // Set flag to show payment redirect
            $show_payment_redirect = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore - Koko: Buy Now Pay Later</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            color: #212529;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2c3e50;
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .header .koko-notice {
            text-align: center;
            color: #28a745;
            font-weight: 600;
            margin-top: 10px;
            font-size: 1.1rem;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: #f8f9fa;
        }
        
        .product-details {
            padding: 20px;
        }
        
        .product-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 10px;
        }
        
        .product-description {
            color: #6c757d;
            margin-bottom: 15px;
        }
        
        .product-features {
            margin-bottom: 20px;
        }
        
        .product-features ul {
            list-style: none;
            padding-left: 0;
        }
        
        .product-features li {
            padding: 5px 0;
            position: relative;
            padding-left: 20px;
            color: #495057;
        }
        
        .product-features li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }
        
        .btn {
            background: #007bff;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background 0.3s ease;
            width: 100%;
        }
        
        .btn:hover {
            background: #0056b3;
        }
        
        .btn-success {
            background: #28a745;
        }
        
        .btn-success:hover {
            background: #1e7e34;
        }
        
        .checkout-form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #007bff;
        }
        
        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .order-summary h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
        }
        
        .summary-row.total {
            border-top: 2px solid #dee2e6;
            padding-top: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            color: #e74c3c;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 6px;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .payment-redirect {
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .message-page {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .message-page h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }
        
        .message-page.success h2 {
            color: #28a745;
        }
        
        .message-page.error h2 {
            color: #dc3545;
        }
        
        .koko-split-info {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        }
        
        .koko-split-info h3 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .split-breakdown {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 15px;
        }
        
        .split-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            flex: 1;
            backdrop-filter: blur(10px);
        }
        
        .split-number {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .split-amount {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .split-time {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .koko-features {
            display: flex;
            justify-content: center;
            gap: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 15px;
        }
        
        .feature {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        @media (max-width: 768px) {
            .split-breakdown {
                flex-direction: column;
                gap: 10px;
            }
            
            .koko-features {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1>TechStore</h1>
            <div class="koko-notice">Pay in 3 interest free instalments with Koko</div>
        </div>
    </div>

    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-<?= $status === 'error' ? 'error' : 'success' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if ($action == 'product_list'): ?>
            <!-- Product Listing -->
            <div class="products-grid">
                <?php foreach ($products as $id => $product): ?>
                    <div class="product-card">
                        <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                        <div class="product-details">
                            <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                            <div class="product-price">LKR <?= number_format($product['price'], 2) ?></div>
                            <p class="product-description"><?= htmlspecialchars($product['description']) ?></p>
                            <div class="product-features">
                                <ul>
                                    <?php foreach ($product['features'] as $feature): ?>
                                        <li><?= htmlspecialchars($feature) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <a href="?action=checkout&product_id=<?= $id ?>" class="btn">Buy Now</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif ($action == 'checkout' && !$_POST): ?>
            <!-- Checkout Form -->
            <?php
            $product_id = $_GET['product_id'];
            if (!isset($products[$product_id])) {
                echo '<div class="alert alert-error">Product not found.</div>';
                echo '<a href="?" class="btn">Back to Products</a>';
            } else {
                $product = $products[$product_id];
            ?>
                <a href="?" class="back-link">← Back to Products</a>
                
                <div class="checkout-form">
                    <h2>Checkout</h2>
                    
                    <div class="order-summary">
                        <h3>Order Summary</h3>
                        <div class="summary-row">
                            <span>Product:</span>
                            <span><?= htmlspecialchars($product['name']) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Unit Price:</span>
                            <span>LKR <?= number_format($product['price'], 2) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Quantity:</span>
                            <span id="display-quantity">1</span>
                        </div>
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotal-amount">LKR <?= number_format($product['price'], 2) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Transaction Fee (10%):</span>
                            <span id="fee-amount">LKR <?= number_format($product['price'] * 0.10, 2) ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span id="total-amount">LKR <?= number_format($product['price'] * 1.10, 2) ?></span>
                        </div>
                    </div>
                    
                    <!-- Koko Pay 3-Split Information -->
                    <div class="koko-split-info">
                        <h3>💳 Pay in 3 interest-free instalments with Koko</h3>
                        <div class="split-breakdown">
                            <div class="split-item">
                                <div class="split-number">1st</div>
                                <div class="split-details">
                                    <div class="split-amount" id="split-1">LKR <?= number_format($product['price'] * 1.10 / 3, 2) ?></div>
                                    <div class="split-time">Today</div>
                                </div>
                            </div>
                            <div class="split-item">
                                <div class="split-number">2nd</div>
                                <div class="split-details">
                                    <div class="split-amount" id="split-2">LKR <?= number_format($product['price'] * 1.10 / 3, 2) ?></div>
                                    <div class="split-time">30 days</div>
                                </div>
                            </div>
                            <div class="split-item">
                                <div class="split-number">3rd</div>
                                <div class="split-details">
                                    <div class="split-amount" id="split-3">LKR <?= number_format($product['price'] * 1.10 / 3, 2) ?></div>
                                    <div class="split-time">60 days</div>
                                </div>
                            </div>
                        </div>
                        <div class="koko-features">
                            <div class="feature">✓ No interest charges</div>
                            <div class="feature">✓ No hidden fees</div>
                            <div class="feature">✓ Automatic payments</div>
                        </div>
                    </div>
                    
                    <form method="POST" action="?action=checkout">
                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                        
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <select name="quantity" id="quantity" required onchange="updateTotal()">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="first_name">First Name: *</label>
                            <input type="text" name="first_name" id="first_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name: *</label>
                            <input type="text" name="last_name" id="last_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address: *</label>
                            <input type="email" name="email" id="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="mobile">Mobile Number:</label>
                            <input type="tel" name="mobile" id="mobile" placeholder="0771234567">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Proceed to Payment</button>
                    </form>
                </div>
                
                <script>
                    function updateTotal() {
                        const quantity = document.getElementById('quantity').value;
                        const basePrice = <?= $product['price'] ?>;
                        
                        // Calculate amounts
                        const subtotal = quantity * basePrice;
                        const transactionFee = subtotal * 0.10; // 10% fee
                        const total = subtotal + transactionFee;
                        const splitAmount = total / 3; // 3 equal payments
                        
                        // Update display quantity
                        document.getElementById('display-quantity').textContent = quantity;
                        
                        // Update amounts
                        document.getElementById('subtotal-amount').textContent = 'LKR ' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        document.getElementById('fee-amount').textContent = 'LKR ' + transactionFee.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        document.getElementById('total-amount').textContent = 'LKR ' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        
                        // Update split amounts
                        document.getElementById('split-1').textContent = 'LKR ' + splitAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        document.getElementById('split-2').textContent = 'LKR ' + splitAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        document.getElementById('split-3').textContent = 'LKR ' + splitAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                </script>
            <?php } ?>

        <?php elseif ($show_payment_redirect): ?>
            <!-- Payment Redirect -->
            <div class="payment-redirect">
                <h2>Redirecting to Payment Gateway</h2>
                <div class="loading-spinner"></div>
                <p>Please wait while we redirect you to Koko Pay...</p>
                <p><strong>Do not close this window or press the back button.</strong></p>
                
                <form action="<?= $koko_api_url ?>" method="post" id="payment_form">
                    <?php foreach ($payment_data as $key => $value): ?>
                        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                    <?php endforeach; ?>
                    <noscript>
                        <button type="submit" class="btn">Continue to Payment</button>
                    </noscript>
                </form>
                
                <script>
                    // Auto-submit the form immediately
                    setTimeout(function() {
                        document.getElementById('payment_form').submit();
                    }, 1000);
                </script>
                
                <!-- Manual submit for debugging -->
                <div style="margin-top: 20px;">
                    <button type="button" onclick="document.getElementById('payment_form').submit()" class="btn">
                        Manual Submit (for debugging)
                    </button>
                </div>
            </div>

        <?php elseif ($action == 'payment_success'): ?>
            <!-- Payment Success -->
            <div class="message-page success">
                <h2>✅ Payment Successful!</h2>
                <p>Thank you for your purchase. Your order has been processed successfully.</p>
                <p><strong>Order ID:</strong> <?= htmlspecialchars($_GET['order_id'] ?? '') ?></p>
                <?php if (isset($_GET['trnId'])): ?>
                    <p><strong>Transaction ID:</strong> <?= htmlspecialchars($_GET['trnId']) ?></p>
                <?php endif; ?>
                <p>You will receive a confirmation email shortly.</p>
                <a href="?" class="btn">Continue Shopping</a>
            </div>

        <?php elseif ($action == 'payment_cancelled'): ?>
            <!-- Payment Cancelled -->
            <div class="message-page error">
                <h2>❌ Payment Cancelled</h2>
                <p>Your payment was cancelled or failed to process.</p>
                <p><strong>Order ID:</strong> <?= htmlspecialchars($_GET['order_id'] ?? '') ?></p>
                <p>Please try again or contact support if you continue to experience issues.</p>
                <a href="?" class="btn">Try Again</a>
            </div>

        <?php endif; ?>
        
        <!-- Debug Information (Uncomment for debugging) -->
        <?php if (false && isset($_POST) && !empty($_POST)): ?>
            <div style="background: #f8f9fa; padding: 20px; margin-top: 20px; border: 1px solid #dee2e6; border-radius: 8px;">
                <h4>Debug Information:</h4>
                <p><strong>Action:</strong> <?= htmlspecialchars($action) ?></p>
                <p><strong>POST Data Received:</strong> <?= !empty($_POST) ? 'Yes' : 'No' ?></p>
                <p><strong>Message Set:</strong> <?= isset($message) ? htmlspecialchars($message) : 'No' ?></p>
                <p><strong>Payment Data Created:</strong> <?= $payment_data !== null ? 'Yes' : 'No' ?></p>
                <p><strong>Show Payment Redirect:</strong> <?= $show_payment_redirect ? 'Yes' : 'No' ?></p>
                <?php if (isset($signature)): ?>
                    <p><strong>Signature Generated:</strong> <?= $signature !== false ? 'Yes' : 'Failed' ?></p>
                <?php endif; ?>
                <?php if (isset($subtotal)): ?>
                    <p><strong>Subtotal:</strong> LKR <?= number_format($subtotal, 2) ?></p>
                    <p><strong>Transaction Fee:</strong> LKR <?= number_format($transaction_fee, 2) ?></p>
                    <p><strong>Total Amount:</strong> LKR <?= htmlspecialchars($total_amount) ?></p>
                <?php endif; ?>
                <?php if (isset($dataString)): ?>
                    <p><strong>Data String Length:</strong> <?= strlen($dataString) ?></p>
                <?php endif; ?>
                <?php if (isset($base_url)): ?>
                    <p><strong>Base URL:</strong> <?= htmlspecialchars($base_url) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
