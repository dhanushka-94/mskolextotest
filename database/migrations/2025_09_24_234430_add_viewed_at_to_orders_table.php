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
            $table->timestamp('admin_viewed_at')->nullable()->after('updated_at');
            $table->unsignedBigInteger('viewed_by_admin_id')->nullable()->after('admin_viewed_at');
            
            // Add foreign key constraint for admin who viewed the order
            $table->foreign('viewed_by_admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['viewed_by_admin_id']);
            $table->dropColumn(['admin_viewed_at', 'viewed_by_admin_id']);
        });
    }
};