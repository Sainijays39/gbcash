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
        Schema::create('recharge_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('mobile', 15);
            $table->string('operator');
            $table->string('plan_name');
            $table->decimal('amount', 12, 2);
            $table->string('validity')->nullable();
            $table->string('data_benefit')->nullable();
            $table->json('benefits')->nullable();
            $table->string('status')->default('pending'); // pending | success | failed
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharge_requests');
    }
};
