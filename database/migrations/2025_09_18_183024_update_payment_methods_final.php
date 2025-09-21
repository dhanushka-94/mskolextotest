<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing cash_on_delivery or payhere orders to webxpay
        DB::table('orders')
            ->whereIn('payment_method', ['cash_on_delivery', 'payhere'])
            ->update(['payment_method' => 'webxpay']);
            
        // Now safely update the enum to only include webxpay and bank_transfer
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('webxpay', 'bank_transfer') NOT NULL DEFAULT 'webxpay'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the original enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cash_on_delivery', 'bank_transfer', 'card_payment', 'mobile_payment', 'webxpay', 'payhere') NOT NULL DEFAULT 'cash_on_delivery'");
    }
};
