@php
    $cashPrice = (float) $product->final_price;
    $cardPrice = round($cashPrice * 1.03, 2);   // Visa / Master / Amex
    $kokoTotal = round($cashPrice * 1.12, 2);   // KOKO Pay total
    $kokoSplit = round($kokoTotal / 3, 2);      // 3 installments
    $retailPrice = $kokoTotal;                  // highest total used for "vs retail"
@endphp

<section class="mb-4 sm:mb-6" aria-labelledby="product-payment-methods-heading">
    <div class="flex items-center justify-between gap-2 mb-3">
        <h2 id="product-payment-methods-heading" class="text-sm sm:text-base font-semibold text-white">
            Payment Methods
        </h2>
        <p class="text-[11px] sm:text-xs text-gray-500">Card installments available via WebXPay</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-3">
        {{-- CASH --}}
        <article class="relative rounded-xl bg-[#1a1a1c] border border-gray-800/80 p-3 sm:p-4 text-center hover:border-primary-500/40 transition-colors">
            <span class="absolute top-2 right-2 text-primary-400" title="Best price" aria-label="Best price">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </span>
            <div class="h-8 flex items-center justify-center mb-2">
                <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Cash</p>
            <p class="text-sm sm:text-base font-bold text-white leading-tight">{{ number_format($cashPrice, 0) }} <span class="text-[10px] font-medium text-gray-400">LKR</span></p>
            @if($retailPrice > $cashPrice)
                <p class="mt-2 inline-flex items-center gap-1 rounded-full bg-gray-700/70 px-2 py-0.5 text-[10px] text-gray-200">
                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    save {{ number_format($retailPrice - $cashPrice, 0) }} LKR
                </p>
                <p class="mt-1 text-[10px] text-gray-500">Vs Retail price {{ number_format($retailPrice, 0) }} LKR</p>
            @endif
        </article>

        {{-- BANK DEPOSIT --}}
        <article class="relative rounded-xl bg-[#1a1a1c] border border-gray-800/80 p-3 sm:p-4 text-center hover:border-primary-500/40 transition-colors">
            <span class="absolute top-2 right-2 text-primary-400" title="Best price" aria-label="Best price">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </span>
            <div class="h-8 flex items-center justify-center mb-2">
                <svg class="w-7 h-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
            </div>
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Bank Deposit</p>
            <p class="text-sm sm:text-base font-bold text-white leading-tight">{{ number_format($cashPrice, 0) }} <span class="text-[10px] font-medium text-gray-400">LKR</span></p>
            @if($retailPrice > $cashPrice)
                <p class="mt-2 inline-flex items-center gap-1 rounded-full bg-gray-700/70 px-2 py-0.5 text-[10px] text-gray-200">
                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    save {{ number_format($retailPrice - $cashPrice, 0) }} LKR
                </p>
                <p class="mt-1 text-[10px] text-gray-500">Vs Retail price {{ number_format($retailPrice, 0) }} LKR</p>
            @endif
        </article>

        {{-- VISA --}}
        <article class="relative rounded-xl bg-[#1a1a1c] border border-gray-800/80 p-3 sm:p-4 text-center hover:border-blue-500/40 transition-colors">
            <div class="h-8 flex items-center justify-center mb-2">
                <span class="inline-flex items-center justify-center h-6 min-w-[3.5rem] px-2 rounded-sm text-[11px] font-extrabold tracking-widest" style="background-color:#1A1F71;color:#fff;">VISA</span>
            </div>
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Visa</p>
            <p class="text-sm sm:text-base font-bold text-white leading-tight">{{ number_format($cardPrice, 0) }} <span class="text-[10px] font-medium text-gray-400">LKR</span></p>
            <p class="mt-2 text-[10px] sm:text-xs font-semibold text-blue-300 leading-snug">Installments available</p>
            @if($retailPrice > $cardPrice)
                <p class="mt-2 inline-flex items-center gap-1 rounded-full bg-gray-700/70 px-2 py-0.5 text-[10px] text-gray-200">
                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    save {{ number_format($retailPrice - $cardPrice, 0) }} LKR
                </p>
                <p class="mt-1 text-[10px] text-gray-500">Vs Retail price {{ number_format($retailPrice, 0) }} LKR</p>
            @endif
        </article>

        {{-- MASTER --}}
        <article class="relative rounded-xl bg-[#1a1a1c] border border-gray-800/80 p-3 sm:p-4 text-center hover:border-orange-500/40 transition-colors">
            <div class="h-8 flex items-center justify-center mb-2">
                <span class="inline-flex items-center justify-center h-6 min-w-[3.5rem] px-1.5 rounded-sm bg-black border border-gray-600">
                    <svg width="30" height="16" viewBox="0 0 28 16" aria-hidden="true" focusable="false">
                        <circle cx="10" cy="8" r="6" fill="#EB001B"/>
                        <circle cx="18" cy="8" r="6" fill="#F79E1B"/>
                        <path fill="#FF5F00" d="M14 3.2c-1.1.9-1.8 2.3-1.8 3.8s.7 2.9 1.8 3.8c1.1-.9 1.8-2.3 1.8-3.8s-.7-2.9-1.8-3.8z"/>
                    </svg>
                </span>
            </div>
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Master</p>
            <p class="text-sm sm:text-base font-bold text-white leading-tight">{{ number_format($cardPrice, 0) }} <span class="text-[10px] font-medium text-gray-400">LKR</span></p>
            <p class="mt-2 text-[10px] sm:text-xs font-semibold text-orange-300 leading-snug">Installments available</p>
            @if($retailPrice > $cardPrice)
                <p class="mt-2 inline-flex items-center gap-1 rounded-full bg-gray-700/70 px-2 py-0.5 text-[10px] text-gray-200">
                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    save {{ number_format($retailPrice - $cardPrice, 0) }} LKR
                </p>
                <p class="mt-1 text-[10px] text-gray-500">Vs Retail price {{ number_format($retailPrice, 0) }} LKR</p>
            @endif
        </article>

        {{-- AMEX --}}
        <article class="relative rounded-xl bg-[#1a1a1c] border border-gray-800/80 p-3 sm:p-4 text-center hover:border-sky-500/40 transition-colors">
            <div class="h-8 flex items-center justify-center mb-2">
                <img src="{{ asset('images/amex-logo.svg') }}" alt="American Express" width="56" height="20" class="h-5 w-auto" loading="lazy" decoding="async">
            </div>
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Amex</p>
            <p class="text-sm sm:text-base font-bold text-white leading-tight">{{ number_format($cardPrice, 0) }} <span class="text-[10px] font-medium text-gray-400">LKR</span></p>
            <p class="mt-2 text-[10px] sm:text-xs font-semibold text-sky-300 leading-snug">Installments available</p>
            @if($retailPrice > $cardPrice)
                <p class="mt-2 inline-flex items-center gap-1 rounded-full bg-gray-700/70 px-2 py-0.5 text-[10px] text-gray-200">
                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    save {{ number_format($retailPrice - $cardPrice, 0) }} LKR
                </p>
                <p class="mt-1 text-[10px] text-gray-500">Vs Retail price {{ number_format($retailPrice, 0) }} LKR</p>
            @endif
        </article>

        {{-- KOKO PAY --}}
        <article class="relative rounded-xl bg-[#1a1a1c] border border-pink-500/30 p-3 sm:p-4 text-center hover:border-pink-400/50 transition-colors">
            <span class="absolute top-2 right-2 text-gray-400" title="Pay in 3 instalments" aria-label="Pay in 3 instalments">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </span>
            <div class="h-8 flex items-center justify-center mb-2">
                <img src="{{ asset('images/kokopay-logo.png') }}" alt="KOKO Pay" class="h-7 w-auto object-contain" loading="lazy" decoding="async">
            </div>
            <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">KOKO Pay</p>
            <p class="text-sm sm:text-base font-bold text-white leading-tight">{{ number_format($kokoTotal, 0) }} <span class="text-[10px] font-medium text-gray-400">LKR</span></p>
            <p class="mt-2 text-[10px] sm:text-xs font-semibold text-pink-400 leading-snug">
                PAY IN 3 × {{ number_format($kokoSplit, 2) }} LKR
            </p>
            <p class="mt-1 text-[10px] text-pink-300/80">Buy now, pay later</p>
        </article>
    </div>
</section>
