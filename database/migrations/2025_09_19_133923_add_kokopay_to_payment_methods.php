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
        // Add 'kokopay' to the payment_method enum in orders table
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('webxpay', 'kokopay', 'bank_transfer') DEFAULT 'webxpay'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'kokopay' from the payment_method enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('webxpay', 'bank_transfer') DEFAULT 'webxpay'");
    }
};
