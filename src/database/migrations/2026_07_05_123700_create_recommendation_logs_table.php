<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('scholarship_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('match_score');
            $table->unsignedInteger('rank_position');
            $table->boolean('is_manual_curated')->default(false);

            $table->timestamps();

            $table->index(['user_id', 'rank_position'], 'recommendation_user_rank_idx');
            $table->index(['scholarship_id', 'match_score'], 'recommendation_scholarship_score_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_logs');
    }
};