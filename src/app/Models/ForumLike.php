<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumLike extends Model
{
    protected $fillable = [
        'forum_question_id',
        'user_id',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(ForumQuestion::class, 'forum_question_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
