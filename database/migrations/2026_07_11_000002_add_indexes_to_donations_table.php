<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add composite indexes to the donations table for common report queries.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // SUM(amount) WHERE status = 'success' query
            $table->index(['status', 'created_at'], 'idx_donations_status_created');

            // Monthly trend query: WHERE status = 'success' AND YEAR() AND MONTH()
            $table->index(['status', 'donor_email'], 'idx_donations_status_email');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropIndex('idx_donations_status_created');
            $table->dropIndex('idx_donations_status_email');
        });
    }
};
