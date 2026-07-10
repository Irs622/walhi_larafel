<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add composite indexes to the contents table for common filter queries.
     * These dramatically speed up category+status filtering throughout the app.
     */
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            // Most common query: WHERE category = ? AND status = ?
            $table->index(['category', 'status'], 'idx_contents_category_status');

            // Ordered listing query: WHERE category = ? AND status = ? ORDER BY publish_date DESC
            $table->index(['category', 'status', 'publish_date'], 'idx_contents_category_status_date');

            // Promoted content query: WHERE is_promoted = 1 AND status = ?
            $table->index(['is_promoted', 'status', 'publish_date'], 'idx_contents_promoted_status_date');
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropIndex('idx_contents_category_status');
            $table->dropIndex('idx_contents_category_status_date');
            $table->dropIndex('idx_contents_promoted_status_date');
        });
    }
};
