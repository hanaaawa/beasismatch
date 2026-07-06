<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurationRequest extends Model
{
    protected $fillable = [
        'user_id',
        'handled_by',
        'status',
        'user_notes',
        'admin_notes',
        'requested_at',
        'handled_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'handled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}