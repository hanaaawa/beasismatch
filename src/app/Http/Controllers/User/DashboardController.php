<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $profile = auth()->user()->profile;

        // AMBIL BEASISWA UNTUK TAMPILAN AWAL DASHBOARD
        $recommendations = Scholarship::query()
            ->where('is_active', true)
            ->latest()
            ->take(10)
            ->get();

        return view('user.dashboard', [
            'profile' => $profile,
            'recommendations' => $recommendations,
        ]);
    }
}