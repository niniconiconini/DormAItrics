<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// Route::view('/', 'user-regis')->name('user-regis');

// Route::get('/', [AnnouncementsController::class, 'index']);

// Route::view('home', [AnnouncementsController::class, 'index'])->name('home');

// // Route::get('/', [AnnouncementsController::class, 'index']);

Route::get('user-login', function () {
    return view('user-login');
    }) ->name('login');
    Route::post('home', LoginController::class)->name('login.attempt');
    
Route::get('logout', function() {
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();
    return redirect('user-login');
}) ->name('logout');

Route::get('/', function () {
    return view('home');
});
    
Route::view('home', 'home')->name('home');
Route::view('dormer-mgmt', 'dormer-mgmt')->name('dormer-mgmt');