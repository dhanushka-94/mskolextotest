<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PerformanceCacheService;

class WarmCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up application caches';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Warming up caches...');
        
        // Warm up performance caches
        PerformanceCacheService::warmUpCaches();
        
        $this->info('✅ Caches warmed up successfully!');
        
        return Command::SUCCESS;
    }
}
