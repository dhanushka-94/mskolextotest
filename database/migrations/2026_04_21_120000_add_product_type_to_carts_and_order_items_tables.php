<?php

use App\Models\SmaProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('product_type')->default(SmaProduct::class)->after('product_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->string('product_type')->default(SmaProduct::class)->after('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });
    }
};
