<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_trackings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('scholarship_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status', [
                'viewed',
                'preparing',
                'applied',
                'passed_administration',
                'passed_interview',
                'failed',
                'success',
            ])->default('viewed');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'scholarship_id'], 'user_scholarship_tracking_unique');
            $table->index(['user_id', 'status'], 'user_tracking_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_trackings');
    }
};