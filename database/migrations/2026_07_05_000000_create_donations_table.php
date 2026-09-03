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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone');
            $table->unsignedBigInteger('amount');
            $table->string('status')->default('pending'); // pending, success, failed, expired
            $table->string('snap_token')->nullable();
            $table->foreignId('campaign_id')->nullable()->constrained('contents')->nullOnDelete();
            $table->string('payment_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
