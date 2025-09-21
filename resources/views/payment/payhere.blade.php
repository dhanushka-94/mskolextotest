<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to PayHere...</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1c 100%);
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            text-align: center;
            max-width: 400px;
            padding: 2rem;
        }
        .spinner {
            border: 4px solid #333;
            border-top: 4px solid #f59e0b;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h1 {
            color: #f59e0b;
            margin-bottom: 1rem;
        }
        p {
            color: #ccc;
            margin-bottom: 1rem;
        }
        .order-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="spinner"></div>
        <h1>Redirecting to PayHere</h1>
        <p>Please wait while we redirect you to the secure payment page...</p>
        
        <div class="order-info">
            <strong>Order: {{ $order->order_number }}</strong><br>
            <strong>Amount: LKR {{ number_format($order->total_amount, 2) }}</strong>
        </div>
        
        <p>Do not close this window or press the back button.</p>
    </div>

    <!-- PayHere Payment Form -->
    <form method="post" action="{{ config('payhere.checkout_url') }}" id="payhere-form" style="display: none;">
        @foreach($paymentData as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>

    <script>
        // Auto-submit the form after a short delay
        setTimeout(function() {
            document.getElementById('payhere-form').submit();
        }, 2000);
    </script>
</body>
</html>
