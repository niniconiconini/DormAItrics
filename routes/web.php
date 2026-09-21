<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

//      DMS AND PUBLIC CAN ACCESS
Route::view('registration', 'user-regis')->name('Registration');
Route::post('user-regis', RegisterController::class)->name('register');

Route::get('login', function () {
    return view('user-login');
    }) ->name('login');
Route::post('/', LoginController::class)->middleware('throttle:5,1')->name('login.attempt');
    
Route::get('logout', function() {
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();
    return redirect('user-login');
}) ->name('logout');

//      ALL DMS USERS CAN ACCESS
Route::middleware(['auth', 'can:all-users'])->group(function () {
    // homepage
    Route::get('/', function () {
        return view('home');
    });
    Route::view('/', 'home')->name('home');

    // reviews

    // concerns

    // pass slips

});

//      ADMIN ONLY ACCESS
Route::middleware(['auth','can:admins'])->group(function () {
    // dormer management
    Route::view('dormer-mgmt', 'dormer-mgmt')->name('dormer-mgmt');

    //

});
