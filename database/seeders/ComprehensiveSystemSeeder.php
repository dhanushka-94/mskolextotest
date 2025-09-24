<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ActivityLog;
use Carbon\Carbon;

class ComprehensiveSystemSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting comprehensive system data seeding...');
        
        // Clear existing data (except products)
        $this->clearExistingData();
        
        // Create sample users
        $this->createSystemUsers();
        
        // Create sample customers
        $customers = $this->createSampleCustomers();
        
        // Create sample orders
        $this->createSampleOrders($customers);
        
        // Create sample activity logs
        $this->createSampleActivityLogs();
        
        $this->command->info('✅ Database seeding completed successfully!');
        $this->displaySummary();
    }
    
    private function clearExistingData(): void
    {
        $this->command->info('🧹 Clearing existing data...');
        
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear in proper order to respect foreign key constraints
        DB::table('activity_logs')->delete();
        DB::table('transactions')->delete(); // Clear transactions first
        DB::table('order_items')->delete();
        DB::table('orders')->delete();
        DB::table('users')->where('email', '!=', 'admin@mskcomputers.lk')->delete();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('✅ Existing data cleared');
    }
    
    private function createSystemUsers(): void
    {
        $this->command->info('👥 Creating system users...');
        
        // Create main admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@mskcomputers.lk'],
            [
                'name' => 'MSK Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now()->subDays(365),
                'updated_at' => now()->subDays(365),
            ]
        );
        
        // Create additional admin users
        $adminUsers = [
            [
                'name' => 'Dhanushka Perera',
                'email' => 'dhanushka@mskcomputers.lk',
                'password' => Hash::make('dhanushka123'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now()->subDays(300),
            ],
            [
                'name' => 'Kasun Silva',
                'email' => 'kasun@mskcomputers.lk',
                'password' => Hash::make('kasun123'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now()->subDays(250),
            ],
            [
                'name' => 'Nuwan Fernando',
                'email' => 'nuwan@mskcomputers.lk',
                'password' => Hash::make('nuwan123'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now()->subDays(200),
            ],
        ];
        
        foreach ($adminUsers as $userData) {
            User::create($userData);
        }
        
        $this->command->info('✅ System users created');
    }
    
    private function createSampleCustomers(): array
    {
        $this->command->info('👤 Creating sample customers...');
        
        $customerData = [
            ['name' => 'Amal Jayasinghe', 'email' => 'amal.j@gmail.com', 'phone' => '0771234567'],
            ['name' => 'Nimali Perera', 'email' => 'nimali.p@yahoo.com', 'phone' => '0772345678'],
            ['name' => 'Ruwan Wickramasinghe', 'email' => 'ruwan.w@hotmail.com', 'phone' => '0773456789'],
            ['name' => 'Saman Fernando', 'email' => 'saman.f@gmail.com', 'phone' => '0774567890'],
            ['name' => 'Dilani Silva', 'email' => 'dilani.s@gmail.com', 'phone' => '0775678901'],
            ['name' => 'Kumara Rajapaksa', 'email' => 'kumara.r@yahoo.com', 'phone' => '0776789012'],
            ['name' => 'Chaminda Gunawardena', 'email' => 'chaminda.g@gmail.com', 'phone' => '0777890123'],
            ['name' => 'Madhavi Bandara', 'email' => 'madhavi.b@hotmail.com', 'phone' => '0778901234'],
            ['name' => 'Pradeep Amarasinghe', 'email' => 'pradeep.a@gmail.com', 'phone' => '0779012345'],
            ['name' => 'Sanduni Wijeratne', 'email' => 'sanduni.w@gmail.com', 'phone' => '0770123456'],
            ['name' => 'Mahesh Dias', 'email' => 'mahesh.d@yahoo.com', 'phone' => '0771234560'],
            ['name' => 'Kanchana Senanayake', 'email' => 'kanchana.s@gmail.com', 'phone' => '0772345601'],
            ['name' => 'Gayan Rodrigo', 'email' => 'gayan.r@hotmail.com', 'phone' => '0773456012'],
            ['name' => 'Tharanga Mendis', 'email' => 'tharanga.m@gmail.com', 'phone' => '0774560123'],
            ['name' => 'Nirosha Kumari', 'email' => 'nirosha.k@yahoo.com', 'phone' => '0775601234'],
            ['name' => 'Lakmal Siriwardena', 'email' => 'lakmal.s@gmail.com', 'phone' => '0776012345'],
            ['name' => 'Suranga Perera', 'email' => 'suranga.p@hotmail.com', 'phone' => '0777012345'],
            ['name' => 'Chathura Silva', 'email' => 'chathura.s@gmail.com', 'phone' => '0778012345'],
            ['name' => 'Malini Fernando', 'email' => 'malini.f@yahoo.com', 'phone' => '0779012340'],
            ['name' => 'Asanka Gunasekara', 'email' => 'asanka.g@gmail.com', 'phone' => '0770123450'],
        ];
        
        $customers = [];
        foreach ($customerData as $index => $data) {
            $customer = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make('customer123'),
                'email_verified_at' => now()->subDays(rand(1, 365)),
                'role' => 'customer',
                'status' => 'active',
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ]);
            $customers[] = $customer;
        }
        
        $this->command->info('✅ Sample customers created');
        return $customers;
    }
    
    private function createSampleOrders(array $customers): void
    {
        $this->command->info('📦 Creating sample orders...');
        
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];
        $paymentMethods = ['webxpay', 'kokopay', 'bank_transfer'];
        
        // Sample product data (we won't touch the actual products table)
        $sampleProducts = [
            ['name' => 'Dell Inspiron 15 3000', 'sku' => 'LAPTOP001', 'price' => 125000],
            ['name' => 'HP Pavilion Gaming', 'sku' => 'LAPTOP002', 'price' => 180000],
            ['name' => 'Lenovo ThinkPad E14', 'sku' => 'LAPTOP003', 'price' => 165000],
            ['name' => 'ASUS VivoBook 15', 'sku' => 'LAPTOP004', 'price' => 145000],
            ['name' => 'Acer Aspire 5', 'sku' => 'LAPTOP005', 'price' => 135000],
            ['name' => 'Intel Core i5-12400F', 'sku' => 'CPU001', 'price' => 32000],
            ['name' => 'AMD Ryzen 5 5600X', 'sku' => 'CPU002', 'price' => 28000],
            ['name' => 'Intel Core i7-12700K', 'sku' => 'CPU003', 'price' => 52000],
            ['name' => 'NVIDIA RTX 3060', 'sku' => 'GPU001', 'price' => 85000],
            ['name' => 'NVIDIA RTX 3070', 'sku' => 'GPU002', 'price' => 125000],
            ['name' => 'NVIDIA RTX 4060', 'sku' => 'GPU003', 'price' => 95000],
            ['name' => 'ASUS ROG Strix B550-F', 'sku' => 'MB001', 'price' => 28000],
            ['name' => 'MSI MAG B550 Tomahawk', 'sku' => 'MB002', 'price' => 25000],
            ['name' => 'Gigabyte B450 AORUS Elite', 'sku' => 'MB003', 'price' => 18000],
            ['name' => 'Corsair Vengeance LPX 16GB', 'sku' => 'RAM001', 'price' => 12000],
            ['name' => 'G.Skill Ripjaws V 32GB', 'sku' => 'RAM002', 'price' => 22000],
            ['name' => 'Kingston Fury Beast 16GB', 'sku' => 'RAM003', 'price' => 11000],
            ['name' => 'Samsung 980 PRO 1TB SSD', 'sku' => 'SSD001', 'price' => 18000],
            ['name' => 'Western Digital Blue 1TB SSD', 'sku' => 'SSD002', 'price' => 14000],
            ['name' => 'Kingston NV2 500GB SSD', 'sku' => 'SSD003', 'price' => 8500],
            ['name' => 'Corsair RM750x 750W PSU', 'sku' => 'PSU001', 'price' => 22000],
            ['name' => 'Cooler Master MWE 650W', 'sku' => 'PSU002', 'price' => 15000],
            ['name' => 'EVGA 600 BR 600W', 'sku' => 'PSU003', 'price' => 12000],
        ];
        
        $sriLankanCities = [
            'Colombo', 'Kandy', 'Galle', 'Jaffna', 'Negombo', 'Anuradhapura', 'Ratnapura', 
            'Batticaloa', 'Matara', 'Kurunegala', 'Trincomalee', 'Badulla', 'Kalutara',
            'Puttalam', 'Kegalle', 'Ampara', 'Hambantota', 'Monaragala', 'Polonnaruwa',
            'Ragama', 'Maharagama', 'Kelaniya', 'Moratuwa', 'Wattala', 'Panadura'
        ];
        
        for ($i = 1; $i <= 150; $i++) {
            $customer = $customers[array_rand($customers)];
            $orderDate = now()->subDays(rand(1, 365));
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            
            // Create order
            $order = Order::create([
                'order_number' => 'MSK' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'user_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => '077' . rand(1000000, 9999999),
                'status' => $status,
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'subtotal' => 0, // Will calculate after adding items
                'tax_amount' => 0,
                'shipping_cost' => rand(0, 1) ? rand(500, 2000) : 0,
                'discount_amount' => rand(0, 1) ? rand(1000, 10000) : 0,
                'total_amount' => 0, // Will calculate after adding items
                'billing_address_line_1' => rand(1, 999) . '/' . chr(rand(65, 90)) . ', ' . ['Main Street', 'Galle Road', 'Kandy Road', 'Negombo Road'][array_rand(['Main Street', 'Galle Road', 'Kandy Road', 'Negombo Road'])],
                'billing_city' => $sriLankanCities[array_rand($sriLankanCities)],
                'billing_state' => ['Western', 'Central', 'Southern', 'Northern', 'Eastern', 'North Western', 'North Central', 'Uva', 'Sabaragamuwa'][array_rand(['Western', 'Central', 'Southern', 'Northern', 'Eastern', 'North Western', 'North Central', 'Uva', 'Sabaragamuwa'])],
                'billing_postal_code' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                'billing_country' => 'Sri Lanka',
                'shipping_address_line_1' => rand(1, 999) . '/' . chr(rand(65, 90)) . ', ' . ['Main Street', 'Galle Road', 'Kandy Road', 'Negombo Road'][array_rand(['Main Street', 'Galle Road', 'Kandy Road', 'Negombo Road'])],
                'shipping_city' => $sriLankanCities[array_rand($sriLankanCities)],
                'shipping_state' => ['Western', 'Central', 'Southern', 'Northern', 'Eastern', 'North Western', 'North Central', 'Uva', 'Sabaragamuwa'][array_rand(['Western', 'Central', 'Southern', 'Northern', 'Eastern', 'North Western', 'North Central', 'Uva', 'Sabaragamuwa'])],
                'shipping_postal_code' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                'shipping_country' => 'Sri Lanka',
                'notes' => rand(0, 1) ? ['Please call before delivery', 'Urgent delivery required', 'Handle with care', 'Gift wrapping requested', 'Corporate order'][array_rand(['Please call before delivery', 'Urgent delivery required', 'Handle with care', 'Gift wrapping requested', 'Corporate order'])] : null,
                'admin_notes' => rand(0, 1) ? ['VIP customer', 'Regular customer', 'New customer', 'Bulk order discount applied'][array_rand(['VIP customer', 'Regular customer', 'New customer', 'Bulk order discount applied'])] : null,
                'admin_viewed_at' => rand(0, 1) ? $orderDate->addHours(rand(1, 48)) : null,
                'viewed_by_admin_id' => rand(0, 1) ? User::where('role', 'admin')->inRandomOrder()->first()->id : null,
                'created_at' => $orderDate,
                'updated_at' => $orderDate->addHours(rand(1, 72)),
            ]);
            
            // Add 1-5 items to each order
            $itemCount = rand(1, 5);
            $subtotal = 0;
            
            for ($j = 0; $j < $itemCount; $j++) {
                $product = $sampleProducts[array_rand($sampleProducts)];
                $quantity = rand(1, 3);
                $unitPrice = $product['price'];
                $totalPrice = $unitPrice * $quantity;
                $subtotal += $totalPrice;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => rand(1, 100), // Random product ID (we're not touching products table)
                    'product_name' => $product['name'],
                    'product_code' => $product['sku'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);
            }
            
            // Calculate totals
            $taxAmount = $subtotal * 0.05; // 5% tax
            $totalAmount = $subtotal + $taxAmount + $order->shipping_cost - $order->discount_amount;
            
            // Update order totals
            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ]);
        }
        
        $this->command->info('✅ Sample orders created');
    }
    
    private function createSampleActivityLogs(): void
    {
        $this->command->info('📝 Creating sample activity logs...');
        
        $customers = User::where('role', 'customer')->get();
        $admins = User::where('role', 'admin')->get();
        $orders = Order::all();
        
        $activities = [
            // Customer activities
            ['type' => 'customer', 'action' => 'login', 'description' => 'User logged in'],
            ['type' => 'customer', 'action' => 'logout', 'description' => 'User logged out'],
            ['type' => 'customer', 'action' => 'register', 'description' => 'New user registration'],
            ['type' => 'customer', 'action' => 'profile_update', 'description' => 'User updated profile information'],
            ['type' => 'customer', 'action' => 'order_placed', 'description' => 'Order placed by customer'],
            ['type' => 'customer', 'action' => 'password_change', 'description' => 'User changed password'],
            
            // Admin activities
            ['type' => 'admin', 'action' => 'login', 'description' => 'Admin logged in'],
            ['type' => 'admin', 'action' => 'logout', 'description' => 'Admin logged out'],
            ['type' => 'admin', 'action' => 'order_update', 'description' => 'Admin updated order status'],
            ['type' => 'admin', 'action' => 'user_management', 'description' => 'Admin accessed user management'],
            ['type' => 'admin', 'action' => 'analytics_view', 'description' => 'Admin viewed analytics dashboard'],
            ['type' => 'admin', 'action' => 'sitemap_regenerate', 'description' => 'Admin regenerated sitemap'],
            
            // System activities
            ['type' => 'system', 'action' => 'backup', 'description' => 'System backup completed'],
            ['type' => 'system', 'action' => 'maintenance', 'description' => 'System maintenance performed'],
            ['type' => 'system', 'action' => 'error', 'description' => 'System error occurred'],
            ['type' => 'system', 'action' => 'optimization', 'description' => 'System optimization completed'],
        ];
        
        // Create 500 activity logs
        for ($i = 0; $i < 500; $i++) {
            $activity = $activities[array_rand($activities)];
            $date = now()->subDays(rand(1, 365))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            $causerId = null;
            $subjectId = null;
            $subjectType = null;
            
            if ($activity['type'] === 'customer') {
                $causerId = $customers->random()->id;
                if ($activity['action'] === 'order_placed') {
                    $order = $orders->random();
                    $subjectId = $order->id;
                    $subjectType = 'App\\Models\\Order';
                }
            } elseif ($activity['type'] === 'admin') {
                $causerId = $admins->random()->id;
                if ($activity['action'] === 'order_update') {
                    $order = $orders->random();
                    $subjectId = $order->id;
                    $subjectType = 'App\\Models\\Order';
                }
            }
            
            ActivityLog::create([
                'type' => $activity['type'],
                'action' => $activity['action'],
                'description' => $activity['description'],
                'properties' => [
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'ip' => '192.168.1.' . rand(1, 255),
                    'old' => [],
                    'new' => [],
                ],
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'causer_type' => $causerId ? 'App\\Models\\User' : null,
                'causer_id' => $causerId,
                'ip_address' => '192.168.1.' . rand(1, 255),
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'url' => '/admin/' . ['dashboard', 'orders', 'users', 'analytics'][array_rand(['dashboard', 'orders', 'users', 'analytics'])],
                'method' => ['GET', 'POST', 'PUT', 'DELETE'][array_rand(['GET', 'POST', 'PUT', 'DELETE'])],
                'device_type' => ['Desktop', 'Mobile', 'Tablet'][array_rand(['Desktop', 'Mobile', 'Tablet'])],
                'browser' => ['Chrome', 'Firefox', 'Safari', 'Edge'][array_rand(['Chrome', 'Firefox', 'Safari', 'Edge'])],
                'platform' => ['Windows', 'macOS', 'Linux', 'Android', 'iOS'][array_rand(['Windows', 'macOS', 'Linux', 'Android', 'iOS'])],
                'severity' => ['low', 'medium', 'high'][array_rand(['low', 'medium', 'high'])],
                'status' => ['success', 'failed', 'pending'][array_rand(['success', 'failed', 'pending'])],
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
        
        $this->command->info('✅ Sample activity logs created');
    }
    
    private function displaySummary(): void
    {
        $this->command->info('');
        $this->command->info('📊 DATABASE SEEDING SUMMARY:');
        $this->command->info('=====================================');
        $this->command->info('👥 Users: ' . User::count() . ' (including ' . User::where('role', 'admin')->count() . ' admins)');
        $this->command->info('📦 Orders: ' . Order::count());
        $this->command->info('📋 Order Items: ' . OrderItem::count());
        $this->command->info('📝 Activity Logs: ' . ActivityLog::count());
        $this->command->info('💰 Total Revenue: LKR ' . number_format(Order::sum('total_amount'), 2));
        $this->command->info('=====================================');
        $this->command->info('');
        $this->command->info('🔐 ADMIN LOGIN CREDENTIALS:');
        $this->command->info('Email: admin@mskcomputers.lk | Password: admin123');
        $this->command->info('Email: dhanushka@mskcomputers.lk | Password: dhanushka123');
        $this->command->info('Email: kasun@mskcomputers.lk | Password: kasun123');
        $this->command->info('Email: nuwan@mskcomputers.lk | Password: nuwan123');
        $this->command->info('');
        $this->command->info('👤 CUSTOMER LOGIN CREDENTIALS:');
        $this->command->info('Any customer email | Password: customer123');
        $this->command->info('Example: amal.j@gmail.com | Password: customer123');
        $this->command->info('');
    }
}
