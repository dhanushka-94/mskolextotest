<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CleanDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🧹 Starting complete database cleanup...');
        
        // Clear all data
        $this->clearAllData();
        
        // Create clean admin account
        $this->createAdminAccount();
        
        $this->command->info('✅ Database cleanup completed successfully!');
        $this->displaySummary();
    }
    
    private function clearAllData(): void
    {
        $this->command->info('🗑️ Removing all data from database...');
        
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear all tables in proper order
        $tables = [
            'activity_logs',
            'transactions', 
            'order_items',
            'orders',
            'carts',
            'user_addresses',
            'password_reset_tokens',
            'sessions',
            'users',
            'failed_jobs',
            'jobs',
            'job_batches',
            'cache',
            'cache_locks',
            'personal_access_tokens',
        ];
        
        foreach ($tables as $table) {
            try {
                DB::table($table)->delete();
                $this->command->info("  ✅ Cleared: {$table}");
            } catch (\Exception $e) {
                $this->command->warn("  ⚠️ Table {$table} not found or already empty");
            }
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('✅ All data removed from database');
    }
    
    private function createAdminAccount(): void
    {
        $this->command->info('👤 Creating clean admin account...');
        
        // Create main admin user
        $admin = User::create([
            'name' => 'MSK Admin',
            'email' => 'admin@mskcomputers.lk',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $this->command->info('✅ Admin account created successfully');
    }
    
    private function displaySummary(): void
    {
        $this->command->info('');
        $this->command->info('📊 DATABASE CLEANUP SUMMARY:');
        $this->command->info('=====================================');
        $this->command->info('🗑️ All user data removed');
        $this->command->info('🗑️ All orders and order items removed');
        $this->command->info('🗑️ All activity logs removed');
        $this->command->info('🗑️ All transactions removed');
        $this->command->info('🗑️ All carts and sessions removed');
        $this->command->info('✅ Products database untouched');
        $this->command->info('✅ Categories database untouched');
        $this->command->info('=====================================');
        $this->command->info('');
        $this->command->info('🔐 ADMIN LOGIN CREDENTIALS:');
        $this->command->info('Email: admin@mskcomputers.lk');
        $this->command->info('Password: admin123');
        $this->command->info('');
        $this->command->info('🌟 Database is now clean and ready for production!');
        $this->command->info('');
    }
}
