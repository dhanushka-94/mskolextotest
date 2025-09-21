<?php if($product->status): ?>
    <?php
        $statusName = $product->status->status_name;
        
        // Define status colors and styles
        $statusConfig = [
            'Coming Soon' => [
                'bg' => 'bg-blue-500/10',
                'text' => 'text-blue-400',
                'border' => 'border-blue-500/20',
                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>'
            ],
            'Pre Order' => [
                'bg' => 'bg-orange-500/10',
                'text' => 'text-orange-400',
                'border' => 'border-orange-500/20',
                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>'
            ],
            'In Stock (for PC Build)' => [
                'bg' => 'bg-green-500/10',
                'text' => 'text-green-400',
                'border' => 'border-green-500/20',
                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>'
            ],
            'Reserved' => [
                'bg' => 'bg-purple-500/10',
                'text' => 'text-purple-400',
                'border' => 'border-purple-500/20',
                'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>'
            ]
        ];
        
        $config = $statusConfig[$statusName] ?? [
            'bg' => 'bg-gray-500/10',
            'text' => 'text-gray-400',
            'border' => 'border-gray-500/20',
            'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>'
        ];
    ?>
    
    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?> <?php echo e($config['border']); ?>">
        <?php echo $config['icon']; ?>

        <span><?php echo e($statusName); ?></span>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\Dhanushka\Desktop\MSK\MSKMSV3\resources\views\components\product-status-badge.blade.php ENDPATH**/ ?>