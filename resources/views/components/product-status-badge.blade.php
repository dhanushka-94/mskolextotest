@if($product->status)
    @php
        $statusName = $product->status->status_name;

        // Quantity is the source of truth; LE/POS status rows may still say "In Stock" when qty is 0/null.
        $qtyRaw = $product->getAttributes()['quantity'] ?? null;
        $qty = ($qtyRaw === null || $qtyRaw === '') ? 0.0 : (float) $qtyRaw;
        $normalized = strtolower(trim((string) $statusName));
        $special = in_array($normalized, ['coming soon', 'pre order', 'pre-order'], true);
        $misleadingAvailable = in_array($normalized, ['in stock', 'available'], true);
        if ($qty <= 0.0 && ! $special && $misleadingAvailable) {
            $statusName = 'Out of Stock';
        }
        
        // Define status colors and styles with glass effect
        $statusConfig = [
            'Coming Soon' => [
                'bg' => 'bg-gradient-to-r from-blue-500/15 to-indigo-500/15',
                'text' => 'text-blue-200',
                'border' => 'border-blue-400/40',
                'hover' => 'hover:from-blue-500/20 hover:to-indigo-500/20 hover:border-blue-400/60 hover:shadow-blue-500/20',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>'
            ],
            'Pre Order' => [
                'bg' => 'bg-gradient-to-r from-orange-500/15 to-amber-500/15',
                'text' => 'text-orange-200',
                'border' => 'border-orange-400/40',
                'hover' => 'hover:from-orange-500/20 hover:to-amber-500/20 hover:border-orange-400/60 hover:shadow-orange-500/20',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>'
            ],
            'In Stock (for PC Build)' => [
                'bg' => 'bg-gradient-to-r from-green-500/15 to-emerald-500/15',
                'text' => 'text-green-200',
                'border' => 'border-green-400/40',
                'hover' => 'hover:from-green-500/20 hover:to-emerald-500/20 hover:border-green-400/60 hover:shadow-green-500/20',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>'
            ],
            'Reserved' => [
                'bg' => 'bg-gradient-to-r from-purple-500/15 to-violet-500/15',
                'text' => 'text-purple-200',
                'border' => 'border-purple-400/40',
                'hover' => 'hover:from-purple-500/20 hover:to-violet-500/20 hover:border-purple-400/60 hover:shadow-purple-500/20',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>'
            ]
        ];
        
        $config = $statusConfig[$statusName] ?? [
            'bg' => 'bg-gradient-to-r from-gray-500/15 to-slate-500/15',
            'text' => 'text-gray-200',
            'border' => 'border-gray-400/40',
            'hover' => 'hover:from-gray-500/20 hover:to-slate-500/20 hover:border-gray-400/60 hover:shadow-gray-500/20',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>'
        ];
    @endphp
    
    <div class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold backdrop-blur-sm border shadow-lg transition-all duration-300 {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} {{ $config['hover'] }}">
        {!! $config['icon'] !!}
        <span class="tracking-wide">{{ $statusName }}</span>
    </div>
@endif
