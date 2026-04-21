<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$cols = Illuminate\Support\Facades\Schema::connection('laptopexpert_products_db')->getColumnListing('sma_products');
$interesting = array_values(array_filter($cols, function ($c) {
    return stripos($c, 'stock') !== false
        || $c === 'quantity'
        || $c === 'product_status'
        || $c === 'track_quantity';
}));
sort($interesting);
echo "LE sma_products columns (stock-related): " . implode(', ', $interesting) . "\n";

$p = \App\Models\LaptopExpertProduct::where('code', 'LAP105')->first();
if ($p) {
    echo "\nLAP105 raw attributes keys (subset): ";
    echo implode(', ', array_keys(array_slice($p->getAttributes(), 0, 25))) . "...\n";
    echo "quantity raw: " . json_encode($p->getAttributes()['quantity'] ?? 'MISSING') . "\n";
    if (array_key_exists('stock_quantity', $p->getAttributes())) {
        echo "stock_quantity COLUMN raw: " . json_encode($p->getAttributes()['stock_quantity']) . "\n";
    } else {
        echo "no stock_quantity column in loaded row\n";
    }
    echo "accessor stock_quantity: " . json_encode($p->stock_quantity) . "\n";
    echo "toArray stock_quantity: " . json_encode($p->toArray()['stock_quantity'] ?? 'absent') . "\n";
}
