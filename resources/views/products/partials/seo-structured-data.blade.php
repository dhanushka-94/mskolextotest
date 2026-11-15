@php
    $category = $product->category;
    $categorySlug = $category ? ($category->slug ?: $category->id) : null;
    $productUrl = $categorySlug
        ? route('products.show', ['category' => $categorySlug, 'product' => $product->slug ?: $product->id])
        : url()->current();

    $rawDescription = $product->product_details ?: ($product->details ?: '');
    $plainDescription = trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode((string) $rawDescription))));
    if ($plainDescription === '') {
        $plainDescription = $product->name . ' available at MSK Computers Sri Lanka'
            . ($category ? ' in ' . $category->name : '')
            . '. Buy online with warranty, island-wide delivery, and expert support.';
    }
    $plainDescription = \Illuminate\Support\Str::limit($plainDescription, 5000);

    $images = collect($product->images ?? [])
        ->filter(fn ($img) => is_string($img) && $img !== '' && !str_contains($img, 'unsplash.com'))
        ->values()
        ->all();
    if (empty($images) && !empty($product->main_image) && !str_contains($product->main_image, 'unsplash.com')) {
        $images = [$product->main_image];
    }
    if (empty($images)) {
        $images = [asset('images/msk-share-og.png')];
    }

    $inStock = method_exists($product, 'shelfQuantity')
        ? $product->shelfQuantity() > 0
        : ((float) ($product->quantity ?? 0) > 0);

    $availability = $inStock
        ? 'https://schema.org/InStock'
        : 'https://schema.org/OutOfStock';

    if ($product->status && in_array($product->status->status_name, ['Coming Soon', 'Pre Order'], true)) {
        $availability = 'https://schema.org/PreOrder';
    }

    $price = (float) $product->final_price;
    $brandName = null;
    if (!empty($product->grouped_attributes['Brand'][0] ?? null)) {
        $brandName = $product->grouped_attributes['Brand'][0];
    } elseif (!empty($product->grouped_attributes['BRAND'][0] ?? null)) {
        $brandName = $product->grouped_attributes['BRAND'][0];
    } else {
        // Infer brand from leading token of product name when useful
        $tokens = preg_split('/\s+/', trim((string) $product->name)) ?: [];
        $candidate = strtoupper($tokens[0] ?? '');
        $known = ['BASEUS', 'UGREEN', 'ASUS', 'ACER', 'HP', 'LENOVO', 'DELL', 'MSI', 'GIGABYTE', 'INTEL', 'AMD', 'SAMSUNG', 'APPLE', 'ANTEC', 'RAIDMAX'];
        if (in_array($candidate, $known, true)) {
            $brandName = $tokens[0];
        }
    }

    $productLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        '@id' => $productUrl . '#product',
        'name' => $product->name,
        'description' => $plainDescription,
        'image' => $images,
        'sku' => $product->code ?: (string) $product->id,
        'mpn' => $product->code ?: (string) $product->id,
        'url' => $productUrl,
        'category' => $category?->name,
        'brand' => [
            '@type' => 'Brand',
            'name' => $brandName ?: 'MSK Computers',
        ],
        'offers' => [
            '@type' => 'Offer',
            'url' => $productUrl,
            'priceCurrency' => 'LKR',
            'price' => number_format($price > 0 ? $price : 0, 2, '.', ''),
            'priceValidUntil' => now()->addYear()->toDateString(),
            'availability' => $availability,
            'itemCondition' => 'https://schema.org/NewCondition',
            'seller' => [
                '@type' => 'Organization',
                'name' => 'MSK Computers',
                'url' => url('/'),
            ],
        ],
    ];

    if (!empty($product->warranty)) {
        $productLd['warranty'] = (string) $product->warranty;
    }

    $breadcrumbItems = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => url('/'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Products',
            'item' => route('products.index'),
        ],
    ];

    if ($category) {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $category->name,
            'item' => route('categories.show', $category->slug ?: $category->id),
        ];
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 4,
            'name' => $product->name,
            'item' => $productUrl,
        ];
    } else {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $product->name,
            'item' => $productUrl,
        ];
    }

    $breadcrumbLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbItems,
    ];

    $orgLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'MSK Computers',
        'url' => url('/'),
        'logo' => asset('msk-computers-logo-color.png'),
        'telephone' => ['+94112959005', '+94777506939'],
        'email' => 'info@mskcomputers.lk',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'No.296/3D, Delpe Junction',
            'addressLocality' => 'Ragama',
            'addressCountry' => 'LK',
        ],
        'sameAs' => [
            'https://www.facebook.com/mskcomputers',
            'https://www.youtube.com/@mskcomputers',
            'https://www.tiktok.com/@mskcomputers',
        ],
    ];

    $webpageLd = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => $productUrl . '#webpage',
        'url' => $productUrl,
        'name' => $product->name . ' | Buy Online Sri Lanka - MSK Computers',
        'description' => \Illuminate\Support\Str::limit($plainDescription, 300),
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => 'MSK Computers',
            'url' => url('/'),
        ],
        'about' => ['@id' => $productUrl . '#product'],
        'inLanguage' => 'en-LK',
    ];
@endphp

<script type="application/ld+json">{!! json_encode($productLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($orgLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($webpageLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
