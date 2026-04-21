<?php

/**
 * One-off: list products for a category slug (same resolution as CategoryController@show).
 * Usage: php scripts/list-category-products.php brand-new-laptops
 */

use App\Models\LaptopExpertCategory;
use App\Models\LaptopExpertProduct;
use App\Models\SmaCategory;
use App\Models\SmaProduct;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$slug = $argv[1] ?? 'brand-new-laptops';

$mskCategory = SmaCategory::where('slug', $slug)->orWhere('id', $slug)->first();
$lpCategory = LaptopExpertCategory::where('slug', $slug)->orWhere('id', $slug)->first();

if ($mskCategory) {
    $category = $mskCategory;
    $productModel = SmaProduct::class;
    $source = 'MSK (products_db)';
} elseif ($lpCategory) {
    $category = $lpCategory;
    $productModel = LaptopExpertProduct::class;
    $source = 'LaptopExpert (laptopexpert_products_db)';
} else {
    fwrite(STDERR, "No category found for slug/id: {$slug}\n");
    exit(1);
}

$query = $productModel::query()
    ->where(function ($q) use ($category) {
        $q->where('category_id', $category->id)
            ->orWhere('subcategory_id', $category->id);
    })
    ->where('hide', 0)
    ->orderByRaw('
        CASE
            WHEN quantity > 10 THEN 1
            WHEN quantity > 0 THEN 2
            ELSE 4
        END ASC
    ')
    ->orderBy('id', 'desc');

$total = (clone $query)->count();
$rows = $query->limit(200)->get(['id', 'code', 'name', 'quantity', 'slug', 'category_id', 'subcategory_id']);

echo "URL: /categories/{$slug}\n";
echo "Source: {$source}\n";
echo "Category: {$category->name} (id={$category->id}, slug=" . ($category->slug ?? '') . ")\n";
echo "Total visible products (hide=0, in this category or subcategory): {$total}\n";
echo str_repeat('-', 120) . "\n";
printf("%-8s %-14s %-36s %-10s %-8s %-8s %s\n", 'id', 'code', 'slug', 'quantity', 'cat_id', 'subcat', 'name (trimmed)');
echo str_repeat('-', 120) . "\n";

foreach ($rows as $p) {
    $name = mb_substr((string) $p->name, 0, 55);
    printf(
        "%-8s %-14s %-36s %-10s %-8s %-8s %s\n",
        $p->id,
        (string) ($p->code ?? ''),
        (string) ($p->slug ?? ''),
        $p->quantity === null ? 'NULL' : (string) $p->quantity,
        (string) $p->category_id,
        (string) ($p->subcategory_id ?? ''),
        $name
    );
}

if ($total > 200) {
    echo "\n(Showing first 200 of {$total}.)\n";
}
