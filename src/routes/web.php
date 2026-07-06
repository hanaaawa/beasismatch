<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\GoogleAuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ScholarshipController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ForumController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Livewire Routes
|--------------------------------------------------------------------------
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| GOOGLE AUTH
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');

/*
|--------------------------------------------------------------------------
| GUEST (LOGIN / REGISTER)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('user.register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('user.register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('user.login.store');
});

/*
|--------------------------------------------------------------------------
| AUTH USER AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    | DASHBOARD (FIXED)
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('user.dashboard');

    /*
    | PROFILE
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('user.profile.edit');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('user.profile.update');

    /*
    | SCHOLARSHIPS
    */
    Route::get('/scholarships', [ScholarshipController::class, 'index'])
        ->name('user.scholarships.index');

    Route::get('/scholarships/search', [ScholarshipController::class, 'search'])
        ->name('user.scholarships.search');

    Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show'])
        ->name('user.scholarships.show');

    /*
    | FORUM
    */
    Route::get('/forum', [ForumController::class, 'index'])
        ->name('user.forum.index');

    Route::post('/forum', [ForumController::class, 'store'])
        ->name('user.forum.store');

    Route::get('/forum/{question}', [ForumController::class, 'show'])
        ->name('user.forum.show');

    Route::post('/forum/{question}/reply', [ForumController::class, 'storeReply'])
        ->name('user.forum.reply.store');

    /*
    | LOGOUT
    */
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('user.logout');
});