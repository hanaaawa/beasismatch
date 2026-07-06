<?php

namespace App\Services;

use App\Models\Scholarship;
use App\Models\User;

class ScholarshipService
{
    public function getMatchedScholarships(User $user)
    {
        $profile = $user->profile;

        return Scholarship::query()
            ->where('is_active', true)
            ->get()
            ->filter(fn ($s) => $this->match($s, $profile))
            ->values();
    }

    private function match(Scholarship $s, $profile): bool
    {
        if (!$profile) return true;

        if (!empty($s->eligible_levels)) {
            $userLevels = array_filter([
                $profile->education_level,
                $profile->target_education_level,
            ]);

            if (!array_intersect($s->eligible_levels, $userLevels)) {
                return false;
            }
        }

        if ($s->minimum_gpa && $profile->gpa) {
            if ((float)$profile->gpa < (float)$s->minimum_gpa) {
                return false;
            }
        }

        return true;
    }
}
