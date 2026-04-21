<?php

/**
 * Show product_status id + status_name + quantity for a product code (LE DB).
 * Usage: php scripts/show-product-status.php LAP105
 */

use App\Models\LaptopExpertProduct;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$code = $argv[1] ?? 'LAP105';

$p = LaptopExpertProduct::query()
    ->where('code', $code)
    ->with('status:id,status_name')
    ->first(['id', 'code', 'name', 'quantity', 'product_status', 'slug', 'hide']);

if (! $p) {
    fwrite(STDERR, "No LaptopExpert product with code: {$code}\n");
    exit(1);
}

$statusName = $p->status ? $p->status->status_name : '(no status row)';
$statusId = $p->product_status;

echo "Connection: laptopexpert_products_db (LaptopExpert)\n";
echo "id: {$p->id}\n";
echo "code: {$p->code}\n";
echo "slug: " . ($p->slug ?? '') . "\n";
echo "hide: {$p->hide}\n";
echo "quantity (DB): " . ($p->getAttributes()['quantity'] ?? 'null') . "\n";
echo "product_status (FK id): " . ($statusId ?? 'null') . "\n";
echo "status_name: {$statusName}\n";
echo "name: " . mb_substr($p->name, 0, 80) . "\n";
