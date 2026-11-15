@extends('layouts.app')

@php
    $seoTitle = 'Computer Repair Services Sri Lanka | Islandwide Laptop & PC Repair - MSK Computers';
    $seoDescription = 'Islandwide computer repair services in Sri Lanka by MSK Computers Service Center (Ragama). Laptop repair, desktop PC repair, motherboard and screen repairs, virus removal, Windows installation and upgrades — expert technicians, genuine parts, and warranty.';
    $seoKeywords = implode(', ', [
        'computer repair services Sri Lanka',
        'computer repair islandwide',
        'laptop repair Sri Lanka',
        'PC repair Sri Lanka',
        'desktop computer repair',
        'motherboard repair Sri Lanka',
        'laptop screen replacement',
        'virus removal Sri Lanka',
        'Windows installation Sri Lanka',
        'computer service center Ragama',
        'MSK Computers Service Center',
        'computer repair Colombo',
        'computer repair Gampaha',
        'islandwide laptop repair',
    ]);
    $seoUrl = route('services.index');
    $seoImage = asset('images/msk-share-og.png') . '?v=' . config('assets.version', '20261116');
@endphp

@section('title', $seoTitle)
@section('description', $seoDescription)
@section('keywords', $seoKeywords)
@section('canonical', $seoUrl)
@section('og_title', 'Computer Repair Services Islandwide in Sri Lanka | MSK Computers')
@section('og_description', $seoDescription)
@section('og_image', $seoImage)
@section('og_image_alt', 'MSK Computers Service Center — Computer Repair Services Sri Lanka')
@section('og_type', 'website')
@section('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')

@push('structured_data')
@php
    $serviceLd = [
        '@context' => 'https://schema.org',
        '@type' => ['ComputerStore', 'LocalBusiness', 'ElectronicsStore'],
        '@id' => $seoUrl . '#service-center',
        'name' => 'MSK Computers Service Center',
        'alternateName' => 'MSK Computers — Computer Repair Services',
        'url' => $seoUrl,
        'image' => $seoImage,
        'logo' => asset('msk-computers-logo-color.png'),
        'description' => $seoDescription,
        'telephone' => ['+94755506939', '+94112959005'],
        'email' => 'info@mskcomputers.lk',
        'priceRange' => '$$',
        'currenciesAccepted' => 'LKR',
        'paymentAccepted' => 'Cash, Bank Transfer, Credit Card',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'No. 296/3B, Delpe Junction',
            'addressLocality' => 'Ragama',
            'addressRegion' => 'Western Province',
            'addressCountry' => 'LK',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 7.0300,
            'longitude' => 79.9220,
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'opens' => '09:00',
                'closes' => '18:00',
            ],
        ],
        'areaServed' => [
            ['@type' => 'Country', 'name' => 'Sri Lanka'],
            ['@type' => 'AdministrativeArea', 'name' => 'Western Province'],
            ['@type' => 'City', 'name' => 'Colombo'],
            ['@type' => 'City', 'name' => 'Gampaha'],
            ['@type' => 'City', 'name' => 'Ragama'],
            ['@type' => 'City', 'name' => 'Negombo'],
            ['@type' => 'City', 'name' => 'Kelaniya'],
            ['@type' => 'City', 'name' => 'Kadawatha'],
            ['@type' => 'City', 'name' => 'Ja-Ela'],
            ['@type' => 'City', 'name' => 'Wattala'],
            ['@type' => 'City', 'name' => 'Kandy'],
            ['@type' => 'City', 'name' => 'Galle'],
            ['@type' => 'City', 'name' => 'Kurunegala'],
        ],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Computer Repair Services',
            'itemListElement' => [
                ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Laptop Repair', 'description' => 'Islandwide laptop repair including screen, keyboard, battery, and motherboard work']],
                ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Desktop PC Repair', 'description' => 'Desktop computer diagnosis, hardware repair, and upgrades']],
                ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Motherboard Repair', 'description' => 'Component-level motherboard diagnostics and repair']],
                ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Virus & Malware Removal', 'description' => 'Complete virus removal and system security cleanup']],
                ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'Windows Installation', 'description' => 'Windows OS installation, drivers, and software setup']],
                ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => 'SSD & RAM Upgrades', 'description' => 'Performance upgrades with genuine parts']],
            ],
        ],
        'sameAs' => [
            'https://www.facebook.com/mskcomputers',
            'https://www.youtube.com/@mskcomputers',
            'https://www.tiktok.com/@mskcomputers',
        ],
    ];

    $breadcrumbLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Service Center', 'item' => $seoUrl],
            ['@type' => 'ListItem', 'position' => 3, 'name' => 'Computer Repair Services Sri Lanka', 'item' => $seoUrl],
        ],
    ];

    $webpageLd = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => $seoUrl . '#webpage',
        'url' => $seoUrl,
        'name' => $seoTitle,
        'description' => $seoDescription,
        'inLanguage' => 'en-LK',
        'isPartOf' => ['@type' => 'WebSite', 'name' => 'MSK Computers', 'url' => url('/')],
        'about' => ['@id' => $seoUrl . '#service-center'],
        'primaryImageOfPage' => $seoImage,
    ];

    $faqLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'Do you provide islandwide computer repair services in Sri Lanka?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes. MSK Computers Service Center in Ragama provides computer and laptop repair services for customers islandwide across Sri Lanka. Bring your device to our workshop or contact us for guidance on shipping and drop-off.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What computer repair services does MSK Computers offer?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We offer laptop repair, desktop PC repair, motherboard repair, screen replacement, keyboard repair, virus and malware removal, Windows installation, RAM/SSD upgrades, network setup, and printer services.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How long does computer repair usually take?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Most devices receive same-day diagnosis. Basic repairs are typically completed within 24–48 hours. Complex motherboard or parts-dependent jobs may take longer. Express service is available.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Is there a warranty on computer repairs?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes. Repairs at MSK Computers Service Center include a 90-day service warranty, genuine parts where applicable, and free follow-up within the warranty period.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Where is the MSK Computers Service Center located?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'MSK Computers Service Center is at No. 296/3B, Delpe Junction, Ragama, Sri Lanka. Call 075 550 69 39 or WhatsApp +94 755 506 939.',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($serviceLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($webpageLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($faqLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-b from-black to-[#0f0f0f]" aria-labelledby="service-center-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm mb-6 text-gray-500" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{{ route('home') }}" class="hover:text-primary-400"><span itemprop="name">Home</span></a>
                    <meta itemprop="position" content="1">
                </li>
                <li>/</li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-gray-400">
                    <span itemprop="name">Service Center</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>

        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-[#f59e0b]/10 border border-[#f59e0b]/20 rounded-lg text-[#f59e0b] text-sm font-medium mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                </svg>
                Service Center · Islandwide Sri Lanka
            </div>
            <h1 id="service-center-heading" class="text-4xl md:text-6xl font-bold text-white mb-6">
                Computer Repair Services
                <span class="block text-[#f59e0b] mt-2">Islandwide in Sri Lanka</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                Professional <strong class="text-white">laptop &amp; PC repair</strong> from MSK Computers Service Center in Ragama —
                expert technicians, genuine parts, and warranty-backed service for customers across Sri Lanka.
            </p>
        </div>
        
        <!-- Contact Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white mb-2">Service Center Location</h2>
                <p class="text-gray-400 text-sm">No. 296/3B, Delpe Junction<br>Ragama, Sri Lanka</p>
            </div>
            
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white mb-2">Call for Repair</h2>
                <a href="tel:0755506939" class="text-[#f59e0b] font-medium hover:underline">075 550 69 39</a>
            </div>
            
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#f59e0b]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.386"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white mb-2">WhatsApp Support</h2>
                <a href="https://wa.me/94755506939?text={{ rawurlencode('Hi MSK Computers, I need computer repair services.') }}" target="_blank" rel="noopener" class="text-[#f59e0b] font-medium hover:underline">+94 755 506 939</a>
            </div>
        </div>
    </div>
</section>

<!-- Islandwide SEO intro -->
<section class="py-12 bg-black border-t border-gray-900" aria-labelledby="islandwide-repair-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="rounded-xl border border-gray-800/60 bg-[#0f0f10] p-5 sm:p-8">
            <h2 id="islandwide-repair-heading" class="text-2xl sm:text-3xl font-bold text-white mb-4">
                Trusted Computer Repair Services Across Sri Lanka
            </h2>
            <p class="text-gray-300 leading-relaxed mb-4">
                Looking for reliable <strong class="text-white">computer repair services in Sri Lanka</strong>?
                MSK Computers Service Center specializes in <strong class="text-white">laptop repair</strong>,
                <strong class="text-white">desktop PC repair</strong>, motherboard work, data-safe diagnostics,
                virus removal, and performance upgrades — serving customers <strong class="text-white">islandwide</strong>
                from our Ragama workshop.
            </p>
            <p class="text-gray-400 text-sm sm:text-base leading-relaxed">
                Whether you are in Colombo, Gampaha, Negombo, Kelaniya, Kadawatha, Ja-Ela, Wattala, Kandy, Galle, Kurunegala,
                or elsewhere in Sri Lanka, bring or send your device to MSK Computers for professional repair with transparent estimates and warranty-backed workmanship.
            </p>
        </article>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-black" aria-labelledby="our-repair-services-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 id="our-repair-services-heading" class="text-3xl md:text-4xl font-bold text-white mb-4">Our Computer Repair Services</h2>
            <p class="text-lg text-gray-400">Full-service laptop and PC repair for homes and businesses islandwide.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Hardware Services -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Hardware</h3>
                <h4 class="text-lg text-[#f59e0b] mb-3">Laptop &amp; Desktop Computer Repair</h4>
                <p class="text-gray-400 text-sm mb-4">Complete diagnosis and repair for desktops and laptops across Sri Lanka.</p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Hardware diagnostics</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Motherboard repair</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Screen replacement</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Keyboard repair</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Power supply issues</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Component upgrades</li>
                </ul>
            </div>

            <!-- Software Services -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Software</h3>
                <h4 class="text-lg text-[#f59e0b] mb-3">Windows Installation &amp; Support</h4>
                <p class="text-gray-400 text-sm mb-4">Operating system installation and software configuration</p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Windows installation</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Software setup</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Driver installation</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>System optimization</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>License activation</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Custom configurations</li>
                </ul>
            </div>

            <!-- Security Services -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Security</h3>
                <h4 class="text-lg text-[#f59e0b] mb-3">Virus &amp; Malware Removal</h4>
                <p class="text-gray-400 text-sm mb-4">Complete system cleanup and security protection</p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Virus detection &amp; removal</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Malware cleanup</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Antivirus installation</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>System security audit</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Firewall configuration</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Performance optimization</li>
                </ul>
            </div>

            <!-- Network Services -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Network</h3>
                <h4 class="text-lg text-[#f59e0b] mb-3">Network &amp; Internet Setup</h4>
                <p class="text-gray-400 text-sm mb-4">Home and office network configuration services</p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>WiFi setup</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Router configuration</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Network troubleshooting</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Internet connectivity</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>File sharing setup</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Network security</li>
                </ul>
            </div>

            <!-- Peripherals Services -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Peripherals</h3>
                <h4 class="text-lg text-[#f59e0b] mb-3">Printer &amp; Scanner Services</h4>
                <p class="text-gray-400 text-sm mb-4">Printer maintenance and troubleshooting services</p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Printer setup</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Driver installation</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Print quality issues</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Paper jam resolution</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Ink system cleaning</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Network printing setup</li>
                </ul>
            </div>

            <!-- Upgrade Services -->
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 hover:border-[#f59e0b]/30 transition-all duration-300">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Upgrade</h3>
                <h4 class="text-lg text-[#f59e0b] mb-3">SSD, RAM &amp; System Optimization</h4>
                <p class="text-gray-400 text-sm mb-4">Hardware upgrades and performance enhancement</p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>RAM upgrades</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>SSD installation</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Graphics card upgrade</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>System speed optimization</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Storage expansion</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Component compatibility</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Areas We Serve -->
<section class="py-16 bg-[#0f0f0f]" aria-labelledby="areas-served-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 id="areas-served-heading" class="text-3xl md:text-4xl font-bold text-white mb-4">Islandwide Coverage</h2>
            <p class="text-lg text-gray-400 max-w-3xl mx-auto">
                Computer repair services for customers across Sri Lanka — with a workshop based in Ragama and islandwide support
            </p>
        </div>
        <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 text-center">
            @foreach(['Colombo', 'Gampaha', 'Ragama', 'Negombo', 'Kelaniya', 'Kadawatha', 'Ja-Ela', 'Wattala', 'Kandy', 'Galle', 'Kurunegala', 'Islandwide'] as $area)
                <li class="rounded-lg border border-gray-800 bg-[#1a1a1c] px-3 py-3 text-sm text-gray-300">{{ $area }}</li>
            @endforeach
        </ul>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16 bg-black" aria-labelledby="why-choose-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 id="why-choose-heading" class="text-3xl md:text-4xl font-bold text-white mb-4">Why Choose MSK Computers Service Center?</h2>
            <p class="text-lg text-gray-400">Professional computer repair with warranty and expert support</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 text-center">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Service Warranty</h3>
                <p class="text-gray-400 text-sm mb-4">All repairs come with comprehensive warranty coverage</p>
                <ul class="space-y-2 text-sm text-gray-300 text-left">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>90-day service warranty on all repairs</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Genuine parts guarantee</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Free follow-up within warranty period</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Comprehensive service documentation</li>
                </ul>
            </div>

            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 text-center">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Quick Turnaround</h3>
                <p class="text-gray-400 text-sm mb-4">Fast and efficient service delivery</p>
                <ul class="space-y-2 text-sm text-gray-300 text-left">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Same-day diagnosis</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Basic repairs within 24–48 hours</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Express service available</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Priority service for businesses</li>
                </ul>
            </div>

            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-8 text-center">
                <div class="w-16 h-16 bg-[#f59e0b]/20 rounded-lg flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Expert Technicians</h3>
                <p class="text-gray-400 text-sm mb-4">Certified professionals with years of experience</p>
                <ul class="space-y-2 text-sm text-gray-300 text-left">
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Certified repair technicians</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Continuous training programs</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>Latest diagnostic equipment</li>
                    <li class="flex items-center"><span class="w-2 h-2 bg-[#f59e0b] rounded-full mr-3"></span>15+ years of experience</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Service Process Section -->
<section class="py-16 bg-[#0f0f0f]" aria-labelledby="process-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 id="process-heading" class="text-3xl md:text-4xl font-bold text-white mb-4">Our Repair Process</h2>
            <p class="text-lg text-gray-400">Simple and transparent process for all computer repairs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">01</span>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Diagnosis</h3>
                <p class="text-gray-400 text-sm">Free comprehensive diagnosis of issues with your device</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">02</span>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Estimate</h3>
                <p class="text-gray-400 text-sm">Transparent pricing with detailed repair estimate</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">03</span>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Repair</h3>
                <p class="text-gray-400 text-sm">Professional repair using genuine parts and tools</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-[#f59e0b] rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-black">04</span>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Testing</h3>
                <p class="text-gray-400 text-sm">Thorough testing and quality assurance before delivery</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-16 bg-black border-t border-gray-900" aria-labelledby="repair-faq-heading">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 id="repair-faq-heading" class="text-3xl font-bold text-white mb-8 text-center">Computer Repair FAQ</h2>
        <div class="space-y-4">
            <details class="group rounded-xl border border-gray-800 bg-[#1a1a1c] p-5 open:border-[#f59e0b]/40">
                <summary class="cursor-pointer list-none font-semibold text-white flex justify-between gap-4">
                    Do you provide islandwide computer repair services in Sri Lanka?
                    <span class="text-[#f59e0b] group-open:rotate-45 transition-transform">+</span>
                </summary>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    Yes. MSK Computers Service Center in Ragama provides laptop and PC repair for customers islandwide.
                    Contact us for drop-off or shipping guidance from your city.
                </p>
            </details>
            <details class="group rounded-xl border border-gray-800 bg-[#1a1a1c] p-5">
                <summary class="cursor-pointer list-none font-semibold text-white flex justify-between gap-4">
                    What computer repair services do you offer?
                    <span class="text-[#f59e0b] group-open:rotate-45 transition-transform">+</span>
                </summary>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    Laptop repair, desktop PC repair, motherboard repair, screen/keyboard replacement, virus removal,
                    Windows installation, SSD/RAM upgrades, network setup, and printer services.
                </p>
            </details>
            <details class="group rounded-xl border border-gray-800 bg-[#1a1a1c] p-5">
                <summary class="cursor-pointer list-none font-semibold text-white flex justify-between gap-4">
                    How long does a typical repair take?
                    <span class="text-[#f59e0b] group-open:rotate-45 transition-transform">+</span>
                </summary>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    Same-day diagnosis for most devices. Basic repairs usually 24–48 hours. Express options available.
                </p>
            </details>
            <details class="group rounded-xl border border-gray-800 bg-[#1a1a1c] p-5">
                <summary class="cursor-pointer list-none font-semibold text-white flex justify-between gap-4">
                    Is there a warranty on repairs?
                    <span class="text-[#f59e0b] group-open:rotate-45 transition-transform">+</span>
                </summary>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    Yes — 90-day service warranty on repairs, with genuine parts where applicable and free follow-up in the warranty period.
                </p>
            </details>
            <details class="group rounded-xl border border-gray-800 bg-[#1a1a1c] p-5">
                <summary class="cursor-pointer list-none font-semibold text-white flex justify-between gap-4">
                    Where is the Service Center?
                    <span class="text-[#f59e0b] group-open:rotate-45 transition-transform">+</span>
                </summary>
                <p class="mt-3 text-sm text-gray-400 leading-relaxed">
                    No. 296/3B, Delpe Junction, Ragama, Sri Lanka. Call 075 550 69 39 or WhatsApp +94 755 506 939.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="py-16 bg-gradient-to-b from-[#0f0f0f] to-black" aria-labelledby="repair-cta-heading">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 id="repair-cta-heading" class="text-3xl md:text-4xl font-bold text-white mb-6">Need Computer Repair Services?</h2>
        <p class="text-lg text-gray-400 mb-8">Book laptop or PC repair with MSK Computers — islandwide support from our Ragama Service Center.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 text-left md:text-center">
                <h3 class="text-lg font-semibold text-white mb-2">MSK Computers Service Center</h3>
                <p class="text-gray-400 text-sm mb-4">No. 296/3B, Delpe Junction<br>Ragama, Sri Lanka</p>
                <div class="space-y-2">
                    <p class="text-[#f59e0b] font-medium">Call: 075 550 69 39</p>
                    <p class="text-[#f59e0b] font-medium">WhatsApp: +94 755 506 939</p>
                </div>
            </div>
            
            <div class="bg-[#1a1a1c] border border-gray-800 rounded-xl p-6 flex flex-col justify-center">
                <div class="space-y-4">
                    <a href="tel:0755506939" class="block w-full bg-[#f59e0b] hover:bg-[#d97706] text-black font-semibold py-3 px-6 rounded-lg transition-colors">
                        Call Now: 075 550 69 39
                    </a>
                    <a href="https://wa.me/94755506939?text={{ rawurlencode('Hi MSK Computers, I need islandwide computer repair services.') }}" target="_blank" rel="noopener" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        WhatsApp Repair Inquiry
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
