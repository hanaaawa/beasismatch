<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scholarship extends Model
{
    protected $fillable = [
        'name',
        'provider',

        // field lama
        'target_level',
        'intake_semester',
        'eligibility_status',
        'country',
        'min_gpa',
        'min_toefl',
        'min_ielts',
        'major_focus',
        'funding_type',
        'quota',
        'description',
        'benefit',
        'official_link',
        'deadline',

        // field baru untuk kalender + filter
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
    ];

    protected $casts = [
        // field lama
        'min_gpa' => 'decimal:2',
        'min_ielts' => 'decimal:1',
        'deadline' => 'date',

        // field baru
        'eligible_statuses' => 'array',
        'eligible_levels' => 'array',
        'eligible_semesters' => 'array',
        'allowed_genders' => 'array',
        'minimum_gpa' => 'decimal:2',
        'registration_start' => 'date',
        'registration_deadline' => 'date',
        'allow_active_scholarship_holder' => 'boolean',
        'requires_low_income' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function recommendationLogs(): HasMany
    {
        return $this->hasMany(RecommendationLog::class);
    }

    public function trackings(): HasMany
    {
        return $this->hasMany(UserTracking::class);
    }
}