<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecommendationLog extends Model
{
    protected $fillable = [
        'user_id',
        'scholarship_id',
        'match_score',
        'rank_position',
        'is_manual_curated',
    ];

    protected $casts = [
        'match_score' => 'integer',
        'rank_position' => 'integer',
        'is_manual_curated' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }
}