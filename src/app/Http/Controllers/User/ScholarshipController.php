<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\UserProfile;
use App\Services\ScholarshipService;
use Carbon\CarbonImmutable;
use Illuminate\View\View;

class ScholarshipController extends Controller
{
    public function index(ScholarshipService $service): View
    {
        $profile = auth()->user()->profile;

        $selectedMonth = (int) request('month', now()->month);
        $selectedYear = (int) request('year', now()->year);

        $selectedDate = CarbonImmutable::create($selectedYear, $selectedMonth, 1);
        $monthStart = $selectedDate->startOfMonth();
        $monthEnd = $selectedDate->endOfMonth();

        // pakai service (clean architecture)
        $allScholarships = $service->getMatchedScholarships(auth()->user());

        // tetap support filter bulan (biar UI kamu tidak rusak)
        $scholarships = $allScholarships
            ->filter(function ($scholarship) use ($monthStart, $monthEnd) {
                return
                    $scholarship->registration_start &&
                    $scholarship->registration_deadline &&
                    $scholarship->registration_start <= $monthEnd &&
                    $scholarship->registration_deadline >= $monthStart;
            })
            ->values();

        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        return view('user.scholarships.index', [
            'profile' => $profile, // tetap biar blade kamu aman
            'scholarships' => $scholarships,
            'months' => $months,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'selectedMonthName' => $months[$selectedMonth] ?? 'Bulan Ini',
        ]);
    }

    public function show(Scholarship $scholarship): View
    {
        abort_if(! $scholarship->is_active, 404);

        return view('user.scholarships.show', [
            'scholarship' => $scholarship,
        ]);
    }

    // ===== fallback lama kamu tetap aman =====
    private function matchesProfile(Scholarship $scholarship, ?UserProfile $profile): bool
    {
        if (! $profile) {
            return true;
        }

        $eligibleStatuses = $scholarship->eligible_statuses ?? [];
        $eligibleLevels = $scholarship->eligible_levels ?? [];
        $eligibleSemesters = $scholarship->eligible_semesters ?? [];
        $allowedGenders = $scholarship->allowed_genders ?? [];

        if (! empty($eligibleStatuses)) {
            $isGeneralScholarship = in_array('general', $eligibleStatuses, true);

            if (
                ! $isGeneralScholarship
                && $profile->education_status
                && ! in_array($profile->education_status, $eligibleStatuses, true)
            ) {
                return false;
            }
        }

        if (! empty($eligibleLevels)) {
            $userLevels = array_filter([
                $profile->education_level,
                $profile->target_education_level,
            ]);

            if (! empty($userLevels) && empty(array_intersect($eligibleLevels, $userLevels))) {
                return false;
            }
        }

        if (! empty($eligibleSemesters)) {
            $userSemesters = $profile->target_semesters ?? [];

            if (! empty($userSemesters) && empty(array_intersect($eligibleSemesters, $userSemesters))) {
                return false;
            }
        }

        if (
            $scholarship->allowed_institution_type
            && ! in_array($scholarship->allowed_institution_type, ['all', 'not_applicable'], true)
            && $profile->institution_type
            && $scholarship->allowed_institution_type !== $profile->institution_type
        ) {
            return false;
        }

        if (
            $scholarship->minimum_gpa !== null
            && $profile->gpa !== null
            && (float) $profile->gpa < (float) $scholarship->minimum_gpa
        ) {
            return false;
        }

        if (
            ! empty($allowedGenders)
            && $profile->gender
            && ! in_array($profile->gender, $allowedGenders, true)
        ) {
            return false;
        }

        if (
            $profile->has_active_scholarship
            && ! $scholarship->allow_active_scholarship_holder
        ) {
            return false;
        }

        if (
            $scholarship->requires_low_income
            && ! $profile->is_low_income
        ) {
            return false;
        }

        if (
            $profile->scholarship_scope
            && $profile->scholarship_scope !== 'both'
            && $scholarship->scholarship_scope !== 'both'
            && $scholarship->scholarship_scope !== $profile->scholarship_scope
        ) {
            return false;
        }

        return true;
    }

    public function search(ScholarshipService $service): View
    {
        $profile = auth()->user()->profile;
        $query = request('q');
        $level = request('level');
        $scope = request('scope');

        $allScholarships = $service->getMatchedScholarships(auth()->user());

        $scholarships = collect($allScholarships);

        if ($query) {
            $scholarships = $scholarships->filter(function ($s) use ($query) {
                return stripos($s->name, $query) !== false || stripos($s->provider, $query) !== false;
            });
        }

        if ($level) {
            $scholarships = $scholarships->filter(function ($s) use ($level) {
                return in_array($level, $s->eligible_levels ?? [], true);
            });
        }

        if ($scope) {
            $scholarships = $scholarships->filter(function ($s) use ($scope) {
                return $s->scholarship_scope === $scope;
            });
        }

        return view('user.scholarships.search', [
            'profile' => $profile,
            'scholarships' => $scholarships->values(),
            'query' => $query,
            'selectedLevel' => $level,
            'selectedScope' => $scope,
        ]);
    }
}