<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Site-DB only: display order for MSK categories (products_db ids).
     * Does not modify POS sma_categories.
     */
    public function up(): void
    {
        Schema::create('category_display_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->unique();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_display_orders');
    }
};
