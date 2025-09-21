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
        // Add 'webxpay' to the payment_method enum and set default to webxpay
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('webxpay', 'bank_transfer', 'card_payment', 'mobile_payment') NOT NULL DEFAULT 'webxpay'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'webxpay' from the payment_method enum and restore original default
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('cash_on_delivery', 'bank_transfer', 'card_payment', 'mobile_payment') NOT NULL DEFAULT 'cash_on_delivery'");
    }
};
