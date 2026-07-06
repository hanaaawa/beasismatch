<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->json('eligible_statuses')->nullable()->after('eligibility_status');
            $table->json('eligible_levels')->nullable()->after('eligible_statuses');
            $table->json('eligible_semesters')->nullable()->after('eligible_levels');

            $table->enum('allowed_institution_type', [
                'PTN',
                'PTS',
                'all',
                'school',
                'not_applicable',
            ])->default('all')->after('eligible_semesters');

            $table->decimal('minimum_gpa', 3, 2)->nullable()->after('allowed_institution_type');

            $table->date('registration_start')->nullable()->after('minimum_gpa');
            $table->date('registration_deadline')->nullable()->after('registration_start');

            $table->enum('scholarship_scope', [
                'domestic',
                'abroad',
                'both',
            ])->default('domestic')->after('registration_deadline');

            $table->json('allowed_genders')->nullable()->after('scholarship_scope');

            $table->boolean('allow_active_scholarship_holder')->default(false)->after('allowed_genders');
            $table->boolean('requires_low_income')->default(false)->after('allow_active_scholarship_holder');

            $table->string('funding_label')->nullable()->after('requires_low_income');
            $table->text('eligible_institutions')->nullable()->after('funding_label');
            $table->longText('requirements')->nullable()->after('eligible_institutions');
            $table->longText('documents')->nullable()->after('requirements');
            $table->string('booklet_link')->nullable()->after('documents');
            $table->string('apply_link')->nullable()->after('booklet_link');

            $table->boolean('is_active')->default(true)->after('apply_link');

            $table->index(['registration_start', 'registration_deadline'], 'scholarship_calendar_idx');
            $table->index(['allowed_institution_type', 'minimum_gpa'], 'scholarship_eligibility_idx');
            $table->index('is_active', 'scholarship_active_idx');
        });
    }

    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropIndex('scholarship_calendar_idx');
            $table->dropIndex('scholarship_eligibility_idx');
            $table->dropIndex('scholarship_active_idx');

            $table->dropColumn([
                'eligible_statuses',
                'eligible_levels',
                'eligible_semesters',
                'allowed_institution_type',
                'minimum_gpa',
                'registration_start',
                'registration_deadline',
                'scholarship_scope',
                'allowed_genders',
                'allow_active_scholarship_holder',
                'requires_low_income',
                'funding_label',
                'eligible_institutions',
                'requirements',
                'documents',
                'booklet_link',
                'apply_link',
                'is_active',
            ]);
        });
    }
};