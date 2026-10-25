<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PassSlipController;
use App\Http\Controllers\PassSlipMgmtController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//      DMS AND PUBLIC CAN ACCESS
Route::view('registration', 'user-regis')->name('Registration');
Route::post('user-regis', RegisterController::class)->name('register');

Route::view('login', 'user-login')->name('login')->middleware('throttle:5,1');
Route::post('login', LoginController::class)->name('login.attempt');

Route::get('logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('login');
})->name('logout');

//      ALL DMS USERS CAN ACCESS
Route::middleware(['auth', 'can:all-users'])->group(function () {
    // homepage
    Route::get('/', [AnnouncementsController::class, 'index'])->name('home');

    // reviews
    Route::view('reviews', 'reviews')->name('reviews');

    // concerns
    Route::get('concerns', [ConcernController::class, 'index'])->name('concerns');
    Route::post('concerns', [ConcernController::class, 'store'])->name('concerns.store');
    Route::post('concerns/{concern}/like', [ConcernController::class, 'like'])->name('concerns.like');
    Route::post('concerns/{concern}/replies', [ConcernController::class, 'reply'])->name('concerns.reply');
    Route::put('concern-replies/{reply}', [ConcernController::class, 'updateReply'])->name('concern-replies.update');
    Route::delete('concern-replies/{reply}', [ConcernController::class, 'destroyReply'])->name('concern-replies.destroy');

    // pass slips
    Route::get('pass-slip', [PassSlipController::class, 'index'])->name('pass-slips');
    Route::post('pass-slip', [PassSlipController::class, 'store'])->name('pass-slips.store');
    Route::patch('pass-slip/{passSlip}/cancel', [PassSlipController::class, 'cancel'])->name('pass-slips.cancel');

    // profile
    Route::view('profile', 'profile')->name('profile');
    Route::put('profile/{user}', [UserController::class, 'update'])->name('profile.update');
});

//      ADMIN ONLY ACCESS
Route::middleware(['auth', 'can:admins'])->group(function () {
    // dormer management
    Route::resource('users', UserController::class);

    // room management
    Route::resource('rooms', RoomController::class);

    // announcements
    Route::resource('announcements', AnnouncementsController::class)->only(['store', 'update', 'destroy']);

    // concerns
    Route::delete('concerns/{concern}', [ConcernController::class, 'destroy'])->name('concerns.destroy');

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
