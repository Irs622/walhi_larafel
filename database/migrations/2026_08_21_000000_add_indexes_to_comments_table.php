<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add composite indexes to the comments table for thread and moderation queries.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Accelerates top-level approved comments lookup: WHERE content_id = ? AND status = 'approved' AND parent_id IS NULL
            $table->index(['content_id', 'status', 'parent_id'], 'idx_comments_content_status_parent');

            // Accelerates nested replies lookup: WHERE parent_id = ? AND status = 'approved' ORDER BY created_at ASC
            $table->index(['parent_id', 'status', 'created_at'], 'idx_comments_parent_status_created');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('idx_comments_content_status_parent');
            $table->dropIndex('idx_comments_parent_status_created');
        });
    }
};
