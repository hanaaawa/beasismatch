<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('address')->nullable();
            $table->string('phone')->nullable();

            $table->enum('current_level', ['S1', 'S2', 'S3']);
            $table->unsignedTinyInteger('current_semester');
            $table->enum('target_level', ['S1', 'S2', 'S3']);

            $table->decimal('current_gpa', 3, 2);
            $table->string('current_major');
            $table->string('university');

            $table->unsignedInteger('toefl_score')->nullable();
            $table->decimal('ielts_score', 3, 1)->nullable();

            $table->string('target_country')->nullable();
            $table->enum('funding_preference', ['full', 'partial'])->nullable();
            $table->enum('target_intake', ['ganjil', 'genap', 'fleksibel'])->nullable();
            $table->enum('ready_time', ['1_bulan', '3_bulan', '6_bulan', 'lebih'])->nullable();

            $table->string('photo_path')->nullable();

            $table->timestamps();

            $table->unique('user_id');
            $table->index(['target_level', 'current_level'], 'user_profile_level_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};