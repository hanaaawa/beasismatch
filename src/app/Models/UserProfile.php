<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',

        'address',
        'phone',

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

        // field lama, sementara dibiarkan agar tidak merusak kode lama
        'current_level',
        'current_semester',
        'target_level',
        'current_gpa',
        'current_major',
        'university',
        'toefl_score',
        'ielts_score',
        'target_country',
        'funding_preference',
        'target_intake',
        'ready_time',
        'photo_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'gpa' => 'decimal:2',
        'target_semesters' => 'array',
        'target_countries' => 'array',
        'has_active_scholarship' => 'boolean',
        'is_low_income' => 'boolean',

        // field lama
        'current_semester' => 'integer',
        'current_gpa' => 'decimal:2',
        'toefl_score' => 'integer',
        'ielts_score' => 'decimal:1',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}