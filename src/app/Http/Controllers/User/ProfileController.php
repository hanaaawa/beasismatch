<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('user.profile.edit', [
            'profile' => auth()->user()->profile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gender' => ['required', 'in:male,female'],
            'birth_date' => ['required', 'date'],

            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],

            'education_status' => ['required', 'in:active,inactive_graduated,gap_year,general'],
            'education_level' => ['required', 'in:SMP,SMA,D3,D4,S1,S2,S3,Profesi'],

            'institution_name' => ['nullable', 'string', 'max:255'],
            'institution_type' => ['required', 'in:PTN,PTS,school,other,not_applicable'],
            'gpa' => ['nullable', 'numeric', 'min:0', 'max:4'],

            'target_education_level' => ['required', 'in:SMP,SMA,D3,D4,S1,S2,S3,Profesi'],
            'target_semesters' => ['nullable', 'array'],
            'target_semesters.*' => ['string', 'max:50'],

            'scholarship_scope' => ['required', 'in:domestic,abroad,both'],
            'target_countries' => ['nullable', 'string', 'max:500'],

            'has_active_scholarship' => ['required', 'boolean'],
            'is_low_income' => ['required', 'boolean'],
        ]);

        $targetCountries = collect(explode(',', $validated['target_countries'] ?? ''))
            ->map(fn ($country) => trim($country))
            ->filter()
            ->values()
            ->all();

        $validated['target_countries'] = $targetCountries;
        $validated['target_semesters'] = $validated['target_semesters'] ?? [];

        UserProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated + ['user_id' => auth()->id()]
        );

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Profil pencarian beasiswa berhasil disimpan.');
    }
}