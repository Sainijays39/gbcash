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
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('service_type'); // electricity | fastag | recharge
            $table->uuid('service_id'); // id of the source *_requests row
            $table->string('reference_number')->unique();
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending | success | failed
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['service_type', 'service_id']);
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
