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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id'); // Reference to products DB
            $table->string('product_name'); // Store product name for record keeping
            $table->string('product_code')->nullable(); // Store product code
            $table->string('product_image')->nullable(); // Store product image URL
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); // Price at time of order
            $table->decimal('total_price', 10, 2); // quantity * unit_price
            $table->json('product_attributes')->nullable(); // Store product specs/attributes
            $table->timestamps();
            
            $table->index(['order_id']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
