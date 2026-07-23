<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, \BezhanSalleh\FilamentShield\Traits\HasPanelShield;

    protected $fillable = [
        'avatar_url',
        'name',
        'email',
        'password',
        'role',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            return asset('storage/' . $this->avatar_url);
        }

        $hash = md5(strtolower(trim($this->email)));

        return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
    }



    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function recommendationLogs(): HasMany
    {
        return $this->hasMany(RecommendationLog::class);
    }

    public function trackings(): HasMany
    {
        return $this->hasMany(UserTracking::class);
    }

    public function curationRequests(): HasMany
    {
        return $this->hasMany(CurationRequest::class);
    }

    public function handledCurationRequests(): HasMany
    {
        return $this->hasMany(CurationRequest::class, 'handled_by');
    }
}