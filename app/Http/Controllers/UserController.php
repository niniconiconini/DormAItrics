<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $admins = User::whereIn('user_type', ['Admin', 'Manager'])->get();
        // $residents = User::where('user_type', 'Resident')->get();
        $residents = Resident::with(['user', 'room'])->get();

        return view('residents', ['admins' => $admins, 'residents' => $residents]);
    }
}
