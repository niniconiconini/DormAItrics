<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

//      DMS AND PUBLIC CAN ACCESS
Route::view('registration', 'user-regis')->name('Registration');
Route::post('user-regis', RegisterController::class)->name('register');

Route::view('login', 'user-login')->name('login')->middleware('throttle:5,1');
Route::post('login', LoginController::class)->name('login.attempt');

Route::get('logout', function () {
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();

    return redirect('login');
})->name('logout');

//      ALL DMS USERS CAN ACCESS
Route::middleware(['auth', 'can:all-users'])->group(function () {
    // homepage
    Route::get('/', [AnnouncementsController::class, 'index'])->name('home');
    Route::post('/', [AnnouncementsController::class, 'store'])->name('post-announcement');

    // reviews
    Route::view('reviews', 'reviews')->name('reviews');

    // concerns
    Route::view('concerns', 'concerns')->name('concerns');

    // pass slips
    Route::view('pass-slip', 'slips')->name('pass-slips');

    // profile
    Route::view('profile', 'profile')->name('profile');

});

//      ADMIN ONLY ACCESS
Route::middleware(['auth', 'can:admins'])->group(function () {
    // dormer management
    Route::view('dormer-management', 'dormer-mgmt')->name('dormer-mgmt');

    // room management
    Route::view('room-management', 'room-mgmt')->name('room-mgmt');

    // pass slip management
    Route::view('pass-slip-management', 'slips-mgmt')->name('slips-mgmt');

    // reports
    Route::view('reports', 'reports')->name('reports');

    // analytics
    Route::view('analytics', 'analytics')->name('analytics');

    // biometrics
    Route::view('logbook', 'biometrics')->name('biometrics');

});
