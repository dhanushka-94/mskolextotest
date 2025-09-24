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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // Activity Information
            $table->string('type', 50)->index(); // 'system', 'customer', 'admin', 'api'
            $table->string('action', 100)->index(); // 'login', 'order_created', 'product_viewed', etc.
            $table->string('description', 500);
            $table->json('properties')->nullable(); // Additional data as JSON
            
            // Subject (what was acted upon)
            $table->string('subject_type', 100)->nullable()->index(); // Model class name
            $table->unsignedBigInteger('subject_id')->nullable()->index(); // Model ID
            
            // Causer (who performed the action)
            $table->string('causer_type', 100)->nullable()->index(); // Usually User model
            $table->unsignedBigInteger('causer_id')->nullable()->index(); // User ID
            
            // Request Information
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('user_agent', 1000)->nullable();
            $table->string('url', 1000)->nullable();
            $table->string('method', 10)->nullable(); // GET, POST, etc.
            $table->json('request_data')->nullable(); // Request payload
            
            // Location & Device Info
            $table->string('device_type', 50)->nullable(); // mobile, desktop, tablet
            $table->string('browser', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            
            // Status & Priority
            $table->enum('status', ['success', 'failed', 'pending', 'cancelled'])->default('success')->index();
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium')->index();
            
            // Timestamps
            $table->timestamp('created_at')->index();
            $table->timestamp('updated_at')->nullable();
            
            // Indexes for performance
            $table->index(['type', 'created_at']);
            $table->index(['causer_type', 'causer_id', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
            $table->index(['status', 'severity']);
            $table->index(['ip_address', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};