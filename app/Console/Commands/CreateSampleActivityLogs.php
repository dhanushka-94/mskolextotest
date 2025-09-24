<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActivityLog;
use App\Models\User;

class CreateSampleActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'logs:create-samples {--count=20 : Number of sample logs to create}';

    /**
     * The console command description.
     */
    protected $description = 'Create sample activity logs for testing the activity log system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = $this->option('count');
        $user = User::first();
        
        if (!$user) {
            $this->error('No users found. Please create a user first.');
            return 1;
        }

        $this->info("Creating {$count} sample activity logs...");

        $actions = [
            ['type' => 'customer', 'action' => ActivityLog::ACTION_LOGIN, 'description' => 'User logged in from web browser'],
            ['type' => 'customer', 'action' => ActivityLog::ACTION_PRODUCT_VIEWED, 'description' => 'Viewed gaming laptop product page'],
            ['type' => 'customer', 'action' => ActivityLog::ACTION_CATEGORY_VIEWED, 'description' => 'Browsed laptops category'],
            ['type' => 'customer', 'action' => ActivityLog::ACTION_SEARCH_PERFORMED, 'description' => 'Searched for gaming PC'],
            ['type' => 'customer', 'action' => ActivityLog::ACTION_PRODUCT_ADDED_TO_CART, 'description' => 'Added gaming mouse to cart'],
            ['type' => 'customer', 'action' => ActivityLog::ACTION_CART_CHECKOUT, 'description' => 'Proceeded to checkout'],
            ['type' => 'system', 'action' => ActivityLog::ACTION_ORDER_CREATED, 'description' => 'New order placed successfully'],
            ['type' => 'system', 'action' => ActivityLog::ACTION_PAYMENT_SUCCESS, 'description' => 'Payment processed successfully'],
            ['type' => 'admin', 'action' => 'user_viewed', 'description' => 'Admin viewed user profile'],
            ['type' => 'admin', 'action' => 'order_status_updated', 'description' => 'Admin updated order status to shipped'],
            ['type' => 'customer', 'action' => ActivityLog::ACTION_LOGOUT, 'description' => 'User logged out'],
            ['type' => 'customer', 'action' => 'homepage_visited', 'description' => 'Visited MSK Computers homepage'],
            ['type' => 'system', 'action' => ActivityLog::ACTION_EMAIL_SENT, 'description' => 'Order confirmation email sent'],
            ['type' => 'customer', 'action' => ActivityLog::ACTION_PROFILE_UPDATED, 'description' => 'User updated profile information'],
            ['type' => 'admin', 'action' => 'bulk_action_performed', 'description' => 'Admin performed bulk order update'],
        ];

        $severities = [
            ActivityLog::SEVERITY_LOW,
            ActivityLog::SEVERITY_MEDIUM,
            ActivityLog::SEVERITY_HIGH,
        ];

        $statuses = [
            ActivityLog::STATUS_SUCCESS,
            ActivityLog::STATUS_FAILED,
            ActivityLog::STATUS_PENDING,
        ];

        $ips = [
            '192.168.1.100',
            '10.0.0.50',
            '172.16.0.25',
            '203.115.72.10',
            '118.189.12.45',
        ];

        $devices = ['desktop', 'mobile', 'tablet'];
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge'];
        $platforms = ['Windows', 'macOS', 'Linux', 'iOS', 'Android'];

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i = 0; $i < $count; $i++) {
            $action = $actions[array_rand($actions)];
            
            $properties = [];
            
            // Add specific properties based on action
            switch ($action['action']) {
                case ActivityLog::ACTION_SEARCH_PERFORMED:
                    $properties = ['search_query' => 'gaming PC RTX 4080'];
                    break;
                case ActivityLog::ACTION_ORDER_CREATED:
                    $properties = [
                        'order_total' => rand(500, 5000),
                        'items_count' => rand(1, 5),
                        'order_number' => 'MSK-2024-' . strtoupper(substr(md5(rand()), 0, 8)),
                    ];
                    break;
                case ActivityLog::ACTION_PRODUCT_ADDED_TO_CART:
                    $properties = [
                        'product_name' => 'Gaming Mouse RGB',
                        'product_price' => rand(20, 200),
                        'quantity' => rand(1, 3),
                    ];
                    break;
                case ActivityLog::ACTION_PAYMENT_SUCCESS:
                    $properties = [
                        'amount' => rand(100, 2000),
                        'payment_method' => 'credit_card',
                        'transaction_id' => 'TXN' . rand(100000, 999999),
                    ];
                    break;
            }

            // Create the activity log
            ActivityLog::create([
                'type' => $action['type'],
                'action' => $action['action'],
                'description' => $action['description'],
                'properties' => $properties,
                'causer_type' => User::class,
                'causer_id' => $user->id,
                'subject_type' => null,
                'subject_id' => null,
                'ip_address' => $ips[array_rand($ips)],
                'user_agent' => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36",
                'url' => '/',
                'method' => 'GET',
                'device_type' => $devices[array_rand($devices)],
                'browser' => $browsers[array_rand($browsers)],
                'platform' => $platforms[array_rand($platforms)],
                'severity' => $severities[array_rand($severities)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now()->subMinutes(rand(1, 10080)), // Random time in last week
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Successfully created {$count} sample activity logs!");
        
        return 0;
    }
}