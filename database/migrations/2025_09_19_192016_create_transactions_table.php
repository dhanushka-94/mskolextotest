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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Basic transaction info
            $table->string('transaction_id')->unique();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->string('payment_method'); // webxpay, kokopay, bank_transfer
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('LKR');
            
            // Gateway specific data
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_reference')->nullable();
            $table->json('gateway_response')->nullable();
            
            // Customer information
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            
            // Payment details
            $table->decimal('transaction_fee', 8, 2)->default(0);
            $table->text('description')->nullable();
            $table->text('failure_reason')->nullable();
            
            // Timestamps for payment flow
            $table->timestamp('initiated_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            
            // Additional metadata
            $table->json('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['payment_method', 'status']);
            $table->index(['order_id', 'status']);
            $table->index(['created_at', 'status']);
            $table->index('gateway_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
