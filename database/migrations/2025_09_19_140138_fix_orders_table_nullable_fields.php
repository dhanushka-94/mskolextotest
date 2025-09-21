<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make optional fields nullable
            $table->string('customer_email')->nullable()->change();
            $table->string('billing_address_line_2')->nullable()->change();
            $table->string('billing_state')->nullable()->change();
            $table->string('billing_postal_code')->nullable()->change();
            $table->string('shipping_address_line_2')->nullable()->change();
            $table->string('shipping_state')->nullable()->change();
            $table->string('shipping_postal_code')->nullable()->change();
            $table->text('notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert changes if needed (optional)
            $table->string('customer_email')->nullable(false)->change();
            $table->string('billing_address_line_2')->nullable(false)->change();
            $table->string('billing_state')->nullable(false)->change();
            $table->string('billing_postal_code')->nullable(false)->change();
            $table->string('shipping_address_line_2')->nullable(false)->change();
            $table->string('shipping_state')->nullable(false)->change();
            $table->string('shipping_postal_code')->nullable(false)->change();
            $table->text('notes')->nullable(false)->change();
        });
    }
};
