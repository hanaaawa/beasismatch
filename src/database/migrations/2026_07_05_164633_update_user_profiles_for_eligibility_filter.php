<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('gender');

            $table->string('province')->nullable()->after('birth_date');
            $table->string('city')->nullable()->after('province');

            $table->enum('education_status', [
                'active',
                'inactive_graduated',
                'gap_year',
                'general',
            ])->nullable()->after('city');

            $table->enum('education_level', [
                'SMP',
                'SMA',
                'D3',
                'D4',
                'S1',
                'S2',
                'S3',
                'Profesi',
            ])->nullable()->after('education_status');

            $table->string('institution_name')->nullable()->after('education_level');

            $table->enum('institution_type', [
                'PTN',
                'PTS',
                'school',
                'other',
                'not_applicable',
            ])->nullable()->after('institution_name');

            $table->decimal('gpa', 3, 2)->nullable()->after('institution_type');

            $table->enum('target_education_level', [
                'SMP',
                'SMA',
                'D3',
                'D4',
                'S1',
                'S2',
                'S3',
                'Profesi',
            ])->nullable()->after('gpa');

            $table->json('target_semesters')->nullable()->after('target_education_level');

            $table->enum('scholarship_scope', [
                'domestic',
                'abroad',
                'both',
            ])->nullable()->after('target_semesters');

            $table->json('target_countries')->nullable()->after('scholarship_scope');

            $table->boolean('has_active_scholarship')->nullable()->after('target_countries');
            $table->boolean('is_low_income')->nullable()->after('has_active_scholarship');

            $table->index(['education_status', 'education_level'], 'profile_edu_idx');
            $table->index(['institution_type', 'gpa'], 'profile_inst_gpa_idx');
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropIndex('profile_edu_idx');
            $table->dropIndex('profile_inst_gpa_idx');

            $table->dropColumn([
                'gender',
                'birth_date',
                'province',
                'city',
                'education_status',
                'education_level',
                'institution_name',
                'institution_type',
                'gpa',
                'target_education_level',
                'target_semesters',
                'scholarship_scope',
                'target_countries',
                'has_active_scholarship',
                'is_low_income',
            ]);
        });
    }
};