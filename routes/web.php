<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PassSlipController;
use App\Http\Controllers\PassSlipMgmtController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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

    // reviews
    Route::view('reviews', 'reviews')->name('reviews');

    // concerns
    Route::view('concerns', 'concerns')->name('concerns');

    // pass slips
    Route::get('pass-slip', [PassSlipController::class, 'index'])->name('pass-slips');
    Route::post('pass-slip', [PassSlipController::class, 'store'])->name('pass-slips.store');
    Route::patch('pass-slip/{passSlip}/cancel', [PassSlipController::class, 'cancel'])->name('pass-slips.cancel');

    // profile
    Route::view('profile', 'profile')->name('profile');

});

//      ADMIN ONLY ACCESS
    Route::middleware(['auth', 'can:admins'])->group(function () {
    // dormer management
    Route::resource('users', UserController::class);

    // room management
    Route::resource('rooms', RoomController::class);

    // announcements
    Route::resource('announcements', AnnouncementsController::class)->only(['store', 'update', 'destroy']);

    // pass slip management
    Route::get('slips-mgmt', [PassSlipMgmtController::class, 'index'])->name('slips-mgmt');
    Route::patch('slips-mgmt/{passSlip}/approve', [PassSlipMgmtController::class, 'approve'])->name('slips-mgmt.approve');
    Route::patch('slips-mgmt/{passSlip}/deny', [PassSlipMgmtController::class, 'deny'])->name('slips-mgmt.deny');
    Route::delete('slips-mgmt', [PassSlipMgmtController::class, 'destroyAll'])->name('slips-mgmt.destroy-all');

    // reports
    Route::view('reports', 'reports')->name('reports');

    // analytics
    Route::view('analytics', 'analytics')->name('analytics');

    // biometrics
    Route::view('logbook', 'biometrics')->name('biometrics');

});
