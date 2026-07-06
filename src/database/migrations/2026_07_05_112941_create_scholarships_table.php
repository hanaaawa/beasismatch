<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('provider');

            $table->enum('target_level', ['S1', 'S2', 'S3', 'D4']);
            $table->enum('intake_semester', ['ganjil', 'genap', 'fleksibel']);
            $table->enum('eligibility_status', ['aktif', 'lulusan', 'semua']);

            $table->string('country')->nullable();
            $table->decimal('min_gpa', 3, 2)->default(0);
            $table->unsignedInteger('min_toefl')->nullable();
            $table->decimal('min_ielts', 3, 1)->nullable();

            $table->string('major_focus')->nullable();
            $table->enum('funding_type', ['full', 'partial']);
            $table->unsignedInteger('quota')->nullable();

            $table->text('description')->nullable();
            $table->text('benefit')->nullable();
            $table->string('official_link')->nullable();
            $table->date('deadline');

            $table->timestamps();

            $table->index(['target_level', 'intake_semester', 'eligibility_status'], 'scholarship_filter_idx');
            $table->index('deadline');
            $table->index('funding_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
