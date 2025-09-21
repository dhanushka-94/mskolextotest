<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if doesn't exist
        $adminEmail = 'admin@mskcomputers.lk';
        
        $admin = User::where('email', $adminEmail)->first();
        
        if (!$admin) {
            User::create([
                'name' => 'MSK Admin',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'), // Change this in production
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: ' . $adminEmail);
            $this->command->info('Password: admin123');
            $this->command->warn('Please change the password after first login!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}