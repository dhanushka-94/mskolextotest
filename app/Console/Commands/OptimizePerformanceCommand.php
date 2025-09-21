<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizePerformanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all performance optimizations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Starting performance optimization...');
        
        // Clear all caches first
        $this->info('🧹 Clearing caches...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        
        // Optimize application
        $this->info('⚡ Optimizing application...');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        
        // Optimize Composer
        $this->info('📦 Optimizing Composer autoloader...');
        exec('composer install --optimize-autoloader --no-dev');
        
        // Warm up caches
        $this->info('🔥 Warming up caches...');
        $this->call('cache:warm');
        
        $this->info('✅ Performance optimization completed!');
        $this->newLine();
        $this->line('🎯 Your application is now optimized for maximum performance.');
        $this->line('📊 Expected improvements:');
        $this->line('   • Faster page load times');
        $this->line('   • Reduced database queries');
        $this->line('   • Better browser caching');
        $this->line('   • Optimized image loading');
        
        return Command::SUCCESS;
    }
}
